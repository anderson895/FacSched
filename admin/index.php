<?php 
include "components/header.php";
?>
<link rel="stylesheet" href="css/style.css">

<div class="container-fluid py-4">
    <div class="row">
        <!-- Total Teachers Card -->
        <div class="col-lg-4 col-md-6 mb-4">
            <div class="card shadow-lg border-0 rounded-3">
                <div class="card-body">
                    <h5 class="card-title text-primary">Total Teachers</h5>
                    <h2 id="total-teachers" class="fw-bold">0</h2>
                </div>
            </div>
        </div>

        <!-- Total Subjects Card -->
        <div class="col-lg-4 col-md-6 mb-4">
            <div class="card shadow-lg border-0 rounded-3">
                <div class="card-body">
                    <h5 class="card-title text-success">Total Subjects</h5>
                    <h2 id="total-subjects" class="fw-bold">0</h2>
                </div>
            </div>
        </div>

        <!-- Total Sections Card -->
        <div class="col-lg-4 col-md-6 mb-4">
            <div class="card shadow-lg border-0 rounded-3">
                <div class="card-body">
                    <h5 class="card-title text-warning">Total Sections</h5>
                    <h2 id="total-sections" class="fw-bold">0</h2>
                </div>
            </div>
        </div>
    </div>


 


    <!-- Chart Section -->
    <div class="row">
        <!-- Interactive Bar Chart -->
        <div class="col-12">
            <div id="chart" class="bg-light p-3 rounded-3 shadow-sm">
                <!-- The chart will be rendered here -->
            </div>
        </div>
    </div>

    
    <div class="row">
        <!-- Interactive Bar Chart -->
        <div class="col-12">
            <div id="chartSections" class="bg-light p-3 rounded-3 shadow-sm">
                <!-- The chart will be rendered here -->
            </div>
        </div>
    </div>
   
</div>

<?php 
include "components/footer.php";
?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
<script src="js/statistics.js"></script>
