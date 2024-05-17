<?php
session_start();

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "circol";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$alert_type = "success"; // Default alert type
$alert_message = ""; // Initialize alert message

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["login"])) {
    $email = $_POST["email"];
    $password = $_POST["password"];

    $sql = "SELECT * FROM users WHERE email='$email'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();

        // Verify the password
        if (password_verify($password, $row["password"])) {
            if ($row["type"] == 2) {
                // User is an admin, proceed to login
                // After successful login
                $_SESSION["seller"] = $row; // Store the entire row in the session
                header("Location: home.php"); // Redirect to the dashboard after successful login
                exit();
            } else {
                // Set error message for invalid email or password
                $_SESSION['error'] = 'You have no access to the seller page.';
            }
        } else {
            $_SESSION['error'] = 'Invalid password. Please try again.';
        }
    } else {
        $_SESSION['error'] = "Email not found.";
    }
}

// Close the connection
$conn->close();

// Redirect back to the login page with error message if set
header("Location: login.php" . (isset($_SESSION['error']) ? '?alert=' . urlencode($_SESSION['error']) : ''));
exit();
?>
