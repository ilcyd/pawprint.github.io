<?php
include 'includes/session.php';

if (isset($_POST['id'])) {
    $saleId = $_POST['id'];

    // Ensure the ID is safely handled to prevent SQL injection
    $saleId = mysqli_real_escape_string($conn, $saleId);

    // Query the database for sale details using the saleId
    $query = "SELECT s.sales_date, u.firstname, u.lastname, p.name, d.quantity, p.price
              FROM sales s
              JOIN users u ON s.user_id = u.id
              JOIN details d ON s.id = d.sales_id
              JOIN products p ON d.product_id = p.id
              WHERE s.pay_id = ?";  // Assuming pay_id is used as saleId

    // Prepare the query
    $stmt = $conn->prepare($query);
    $stmt->bind_param('s', $saleId);  // 's' for string
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $details = '';
        while ($row = $result->fetch_assoc()) {
            $details .= '<p>' . $row['name'] . ' - ' . $row['quantity'] . ' x ' . '&#8369; ' . number_format($row['price'], 2) . '</p>';
        }

        // Respond with success and sale details
        echo json_encode([
            'success' => true,
            'details' => $details
        ]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Sale not found.']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Sale ID not provided.']);
}
?>
