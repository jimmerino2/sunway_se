// Global chart variable
let myLineChart;
let allApiData = []; // This will store all data from the API

// Set new default font family and font color
Chart.defaults.global.defaultFontFamily = 'Inter, -apple-system,system-ui,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif';
Chart.defaults.global.defaultFontColor = '#292b2c';

// Wait for the DOM to be ready
document.addEventListener('DOMContentLoaded', () => {

  // --- This is the *initial* fetch call ---
  fetch('http://localhost/software_engineering/backend/orders/rate_orders')
    .then(response => {
      if (!response.ok) {
        throw new Error(`HTTP error! status: ${response.status}`);
      }
      return response.json();
    })
    .then(apiResponse => {
      if (apiResponse.success && Array.isArray(apiResponse.data)) {
        // Store the fetched data globally
        allApiData = new Map(apiResponse.data.map(d => [d.day, d.total]));

        // Initialize the app (creates chart, daterangepicker)
        initializeApp();

        // --- ADDED THIS LINE ---
        // Start the 10-second auto-update timer
        setInterval(fetchAndRefreshChart, 10000);
        // --- END OF ADDED LINE ---

      } else {
        console.error('API response was not successful or data is missing:', apiResponse.message);
      }
    })
    .catch(error => console.error('Error fetching data:', error));
});

// ---
// --- NEW FUNCTION TO HANDLE LIVE UPDATES ---
// ---

/**
 * Fetches new data from the API, updates the global data store,
 * and refreshes the chart using the currently selected date range.
 */
function fetchAndRefreshChart() {
  console.log("Auto-refreshing chart data..."); // For debugging

  fetch('http://localhost/software_engineering/backend/orders/rate_orders')
    .then(response => {
      if (!response.ok) {
        throw new Error(`HTTP error! status: ${response.status}`);
      }
      return response.json();
    })
    .then(apiResponse => {
      if (apiResponse.success && Array.isArray(apiResponse.data)) {

        // 1. Update the global data store with the fresh data
        allApiData = new Map(apiResponse.data.map(d => [d.day, d.total]));

        // 2. Get the daterangepicker instance to find its current range
        const picker = $('#myDateRange').data('daterangepicker');

        if (picker) {
          // 3. Re-render the chart with the *current* date range
          updateChart(picker.startDate, picker.endDate);
          console.log("Chart refreshed with new data.");
        } else {
          // This might happen if the fetch completes before the picker is initialized
          console.warn("Could not find daterangepicker instance to refresh chart.");
        }
      } else {
        console.error('Auto-refresh: API response error:', apiResponse.message);
      }
    })
    .catch(error => console.error('Error auto-refreshing data:', error));
}

// ---
// --- (Rest of your code is unchanged) ---
// ---

/**
 * Initializes the daterangepicker and the chart.
 */
function initializeApp() {
  // 1. Initialize the Chart.js canvas
  initChart();

  // 2. Set up the daterangepicker
  // Set default range to "This Month"
  const start = moment().startOf('month');
  const end = moment().endOf('month');

  $('#myDateRange').daterangepicker({
    startDate: start,
    endDate: end,

    // --- UPDATED RANGES ---
    ranges: {
      'This Week': [moment().startOf('week'), moment().endOf('week')],
      'Last Week': [moment().subtract(1, 'week').startOf('week'), moment().subtract(1, 'week').endOf('week')],
      'Last 30 Days': [moment().subtract(29, 'days'), moment()],
      'This Month': [moment().startOf('month'), moment().endOf('month')],
      'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
    }
    // --- END OF UPDATED RANGES ---

  }, (startDate, endDate) => {
    // This callback function runs every time a new date range is applied
    updateChart(startDate, endDate);
  });

  // 3. Render the chart with the default date range ("This Month")
  updateChart(start, end);
}


/**
 * Initializes the Chart.js instance.
 */
function initChart() {
  const ctx = document.getElementById("myAreaChart").getContext('2d');
  myLineChart = new Chart(ctx, {
    type: 'line',
    data: {
      labels: [], // Populated by updateChart()
      datasets: [{
        label: "Orders",
        lineTension: 0.3,
        backgroundColor: "rgba(2,117,216,0.2)",
        borderColor: "rgba(2,117,216,1)",
        pointRadius: 5,
        pointBackgroundColor: "rgba(2,117,216,1)",
        pointBorderColor: "rgba(255,255,255,0.8)",
        pointHoverRadius: 5,
        pointHoverBackgroundColor: "rgba(2,117,216,1)",
        pointHitRadius: 50,
        pointBorderWidth: 2,
        data: [], // Populated by updateChart()
      }],
    },
    options: {
      scales: {
        xAxes: [{
          gridLines: {
            display: false
          },
          ticks: {
            // We'll set maxTicksLimit dynamically in updateChart
          }
        }],
        yAxes: [{
          ticks: {
            min: 0,
            maxTicksLimit: 5,
            // Add a callback to format ticks as integers
            callback: function (value) {
              if (Number.isInteger(value)) {
                return value;
              }
            }
          },
          gridLines: {
            color: "rgba(0, 0, 0, .125)",
          }
        }],
      },
      legend: {
        display: false
      },
      tooltips: {
        callbacks: {
          label: function (tooltipItem, data) {
            let label = data.datasets[tooltipItem.datasetIndex].label || '';
            if (label) {
              label += ': ';
            }
            label += tooltipItem.yLabel;
            return label;
          }
        }
      }
    }
  });
}

/**
 * Updates the chart with data from the selected date range.
 * This function is now called by the daterangepicker AND the auto-refresher.
 *
 * @param {moment} startDate - The start of the date range
 * @param {moment} endDate - The end of the date range
 */
function updateChart(startDate, endDate) {
  if (!myLineChart) return; // Don't run if chart isn't initialized

  let chartLabels = [];
  let chartData = [];

  // --- 1. Populate chart arrays ---
  // Loop from the start date to the end date, one day at a time
  for (let m = moment(startDate); m.isSameOrBefore(endDate, 'day'); m.add(1, 'day')) {

    // Use 'MMM D' (e.g., "Nov 10") as the label
    chartLabels.push(m.format('MMM D'));

    // Get the data from our global Map.
    // Use the 'YYYY-MM-DD' format to match the API data.
    const dayKey = m.format('YYYY-MM-DD');
    chartData.push(allApiData.get(dayKey) || 0); // Use 0 if no data for that day
  }

  // --- 2. Update the chart instance ---
  myLineChart.data.labels = chartLabels;
  myLineChart.data.datasets[0].data = chartData;

  // --- 3. Dynamically set Y-axis max (with the fix) ---
  const maxDataValue = Math.max(...chartData, 0);
  const newMax = (maxDataValue === 0) ? 5 : Math.ceil(maxDataValue * 1.2);
  myLineChart.options.scales.yAxes[0].ticks.max = newMax;

  // --- 4. Adjust X-axis ticks based on range length ---
  // If we have more than 14 days, only show 7 ticks. Otherwise, show all.
  const daysInRange = chartLabels.length;
  myLineChart.options.scales.xAxes[0].ticks.maxTicksLimit = (daysInRange > 14) ? 7 : daysInRange;

  // --- 5. Render the changes ---
  myLineChart.update();
}