<?php 
include "components/header.php";
?>
 <link rel="stylesheet" href="css/style.css">


<div class="container-fluid">
        <div class="row">
            <!-- Total Teachers Card -->
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title text-primary">Total Teachers</h5>
                        <h2 id="total-teachers">150</h2>
                    </div>
                </div>
            </div>

            <!-- Total Subjects Card -->
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title text-success">Total Subjects</h5>
                        <h2 id="total-subjects">30</h2>
                    </div>
                </div>
            </div>

            <!-- Total Sections Card -->
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title text-warning">Total Sections</h5>
                        <h2 id="total-sections">12</h2>
                    </div>
                </div>
            </div>
        </div>

        <!-- Chart Section -->
        <div class="row">
            <!-- Interactive Bar Chart -->
            <div class="col-12">
                <div id="chart"></div>
            </div>
        </div>
    </div>

    <script>
        // Initialize ApexCharts with animation and customized color scheme
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
                data: [150, 30, 12] // Example data for Total Teachers, Total Subjects, Total Sections
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
            colors: ['#007bff', '#28a745', '#ffc107'], // Custom colors
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

        var chart = new ApexCharts(document.querySelector("#chart"), options);
        chart.render();
    </script>

<?php 
include "components/footer.php";
?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>