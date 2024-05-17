<?php
session_start();

// Assuming you have a database connection, replace these values with your database credentials
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "circol"; // Change this to your actual database name

// Create connection
$con = mysqli_connect($servername, $username, $password, $dbname);

// Check connection
if (!$con) {
    die("Connection failed: " . mysqli_connect_error());
}

// CHANGING OF PASSWORD //
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if the user is authenticated
    if (!isset($_SESSION['seller'])) {
        echo "User not authenticated.";
        exit;
    }

    // Validate the form data (add more validation as needed)
    if (empty($_POST['password']) || empty($_POST['newpassword']) || empty($_POST['renewpassword'])) {
        echo "All fields are required.";
        exit;
    }

    // Retrieve form data
    $currentPassword = $_POST['password'];
    $newPassword = $_POST['newpassword'];
    $reenteredPassword = $_POST['renewpassword'];

    if ($newPassword !== $reenteredPassword) {
        echo "New passwords do not match.";
        exit;
    }

    // Get the user ID from the session
    $userId = $_SESSION['seller']['id'];

    // Example: Fetch the hashed password from the database
    $fetchPasswordQuery = "SELECT password FROM users WHERE id = '$userId'";
    $result = mysqli_query($con, $fetchPasswordQuery);

    if ($result) {
        // Check if the query returned any result
        if (mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
            $hashedPasswordFromDatabase = $row['password'];

            // Verify the current password
            if (password_verify($currentPassword, $hashedPasswordFromDatabase)) {
                // Update the password in the database
                $hashedNewPassword = password_hash($newPassword, PASSWORD_DEFAULT);
                $updatePasswordQuery = "UPDATE users SET password = '$hashedNewPassword' WHERE id = '$userId'";
                $updateResult = mysqli_query($con, $updatePasswordQuery);

                if ($updateResult) {
                    echo '<script type="text/javascript">window.location.href = "users-profile.php"; </script>';
                } else {
                    echo "Error updating password: " . mysqli_error($con);
                }
            } else {
                echo "Current password is incorrect.";
            }
        } else {
            // Redirect or display an error message
            echo "User not found.";
        }
    } else {
        echo "Error fetching password from the database: " . mysqli_error($con);
    }
}
?>
