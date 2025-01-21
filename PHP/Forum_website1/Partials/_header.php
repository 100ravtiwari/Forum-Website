<?php session_start(); ?>
<?php include('db_connection.php'); ?>
<?php
if (isset($_SESSION['username'])) {
    $username = $_SESSION['username'];
    echo '
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container-fluid">
        <a class="navbar-brand" href="index.php">iDiscuss</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="index.php">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="about.php">About</a>
                </li>

                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Top categories
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="navbarDropdown">';

    //selecting category title in the dropdown --
    $sql2 = "SELECT * FROM `category` LIMIT 6 ";
    $result = mysqli_query($conn, $sql2);
    if ($result) {
        while ($fetch = mysqli_fetch_assoc($result)) {
            $title = $fetch['category_name'];
            $id = $fetch['category_id'];
            echo '
                                        <li><a class="dropdown-item" href="/PHP/Forum_website1/thread_list.php?id=' . $id . '">' . $title . '</a></li>
                                        ';
        }
    }

    echo '
                </ul>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="contact_form.php" tabindex="-1">Contact</a>
                </li>
            </ul>

           <form class="d-flex" action = "search.php?" method="GET">
                <input class="form-control me-2 ms-2 px-2 py-0" name = "query" type="search" placeholder="Search threads" aria-label="Search" required>
                <button class="btn btn-outline-success ms-2 px-2" type="submit">Search</button>

                <span class="nav-item text-light ms-4 my-2 me-0 ml-4">
                <div class="d-flex align-items-center mb-0 my-0">
                    <img src="images/user.png" style="width: 22px;" class="me-0 mt-0 rounded-pill border border-primary" alt="media-image">
                    <p class="mb-0 text-primary ms-2" style="margin-left: auto;">' . (substr($username, 0, 7)) . '</p> 
                </div>
               </span>

                <button class="btn btn-outline-success ms-2 px-2 " type="button">
                    <a href="Partials/_handle_logout.php" class="text-decoration-none text-success">Logout</a>
                </button>
               </form>


        </div>
    </div>
</nav>
';
} else {

    echo '
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="index.php">iDiscuss</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="index.php">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="about.php">About</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Categories
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="navbarDropdown">';
    // Fetch categories dynamically
    $sql2 = "SELECT * FROM `category` LIMIT 6";
    $result = mysqli_query($conn, $sql2);
    if ($result) {
        while ($fetch = mysqli_fetch_assoc($result)) {
            $title = $fetch["category_name"];
            $id = $fetch["category_id"];
            echo '<li><a class="dropdown-item" href="/PHP/Forum_website1/thread_list.php?id=' . $id . '">' . $title . '</a></li>';
        }
    }
    echo '
                        </ul>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="contact_form.php" tabindex="-1">Contact</a>
                    </li>
                </ul>
                <form class="d-flex align-items-center" action="search.php" method="GET">
    <!-- Search Input -->
    <input class="form-control me-2 ms-2 px-1 py-1 " name="query" type="search" placeholder="Search threads" aria-label="Search" required>

    <!-- Search Button -->
    <button class="btn btn-outline-success ms-2 px-2" type="submit">Search</button>

    <!-- Login Dropdown -->
    <div class="btn-group ms-2">
        <button class="btn btn-outline-success dropdown-toggle px-2" type="button" id="loginDropdown" data-bs-toggle="dropdown" aria-expanded="false">
            Login
        </button>
        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="loginDropdown">
            <li><a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#loginModal"> User Login</a></li>
            <li><a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#adminLoginModal"> Admin Login </a></li>
        </ul>
    </div>

    <!-- Signup Button -->
    <button class="btn btn-outline-success ms-2 px-2" data-bs-toggle="modal" type="button" data-bs-target="#signupModal">Signup</button>
</form>

            </div>
        </div>
    </nav>';




}

// Alert for existing username
if (isset($_GET['exist']) && $_GET['exist'] == 'true') {
    echo '<div class="alert alert-warning alert-dismissible fade show my-0" role="alert" m>
            <strong>Error!</strong> This username is already taken, try another name.
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>
          <script>
        // Set a timeout to automatically hide and remove the alert after 3 seconds
        setTimeout(function() {
            var alertElement = document.querySelector(".alert");
            if (alertElement) {
                alertElement.classList.remove("show");
                alertElement.classList.add("fade"); // Ensure the alert fades out smoothly
                // Remove the alert from the DOM after 0.5 seconds (fade time)
                setTimeout(function() {
                    alertElement.remove();
                }, 500); // Match the fade duration
            }
        }, 3000); // Hide alert after 3 seconds
    </script>';
}

