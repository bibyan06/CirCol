<?php
    // Start the session
    session_start();

    // Check if the user is logged in
    if (!isset($_SESSION['seller'])) {
        // Redirect to login page if not logged in
        header("Location: login.php");
        exit();
    }

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

    // Retrieve user information from session variable
    $user = $_SESSION['seller'];
    $seller_id = $user['id']; // Assuming the seller's ID is stored in the 'id' field of the user array
    
    // Construct SQL query to fetch user information
    $sql = "SELECT * FROM users WHERE id = $seller_id";

    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();

        // Calculate commission revenue
        $commissionRevenue = 0;

        // Query to fetch all orders
        $ordersQuery = "SELECT * FROM orders";
        $ordersResult = $conn->query($ordersQuery);

        if ($ordersResult->num_rows > 0) {
            while ($order = $ordersResult->fetch_assoc()) {
                // Calculate commission for each order (5% of total price)
                $commission = $order['total_price'] * 0.05;
                $commissionRevenue += $commission;
            }
        }

        // Query to count active users
        $activeUsersQuery = "SELECT COUNT(*) AS total_active_users FROM users WHERE status = '1'";
        $activeUsersResult = $conn->query($activeUsersQuery);
        $activeUsers = $activeUsersResult->fetch_assoc()['total_active_users'];

        // Query to count total categories
        $totalCategoriesQuery = "SELECT COUNT(*) AS total_categories FROM category";
        $totalCategoriesResult = $conn->query($totalCategoriesQuery);
        $totalCategories = $totalCategoriesResult->fetch_assoc()['total_categories'];

        // Close the database connection
        $conn->close();
    }
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <title>Dashboard</title>
    <meta content="" name="description">
    <meta content="" name="keywords">
    <link rel="shortcut icon" type="x-icon" href="../customer_assets/images/about.svg">
    
    <!-- Google Fonts -->
    <link href="https://fonts.gstatic.com" rel="preconnect">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">
    <!-- Vendor CSS Files -->
    <link href="../assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="../assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
    <!-- Template Main CSS File -->
    <link href="../assets/css/style.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>

    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
</head>

