<?php 
session_start();
include('backend/class.php');

$db = new global_class();
?>

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>FACSCHED</title>
  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

  <!-- SweetAlert2 CSS -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
  <!-- SweetAlert2 JS -->
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.js"></script>

  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/AlertifyJS/1.13.1/css/alertify.css" integrity="sha512-MpdEaY2YQ3EokN6lCD6bnWMl5Gwk7RjBbpKLovlrH6X+DRokrPRAF3zQJl1hZUiLXfo2e9MrOt+udOnHCAmi5w==" crossorigin="anonymous" referrerpolicy="no-referrer" />
  <script src="https://cdnjs.cloudflare.com/ajax/libs/AlertifyJS/1.13.1/alertify.min.js" integrity="sha512-JnjG+Wt53GspUQXQhc+c4j8SBERsgJAoHeehagKHlxQN+MtCCmFDghX9/AcbkkNRZptyZU4zC8utK59M5L45Iw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

  <link rel="stylesheet" href="css/header.css">
</head>

<body>
  <?php include "../function/PageLoader.php";?>

  <!-- Sidebar -->
  <div class="sidebar" id="sidebar">
    <div class="mb-4"></div>
    <a href="index.php">Dashboard</a>
    <a href="section.php">Sections</a>
    <a href="curriculum.php">Curriculum</a>
    
    <!-- Teachers Dropdown -->
    <ul class="navbar-nav">
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="teachersDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
          Teachers
        </a>
        <ul class="dropdown-menu bg-dark" aria-labelledby="teachersDropdown">
          <li><a class="dropdown-item" href="list_teachers.php">List of Teachers</a></li>
          <li><a class="dropdown-item" href="list_schedules.php">List of Schedules</a></li>
        </ul>
      </li>
    </ul>

    <a href="logout.php">Logout</a>
  </div>

  <!-- Header with Hamburger Menu -->
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container-fluid">
      <button class="navbar-toggler" type="button" id="toggleSidebar" aria-label="Toggle sidebar">
        <span class="navbar-toggler-icon"></span>
      </button>
      <a class="navbar-brand" href="#">
        <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSiQc01tubeOKno4VlBcUlZ-OEjad8ChfAYOw&s" alt="Logo" class="rounded-circle" style="width: 40px; height: 40px; object-fit: cover;">
      </a>

      <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav ms-auto">
          <li class="nav-item">
            <a class="nav-link" href="index.php">Dashboard</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="section.php">Sections</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="curriculum.php">Curriculum</a>
          </li>


          <li class="nav-item">
            <a class="nav-link" href="report.php">Reports</a>
          </li>

          <!-- Teachers Dropdown in Navbar -->
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="navbarTeachersDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
              Teachers
            </a>
            <ul class="dropdown-menu" aria-labelledby="navbarTeachersDropdown">
              <li><a class="dropdown-item" href="list_teachers.php">List of Teachers</a></li>
              <li><a class="dropdown-item" href="list_schedules.php">List of Schedules</a></li>
            </ul>
          </li>

          <li class="nav-item">
            <a class="nav-link" href="logout.php">Logout</a>
          </li>
        </ul>
      </div>
    </div>
  </nav>

  <!-- Main Content -->
  <div class="content">