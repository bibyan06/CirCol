<?php
include '../includes/conn.php';

if(isset($_POST['userId'])) {
    $userId = $_POST['userId'];

    // Fetch user's information from the database
    $conn = $pdo->open();
    $stmt = $conn->prepare("SELECT firstname, lastname, email, address, contact_info FROM users WHERE id=:id");
    $stmt->execute(['id' => $userId]);
    $user = $stmt->fetch();
    $pdo->close();

    // Prepare the response as JSON
    $response = json_encode($user);

    // Send the response
    echo $response;
}
?>
