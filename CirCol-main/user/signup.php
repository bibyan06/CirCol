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
    <title>SignUp</title>
    <link rel="shortcut icon" type="x-icon" href="../customer_assets/images/about.svg">
  	<link rel="stylesheet" href="cart.css">
    <!-- Google Fonts -->
    <link href="https://fonts.gstatic.com" rel="preconnect">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">
    <!--- custom css link -->
    <link rel="stylesheet" href="../customer_assets/css/style-prefix.css">
    <!--- google font link-->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800;900&display=swap"rel="stylesheet">
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
            
    <style>
        body {
            /* background-image: url("../customer_assets/images/BU_Torch_Banner.jpg"); */
            background: #f6f9ff;
            background-repeat: no-repeat;
            /* Center and scale the image nicely */
            background-position: center;
            background-size: cover;
        }

        .register-box {
            margin: 150px auto; /* Center the register box */
            width: 400px; /* Set a width for the register box */
            background-color: #fff; /* Set a background color for the register box */
            padding: 20px; /* Add some padding */
            border-radius: 5px; /* Add border radius for rounded corners */
            box-shadow: 0px 0 30px rgba(1, 41, 112, 0.1);
        }

        .register-box-body {
            padding: 20px; /* Add some padding */
        }

        .input-form {
            padding: 5px;
            font-size: 16px;
        }

        .group-form {
           margin-bottom: 10px;
        }

        .upload{
            font-size: 16px;
        }

        .btn-primary {
            background-color:#183661;
            color: #fd851f;
            border: none;
            font-weight: 650;
            border-radius: 30px;
        }

        .btn-primary:hover {
            background-color: #fd851f;
            color: #183661;
        }

        a {
            color: #007bff; /* Set link color */
            font-size: 15px;
            margin: 0;
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
            font-size: 22px;
            font-weight: 500;
            color: #061e39;
        }

        .login-box-msg2{
            text-align: center;
            font-size: 16px;
            color: gray;
        }
        
        .signup-btn{
            width: 100%;
            padding: 5px;
            text-align: center;
            font-size: 16px;
        }
        .register-box-body a{
            /*display: flex;*/
        }

        .register-box-body img{
            margin-right: auto;
            margin-left: auto;
            padding-bottom: 10px;
        }

        a ion-icon{
            font-size: 20px;
            padding-right: 5px;
        }
        .footer{
            margin-top: 10px;
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
            top: 50%;
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
        .success {
            background: #d4edda; /* Green color for success alerts */
            color: #155724;
        }
        .success_icon ion-icon{
            color: #155724;
        }
    </style>

<body>
<!-- Define the hideAlertMessage() function globally -->
<script>
    function hideAlertMessage() {
        var alertContainer = document.getElementById('alertMessageContainer');
        alertContainer.classList.add('hide');
    }
</script>

<!----------- ERROR ALERT ------------->
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
        var icon = alertContainer.querySelector('.error_icon');

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

    <div class="register-box">
        <div class="register-box-body">
            <img src="../customer_assets/images/logo/login-banner.png" alt="subscribe newsletter" height="150" width="200">
            <p class="login-box-msg">Register a new membership</p>
            <p class="login-box-msg2">Enter your information</p>
            <br>
            <form action="register.php" method="POST" enctype="multipart/form-data">
                <div class="group-form has-feedback">
                    <input type="text" class="input-form" name="firstname" placeholder="Firstname" required>
                </div>
                <div class="group-form has-feedback">
                    <input type="text" class="input-form" name="lastname" placeholder="Lastname" required>
                </div>
                <div class="group-form has-feedback">
                    <input type="email" class="input-form" name="email" placeholder="Email" required>
                </div>
                <div class="group-form has-feedback">
                    <input type="password" class="input-form" name="password" placeholder="Password" required>
                </div>
                <div class="group-form has-feedback">
                    <input type="address" class="input-form" name="address" placeholder="Address" required>
                </div>
                <div class="group-form has-feedback">
                    <input type="text" class="input-form" id="contact_info" name="contact_info" placeholder="Contact Info" required>
                </div>
                <div class="group-form has-feedback upload">
                    <label for="photo">Upload Profile</label>
                    <input type="file" class="form-control-file" id="photo" name="photo">
                </div>

                <div class="row">
                    <div class="col-xs-4">
                        <button type="submit" class="btn btn-primary signup-btn" name="signup"><i class="fa fa-pencil"></i> Sign Up</button>
                    </div>
                </div>
            </form> 
            <div class="footer" style="text-align: center;">
                <a href="login.php"></ion-icon>Back</a>
                <a href="index.php" class="home"></ion-icon>Cancel</a>
            </div>
        </div>
    </div>
</body>
</html>