<body>
    <style>
        .activity-content a{
            color: #2a3e63f0;
        }
        .view_name{
            font-size: 15px;
            font-weight: 600 !important;
        }
        @media print{
            main{
                height: 100%;
                background: white !important;
            }
            body{
                padding: 0 !important;
                background-color: white !important;
            }
            #header {
                display: none !important;
                margin: 0;
                padding: 0 !important;
            }
            .pagetitle * {
                display: none;
            }
            .pagetitle  h1 * {
                display: none;
            }
            /* Modify margins */
            @page {
                margin: 10mm 10mm; /* Adjust the margin values as needed */
            }
            .buttons1{
                display: none !important;
            }
            footer{
                display: none !important;
            }
            .col-xxl-4{
                display: none !important;
            }
            .col-12{
                display: none !important;
            }
            .col-lg-4{
                display: none !important;
            }
            .card{
                margin-top: -50px;
                background-color: white !important;
            }
            .filter{
                display: none !important;
            }
        }

        #myPieChart{
            padding: 0 10px 20px 10px;
        }
    </style>

    <!-- ======= Header ======= -->
    <header id="header" class="header fixed-top d-flex align-items-center">
        <div class="d-flex align-items-center justify-content-between">
            <a href="index.html" class="logo d-flex align-items-center">
                <img src="../customer_assets/images/logo/ebuy_logo.svg" alt="">
                <!-- <span class="d-none d-lg-block">BUMM</span> -->
            </a>
            
            <i class="bi bi-list toggle-sidebar-btn"></i>
        </div><!-- End Logo -->

        <div class="search-bar">
            <form class="search-form d-flex align-items-center" method="POST" action="#">
                <input type="text" name="query" placeholder="Search" title="Enter search keyword">
                <button type="submit" title="Search"><i class="bi bi-search"></i></button>
            </form>
        </div><!-- End Search Bar -->

        <nav class="header-nav ms-auto">
            <ul class="d-flex align-items-center">

                <li class="nav-item d-block d-lg-none">
                <a class="nav-link nav-icon search-bar-toggle " href="#">
                    <i class="bi bi-search"></i>
                </a>
                </li><!-- End Search Icon-->

                <li class="nav-item dropdown pe-3">

                    <a class="nav-link nav-profile d-flex align-items-center pe-0" href="#" data-bs-toggle="dropdown">
                        <?php if (isset($user)): ?>
                            <?php
                            // Display the user's profile photo from the "images" folder
                            $photoFilename = "../images/" . $user['photo'];

                            if (file_exists($photoFilename)) {
                                echo '<img src="' . $photoFilename . '" alt="Profile Photo" class="rounded-circle" style="max-width: 100px;">';
                            } else {
                                // Display a default profile photo if the file doesn't exist
                                echo '<img src="default-profile-photo.jpg" alt="Default Profile Photo" class="rounded-circle" style="max-width: 100px;">';
                            }
                            ?>
                            <span class="d-none d-md-block dropdown-toggle ps-2"><?php echo $user['firstname'] ?></span>
                        <?php else: ?>
                            <!-- Default values if the user is not logged in -->
                            <img src="../assets/img/profile-img.jpg" alt="Profile" class="rounded-circle">
                            <span class="d-none d-md-block dropdown-toggle ps-2">Guest User</span>
                        <?php endif; ?>
                    </a><!-- End Profile Iamge Icon -->


                    <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow profile">
                        <li class="dropdown-header">
                            <h6><?php echo $user['firstname'] . ' ' . $user['lastname']; ?></h6>
                            <span>Designer</span>
                        </li>
                        <li>
                        <hr class="dropdown-divider">
                        </li>

                        <li>
                        <a class="dropdown-item d-flex align-items-center" href="users-profile.php">
                            <i class="bi bi-person"></i>
                            <span>My Profile</span>
                        </a>
                        </li>
                        <li>
                        <hr class="dropdown-divider">
                        </li>

                        <li>
                        <a class="dropdown-item d-flex align-items-center" href="users-profile.php">
                            <i class="bi bi-gear"></i>
                            <span>Account Settings</span>
                        </a>
                        </li>
                        <li>
                        <hr class="dropdown-divider">
                        </li>

                        <li>
                        <a class="dropdown-item d-flex align-items-center" href="contactus.php">
                            <i class="bi bi-question-circle"></i>
                            <span>Need Help? Contact Us</span>
                        </a>
                        </li>
                        <li>
                        <hr class="dropdown-divider">
                        </li>

                        <li>
                        <a href="logout.php" class="dropdown-item d-flex align-items-center">
                            <i class="bi bi-box-arrow-right"></i>
                            <span>Sign Out</span>
                        </a>
                        </li>

                    </ul><!-- End Profile Dropdown Items -->
                </li><!-- End Profile Nav -->

            </ul>
        </nav><!-- End Icons Navigation -->

    </header><!-- End Header -->

    <!-- ======= Sidebar ======= -->
    <aside id="sidebar" class="sidebar">
        <ul class="sidebar-nav" id="sidebar-nav">
            <li class="nav-item">
                <a class="nav-link " href="home.php">
                <i class="bi bi-houses"></i>
                <span>Dashboard</span>
                </a>
            </li><!-- End Dashboard Nav -->

            <li class="nav-item">
                <a class="nav-link collapsed" data-bs-target="#components-nav" href="orders.php">
                <i class="bi bi-menu-button-wide"></i><span>Orders</span>
                </a>
            </li><!-- End Components Nav -->

            <li class="nav-item">
                <a class="nav-link collapsed" data-bs-target="#components-nav" href="done_orders.php">
                <i class="bi bi-cart-check"></i><span>Done Orders</span>
                </a>
            </li><!-- End Components Nav -->

            <li class="nav-item">
                <a class="nav-link collapsed" data-bs-target="#components-nav" href="product_list.php">
                    <i class="bi bi-journal-text"></i>
                <span>Product List</span>
                </a>
            </li><!-- End Dashboard Nav -->

            <li class="nav-heading">Pages</li>

            <li class="nav-item">
                <a class="nav-link collapsed" href="users-profile.php">
                <i class="bi bi-person"></i>
                <span>Profile</span>
                </a>
            </li><!-- End Profile Page Nav -->

            <li class="nav-item">
                <a class="nav-link collapsed" href="contactus.php">
                <i class="bi bi-envelope"></i>
                <span>Contact</span>
                </a>
            </li><!-- End Contact Page Nav -->

            <li class="nav-item">
                <a class="nav-link collapsed" href="logout.php">
                <i class="bi bi-box-arrow-in-right"></i>
                <span>Logout</span>
                </a>
            </li><!-- End Login Page Nav -->
        </ul>
    </aside><!-- End Sidebar-->


