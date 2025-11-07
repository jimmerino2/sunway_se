// Set new default font family and font color
Chart.defaults.global.defaultFontFamily = '-apple-system,system-ui,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif';
Chart.defaults.global.defaultFontColor = '#292b2c';

// Helper array to convert month numbers
const monthNames = [
  "", "January", "February", "March", "April", "May", "June",
  "July", "August", "September", "October", "November", "December"
];

// Declare a unique chart variable for this file
let myBarChart;

async function createMonthlyIncomeChart() {
  try {
    // Check if this specific chart instance already exists. If so, destroy it.
    if (myBarChart) {
      myBarChart.destroy();
    }

    // 1. Fetch the data from your API endpoint
    const response = await fetch('http://localhost/software_engineering/backend/orders/rate_income');
    if (!response.ok) {
      throw new Error(`HTTP error! Status: ${response.status}`);
    }
    const apiData = await response.json();

    // 2. Process the API data
    const chartLabels = [];
    const chartDataPoints = [];
    let maxIncome = 0;

    apiData.forEach(item => {
      chartLabels.push(monthNames[item.month]);
      const income = parseFloat(item.total);
      chartDataPoints.push(income);
      if (income > maxIncome) {
        maxIncome = income;
      }
    });

    // 3. Calculate a dynamic 'max' for the Y-axis
    const yAxisMax = Math.ceil(maxIncome * 1.2);

    // 4. Get the chart canvas and create the new Chart
    var ctx = document.getElementById("myBarChart");

    // Assign to the unique 'myBarChart' variable
    myBarChart = new Chart(ctx, {
      type: 'bar',
      data: {
        labels: chartLabels,
        datasets: [{
          label: "Revenue",
          backgroundColor: "rgba(2,117,216,1)",
          borderColor: "rgba(2,117,216,1)",
          data: chartDataPoints,
        }],
      },
      options: {
        // Add this to prevent the flashing animation on every update
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
              maxTicksLimit: chartLabels.length > 6 ? 6 : chartLabels.length
            }
          }],
          yAxes: [{
            ticks: {
              min: 0,
              max: yAxisMax,
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

// Call the function to run everything

// 1. Run it once immediately on page load
createMonthlyIncomeChart();

// 2. Set it to run again every 10 seconds (10000 milliseconds)
setInterval(createMonthlyIncomeChart, 10000);