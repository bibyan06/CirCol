<?php
    $sql = "SELECT COUNT(*) AS order_count FROM orders WHERE seller_id = :seller_id";
    // Apply filters for Today, This Month, and This Year
    // You need to adjust the date filtering conditions based on your database structure
    if (isset($_GET['filter_customers'])) {
        $filter_customers = $_GET['filter_customers'];
        switch ($filter_customers) {
            case 'Customers_today':
                $sql .= " AND DATE(order_date) = CURDATE()";
                break;
            case 'Customers_this_month':
                $sql .= " AND YEAR(order_date) = YEAR(CURRENT_DATE()) AND MONTH(order_date) = MONTH(CURRENT_DATE())";
                break;
            case 'Customers_this_year':
                $sql .= " AND YEAR(order_date) = YEAR(CURRENT_DATE())";
                break;
            default:
                // Default to count all orders
                break;
        }
    }

    try {
        // Prepare the SQL statement
        $stmt = $pdo->prepare($sql);
        // Bind the seller_id parameter
        $stmt->bindParam(':seller_id', $seller_id, PDO::PARAM_INT);
        // Execute the query
        $stmt->execute();
        // Fetch the result
        $order_count = $stmt->fetchColumn();
    } catch(PDOException $e) {
        // Handle any errors
        echo "Error: " . $e->getMessage();
    }

?>
<!-- Customers Card -->
<div class="col-xxl-4 col-xl-12">
    <div class="card info-card customers-card">
        <div class="filter">
            <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
            <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                <li class="dropdown-header text-start">
                    <h6>Filter</h6>
                </li>
                <li><a class="dropdown-item" href="?filter_customers=Customers_today&card=customers">Customers Today</a></li>
                <li><a class="dropdown-item" href="?filter_customers=Customers_this_month&card=customers">Customers This Month</a></li>
                <li><a class="dropdown-item" href="?filter_customers=Customers_this_year&card=customers">Customers This Year</a></li>
            </ul>
        </div>

        <div class="card-body">
            <?php
            // Display filter text based on the selected filter
            $filter_customers_text = isset($_GET['filter_customers']) ? ucwords($_GET['filter_customers']) : 'Customers_today';
            ?>
            <h5 class="card-title">Customers <span>| <?php echo $filter_customers_text; ?></span></h5>

            <div class="d-flex align-items-center">
                <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                    <i class="bi bi-people"></i>
                </div>
                <div class="ps-3">
                    <h6><?php echo $order_count; ?></h6>
                    <!-- You can style the decrease percentage based on your design -->
                    <!-- Here, I'm just displaying a static text -->
                    <span class="text-danger small pt-1 fw-bold">12%</span> <span class="text-muted small pt-2 ps-1">decrease</span>
                </div>
            </div>
        </div>
    </div>
</div><!-- End Customers Card -->