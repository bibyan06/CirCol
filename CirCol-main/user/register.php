<?php
    // Check if the form is submitted
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['signup'])) {
        
        // Assuming you have a database connection, replace these values with your database credentials
        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "circol"; // Change this to your actual database name
        
        // Create connection
        $conn = new mysqli($servername, $username, $password, $dbname);
        
        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // Collect form data
        $email = mysqli_real_escape_string($conn, $_POST['email']);
        $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Hash the password
        $firstname = mysqli_real_escape_string($conn, $_POST['firstname']);
        $lastname = mysqli_real_escape_string($conn, $_POST['lastname']);
        $address = mysqli_real_escape_string($conn, $_POST['address']);
        $contact_info = mysqli_real_escape_string($conn, $_POST['contact_info']);

        // Set default values for certain fields
        $type = 0; // Customer
        $status = 1; // Active user
        $gcash_qr = null; // Set to null for customers
        $gcash_number = null; // Set to null for customers
        $created_on = date('Y-m-d'); // Current date

        // Handle photo upload
        $photo = '';
        if (isset($_FILES['photo']) && $_FILES['photo']['error'] === UPLOAD_ERR_OK) {
            $photoName = basename($_FILES['photo']['name']);
            $targetPath = "../images/" . $photoName;
            if (move_uploaded_file($_FILES['photo']['tmp_name'], $targetPath)) {
                $photo = $photoName;
            } else {
                header("Location: signup.php?alert=Error%20uploading%20photo.");
                exit;
            }
        }

        // Check if the email already exists in the database
        $emailCheckQuery = "SELECT id FROM circol.users WHERE email = '$email'";
        $result = mysqli_query($conn, $emailCheckQuery);

        if (mysqli_num_rows($result) > 0) {
            // Email already exists, inform the user
            header("Location: signup.php?alert=Email%20already%20exists.%20Please%20use%20another%20email%20or%20log%20in.");
            exit;
        } else {
            // Insert data into the database
            $insertQuery = "INSERT INTO circol.users (email, password, firstname, lastname, address, contact_info, status, created_on, type, photo, gcash_qr, gcash_number) 
                            VALUES ('$email', '$password', '$firstname', '$lastname', '$address', '$contact_info', $status, '$created_on', '$type', '$photo', '$gcash_qr', '$gcash_number')";

            if (mysqli_query($conn, $insertQuery)) {
                $_SESSION['reset_success'] = "Your account is registered.";

                // Redirect to login.php with a success parameter and specify the alert type as 'success'
                header("Location: login.php?alert=" . urlencode($_SESSION['reset_success']) . "&type=success");
                exit(); // Ensure script stops here to prevent further execution
            } else {
                header("Location: signup.php?alert=Error%20adding%20user:%20" . urlencode(mysqli_error($conn)));
                exit;
            }
        }
        // Close the database connection
        mysqli_close($conn);
    }
    // Include header after processing the form to avoid header already sent error
    include 'signup.php';
?>
