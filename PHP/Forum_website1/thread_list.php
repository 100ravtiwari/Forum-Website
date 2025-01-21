<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel = "stylesheet" href ="Partials/style.css">
    <!-- this is the link of bs-4.5 . i used media object component from it -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">

    <title>threads</title>
  </head>
  <div>
<!-- included the _header file where is my navbar  -->
    <?php  include"Partials/_header.php"?>
    <?php  include"Partials/db_connection.php"?>
    <?php  include"Partials/login_modal.php"?>
    <?php  include"Partials/signup_modal.php"?>
  
   
 <!--   php code for the thread form submission  -->
 <?php
      if (($_SERVER['REQUEST_METHOD']) == 'POST') {
        if (isset($_GET['id']) && !empty($_GET['id'])) {
          $thread_category_id = $_GET['id'];
          $titleq = $_POST['title'];
/* i am using the str replace to avoid any script code to be entered
   in my input section with the intension of attacking my website .by using it any user can't
   run any code in my input starting and ending with < or >  because it will replaced 
   semanteously to &lt or &gt --
*/
          $titleq = str_replace("<", "&lt;",  $titleq);
          $titleq = str_replace(">", "&gt;",  $titleq);

          $desc   = $_POST['desc'];
          $desc = str_replace("<", "&lt;",  $desc);
          $desc = str_replace(">", "&gt;",  $desc);
          
          $threadUser = $_SESSION['username'];
          $alert  = false;

         $sql = " INSERT INTO `thread` ( `thread_title`, `thread_desc`, `thread_cat_id`, `thread_user_name`, `time`) VALUES ('$titleq', '$desc', '$thread_category_id', '$threadUser', CURRENT_TIMESTAMP);";
         $result = mysqli_query($conn, $sql); 
         if($result){
                        echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
                        <strong>Success!</strong> Your question is successfully posted wait for others reply.
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                      </div>';
         }}
         else {
                  echo '<div class="alert alert-warning alert-dismissible fade show" role="alert">
                       <strong>Error!</strong> Your question did not post due to some reason please try again.
                       <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                       </div>';
  
         }}

//     adding alert for the form submissionif my form is submitted then it will show alert
//     if not then it also show a alert for it .
  ?>

          
     <?php

// get the clicked card id by get function and store it in $threadID
         if (isset($_GET['id']) && !empty($_GET['id'])) {
              $threadID = $_GET['id']; 
              $sql = "SELECT * FROM `category`WHERE category_id = $threadID";
              $result = mysqli_query($conn, $sql);
              if($result==true){
              while ($fetch = mysqli_fetch_assoc($result)) {
                              echo '<div class="container my-4">
                                    <div class="col-lg-12">
                                            <div class="h-50 p-3 bg-light border rounded-3">
                                              <h2> Welcome to ' . $fetch['category_name'] .' forum </h2>
                                              <p class="p-3"> '. $fetch['category_desc'] .' </p>
                                              <hr>';

                                              if(isset($_SESSION["username"])){
                                                echo '<p> Welcome : <span class ="fw-bold text-danger">'.$_SESSION["username"].'</span></p> ';
                                                 echo '<hr>';
                                               }

                                            echo'
                                              <h4 class="p-0"> Rules: </h4>
                                              <p class="p-3">  Be Respectful and Courteous || Stay On Topic || No Spamming or Advertising || Use Appropriate Language || No Illegal Activities || No Offensive Content</p>
                                            </div>
                                          </div>
                                      </div>';
                             
              }}}

     
     ?>

   
<!-- here is the form form bs in which user will ask its question -->
     <div class="container">
    <hr>
    <?php
       if(isset($_SESSION['username'])){
       echo '
      <h3 class="p-2 bg-danger rounded"> Ask questions here </h3>
<!-- we use here php self in action this mean it will post this request in the same page where the form located -- -->
       <form class="my-3" action="' .($_SERVER["PHP_SELF"]) . '?id=' . $_GET["id"] . '" method="POST">

       <div class="mb-3">
            <label for="titles" class="form-label">Question title</label>
            <input type="text" class="form-control" placeholder="Enter your question title" id="titles" aria-describedby="emailHelp" name="title">
            <div id="emailHelp" class="form-text" name="title">Question title should be understable and simple-short way</div>
          </div>
          <div class="mb-3">
            <label for="description" class="form-label">Full explaination</label>
            <div class="form-floating">
            <textarea class="form-control"  id="floatingTextarea2" style="height: 100px" name="desc"  ></textarea>
            <label for="floatingTextarea2"  id="description">Explain your question in detail</label>
          </div>
          </div>
          <button type="submit" class="btn btn-primary">Submit</button>
        </form>
        </div>
      ';}
      else{
             echo ' <h3 class = "bg-success p-2 text-center rounded-pill"> Please login to post question!  </h3>';
      }
     
    ?>
    </div>
    <hr>

<!-- using media object using bs 4.5 by which we will show users queries -->
 <div class="container my-3">
  <h3 class="p-2 my-3 bg-danger rounded"> User queries </h3>

  <!-- now we will show thread queries using the thread table and here we are fetching it -->
  <?php
/*  getting id of clicked category by $_GET function. we achieve this because we save 
    id of card category to the url of thread.php while clicking it. and then get it by 
    this function */
    if (isset($_GET['id']) && !empty($_GET['id'])) {
       $threadID = $_GET['id'];
       $noResultFound = true; 
       $sql = "SELECT * FROM `thread` WHERE thread_cat_id = $threadID";
              $result = mysqli_query($conn, $sql);
              if($result==true){
              while ($fetch = mysqli_fetch_assoc($result)) {
                              $noResultFound = false;
                              $title = $fetch['thread_title'];
                              $desc  = $fetch['thread_desc'];
                              $time  = $fetch['time'];
                              $threaduser = $fetch['thread_user_name'];
                              $newTime = date('d/m/y  g:i a', strtotime($time));
                              echo '
                              <div class="d-flex align-items-start mb-3">
                                  <img src="images/user.png" alt="..." class="me-3 rounded border border-danger" style="width:40px;">
                                  <div class="w-100"> <!-- Use full width -->
                                      <div class="d-flex justify-content-between align-items-start"> <!-- Flex container for username and time -->
                                          <h8 class="mt-0 text-primary">'.$threaduser.'</h8>
                                          <span class="text-primary">'.$newTime.'</span> <!-- Time aligned to the right -->
                                      </div>
                                      <h5 class="mt-0"> <a class="text-dark" href="threads.php?id='.$fetch['thread_id'].'"> '.$title.' </a> </h5>
                                      <p>'.$desc.'</p>
                                  </div>
                              </div>
                              <hr>
                              ';
                              
                             
              }}}

           
            if($noResultFound == true){
                   echo ' <div class="jumbotron jumbotron-fluid">
                          <div class="container">
                            <h3 class="display-4">No question found </h3>
                            <p class="lead">There is no question related to this category be the first person to ask.</p>
                          </div>
                        </div>';
              }
        


  ?>
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