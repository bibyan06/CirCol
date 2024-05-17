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
        $email = $_POST['email'];

        // Check if the email exists in the users table
        $stmt = $conn->prepare("SELECT id FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows === 0) {
            $_SESSION['error'] = "Email is not registered.";

        } else {
            $_SESSION['user_email'] = $email;
            header('Location: reset_password.php'); // Redirect to reset password page
            exit();
        }
        // Redirect to login.php with an error parameter
        header("Location: password_forgot.php?alert=" . urlencode($_SESSION['error']));
        exit(); // Ensure script stops here to prevent further execution
    }
?>
