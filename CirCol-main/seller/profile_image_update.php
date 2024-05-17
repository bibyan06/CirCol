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

        // Update the user's photo in the database
        if (isset($_FILES['fileInput']) && $_FILES['fileInput']['error'] === UPLOAD_ERR_OK) {
            $photo = mysqli_real_escape_string($con, $_FILES['fileInput']['name']);
            $updatePhotoQuery = "UPDATE users SET photo = '$photo' WHERE id = '$user_id'";
            $query_run = mysqli_query($con, $updatePhotoQuery);

            if ($query_run) {
                echo '<script type="text/javascript">window.location.href = "users-profile.php"; </script>';
            } else {
                echo '<script type="text/javascript">alert("Error updating photo: ' . mysqli_error($con) . '");</script>';
            }
        } else {
            echo '<script type="text/javascript">alert("Photo upload failed.");</script>';
        }
    } else {
        echo '<script type="text/javascript">alert("Error fetching user data: ' . mysqli_error($con) . '");</script>';
    }
} else {
    echo '<script type="text/javascript">alert("User ID is not set.");</script>';
}
?>
