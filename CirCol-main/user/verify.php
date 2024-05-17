<?php
// Include the session file
include '../includes/session.php';

// Open the database connection
$conn = $pdo->open();

// Check if login form is submitted
if(isset($_POST['login'])){
    $email = $_POST['email'];
    $password = $_POST['password'];

    try{
        // Prepare and execute the SQL query to fetch user data
        $stmt = $conn->prepare("SELECT *, COUNT(*) AS numrows FROM users WHERE email = :email");
        $stmt->execute(['email'=>$email]);
        $row = $stmt->fetch();

        // Check if user exists
        if($row['numrows'] > 0){
            // Check if user account is active
            if($row['status']){
                // Verify password
                if(password_verify($password, $row['password'])){
                    // Check user type
                    if($row['type'] == 0){
                        // Set session variable for the user
                        $_SESSION['user'] = $row['id'];
                        
                        // Redirect to index.php after successful login
                        header('location: index.php');
                        exit();
                    } else{
                        // Set error message for user type other than 0
                        $_SESSION['error'] = 'You have no access to this page, you have to signup first.';
                    }
                } else{
                    // Set error message for invalid email or password
                    $_SESSION['error'] = 'Invalid email or password. Please try again.';
                }
            } else{
                // Set error message for inactive account
                $_SESSION['error'] = 'Your account is currently inactive.';
            }
        } else{
            // Set error message for email not found
            $_SESSION['error'] = 'Email not found.';
        }
    } catch(PDOException $e){
        // Handle database connection error
        $_SESSION['error'] = "There is some problem in connection: " . $e->getMessage();
    }

    // Redirect to login.php with an error parameter and specify the alert type as 'error'
    header("Location: login.php?alert=" . urlencode($_SESSION['error']) . "&type=error");
    exit(); // Ensure script stops here to prevent further execution
} else{
    // Set error message for login form not submitted
    $_SESSION['error'] = 'Input login credentials first.';
    
    // Redirect to login.php with an error parameter and specify the alert type as 'error'
    header("Location: login.php?alert=" . urlencode($_SESSION['error']) . "&type=error");
    exit(); // Ensure script stops here to prevent further execution
}

// Close the database connection
$pdo->close();
?>