// Check if the 'signupsuccess' parameter exists in the URL
if (isset($_GET['signupsuccess'])) {
    if ($_GET['signupsuccess'] == 'true') {
        echo '<div class="alert alert-success alert-dismissible fade show my-0" role="alert">
                <strong>Success!</strong> You have signed up successfully; now you can log in.
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
              </div>
              <script>
        // Set a timeout to automatically hide and remove the alert after 3 seconds
        setTimeout(function() {
            var alertElement = document.querySelector(".alert");
            if (alertElement) {
                alertElement.classList.remove("show");
                alertElement.classList.add("fade"); // Ensure the alert fades out smoothly
                // Remove the alert from the DOM after 0.5 seconds (fade time)
                setTimeout(function() {
                    alertElement.remove();
                }, 500); // Match the fade duration
            }
        }, 3000); // Hide alert after 3 seconds
    </script>';

    } elseif ($_GET['signupsuccess'] == 'false' && ($_GET['exist'] == 'false')) {
        echo '<div class="alert alert-warning alert-dismissible fade show my-0" role="alert">
                <strong>Error!</strong> password and confirm password should be same.
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
              </div>
              <script>
        // Set a timeout to automatically hide and remove the alert after 3 seconds
        setTimeout(function() {
            var alertElement = document.querySelector(".alert");
            if (alertElement) {
                alertElement.classList.remove("show");
                alertElement.classList.add("fade"); // Ensure the alert fades out smoothly
                // Remove the alert from the DOM after 0.5 seconds (fade time)
                setTimeout(function() {
                    alertElement.remove();
                }, 500); // Match the fade duration
            }
        }, 3000); // Hide alert after 3 seconds
    </script>';
    }
}


if (isset($_GET['username']) && ($_GET['password'])) {

    if (($_GET['username'] == 'true') && ($_GET['password'] == 'true')) {
        echo '<div class="alert alert-success alert-dismissible fade show my-0" role="alert">
        <strong>Success!</strong> You have successfully logged in.
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        <script>
        // Set a timeout to automatically hide and remove the alert after 3 seconds
        setTimeout(function() {
            var alertElement = document.querySelector(".alert");
            if (alertElement) {
                alertElement.classList.remove("show");
                alertElement.classList.add("fade"); // Ensure the alert fades out smoothly
                // Remove the alert from the DOM after 0.5 seconds (fade time)
                setTimeout(function() {
                    alertElement.remove();
                }, 500); // Match the fade duration
            }
        }, 3000); // Hide alert after 3 seconds
    </script>';
    } elseif (($_GET['username'] == 'false') && ($_GET['password'] == 'false')) {
        echo '<div class="alert alert-warning alert-dismissible fade show my-0" role="alert">
                    <strong>Error!</strong> No user found.
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                    <script>
        // Set a timeout to automatically hide and remove the alert after 3 seconds
        setTimeout(function() {
            var alertElement = document.querySelector(".alert");
            if (alertElement) {
                alertElement.classList.remove("show");
                alertElement.classList.add("fade"); // Ensure the alert fades out smoothly
                // Remove the alert from the DOM after 0.5 seconds (fade time)
                setTimeout(function() {
                    alertElement.remove();
                }, 500); // Match the fade duration
            }
        }, 3000); // Hide alert after 3 seconds
    </script>';
    } elseif (($_GET['username'] == 'true') && ($_GET['password'] == 'false')) {
        echo '<div class="alert alert-warning alert-dismissible fade show my-0" role="alert">
                    <strong>Invalid password! </strong> check your password.
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                    <script>
        // Set a timeout to automatically hide and remove the alert after 3 seconds
        setTimeout(function() {
            var alertElement = document.querySelector(".alert");
            if (alertElement) {
                alertElement.classList.remove("show");
                alertElement.classList.add("fade"); // Ensure the alert fades out smoothly
                // Remove the alert from the DOM after 0.5 seconds (fade time)
                setTimeout(function() {
                    alertElement.remove();
                }, 500); // Match the fade duration
            }
        }, 3000); // Hide alert after 3 seconds
    </script>
                    ';
    }
}

// Alert for wrong admin login entries and alert will disapear after 3 seconds --
if (isset($_GET['adminlogin']) && $_GET['adminlogin'] == 'false') {
    echo '
    <div class="alert alert-danger alert-dismissible fade show my-0" role="alert">
        <strong>Dear Admin!</strong> The credentials are incorrect, please try again.
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    <script>
        // Set a timeout to automatically hide and remove the alert after 3 seconds
        setTimeout(function() {
            var alertElement = document.querySelector(".alert");
            if (alertElement) {
                alertElement.classList.remove("show");
                alertElement.classList.add("fade"); // Ensure the alert fades out smoothly
                // Remove the alert from the DOM after 0.5 seconds (fade time)
                setTimeout(function() {
                    alertElement.remove();
                }, 500); // Match the fade duration
            }
        }, 3000); // Hide alert after 3 seconds
    </script>
    ';
}


?>