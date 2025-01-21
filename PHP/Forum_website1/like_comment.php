<?php
include 'Partials/db_connection.php';  // Ensure DB connection is included

// Check if a POST request with a comment_id is received
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['comment_id'])) {
        $commentID = $_POST['comment_id'];

        // Update the like count in the database by incrementing it
        $sql = "UPDATE `comments` SET `likes` = `likes` + 1 WHERE `comment_id` = $commentID";
        $result = mysqli_query($conn, $sql);

        // Check if the query was successful
        if ($result) {
            // Retrieve the new like count
            $sql = "SELECT `likes` FROM `comments` WHERE `comment_id` = $commentID";
            $result = mysqli_query($conn, $sql);
            $data = mysqli_fetch_assoc($result);

            // Send a response back with the new like count
            echo json_encode(['success' => true, 'newLikes' => $data['likes']]);
        } else {
            // If something goes wrong, send failure response
            echo json_encode(['success' => false]);
        }
    } else {
        // If no comment_id is passed
        echo json_encode(['success' => false]);
    }
}
?>
