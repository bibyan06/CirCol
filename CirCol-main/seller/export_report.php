<?php
// Include database connection details
include_once 'db.php'; // Assuming db.php contains the database connection
require_once 'tcpdf/tcpdf.php'; // Include TCPDF library

// Check if $conn is set and not null
if ($conn) {
    $seller_id = $user['id']; // Get the seller's ID from the session user
    $selectedMonth = $_POST['selectedMonth']; // Get selected month from AJAX request

    // Prepare and execute the SQL query to retrieve filtered orders for the seller
    $stmt = $conn->prepare("SELECT * FROM orders WHERE seller_id = ? AND MONTH(order_date) = ? ORDER BY order_date DESC"); // Add filter by month
    $stmt->bind_param("ii", $seller_id, $selectedMonth);
    $stmt->execute();
    $result = $stmt->get_result();

    // Create PDF
    $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
    $pdf->SetCreator(PDF_CREATOR);
    $pdf->SetAuthor('Your Name');
    $pdf->SetTitle('Order Report');
    $pdf->SetSubject('Order Report');
    $pdf->SetKeywords('Order, Report');

    $pdf->SetFont('helvetica', '', 10);

    $pdf->AddPage();

    // Iterate through fetched orders and add them to the PDF
    while ($row = $result->fetch_assoc()) {
        // Add order details to PDF
        $pdf->Cell(0, 10, 'Firstname: ' . $row['firstname'], 0, 1);
        $pdf->Cell(0, 10, 'Lastname: ' . $row['lastname'], 0, 1);
        // Add other order details similarly
    }

    // Close the statement and connection
    $stmt->close();
    $conn->close();

    // Output PDF as a download
    $pdf->Output('order_report.pdf', 'D');

} else {
    // Database connection not available
    echo "Database connection not available.";
}
?>
