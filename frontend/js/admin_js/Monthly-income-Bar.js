// Set new default font family and font color to mimic Bootstrap's default styling
Chart.defaults.global.defaultFontFamily = '-apple-system,system-ui,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif';
Chart.defaults.global.defaultFontColor = '#292b2c';

// Helper array to convert month numbers (like 11) to names (like "November")
// Note: We use an empty string at index 0 so that 1 maps to "January", 2 to "February", etc.
const monthNames = [
  "", "January", "February", "March", "April", "May", "June",
  "July", "August", "September", "October", "November", "December"
];

// We wrap the chart creation in an async function
// This allows us to 'await' the data from the API before building the chart
async function createMonthlyIncomeChart() {
  try {
    // 1. Fetch the data from your API endpoint
    const response = await fetch('http://localhost/software_engineering/backend/orders/rate_income');
    if (!response.ok) {
      throw new Error(`HTTP error! Status: ${response.status}`);
    }
    const apiData = await response.json();

    // 2. Process the API data into arrays Chart.js can understand
    const chartLabels = [];
    const chartDataPoints = [];

    let maxIncome = 0; // To dynamically set the chart's max Y-axis

    apiData.forEach(item => {
      // Use the month number (e.g., 11) to get the name ("November")
      chartLabels.push(monthNames[item.month]);

      // Convert the total (which is a string "48.00") to a number (48.00)
      const income = parseFloat(item.total);
      chartDataPoints.push(income);

      // Keep track of the highest value for the chart's Y-axis
      if (income > maxIncome) {
        maxIncome = income;
      }
    });

    // 3. Calculate a dynamic 'max' for the Y-axis (e.g., 20% padding)
    // This makes the chart look better than ending exactly at the max value
    const yAxisMax = Math.ceil(maxIncome * 1.2);

    // 4. Get the chart canvas and create the new Chart
    var ctx = document.getElementById("myBarChart");
    var myLineChart = new Chart(ctx, {
      type: 'bar',
      data: {
        labels: chartLabels, // <-- Use dynamic labels
        datasets: [{
          label: "Revenue",
          backgroundColor: "rgba(2,117,216,1)",
          borderColor: "rgba(2,117,216,1)",
          data: chartDataPoints, // <-- Use dynamic data
        }],
      },
      options: {
        scales: {
          xAxes: [{
            time: {
              unit: 'month'
            },
            gridLines: {
              display: false
            },
            ticks: {
              // Use the number of labels we found, or 6 (whichever is less)
              maxTicksLimit: chartLabels.length > 6 ? 6 : chartLabels.length
            }
          }],
          yAxes: [{
            ticks: {
              min: 0,
              max: yAxisMax, // <-- Use dynamic max value
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
    // You could show an error message on the page here
  }
}

// Call the function to run everything
createMonthlyIncomeChart();