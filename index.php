<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin and Faculty Cards</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Optional Icon Library (Offline Example) -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
<body class="bg-dark">
<?php include "function/PageLoader.php";?>


<div class="d-flex vh-100 align-items-center justify-content-center">
    <div class="row g-4">
        <!-- Admin Card -->
        <div class="col-md-6 d-flex justify-content-center">
            <div class="card text-center shadow" style="width: 18rem;">
                <div class="card-body">
                    <div class="icon mb-3">
                        <i class="fas fa-user-shield fa-3x text-primary"></i>
                    </div>
                    <h5 class="card-title">Admin</h5>
                    <a href="admin.php" class="btn btn-primary">Login As Admin</a>
                </div>
            </div>
        </div>
        <!-- Faculty Card -->
        <div class="col-md-6 d-flex justify-content-center">
            <div class="card text-center shadow" style="width: 18rem;">
                <div class="card-body">
                    <div class="icon mb-3">
                        <i class="fas fa-chalkboard-teacher fa-3x text-success"></i>
                    </div>
                    <h5 class="card-title">Faculty</h5>
                    <a href="teacher.php" class="btn btn-success">Login As Teacher</a>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
