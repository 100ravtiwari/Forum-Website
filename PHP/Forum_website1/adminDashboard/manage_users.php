<?php
session_start();
include '../Partials/db_connection.php';

// Verify if admin is logged in
if (!isset($_SESSION['admin_id'])) {
    header('Location: admin_login.php');
    exit();
}

// Delete user account
if (isset($_GET['delete'])) {
    $user_id = intval($_GET['delete']);
    $deleteQuery = "DELETE FROM users WHERE user_id = ?";
    $stmt = $conn->prepare($deleteQuery);
    $stmt->bind_param("i", $user_id);

    if ($stmt->execute()) {
        echo "<script>alert('User deleted successfully!'); window.location.href = 'manage_users.php';</script>";
    } else {
        echo "<script>alert('Error deleting user!');</script>";
    }
    $stmt->close();
}

// Fetch all users
$query = "SELECT user_id, user_name, login_time FROM users";
$result = $conn->query($query);

// Check if the query was successful
if (!$result) {
    die("Error fetching users: " . $conn->error); // Display an error if the query failed
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Users</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        /* Custom styles for the page */
        body {
            background-color: #f4f4f9; /* Light grayish background */
        }

        .container {
            margin-top: 80px; /* Adjusting for navbar space */
        }

        /* Thicker borders for the table */
        .table {
            border: 2px solid #ddd;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .table th, .table td {
            border: 2px solid #ddd; /* Thicker borders */
        }

        /* Table Header Styling */
        .table thead {
            background-color: #007bff; /* Blue background for header */
            color: white;
        }

        /* Hover effect on table rows */
        .table tbody tr:hover {
            background-color: rgba(0, 123, 255, 0.1); /* Light blue hover effect */
        }

        /* Button Styling */
        .btn {
            padding: 8px 15px;
        }

        /* Responsive adjustments */
        @media (max-width: 576px) {
            .table th,
            .table td {
                font-size: 14px;
            }

            .navbar-brand {
                font-size: 16px;
            }

            .navbar-toggler {
                border-color: #fff;
            }
        }
    </style>
</head>

<body>

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
        <div class="container-fluid">
            <a class="navbar-brand" href="admin_dashboard.php">Admin Dashboard</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link active" href="admin_dashboard.php">Back to Dashboard</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="admin_logout.php">Logout</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="container">
        <h2 class="mb-4">Manage Users</h2>
        <a href="admin_dashboard.php" class="btn btn-secondary mb-4">Back to Dashboard</a>

        <div class="table-responsive">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Username</th>
                        <th>Last Login</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($result->num_rows > 0): ?>
                        <?php 
                        $serial_number = 1; // Initialize serial number
                        while ($row = $result->fetch_assoc()): ?>
                            <tr>
                                <td><?= $serial_number++; ?></td> <!-- Serial number -->
                                <td><?= htmlspecialchars($row['user_name']); ?></td>
                                <td><?= htmlspecialchars($row['login_time']); ?></td>
                                <td>
                                    <a href="user_activity.php?user=<?= htmlspecialchars($row['user_name']); ?>" class="btn btn-primary btn-sm mt-1">View Posts & Comments</a>
                                    <a href="manage_users.php?delete=<?= htmlspecialchars($row['user_id']); ?>" class="btn btn-danger btn-sm mt-1" onclick="return confirm('Are you sure you want to delete this account?');">Delete Account</a>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="4" class="text-center">No users found!</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
