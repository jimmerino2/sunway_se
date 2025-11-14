window.addEventListener('DOMContentLoaded', event => {

  // Set new default font family and font color
  Chart.defaults.global.defaultFontFamily = '-apple-system,system-ui,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif';
  Chart.defaults.global.defaultFontColor = '#292b2c';

  // Helper array to convert month numbers to names (index 1 = January)
  const monthNames = [
    "", "January", "February", "March", "April", "May", "June",
    "July", "August", "September", "October", "November", "December"
  ];

  // Declare a unique chart variable for this file
  let myBarChart;

  // This function creates the year options in the dropdown
  function populateYearDropdown() {
    const selector = document.getElementById('yearSelector');
    if (!selector) return;

    const currentYear = new Date().getFullYear();
    const startYear = currentYear - 5; // Go back 5 years

    // Clear existing options before populating
    selector.innerHTML = '';

    for (let year = currentYear; year >= startYear; year--) {
      const option = document.createElement('option');
      option.value = year;
      option.text = year;
      if (year === currentYear) {
        option.selected = true; // Select the current year by default
      }
      selector.appendChild(option);
    }
  }

  async function createMonthlyIncomeChart() {

    // Check for token before fetching
    if (!token) {
      console.error("Authorization token not found. Access denied.");
      if (myBarChart) myBarChart.destroy();
      return;
    }

    try {
      // Get the currently selected year from the dropdown
      const selectedYear = document.getElementById('yearSelector').value;
      if (!selectedYear) {
        console.warn("No year selected.");
        return;
      }

      // Check if this specific chart instance already exists. If so, destroy it.
      if (myBarChart) {
        myBarChart.destroy();
      }

      // 1. Fetch the data from your API endpoint
      // --- FIX: Add Authorization Header ---
      const responseRaw = await fetch('http://localhost/software_engineering/backend/orders/rate_income', {
        method: 'GET',
        headers: {
          'Content-Type': 'application/json',
          'Authorization': `Bearer ${token}`
        }
      });
      // --- END FIX ---

      if (!responseRaw.ok) {
        throw new Error(`HTTP error! Status: ${responseRaw.status}`);
      }
      const responseData = await responseRaw.json();

      if (!responseData.success || !Array.isArray(responseData.data)) {
        console.error('API response format error or unsuccessful:', responseData);
        throw new Error('Invalid API response structure or failure.');
      }
      const apiData = responseData.data;

      // 2. Aggregate Daily Data into Monthly Totals (NEW LOGIC) 📈
      const aggregatedMonthlyTotals = new Map(); // Key: "YYYY-MM", Value: total income for that month

      apiData.forEach(item => {
        // Your API uses "day": "YYYY-MM-DD", but you need "YYYY-MM"
        const dayKey = item.day;
        const monthKey = dayKey ? dayKey.substring(0, 7) : null; // Extracts "YYYY-MM"
        const dailyIncome = parseFloat(item.total);

        // Check for valid data format
        if (monthKey && !isNaN(dailyIncome)) {
          // Get current total for the month, or 0 if undefined
          const currentTotal = aggregatedMonthlyTotals.get(monthKey) || 0;
          // Add the current day's income to the month's total
          aggregatedMonthlyTotals.set(monthKey, currentTotal + dailyIncome);
        }
      });

      // 3. Create the 12-Month Template for the SELECTED YEAR 🗓️
      const chartLabels = [];
      const chartDataPoints = [];
      let maxIncome = 0;

      for (let i = 1; i <= 12; i++) { // Loop 1 (Jan) to 12 (Dec)
        const month = i;
        const monthString = month.toString().padStart(2, '0');

        // Key format "YYYY-MM" (e.g., "2025-01")
        const monthKey = `${selectedYear}-${monthString}`;

        // Label format "Month YYYY" (e.g., "January 2025")
        const label = `${monthNames[month]}`;
        chartLabels.push(label); // Push the month name as the label

        // Get the total from the aggregated map, or default to 0
        const monthlyTotal = aggregatedMonthlyTotals.get(monthKey) || 0;
        chartDataPoints.push(monthlyTotal);

        if (monthlyTotal > maxIncome) {
          maxIncome = monthlyTotal; // Update the max
        }
      }

      // 4. Calculate a dynamic 'max' for the Y-axis
      // If data exists, scale up by 20% and round up. If no data, use a fallback max of 5000.
      const yAxisMax = maxIncome > 0 ? Math.ceil(maxIncome * 1.2) : 5000;

      // 5. Get the chart canvas and create the new Chart
      var ctx = document.getElementById("myBarChart");
      if (!ctx) {
        console.warn("Chart canvas element 'myBarChart' not found.");
        return;
      }

      myBarChart = new Chart(ctx, {
        type: 'bar',
        data: {
          labels: chartLabels, // 12 labels for the selected year
          datasets: [{
            label: "Revenue (RM)",
            backgroundColor: "rgba(2,117,216,1)",
            borderColor: "rgba(2,117,216,1)",
            data: chartDataPoints, // 12 data points
          }],
        },
        options: {
          animation: {
            duration: 0
          },
          scales: {
            xAxes: [{
              time: {
                unit: 'month'
              },
              gridLines: {
                display: false
              },
              ticks: {
                // Forces all 12 month labels to show
                autoSkip: false
              }
            }],
            yAxes: [{
              ticks: {
                min: 0,
                // Ensure tick is an integer if possible, and scale is good
                max: yAxisMax, // <-- Dynamic scaling applied here
                maxTicksLimit: 8 // Increased to 8 for better scale visualization
              },
              gridLines: {
                display: true
              }
            }],
          },
          legend: {
            display: false
          }
        }
      });

    } catch (error) {
      console.error("Failed to fetch data or create chart:", error);
    }
  }

  // --- Initialization and Event Handling ---

  // 1. Create the dropdown options first
  populateYearDropdown();

  // 2. Run it once immediately on page load
  createMonthlyIncomeChart();

  // 3. Set it to run again every 10 seconds (10000 milliseconds) for live data updates
  setInterval(createMonthlyIncomeChart, 10000);

  // 4. Add an event listener to update the chart immediately when the user changes the year.
  document.getElementById('yearSelector').addEventListener('change', createMonthlyIncomeChart);

});