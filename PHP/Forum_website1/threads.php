
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


    <style>
      /* Custom style for date and time */
      .text-attractive-color {
          color: #6c757d; /* A soft gray color */
          font-size: 0.9rem; /* Slightly smaller font size */
          font-style: italic; /* To differentiate it from the main text */
      }

      /* Heart button style */
      .heart-btn {
          font-size: 1.5rem;
          cursor: pointer;
          color: white; /* Default color (unfilled) */
      }

      .heart-btn.liked {
          color: red; /* Red color when filled */
      }

      /* Flexbox container for comment body */
      .comment-body {
          position: relative; /* So that the heart button can be positioned absolutely */
          padding-right: 40px; /* Give space for the like button on the right */
      }

      /* Position the heart button to the upper-right of the comment */
      .heart-container {
          position: absolute;
          top: 0;
          right: 0;
          margin-top: 5px;
          margin-right: 10px;
      }

      /* Container for comment text and time */
      .comment-container {
          display: flex;
          flex-direction: column;
          justify-content: space-between;
      }

      .comment-text {
          margin-bottom: 10px;
      }
      
      /* Additional spacing to ensure comments don't overlap header */
      .media {
          margin-top: 20px; /* Give some space from the top */
      }
      
    </style>

  </head>
<!-- included the _header file where is my navbar  -->
    <?php  include"Partials/_header.php"?>
    <?php  include"Partials/db_connection.php"?>
    <?php  include"Partials/login_modal.php"?>
    <?php  include"Partials/signup_modal.php"?>
    <?php    
            if ($result = true){
              echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
                    <strong>Success!</strong> your comment has been posted successfully.
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                   </div>';
            }
            elseif($result=false){  
              echo'<div class="alert alert-warning alert-dismissible fade show" role="alert">
                    <strong>Error!</strong> you can not post comment right now try later.
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                  </div>';
            }
      ?>

     <?php
// get the clicked card id by get function and store it in $threadID
          if(isset($_GET['id'])){
              $threadsID = $_GET['id']; 
              $sql = "SELECT * FROM `thread`WHERE thread_id = $threadsID";
              $result = mysqli_query($conn, $sql);
              if($result==true){
              while ($fetch = mysqli_fetch_assoc($result)) {
                           
                              echo '<div class="container my-4">
                                    <div class="col-lg-12">
                                            <div class="h-50 p-3 bg-light border rounded-3">
                                              <h2>'. $fetch['thread_title'] .'</h2>
                                              <p class="p-3"> '. $fetch['thread_desc'] .' </p>
                                              <hr>';
                                         
                                              if(isset($_SESSION["username"])){
                                                       echo '<p> posted by  : <span class ="fw-bold text-danger">'.$fetch["thread_user_name"].'</span></p> ';
                                                       echo '<hr>';
                                                   }
                                            
                              echo '
                                              
                                              <h4 class="p-0"> Rules: </h4>
                                              <p class="p-3">  Be Respectful and Courteous || Stay On Topic || No Spamming or Advertising || Use Appropriate Language || No Illegal Activities || No Offensive Content</p>
                                            </div>
                                          </div>
                                      </div>';
                             
              }}}

     
     ?>

