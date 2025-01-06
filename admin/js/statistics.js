$(document).ready(function() {
    // Initialize the chart
    var options = {
        chart: {
            type: 'bar',
            height: 350,
            animations: {
                enabled: true,
                easing: 'easeinout',
                speed: 800,
            }
        },
        series: [{
            name: 'Total',
            data: [0, 0, 0] // Initialize with default data
        }],
        xaxis: {
            categories: ['Teachers', 'Subjects', 'Sections'],
            labels: {
                style: {
                    fontSize: '14px',
                    fontWeight: '500',
                    colors: ['#333']
                }
            }
        },
        yaxis: {
            title: {
                text: 'Count',
                style: {
                    fontSize: '14px',
                    fontWeight: '500',
                    color: '#333'
                }
            },
            labels: {
                style: {
                    fontSize: '12px',
                    fontWeight: '500',
                    colors: ['#333']
                }
            }
        },
        colors: ['#007bff', '#28a745', '#ffc107'],
        title: {
            text: 'Dashboard Overview',
            align: 'center',
            style: {
                fontSize: '20px',
                fontWeight: '600',
                color: '#333'
            }
        },
        plotOptions: {
            bar: {
                horizontal: false,
                endingShape: 'rounded',
            }
        },
        grid: {
            show: true,
            borderColor: '#f1f1f1',
            strokeDashArray: 3,
            yaxis: {
                lines: {
                    show: true
                }
            }
        }
    };

    // Create the chart instance
    var chart = new ApexCharts(document.querySelector("#chart"), options);
    chart.render();

    // Function to fetch and update the statistics
    function fetchStatistics() {
        $.ajax({
            url: 'backend/end-points/statistics.php',
            type: 'GET',
            data: { requestType: 'statistics' },
            success: function(response) {
                console.log(response);
                if (response) {
                    // Update the DOM elements
                    $('#total-subjects').text(response.total_curriculum);
                    $('#total-sections').text(response.total_section);
                    $('#total-teachers').text(response.total_faculty);

                    // Update the chart series dynamically
                    chart.updateSeries([{
                        name: 'Total',
                        data: [response.total_faculty, response.total_curriculum, response.total_section]
                    }]);

                } else {
                    // If no data is returned or there's an error
                    alert('Error: Could not fetch statistics');
                }
            },
            error: function(xhr, status, error) {
                // Handle error during AJAX request
                alert('AJAX Error: ' + error);
            }
        });
    }

    // Fetch data initially
    fetchStatistics();

    // Set interval to fetch data every 5 seconds (5000 milliseconds)
    setInterval(fetchStatistics, 5000);
});
