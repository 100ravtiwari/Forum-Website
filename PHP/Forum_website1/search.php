<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <style>

<style>
    #alertj {
        background-color: #f8d7da; /* Light red background */
        border-color: #f5c6cb; /* Darker red border */
        border-radius: 0.5rem; /* Rounded corners */
        padding: 2rem; /* More padding */
    }
</style>

    </style>
    <title> search results</title>
  </head>
  <body>
<!-- included the _header file where is my navbar  -->
    <?php  include"Partials/db_connection.php"?>
    <?php  include"Partials/_header.php"?>

    <div class="container my-3 min-vh-100">
        <?php 
        if(isset($_GET["query"])){
               $search = $_GET['query'];
        
             echo '<h3 class="text-center bg-danger p-2 rounded my-4">Search results for "'.$search.'"</h3>';


             $sql = "SELECT * FROM thread WHERE thread_title LIKE  '%$search%' 
                     OR thread_desc LIKE '%$search%'";
              $result = mysqli_query($conn, $sql);
              $row = mysqli_num_rows($result);
              if($row > 0){
              while ($fetch = mysqli_fetch_assoc($result)) {
                            $user = $fetch['thread_user_name'];
                            $title = $fetch['thread_title'];
                            $desc = $fetch['thread_desc'];
                            $time = $fetch['time'];
                        
                          echo '
                              <div class="d-flex align-items-start mb-3">
                                  <img src="images/user.png" alt="..." class="me-3 rounded border border-danger" style="width:40px;">
                                  <div class="w-100"> <!-- Use full width -->
                                      <div class="d-flex justify-content-between align-items-start"> <!-- Flex container for username and time -->
                                          <h8 class="mt-0 text-primary">'.$user.'</h8>
                                          <span class="text-primary">'.$time.'</span> <!-- Time aligned to the right -->
                                      </div>
                                      <h5 class="mt-0"> <a class="text-dark" href="threads.php?id='.$fetch['thread_id'].'"> '.$title.' </a> </h5>
                                      <p>'.$desc.'</p>
                                  </div>
                              </div>';}
                            }
                            else{

                                echo '<div class="p-5 mb-4 bg-warning rounded-3 min-vh-100">
                                        <div class="container-fluid py-5">
                                            <h1 class="display-5 fw-bold ">No search result found for "<em>'.$search.'</em>"</h1>
                                            <p class="lead">There are no results corresponding to your search.</p>
                                                <ul>
                                                    <li>It seems we could not find any results for <strong>'.$search.'</strong>. Why not try exploring our categories or check the homepage?</li>
                                                    <li>Check your spelling.</li>
                                                </ul>
                                        </div>
                                        </div>';
                                

                            }}

                        
                            
        ?>
    </div>

    








  <?php include ('Partials/_footer.php'); ?>
    <!-- Optional JavaScript; choose one of the two! -->

    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

    <!-- Option 2: Separate Popper and Bootstrap JS -->
    <!--
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
    -->
  </body>
</html>