<!-- here is the php code for comment post -->
 <div class="container">
     <?php
           if($_SERVER['REQUEST_METHOD']=='POST'){
             if(isset($_GET['id'])){
                  $threadID = $_GET['id']; 
                  $comment = $_POST['comment'];
                  $username = $_SESSION['username'];

                  $sql = "INSERT INTO `comments` (`comment`, `thread_comment_id`, `user_name`, `comment_time`) VALUES ('$comment', '$threadID', '$username', current_timestamp())";
                        $result2 = mysqli_query($conn, $sql);
                        if($result2){
                                              $result = true;
                                      
                        }
                        else{ 
                                die ('<div class="alert alert-warning alert-dismissible fade show" role="alert">
                                <strong>Error!</strong> you can not post comment right now try later.
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                              </div>') ; 
                         }}}

     ?>
     </div>

<!-- here is the form for post comments -->

<div class="container">
  <hr>
  <?php
        if(isset($_SESSION['username'])){
           echo '
            <h2> Post comment for your response</h2>
            <form class="my-3" action="'.$_SERVER['PHP_SELF'].'?id='.$_GET['id'].'" method="POST">
                <div class="mb-3">
                  <label for="description" class="form-label">Write a solution </label>
                  <div class="form-floating">
                  <textarea class="form-control"  id="floatingTextarea2" style="height: 100px" name="comment"  ></textarea>
                  <label for="floatingTextarea2"  id="description">write the solution if you have</label>
                </div>
                </div>
                <button type="submit" class="btn btn-primary">Post</button>
              </form>
            ';}

            else{
                    echo '<h3 class="bg-success p-2 text-center rounded-pill"> Please login to reply ! </h3>';
            }
              
    ?>
            </div>
            <hr>
  

<!-- using media object using bs 4.5 by which we will show users queries -->
 <div class="container my-3">
  <h2 class=" bg-danger  p-2 my-3 rounded"> Discussion </h2>


 <?php
/*  getting id of clicked category by $_GET function. we achieve this because we save 
    id of card category to the url of thread.php while clicking it. and then get it by 
    this function */
       $threadID = $_GET['id']; //its a global id retrieve function
/* 
    here we displaying the comments of user regarding the question 
    we achieving because we fetching data from the table where thread_comment_id = the threadID
    and when we are posting a question then we are giving id to that question as related thread id
    jsut like when we are posting a comment then we gave them a same thread_comment_id 
    same as the threads id. this will save all related category , related thread and 
    related comments with the same ids.
 */
 ?>
   
    <?php
    $threadID = $_GET['id'];
    $sql = "SELECT * FROM `comments` WHERE thread_comment_id = $threadID ORDER BY likes DESC";
    $result = mysqli_query($conn, $sql);
    if ($result == true) {
        while ($fetch = mysqli_fetch_assoc($result)) {
            $commentID = $fetch['comment_id'];
            $user = $fetch['user_name'];
            $comment = $fetch['comment'];
            $time = date('d/m/y g:i a', strtotime($fetch['comment_time']));
            $likes = $fetch['likes'];

            echo '
            <div class="media mb-3">
                <img src="images/user.png" class="mr-3" alt="User" style="width:40px;">
                <div class="media-body comment-body">
                    <h5 class="mt-0 text-primary">' . $user . '</h5>
                    <div class="comment-container">
                        <p class="comment-text">' . $comment . '</p>
                        <small class="text-muted text-attractive-color">' . $time . '</small>
                        <div class="heart-container">
                            <span class="heart-btn" data-comment-id="' . $commentID . '" data-likes="' . $likes . '" id="heart-btn-' . $commentID . '">&#10084;</span>
                            <span id="like-count-' . $commentID . '" class="ms-2">' . $likes . '</span>
                        </div>
                    </div>
                </div>
            </div>';
        }
    }
    ?>
  </div>

  <script>
    document.addEventListener("DOMContentLoaded", function() {
        const heartButtons = document.querySelectorAll(".heart-btn");

        heartButtons.forEach(button => {
            button.addEventListener("click", function() {
                const commentID = this.getAttribute("data-comment-id");
                const likeCountSpan = document.getElementById(`like-count-${commentID}`);
                const isLiked = this.classList.contains("liked");
                let newLikes = parseInt(likeCountSpan.textContent);

                // Toggle the heart color
                if (isLiked) {
                    this.classList.remove("liked");
                    newLikes--; // Decrease like count
                } else {
                    this.classList.add("liked");
                    newLikes++; // Increase like count
                }

                // Update the like count visually
                likeCountSpan.textContent = newLikes;

                // Send like/dislike action to the server
                fetch("like_comment.php", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/x-www-form-urlencoded"
                    },
                    body: `comment_id=${commentID}&action=${isLiked ? 'dislike' : 'like'}`
                })
                .then(response => response.json())
                .then(data => {
                    if (!data.success) {
                        alert("Unable to update the like status. Please try again.");
                    }
                })
                .catch(error => console.error("Error:", error));
            });
        });
    });
  </script>

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