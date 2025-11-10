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

      // 1. Create the 12-Month Template FOR THE SELECTED YEAR
      const monthlyDataMap = new Map();

      for (let i = 1; i <= 12; i++) { // Loop 1 (Jan) to 12 (Dec)
        const month = i;

        // Key format "YYYY-MM" (e.g., "2025-01")
        const monthKey = `${selectedYear}-${month.toString().padStart(2, '0')}`;

        // Label format "Month YYYY" (e.g., "January 2025")
        const label = `${monthNames[month]} ${selectedYear}`;

        // Add this month to our template with 0 income
        monthlyDataMap.set(monthKey, { label: label, income: 0 });
      }

      // 2. Fetch the data from your API endpoint
      const responseRaw = await fetch('http://localhost/software_engineering/backend/orders/rate_income');
      if (!responseRaw.ok) {
        throw new Error(`HTTP error! Status: ${responseRaw.status}`);
      }
      const responseData = await responseRaw.json();

      if (!responseData.success || !Array.isArray(responseData.data)) {
        console.error('API response format error or unsuccessful:', responseData);
        throw new Error('Invalid API response structure or failure.');
      }
      const apiData = responseData.data;

      // 3. Merge API Data into the Template
      apiData.forEach(item => {
        const monthKey = item.month; // "YYYY-MM"
        const income = parseFloat(item.total);

        // If this data from the API exists in our 12-month template,
        // update its income value.
        if (monthlyDataMap.has(monthKey)) {
          monthlyDataMap.get(monthKey).income = income;
        }
      });

      // 4. Generate Chart Arrays FROM THE TEMPLATE and find max income
      const chartLabels = [];
      const chartDataPoints = [];
      let maxIncome = 0; // Tracks the highest income found

      for (const data of monthlyDataMap.values()) {
        chartLabels.push(data.label);
        chartDataPoints.push(data.income);
        if (data.income > maxIncome) {
          maxIncome = data.income; // Update the max
        }
      }

      // 5. Calculate a dynamic 'max' for the Y-axis
      // If data exists, scale up by 20% and round up. If no data, use a fallback max of 5000.
      const yAxisMax = maxIncome > 0 ? Math.ceil(maxIncome * 1.2) : 5000;

      // 6. Get the chart canvas and create the new Chart
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
            label: "Revenue",
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
                max: yAxisMax, // <-- Dynamic scaling applied here
                maxTicksLimit: 5
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