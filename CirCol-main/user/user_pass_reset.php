<?php
    include '../includes/session.php';
    // Establish database connection
    $servername = "localhost"; // Change this to your MySQL server hostname
    $username = "root"; // Change this to your MySQL username
    $password = ""; // Change this to your MySQL password
    $database = "circol"; // Change this to your MySQL database name

    $conn = new mysqli($servername, $username, $password, $database);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['reset'])) {
        if(isset($_SESSION['user_email'])) {
            $email = $_SESSION['user_email'];
            $password = $_POST['password'];
            $confirm_password = $_POST['confirm_password'];

            // Check if passwords match
            if($password !== $confirm_password) {
                $_SESSION['error'] = "Passwords do not match. Please try again.";

                header("Location: reset_password.php?alert=" . urlencode($_SESSION['error']));
                exit(); // Ensure script stops here to prevent further execution
            }

            // Encrypt the passwords
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);

            // Update the hashed password in the database
            $stmt = $conn->prepare("UPDATE users SET password = ? WHERE email = ?");
            $stmt->bind_param("ss", $hashed_password, $email);
            $stmt->execute();

            if ($stmt->affected_rows > 0) {
                $_SESSION['reset_success'] = "Password updated successfully.";
                unset($_SESSION['user_email']); // Clear the stored email from session

                // Redirect to login.php with a success parameter and specify the alert type as 'success'
                header("Location: login.php?alert=" . urlencode($_SESSION['reset_success']) . "&type=success");
                exit(); // Ensure script stops here to prevent further execution

            } else {
                $_SESSION['error'] = "Failed to update password. Please try again later.";
            }
        } else {
            $_SESSION['error'] = "Email is not registered."; // This should not happen, but adding for extra security
        }
        // Redirect to login.php with an error parameter
        header("Location: reset_password.php?alert=" . urlencode($_SESSION['error']));
        exit(); // Ensure script stops here to prevent further execution
    }
?>