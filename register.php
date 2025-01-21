<?php
if (isset($_POST['save'])) {
    // Get form data and sanitize
    $username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_STRING);
    $mobile = filter_input(INPUT_POST, 'mobile', FILTER_SANITIZE_STRING);
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING);

    // Validate form data
    if (empty($username) || empty($mobile) || empty($email) || empty($password)) {
        $message = "All fields are required.";
    } elseif (!preg_match('/^[0-9]{10}$/', $mobile)) {
        $message = "Invalid mobile number. Must be 10 digits.";
    } else {
        // Database connection details
        $servername = "localhost";
        $db_username = "root";
        $db_password = ""; // Empty password for XAMPP
        $dbname = "register";
        
        // Create connection
        $conn = new mysqli($servername, $db_username, $db_password, $dbname);
        
        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }
        
        // Hash the password before storing
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // Prepare and bind
        $stmt = $conn->prepare("INSERT INTO cabdetails (username, mobile, email, password) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $username, $mobile, $email, $hashed_password);

        // Execute statement
        if ($stmt->execute()) {
            $message = "Cab details attached successfully!";
        } else {
            $message = "Error attaching cab details: " . $stmt->error;
        }
        
        // Close connection
        $stmt->close();
        $conn->close();
    }
} else {
    $message = "An error occurred. Please try again.";
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>REGISTER NOW</title>
</head>
<body>
    <p><?php echo isset($message) ? htmlspecialchars($message) : ''; ?></p>
    <form action="register.php" method="post">
        <label for="username">Username:</label>
        <input type="text" id="username" name="username" placeholder="Enter your Username" required>

        <label for="mobile">Enter your mobile number:</label>
        <input type="text" id="mobile" name="mobile" placeholder="Enter your mobile number" required>

        <label for="email">Enter your Email:</label>
        <input type="email" id="email" name="email" placeholder="Enter your Email" required>

        <label for="password">Create password:</label>
        <input type="password" id="password" name="password" placeholder="Create a strong password" required>

        <button type="submit" name="save">Register</button>
    </form>
</body>
</html>
