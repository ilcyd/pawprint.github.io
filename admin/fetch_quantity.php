<?php
include 'includes/session.php';
include 'includes/format.php';

if (isset($_POST['start_date']) && isset($_POST['end_date'])) {
    $start_date = $_POST['start_date'];
    $end_date = $_POST['end_date'];

    $sql = "SELECT d.product_id, SUM(d.quantity) AS total_quantity_sold
            FROM details d
            JOIN sales s ON d.sales_id = s.id
            WHERE s.sales_date BETWEEN ? AND ?
            GROUP BY d.product_id
            ORDER BY total_quantity_sold DESC";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $start_date, $end_date);
    $stmt->execute();
    $result = $stmt->get_result();

    while ($row = $result->fetch_assoc()) {
        $product_id = $row['product_id'];
        $product_name_query = $conn->prepare("SELECT name FROM products WHERE id = ?");
        $product_name_query->bind_param("i", $product_id);
        $product_name_query->execute();
        $product_name_result = $product_name_query->get_result();
        $product_name_row = $product_name_result->fetch_assoc();
        $product_name = $product_name_row['name'];

        echo "
        <tr>
            <td>" . htmlspecialchars($product_name) . "</td>
            <td>" . htmlspecialchars($row['total_quantity_sold']) . "</td>
        </tr>
        ";
    }

    $stmt->close();
}
?>
