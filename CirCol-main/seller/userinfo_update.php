<?php
$host = "localhost";
$user = "root";
$password = "";
$databasename = "circol";

$con = mysqli_connect($host, $user, $password, $databasename);

if (!$con) {
    die("Connection failed: " . mysqli_connect_error());
}

if (isset($_POST['id'])) {
    // Fetch user data based on the user ID
    $user_id = mysqli_real_escape_string($con, $_POST['id']);
    $fetchUserQuery = "SELECT * FROM users WHERE id = '$user_id'";
    $userResult = mysqli_query($con, $fetchUserQuery);

    if ($userResult) {
        $user = mysqli_fetch_assoc($userResult);

        // Check if the necessary keys exist in $_POST
        if (
            isset($_POST['id']) &&
            isset($_POST['firstname']) &&
            isset($_POST['lastname']) &&
            isset($_POST['address']) &&
            isset($_POST['contact']) &&
            isset($_POST['email']) &&
            isset($_POST['shop_name']) &&
            isset($_POST['gcash_number'])
        ) {
            $firstname = mysqli_real_escape_string($con, $_POST['firstname']);
            $lastname = mysqli_real_escape_string($con, $_POST['lastname']);
            $address = mysqli_real_escape_string($con, $_POST['address']);
            $contact = mysqli_real_escape_string($con, $_POST['contact']);
            $email = mysqli_real_escape_string($con, $_POST['email']);
            $shop_name = mysqli_real_escape_string($con, $_POST['shop_name']);
            $gcash_number = mysqli_real_escape_string($con, $_POST['gcash_number']);
            
            // Update the user's photo in the database
            if (isset($_FILES['fileInput']) && $_FILES['fileInput']['error'] === UPLOAD_ERR_OK) {
                $photo = mysqli_real_escape_string($con, $_FILES['fileInput']['name']);
                $updatePhotoQuery = "UPDATE users SET photo = '$photo' WHERE id = '$user_id'";
                mysqli_query($con, $updatePhotoQuery);
            }

            // Update the user's information in the database
            $updateQuery = "UPDATE users SET
                firstname = '$firstname',
                lastname = '$lastname',
                address = '$address',
                contact_info = '$contact',
                email = '$email',
                shop_name = '$shop_name',
                gcash_number = '$gcash_number'
                WHERE id = '$user_id'";

            $query_run = mysqli_query($con, $updateQuery);

            if ($query_run) {
                echo '<script type="text/javascript">window.location.href = "users-profile.php"; </script>';
            } else {
                echo '<script type="text/javascript">alert("Error updating: ' . mysqli_error($con) . '");</script>';
            }
        } else {
            echo '<script type="text/javascript">alert("One or more required fields are missing.");</script>';
        }
    } else {
        echo '<script type="text/javascript">alert("Error fetching user data: ' . mysqli_error($con) . '");</script>';
    }
}
mysqli_close($con);
?>
