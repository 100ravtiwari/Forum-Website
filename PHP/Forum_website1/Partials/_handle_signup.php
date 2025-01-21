<?php

include("db_connection.php");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $cpassword = $_POST['cpassword'];

    // Check if the username already exists
    $sql = "SELECT * FROM `users` WHERE user_name = '$username'";
    $result = mysqli_query($conn, $sql);
    $rows = mysqli_num_rows($result);

    if ($rows > 0) {
        // Username already exists, redirect to index.php with exist=true
        header("Location: /PHP/Forum_website1/index.php?signupsuccess=false&exist=true");
        exit();
    } else {
        // No existing username, proceed with signup
        if ($password == $cpassword) { // Passwords match

            // Hash the password
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

            // Insert the new user into the database
            $sql = "INSERT INTO `users` (`user_name`, `user_password`, `login_time`) VALUES ('$username', '$hashedPassword', current_timestamp())";
            $result = mysqli_query($conn, $sql);

            if ($result) {
                // Signup successful
                header("Location: /PHP/Forum_website1/index.php?signupsuccess=true&exist=false");
                exit();
            } else {
                // Signup failed (database error)
                header("Location: /PHP/Forum_website1/index.php?signupsuccess=false&exist=false");
                exit();
            }
        } else {
            // Passwords don't match
            header("Location: /PHP/Forum_website1/index.php?signupsuccess=false&exist=false");
            exit();
        }
    }
}
?>


<!-- 
<?php

        include("db_connection.php");
       

        if($_SERVER['REQUEST_METHOD'] == 'POST'){
                $exist =   false;
                $username    =  $_POST['username'];
                $password    = $_POST['password'];
                $cpassword   = $_POST['cpassword'];

                $sql    = "SELECT * FROM `users` where user_name = '$username'";
                $result = mysqli_query($conn, $sql);
                $rows   = mysqli_num_rows($result);
                if($rows == 0){
                        if($password == $cpassword){

                                $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        
                                $sql = "INSERT INTO `users` (`user_name`, `user_password`, `login_time`) VALUES ('$username', '$hashedPassword', current_timestamp())";
                                $result = mysqli_query($conn, $sql);
                                if($result){
                                        header("Location:/PHP/Forum_website1/index.php?signupsuccess=true&exist=false");
                                              exit();
                                        }
                                else{   
                                         header("Location:/PHP/Forum_website1/index.php?signupsuccess=false&exist=false");
                                              exit();
                                        }
                                    }

                        else{
                                        header("Location:/PHP/Forum_website1/index.php?exist=true");
                                          exit();     
                                }}}
?> -->
