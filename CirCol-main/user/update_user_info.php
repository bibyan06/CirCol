<?php
// Start session
session_start();

// Database configuration
$servername = "localhost"; // Change this to your MySQL server hostname
$username = "root"; // Change this to your MySQL username
$password = ""; // Change this to your MySQL password
$database = "circol"; // Change this to your MySQL database name

// Create connection
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Optional: Set charset
$conn->set_charset("utf8mb4");

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $editFirstName = $_POST['editFirstName'];
    $editLastName = $_POST['editLastName'];
    $editEmail = $_POST['editemail'];
    $editContact = $_POST['editcontact'];
    $editAddress = $_POST['editaddress'];
    $user_id = $_POST['user_id']; // Fetch user ID from the form

    // Get user ID from session
    if(isset($_SESSION['user'])){
        $user_id = $_SESSION['user']; // Assuming user_id is stored in session, adjust this according to your session structure
    } else {
        echo "User ID not found in session.";
        exit(); // Exit script if user ID is not found
    }

    // Handle profile image upload
    if (isset($_FILES["photo"]) && $_FILES["photo"]["error"] == UPLOAD_ERR_OK) {
        $targetDir = "../images/";
        $fileName = basename($_FILES["photo"]["name"]);
        $targetFilePath = $targetDir . $fileName;
        $fileType = pathinfo($targetFilePath, PATHINFO_EXTENSION);

        if (!empty($fileName)) {
            // Allow certain file formats
            $allowTypes = array('jpg', 'png', 'jpeg', 'gif');
            if (in_array($fileType, $allowTypes)) {
                // Upload file to server
                if (move_uploaded_file($_FILES["photo"]["tmp_name"], $targetFilePath)) {
                    // Update user information in the database with profile image
                    $sql = "UPDATE users SET firstname=?, lastname=?, email=?, contact_info=?, address=?, photo=? WHERE id=?";
                    if ($stmt = $conn->prepare($sql)) {
                        // Bind parameters
                        $stmt->bind_param("ssssssi", $editFirstName, $editLastName, $editEmail, $editContact, $editAddress, $fileName, $user_id);

                        // Execute the prepared statement
                        if ($stmt->execute()) {
                            // Redirect to profile page after successful update
                            header("location: profile.php");
                            exit();
                        } else {
                            // Display an error message if the query fails
                            echo "Error: " . $stmt->error;
                        }

                        // Close statement
                        $stmt->close();
                    }
                } else {
                    echo "Sorry, there was an error uploading your file.";
                }
            } else {
                echo "Sorry, only JPG, JPEG, PNG, & GIF files are allowed to upload.";
            }
        }
    } else {
        // Update user information in the database without profile image
        $sql = "UPDATE users SET firstname=?, lastname=?, email=?, contact_info=?, address=? WHERE id=?";
        if ($stmt = $conn->prepare($sql)) {
            // Bind parameters
            $stmt->bind_param("sssssi", $editFirstName, $editLastName, $editEmail, $editContact, $editAddress, $user_id);

            // Execute the prepared statement
            if ($stmt->execute()) {
                // Redirect to profile page after successful update
                header("location: profile.php");
                exit();
            } else {
                // Display an error message if the query fails
                echo "Error: " . $stmt->error;
            }

            // Close statement
            $stmt->close();
        }
    }

    // Close connection
    $conn->close();
}
?>
