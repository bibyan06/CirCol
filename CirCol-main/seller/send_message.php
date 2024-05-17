<?php
// Include PHPMailer classes
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require_once './PHPMailer/src/PHPMailer.php';
require_once './PHPMailer/src/SMTP.php';
require_once './PHPMailer/src/Exception.php';

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if all required fields are filled out
    if (!empty($_POST['name']) && !empty($_POST['email']) && !empty($_POST['subject']) && !empty($_POST['message'])) {
        // Sanitize input data
        $name = htmlspecialchars($_POST['name']);
        $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
        $subject = htmlspecialchars($_POST['subject']);
        $message = htmlspecialchars($_POST['message']);

        try {
            // Create a new PHPMailer instance
            $mail = new PHPMailer(true);

            // Server settings
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'ebuy1210@gmail.com'; // Your Gmail username
            $mail->Password = 'yitq rjgc zkwl zdkn'; // Your Gmail password
            $mail->Port = 465; // Or 587 for TLS
            $mail->SMTPSecure = 'ssl'; // Or 'tls'

            
            // Recipients
            // Set sender's email address (use user's input)
            $mail->setFrom('ebuy1210@gmail.com', "From: $name <$email>"); // Modify the 'From' header
            $mail->addAddress('ebuy1210@gmail.com'); // Add a recipient
            // Content
            $mail->isHTML(true);
            $mail->Subject = $subject;
            $mail->Body    = $message;

            // Send the email
            $mail->send();
            
            // Redirect back to contactus.php with success parameter
            header("Location: contactus.php?success=true");
            exit();
        } catch (Exception $e) {
            echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }
    } else {
        // If required fields are not filled out, show an error message
        echo "All fields are required.";
    }
} else {
    // If the form is not submitted via POST method, redirect to the contact page
    header("Location: contactus.php");
    exit();
}
?>
