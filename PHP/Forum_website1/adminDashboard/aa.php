<?php
session_start();
include '../Partials/db_connection.php';

// Verify if admin is logged in
if (!isset($_SESSION['admin_id'])) {
    header('Location: admin_login.php');
    exit();
}

$admin_id = $_SESSION['admin_id'];
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        /* Sidebar Styling */
        .sidebar {
            background-color: #343a40;
            color: white;
            height: 100vh;
            width: 250px;
            position: fixed;
            top: 0;
            left: 0;
            z-index: 1030;
            overflow-y: auto;
            padding-top: 20px;
            transition: transform 0.3s ease;
        }

        .sidebar.hidden {
            transform: translateX(-250px);
        }

        .sidebar a {
            color: #ddd;
            padding: 15px 20px;
            text-decoration: none;
            display: block;
            font-size: 1rem;
        }

        .sidebar a:hover {
            background-color: #495057;
            color: white;
        }

        .sidebar h4 {
            text-align: center;
            margin-bottom: 20px;
        }

        /* Navbar Styling */
        .navbar {
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            z-index: 1040;
        }

        .navbar .navbar-brand {
            margin: 0 auto;
            font-weight: bold;
            font-size: 1.5rem;
        }

        /* Hamburger Icon */
        .hamburger {
            font-size: 1.5rem;
            cursor: pointer;
            color: white;
            display: none;
        }

        @media (max-width: 768px) {
            .hamburger {
                display: block;
            }
        }

        /* Main Content */
        .main-content {
            margin-left: 250px;
            padding: 20px;
            transition: margin-left 0.3s ease;
        }

        .main-content.collapsed {
            margin-left: 0;
        }

        /* Media Queries for Responsiveness */
        @media (max-width: 768px) {
            .sidebar {
                width: 200px;
            }

            .main-content {
                margin-left: 0;
            }
        }
    </style>
</head>

<body>

    <!-- Navbar -->
    <nav class="navbar navbar-dark bg-dark fixed-top">
        <div class="container-fluid">
            <span class="hamburger" id="hamburger"><i class="bi bi-list"></i></span>
            <span class="navbar-brand">Welcome Admin</span>
        </div>
    </nav>

    <!-- Sidebar -->
    <div class="sidebar" id="sidebar">
        <h4>Admin Panel</h4>
        <a href="admin_dashboard.php" class="bg-primary"><i class="bi bi-speedometer2"></i> Dashboard</a>
        <a href="manage_users.php"><i class="bi bi-people"></i> Manage Users</a>
        <a href="add_category.php"><i class="bi bi-folder-plus"></i> Add Category</a>
        <a href="manage_category.php"><i class="bi bi-folder"></i> Manage Categories</a>
        <a href="manage_posts.php"><i class="bi bi-file-earmark-text"></i> Manage Posted Questions</a>
        <a href="manage_comments.php"><i class="bi bi-chat-dots"></i> Manage Comments</a>
        <a href="change_password.php"><i class="bi bi-key"></i> Change Password</a>
        <a href="admin_profile.php"><i class="bi bi-person-circle"></i> Profile</a>
        <a href="admin_logout.php"><i class="bi bi-box-arrow-right"></i> Logout</a>
    </div>

    <!-- Main Content -->
    <div class="main-content" id="main-content">
        <div class="container mt-5">
            <div class="row g-4">
                <!-- Total Users -->
                <div class="col-md-6 col-lg-3">
                    <div class="card text-white bg-primary shadow">
                        <div class="card-body text-center">
                            <i class="bi bi-people display-4"></i>
                            <h4 class="card-title mt-3">Total Users</h4>
                            <p class="card-text fs-4">123</p>
                        </div>
                    </div>
                </div>

                <!-- Total Categories -->
                <div class="col-md-6 col-lg-3">
                    <div class="card text-white bg-success shadow">
                        <div class="card-body text-center">
                            <i class="bi bi-folder display-4"></i>
                            <h4 class="card-title mt-3">Total Categories</h4>
                            <p class="card-text fs-4">12</p>
                        </div>
                    </div>
                </div>

                <!-- Total Posts -->
                <div class="col-md-6 col-lg-3">
                    <div class="card text-white bg-warning shadow">
                        <div class="card-body text-center">
                            <i class="bi bi-file-earmark-text display-4"></i>
                            <h4 class="card-title mt-3">Total Posts</h4>
                            <p class="card-text fs-4">456</p>
                        </div>
                    </div>
                </div>

                <!-- Total Comments -->
                <div class="col-md-6 col-lg-3">
                    <div class="card text-white bg-danger shadow">
                        <div class="card-body text-center">
                            <i class="bi bi-chat-dots display-4"></i>
                            <h4 class="card-title mt-3">Total Comments</h4>
                            <p class="card-text fs-4">789</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap 5 JS and Popper.js -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>

    <!-- Sidebar Toggle Script -->
    <script>
        const sidebar = document.getElementById('sidebar');
        const mainContent = document.getElementById('main-content');
        const hamburger = document.getElementById('hamburger');

        // Toggle sidebar visibility
        hamburger.addEventListener('click', () => {
            sidebar.classList.toggle('hidden');
            mainContent.classList.toggle('collapsed');
        });
    </script>

