<?php
include '../includes/session.php';

if(isset($_SESSION['user'])){
    header('location: cart_view.php');
}

?>

<!DOCTYPE html>
<html>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password</title>
    <link rel="shortcut icon" type="x-icon" href="../customer_assets/images/about.svg">
  	<link rel="stylesheet" href="cart.css">
    <!--- custom css link -->
    <link rel="stylesheet" href="../customer_assets/css/style-prefix.css">
    <!--- google font link-->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
            
    <style>
        body {
            /* background-image: url("../customer_assets/images/BU_Torch_Banner.jpg"); */
            background: #f6f9ff;
            background-repeat: no-repeat;
            /* Center and scale the image nicely */
            background-position: center;
            background-size: cover;
        }

        .login-box {
            margin: 150px auto; /* Center the register box */
            width: 400px; /* Set a width for the register box */
            background-color: #fff; /* Set a background color for the register box */
            padding: 20px; /* Add some padding */
            box-shadow: 0px 0 30px rgba(1, 41, 112, 0.1); /* Add a shadow */
            border-radius: 5px;
        }

        .login-box-body {
            padding: 20px; /* Add some padding */
        }
        .login-box-msg2{
            text-align: center;
            font-size: 16px;
            color: #061e39;
        }

        .input-form {
            border: 1px solid #ccc; /* Add a border */
            padding: 5px; /* Add some padding */
        }

        .form-group {
            margin: 20px 0; /* Add some bottom margin */
        }

        .btn-primary {
            background-color: #007bff; /* Set primary button background color */
            color: #fff; /* Set text color */
            border: none; /* Remove border */
        }

        .btn-primary:hover {
            background-color: #0056b3; /* Change background color on hover */
        }

        a {
            color: #007bff; /* Set link color */
        }

        a:hover {
            color: #0056b3; /* Change link color on hover */
        }

        /* Center the buttons */
        .register-box .row {
            text-align: center;
        }

        .login-box-msg{
            text-align: center;
            font-size: 30px;
            font-weight: 500;
            color: #061e39;
        }
        .send-btn{
            width: 100%;
            padding: 5px;
            text-align: center;
            color: #fd851f;
            background: #183661;
            font-weight: 650;
            border-radius: 30px;
        }
        .send-btn:hover{
            color: #fd851f ;
            background: #061e39;
        }
        .option_btn{
            font-size: 16px;
        }
        .option_btn ion-icon{
            font-size: 20px;
            padding: 3px 5px 0 5px;;
        }
        .Iremember{
            /* display: flex; */
            margin: 0;
        }
        .home{
            /* display: flex; */
        }
        .login-box img{
            margin-right: auto;
            margin-left: auto;
        }

        /** ALERT */
        .main-alert{
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            display: flex;
            justify-content: center;
            align-items: center;
        }
        .alert {
            display: flex;
            padding: 5px 20px;
            font-weight: 600;
            border-radius: 4px;
            border: none;
            outline: none;
            /* background: #e69100; */
            letter-spacing: 1px;
            position: fixed;
            z-index: 1000;
            top: -100%; /* Start from outside of the screen */
            text-align: center;
            animation: show_slide 1s ease forwards;
        }

        .hide {
            display: none;
        }

        .error_icon{
            padding: 0;
            font-size: 20px;
        }

        @keyframes show_slide {
            0% {
                top: -100%; /* Start from outside of the screen */
            }
            40% {
                top: 10%; /* Move in slightly */
            }
            80% {
                top: 0; /* Arrive at final position */
            }
            100% {
                top: 10px; /* Slight bounce effect */
            }
        }

        @keyframes hide_slide {
            0% {
                right: 10px; /* Slight bounce effect */
            }
            40% {
                right: 0; /* Return to normal position */
            }
            80% {
                right: 10%; /* Move out slightly */
            }
            100% {
                right: -100%; /* Move outside of the screen */
            }
        }

        .alert .fa-exclamation-circle {
            position: absolute;
            left: 20px;
            top: 50%;
            transform: translateY(-50%);
            color: #ce8500;
            font-size: 30px;
        }

        .alert .msg {
            font-size: 18px;
            display: inline-block;
            padding: 2px 20px 0 10px;
        }

        .alert .close-btn {
            font-size: 25px;
            position: absolute;
            color: #721c24;
            right: 0px;
            top: 47%;
            transform: translateY(-50%);
            padding: 0 5px;
            cursor: pointer;
            border: none;
            background-color: #f8d7da !important;
        }

        .alert .close-btn:hover {
            color: #ffc766;
        }

        /* Define styles for different alert types */
        .error {
            background: #f8d7da; /* Red color for error alerts */
            color: #721c24;
        }
        .error_icon ion-icon{
            color: #721c24;
            margin-top: 5px;
        }
    </style>

