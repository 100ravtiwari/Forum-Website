<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="Partials/style.css">

    <title>iDiscuss</title>

    <style>
  .card-img-top {
    height: 200px; /* Set a fixed height */
    width: 100%; /* Make the width fill the card */
    object-fit: cover; /* Ensures the image scales without distortion */
    border-radius: 5px; /* Optional: Add some rounding to the image corners */
  }

  .card {
    margin-bottom: 20px; /* Add some spacing between cards */
  }
</style>
  </head>
  <body>

    <!-- included the _header file where is my navbar  -->
    <?php include "Partials/_header.php"; ?>
    <?php include "Partials/db_connection.php"; ?>
    <?php include "Partials/login_modal.php"; ?>
    <?php include "Partials/signup_modal.php"; ?>
    <?php include "Partials/admin_login_modal.php"; ?>

    <!-- Carousel Section -->
    <div id="carouselExampleIndicators" class="carousel slide" data-bs-ride="carousel">
      <div class="carousel-indicators">
        <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
        <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="1" aria-label="Slide 2"></button>
        <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="2" aria-label="Slide 3"></button>
      </div>

      <div class="carousel-inner">
        <div class="carousel-item active">
          <img src="images/code1.png" class="d-block w-100" alt="Images">
        </div>
        <div class="carousel-item">
          <img src="images/code2.jpg" class="d-block w-100 " alt="Images">
        </div>
        <div class="carousel-item">
          <img src="images/code3.jpg" class="d-block w-100 " alt="Images">
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

    <!-- Categories Section -->
    <div class="container mt-4">
      <h3 class="text-center bg-danger p-2 rounded">Categories</h3>

      <!-- Grid Layout for Categories -->
      <div class="row g-4 my-2">
        
        <?php
        // SQL Query to fetch categories
        $sql = "SELECT * FROM `category`"; // Ensure the correct table name
        $result = mysqli_query($conn, $sql);

        // Loop through categories and display each category
        while ($fetch = mysqli_fetch_assoc($result)) {
          // Assuming the image path is stored in `category_image` field
          $image_path = "uploads/" . $fetch['category_image']; // Adjust path if necessary
          echo '
          <div class="col-lg-4 col-md-6 col-sm-12">
            <div class="card">
              <!-- Display Image -->
              <img src="' . $image_path . '" class="card-img-top" alt="' . $fetch['category_name'] . '">
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

    <!-- Optional JavaScript -->
    <!-- Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

    <?php include "Partials/_footer.php"; ?>

  </body>
</html>