<main id="main" class="main">
    <div class="pagetitle">
      <h1>Dashboard</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="index.html">Home</a></li>
          <li class="breadcrumb-item active">Dashboard</li>
        </ol>
      </nav>
    </div><!-- End Page Title -->

    <section class="section dashboard">
      <div class="row">

        <!-- Left side columns -->
        <div class="col-lg-8">
          <div class="row">

            <!-- Active Users Card -->
            <div class="col-xxl-4 col-md-6">
              <div class="card info-card sales-card">

                <div class="card-body">
                  <h5 class="card-title">Active Users</h5>

                  <div class="d-flex align-items-center">
                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                        <i class="bi bi-people"></i>
                    </div>
                    <div class="ps-3">
                      <h6><?php echo $activeUsers; ?></h6>
                      <span class="text-success small pt-1 fw-bold">12%</span> <span class="text-muted small pt-2 ps-1">increase</span>
                    </div>
                  </div>
                </div>

              </div>
            </div><!-- End Active Users Card -->

            <!-- Revenue Card -->
            <div class="col-xxl-4 col-md-6">
                <div class="card info-card revenue-card">
                    <div class="card-body">
                        <h5 class="card-title">Commission Revenue</h5>
                        <div class="d-flex align-items-center">
                            <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                <i class="bi bi-currency-dollar"></i>
                            </div>
                            <div class="ps-3">
                                <h6>₱ <?php echo number_format($commissionRevenue, 2); ?></h6>
                                <!-- Assuming there's no previous commission revenue data, we cannot calculate the percentage increase. -->
                                <!-- You can modify this section accordingly if you have previous data. -->
                                <span class="text-success small pt-1 fw-bold">5%</span> <span class="text-muted small pt-2 ps-1">Product Purchase</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div><!-- End Revenue Card -->

            <!-- Category Card -->
            <div class="col-xxl-4 col-xl-12">

              <div class="card info-card customers-card">

                <div class="card-body">
                  <h5 class="card-title">Total Categories</h5>

                    <div class="d-flex align-items-center">
                        <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                          <ion-icon name="grid-outline"></ion-icon>
                        </div>
                        <div class="ps-3">
                        <h6><?php echo $totalCategories ; ?></h6>
                        <span class="text-danger small pt-1 fw-bold">12%</span> <span class="text-muted small pt-2 ps-1">decrease</span>
                        </div>
                    </div>

                </div>
              </div>

            </div><!-- End Category Card -->

            <!-- Reports -->
            <div class="col-12-1">
                <div class="card">
                    <div class="filter">
                        <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
                        <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                            <li><a class="dropdown-item" id="export_pdf" href="#">PRINT</a></li>
                        </ul>
                    </div>

                    <div class="card-body">
                        <h5 class="card-title">Reports</h5>
                        <canvas id="myBarChart" width="400" height="200"></canvas>
                    </div>
                </div>
            </div><!-- End Reports -->
            <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
            <script>
            // Get data from PHP variables
            var activeUsers = <?php echo $activeUsers; ?>;
            var commissionRevenue = <?php echo $commissionRevenue; ?>;
            var totalCategories = <?php echo $totalCategories; ?>;

            // Create chart data
            var ctx = document.getElementById('myBarChart').getContext('2d');
            var myBarChart = new Chart(ctx, {
                type: 'bar',
                data: {
                labels: ['Active Users', 'Commission Revenue', 'Total Categories'],
                datasets: [{
                    label: 'Today',
                    data: [activeUsers, commissionRevenue, totalCategories],
                    backgroundColor: [
                    'rgba(255, 99, 132, 0.2)', // Red for Active Users
                    'rgba(54, 162, 235, 0.2)', // Blue for Commission Revenue
                    'rgba(255, 206, 86, 0.2)' // Yellow for Total Categories
                    ],
                    borderColor: [
                    'rgba(255, 99, 132, 1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(255, 206, 86, 1)'
                    ],
                    borderWidth: 1
                }]
                },
                options: {
                scales: {
                    yAxes: [{
                    ticks: {
                        beginAtZero: true
                    }
                    }]
                }
                }
            });
            </script>

          </div>
        </div><!-- End Left side columns -->

        <!-- Right side columns -->
        <div class="col-lg-4">

            <!-- Recent Activity -->
            <?php
                // Database configuration
                $host = 'localhost';
                $dbname = 'circol';
                $username = 'root';
                $password = '';

                try {
                    // Create a new PDO instance
                    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
                    // Set PDO to throw exceptions on error
                    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                } catch (PDOException $e) {
                    // If connection fails, handle the exception
                    die("Connection failed: " . $e->getMessage());
                }

            ?>
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Most Viewed Product<span> | Today</span></h5>

                    <div class="activity">

                        <?php
                        // Fetch most viewed products for today
                        $now = date('Y-m-d');

                        $stmt = $pdo->prepare("SELECT * FROM products WHERE date_view=:now ORDER BY counter DESC LIMIT 10");
                        $stmt->execute(['now' => $now]);

                        // Check if there are any results
                        if ($stmt->rowCount() > 0) {
                            // Loop through the most viewed products
                            foreach ($stmt as $row) {
                                echo '<div class="activity-item d-flex">';
                                echo '<div class="activite-label">Product</div>';
                                echo '<i class="bi bi-circle-fill activity-badge text-success align-self-start"></i>';
                                echo '<div class="activity-content">';
                                echo '<a href="../user/product.php?product=' . $row['slug'] . '" class="view_name">' . $row['name'] . '</a>';
                                echo '</div>';
                                echo '</div><!-- End activity item-->';
                            }
                        } else {
                            // If there are no results
                            echo '<div class="activity-item d-flex">';
                            echo '<div class="activity-content">';
                            echo 'No products viewed today.';
                            echo '</div>';
                            echo '</div><!-- End activity item-->';
                        }

                        // Close the PDO connection
                        $pdo = null;
                        ?>

                    </div>
                </div>
            </div><!-- End Recent Activity -->

            <!-- Budget Report -->
            <div class="card">
                <div class="card-body pb-0">
                    <h5 class="card-title">Pie Chart</h5>
                    <canvas id="myPieChart" width="250" height="250"></canvas>
                </div>
            </div><!-- End Budget Report -->

            <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
            <script>
            var ctx = document.getElementById('myPieChart').getContext('2d');
            var myPieChart = new Chart(ctx, {
                type: 'pie',
                data: {
                labels: ['Active Users', 'Commission Revenue', 'Total Categories'],
                datasets: [{
                    label: 'Today',
                    data: [
                    <?php echo json_encode($activeUsers); ?>,
                    <?php echo json_encode($commissionRevenue); ?>,
                    <?php echo json_encode($totalCategories); ?>
                    ],
                    backgroundColor: [
                    'rgba(255, 99, 132, 0.6)', // Red for Active Users
                    'rgba(54, 162, 235, 0.6)', // Blue for Commission Revenue
                    'rgba(255, 206, 86, 0.6)' // Yellow for Total Categories
                    ],
                    borderColor: [
                    'rgba(255, 99, 132, 1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(255, 206, 86, 1)'
                    ],
                    borderWidth: 1
                }]
                },
                options: {
                responsive: true,
                legend: {
                    position: 'right',
                    labels: {
                    boxWidth: 20
                    }
                },
                animation: {
                    animateScale: true,
                    animateRotate: true
                }
                }
            });
            </script>
        </div><!-- End Right side columns -->
      </div>
    </section>

</main><!-- End #main -->

    <!-- Include jsPDF library -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.4.0/jspdf.umd.min.js"></script>
    <!-- TABLE PRINT -->
    <script>
        document.addEventListener("DOMContentLoaded", () => {
            // Add event listener to the export button
            document.getElementById('export_pdf').addEventListener('click', function () {
                // Get the table element
                const table = document.getElementById('myBarChart');

                // Open print dialog
                window.print();
            });
        });
    </script>

    <!-- ======= Footer ======= -->
    <footer id="footer" class="footer">
        <div class="copyright">
        &copy; Copyright <strong><span>NiceAdmin</span></strong>. All Rights Reserved
        </div>
        <div class="credits">
        Designed by <a href="https://bootstrapmade.com/">BootstrapMade</a>
        </div>
    </footer><!-- End Footer -->

    <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

    <!-- Vendor JS Files -->
    <script src="../assets/vendor/apexcharts/apexcharts.min.js"></script>
    <script src="../assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>


    <!-- Template Main JS File -->
    <script src="../assets/js/main.js"></script>

</body>

</html>