<body class="hold-transition register-page">
<!-- Define the hideAlertMessage() function globally -->
<script>
    function hideAlertMessage() {
        var alertContainer = document.getElementById('alertMessageContainer');
        alertContainer.classList.add('hide');
    }
</script>
<?php
    // Check if an alert message is present in the URL parameter
    if(isset($_GET['alert'])) {
        // Display the alert message
        echo "<script>showAlertMessage('" . htmlspecialchars($_GET['alert']) . "', 'error');</script>";
    }
?>
<?php
    // Check if the error session variable is set and display the error message
    if (isset($_SESSION['error']) && $_SESSION['error']) {
        // Display the error alert message
        echo "<script>showAlertMessage('" . htmlspecialchars($_SESSION['error']) . "', 'error');</script>";
        // Unset the session variable to avoid showing the message again on page refresh
        unset($_SESSION['error']);
    }
?>
<!-- Your HTML content -->
<div class="main-alert">
    <div class="alert hide error" id="alertMessageContainer">
        <span class="error_icon"><ion-icon name="alert-circle-outline"></ion-icon></span>
        <div class="msg" id="alertMessage"><?php echo isset($message) ? $message : ''; ?></div>
        <button class="close-btn"><span onclick="hideAlertMessage()">&times;</span></button>
    </div>
</div>

<!-- ALERT SCRIPT -->
<script>
    // Define showAlertMessage function
    function showAlertMessage(message, type) {
        var alertContainer = document.getElementById('alertMessageContainer');
        var alertMessage = document.getElementById('alertMessage');
        var icon = alertContainer.querySelector('.icon');

        // Update alert message content
        alertMessage.textContent = message;

        // Show the alert
        alertContainer.classList.remove('hide');

        // Hide the alert after 5 seconds
        setTimeout(hideAlertMessage, 5000);
    }

    // Call showAlertMessage function if message is set
    <?php echo isset($_GET['alert']) ? "showAlertMessage('" . htmlspecialchars($_GET['alert']) . "', 'error');" : ''; ?>
</script>

    <div class="login-box">
         <img src="../customer_assets/images/logo/login-banner.png" alt="subscribe newsletter" height="150" width="200">
        
        <div class="login-box-body">
            <p class="login-box-msg">Forgot Password</p>
            <p class="login-box-msg2">Enter you email address</p>

            <form action="verify_email.php" method="POST">
                <div class="form-group has-feedback">
                    <input type="email" class="input-form" name="email" placeholder="Email" required>
                </div>
                <div class="row">
                    <div class="col-xs-4">
                        <button type="submit" class="btn btn-primary send-btn" name="reset"><i class="fa fa-mail-forward"></i> Send</button>
                    </div>
                </div>
            </form>
            <div class="option_btn" style="text-align: center;">
                <a href="login.php" class="Iremember"></ion-icon>Back</a>
                <a href="index.php" class="home"></ion-icon> Cancel</a>
            </div>
        </div>
    </div>

    <?php include '../includes/scripts.php' ?>
</body>
</html>
