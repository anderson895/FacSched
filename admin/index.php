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
                        <h2 id="total-teachers">0</h2>
                    </div>
                </div>
            </div>

            <!-- Total Subjects Card -->
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title text-success">Total Subjects</h5>
                        <h2 id="total-subjects">0</h2>
                    </div>
                </div>
            </div>

            <!-- Total Sections Card -->
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title text-warning">Total Sections</h5>
                        <h2 id="total-sections">0</h2>
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

   

<?php 
include "components/footer.php";
?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
<script src="js/statistics.js"></script>