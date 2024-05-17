<?php
    // Count total sales quantity
    $sales_quantity = 0; // Initialize sales quantity variable

    // Construct the SQL query to sum up the quantity of ordered products
    $sql = "SELECT SUM(quantity) AS total_sales_quantity FROM orders WHERE seller_id = :seller_id";

    // Apply filters for Today, This Month, and This Year
    // You need to adjust the date filtering conditions based on your database structure
    if (isset($_GET['filter_sales'])) {
        $filter_sales = $_GET['filter_sales'];
        switch ($filter_sales) {
            case 'Sales_today':
                $sql .= " AND DATE(order_date) = CURDATE()";
                break;
            case 'Sales_this_month':
                $sql .= " AND YEAR(order_date) = YEAR(CURRENT_DATE()) AND MONTH(order_date) = MONTH(CURRENT_DATE())";
                break;
            case 'Sales_this_year':
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
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        // Extract the total sales quantity
        $sales_quantity = $result['total_sales_quantity'];
    } catch(PDOException $e) {
        // Handle any errors
        echo "Error: " . $e->getMessage();
    }
?>
<!-- Sales Card -->
<div class="col-xxl-4 col-md-6">
    <div class="card info-card sales-card">

        <div class="filter">
            <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
            <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                <li class="dropdown-header text-start">
                    <h6>Filter</h6>
                </li>
                <li><a class="dropdown-item" href="?filter_sales=Sales_today&card=sales">Sales Today</a></li>
                <li><a class="dropdown-item" href="?filter_sales=Sales_this_month&card=sales">Sales This Month</a></li>
                <li><a class="dropdown-item" href="?filter_sales=Sales_this_year&card=sales">Sales This Year</a></li>
            </ul>
        </div>

        <div class="card-body">
            <?php
            // Determine filter text based on the selected filter
            $filter_sales_text = isset($_GET['filter_sales']) ? ucwords($_GET['filter_sales']) : 'Sales_today';
            ?>
            <h5 class="card-title">Sales <span>| <?php echo $filter_sales_text; ?></span></h5>

            <div class="d-flex align-items-center">
                <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                    <i class="bi bi-cart"></i>
                </div>
                <div class="ps-3">
                    <h6><?php echo $sales_quantity; ?></h6>
                    <!-- You can style the increase/decrease percentage based on your design -->
                    <!-- Here, I'm just displaying a static text -->
                    <span class="text-success small pt-1 fw-bold">12%</span> <span class="text-muted small pt-2 ps-1">increase</span>
                </div>
            </div>
        </div>

    </div>
</div><!-- End Sales Card -->