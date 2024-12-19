<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Responsive Sidebar</title>
  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

  <link rel="stylesheet" href="css/header.css">
</head>
<body>

<?php include "../function/PageLoader.php";?>

  <!-- Sidebar -->
  <div class="sidebar" id="sidebar">
    <a href="#">Dashboard</a>
    <a href="section.php">Sections</a>
    <a href="#">Curriculum</a>
    <a href="#">Teachers</a>
    <a href="logout.php">Logout</a>
  </div>

  <!-- Header with Hamburger Menu -->
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container-fluid">
      <button class="navbar-toggler" type="button" id="toggleSidebar" aria-label="Toggle sidebar">
        <span class="navbar-toggler-icon"></span>
      </button>
      <a class="navbar-brand" href="#">Logo</a>
      <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav ms-auto">
          <li class="nav-item">
            <a class="nav-link" href="index.php">Dashboard</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="section.php">Sections</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#">Curriculum</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#">Teachers</a>
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
  