</body>

</html>
<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel = "stylesheet" href ="Partials/style.css">

    <title>Hello, world!</title>
  </head>
  <body>
<!-- included the _header file where is my navbar  -->
    <?php  include"Partials/_header.php"?>
    <?php  include"Partials/db_connection.php"?>
    <?php  include"Partials/login_modal.php"?>
    <?php  include"Partials/signup_modal.php"?>
    <?php  include"Partials/admin_login_modal.php"?>

    <div id="carouselExampleIndicators" class="carousel slide" data-bs-ride="carousel">
  <div class="carousel-indicators">
    <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
    <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="1" aria-label="Slide 2"></button>
    <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="2" aria-label="Slide 3"></button>
  </div>

  <div class="carousel-inner">
    <div class="carousel-item active">
      <img src="images/code1.png"  class="d-block w-100" alt="Images">
    </div>
    <div class="carousel-item">
      <img src="images/code2.png"  class="d-block w-100 " alt="Images">
    </div>
    <div class="carousel-item">
      <img src="images/code3.png"  class="d-block w-100 " alt="Images">
    </div>
  </div>
  <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="prev">
    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
    <span class="visually-hidden">Previous</span>
  </button>
  <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="next">
    <span class="carousel-control-next-icon" aria-hidden="true"></span>
    <span class="visually-hidden">Next</span>
  </button>
</div>
 
<!-- cards under grid for showing category -->
 <div class="container mt-4 ">
    <h3 class="text-center bg-danger p-2 rounded">Categories </h3>
<!-- using a grid of bs -->
    <div class="row g-4 my-2">
       
       <?php
          $sql = "SELECT * FROM `category`"; // Adjust table name as needed
          $result = mysqli_query($conn, $sql);

          while ($fetch = mysqli_fetch_assoc($result)) {
            echo '
            <div class="col-lg-4 col-md-6 col-sm-12">
                <div class="card">
                    <img src="' . $fetch['category_image'] . '" class="card-img-top" alt="' . $fetch['category_name'] . '">
                    <div class="card-body">
                        <h4 class="card-title">
                            <a class="text-decoration-none" href="thread_list.php?id=' . $fetch['category_id'] . '"> 
                                ' . $fetch['category_name'] . ' 
                            </a>
                        </h4>
                        <p class="card-text">' . substr($fetch['category_desc'], 0, 90) . '... </p>
                        <a href="thread_list.php?id=' . $fetch['category_id'] . '" class="btn btn-primary">Visit thread</a>
                    </div>
                </div>
            </div>';
        
          }
        ?>
    </div>
</div>









    <!-- Optional JavaScript; choose one of the two! -->

    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

    <!-- Option 2: Separate Popper and Bootstrap JS -->
    <!--
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
    -->

    <?php include "Partials/_footer.php"  ?>
  </body>
</html>
