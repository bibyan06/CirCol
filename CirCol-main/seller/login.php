<!DOCTYPE html>
<html lang="en" >
<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title>CirCol - Seller</title>
    <meta content="" name="description">
    <meta content="" name="keywords">
    <link href="../customer_assets/images/about.svg" rel="icon">

    <!-- Google Fonts -->
    <link href="https://fonts.gstatic.com" rel="preconnect">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

    <!-- Vendor CSS Files -->
    <link href="../assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="../assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">

    <!-- Template Main CSS File -->
    <link href="../assets/css/style.css" rel="stylesheet">

    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>

    <style>
        .logo-img{
            text-align: center;
        }
        .pb-2 img{
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
</head>
<body>

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
        <div class="msg" id="alertMessage"><?php echo isset($alert_message) ? $alert_message : ''; ?></div>
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

<main>
    <div class="container">
      <section class="section register min-vh-100 d-flex flex-column align-items-center justify-content-center py-4">
        <div class="container">
          <div class="row justify-content-center">
            <div class="col-lg-4 col-md-6 d-flex flex-column align-items-center justify-content-center">
              <div class="card mb-3">
                <div class="card-body">
                    <div class="pt-4 pb-2">
                        <div class="logo-img">
                            <img src="../customer_assets/images/logo/ebuy_logo.svg" alt="subscribe newsletter">
                        </div>
                        <h5 class="card-title text-center pb-0 fs-4">SELLER LOGIN PAGE</h5>
                        <p class="text-center small">Enter your username & password to login</p>
                    </div>

                    <form class="row g-3 needs-validation" action="seller_verify.php" method="POST">
                        <div class="col-12">
                            <label for="yourUsername" class="form-label">Username</label>
                            <div class="input-group has-validation">
                                <span class="input-group-text" id="inputGroupPrepend">@</span>
                                <input type="email" class="form-control" name="email" placeholder="Email" required>
                                <div class="invalid-feedback">Please enter your username.</div>
                            </div>
                        </div>

                        <div class="col-12">
                            <label for="yourPassword" class="form-label">Password</label>
                            <input type="password" class="form-control" name="password" placeholder="Password" required>
                            <div class="invalid-feedback">Please enter your password!</div>
                        </div>

                        <div class="col-12">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="remember" value="true" id="rememberMe">
                                <label class="form-check-label" for="rememberMe">Remember me</label>
                            </div>
                        </div>
                        <div class="col-12">
                            <button class="btn btn-primary w-100" type="submit" name="login">Login</button>
                        </div>
                    </form>

                </div>
              </div>
            </div>
          </div>
        </div>
      </section>
    </div>
</main>
  <!-- End #main -->
  <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>
  <!-- Vendor JS Files -->
  <script src="../assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <!-- Template Main JS File -->
  <script src="../assets/js/main.js"></script>

</body>
</html>