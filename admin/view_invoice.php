<?php
include 'includes/session.php';
include 'includes/header.php';

if (isset($_GET['order_id'])) {
    $order_id = $_GET['order_id'];

    // Fetch order details
    $sql_order = "SELECT orders.id, orders.date_created, orders.total_with_tax, users.firstname, users.lastname, users.address
                  FROM orders
                  JOIN users ON orders.customer_id = users.id
                  WHERE orders.id = '$order_id'";
    $order_result = mysqli_query($conn, $sql_order);
    $order = mysqli_fetch_assoc($order_result);

    // Fetch order items
    $sql_items = "SELECT order_items.quantity, order_items.price, products.name
                  FROM order_items
                  JOIN products ON order_items.product_id = products.id
                  WHERE order_items.order_id = '$order_id'";
    $items_result = mysqli_query($conn, $sql_items);

    // Calculate the tax and amount before tax
    $tax = $order['total_with_tax'] / 1.05 * 0.05; // 5% tax from the total
    $total_without_tax = $order['total_with_tax'] / 1.05; // Amount without tax

    $dateTime = explode(' ', $order['date_created']); // Splits into [date, time]
    $date = $dateTime[0]; // Extract date part
    $time = $dateTime[1]; // Extract time part
} else {
    echo "Order ID is not specified.";
    exit;
}
?>
<!DOCTYPE html>
<html>

<head>
    <style>
        .invoice-box {
            max-width: 800px;
            margin: auto;
            padding: 30px;
            border: 1px solid #eee;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.15);
            font-size: 16px;
            line-height: 24px;
            font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif;
            color: #555;
        }

        .invoice-box table {
            width: 100%;
            line-height: inherit;
            text-align: left;
        }

        .invoice-box table td {
            padding: 5px;
            vertical-align: top;
        }

        .invoice-box table tr td:nth-child(2) {
            text-align: right;
        }

        .invoice-box table tr.top table td {
            padding-bottom: 20px;
        }

        .invoice-box table tr.information table td {
            padding-bottom: 40px;
        }

        .invoice-box table tr.heading td {
            background: #eee;
            border-bottom: 1px solid #ddd;
            font-weight: bold;
        }

        .invoice-box table tr.details td {
            padding-bottom: 20px;
        }

        .invoice-box table tr.item td {
            border-bottom: 1px solid #eee;
        }

        .invoice-box table tr.item.last td {
            border-bottom: none;
        }

        .invoice-box table tr.total td:nth-child(2) {
            border-top: 2px solid #eee;
            font-weight: bold;
        }

        .invoice-box table .tax-row {
            background-color: #f9f9f9;
            font-weight: bold;
        }
    </style>
</head>

<body>
    <div class="invoice-box">
        <table>
            <tr class="top">
                <td colspan="2">
                    <table>
                        <tr>
                            <td>
                                <strong>Invoice #: </strong><?php echo $order['id']; ?><br>
                                <strong>Date: </strong><?php echo $date; ?><br>
                                <strong>Time: </strong><?php echo $time; ?><br>
                            </td>
                            <td>
                                <strong>Ipil Pet Doctors</strong><br>
                                Purok Dahlia, Lower Taway, Ipil, Zamboanga Sibugay<br>
                                Contact: (062)957-6029<br>
                                Email: ipdvc2023@gmail.com
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr class="information">
                <td colspan="2">
                    <table>
                        <tr>
                            <td>
                                <strong>Bill To:</strong><br>
                                <?php echo $order['firstname'] . ' ' . $order['lastname']; ?><br>
                                <?php echo $order['address']; ?>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr class="heading">
                <td>Item</td>
                <td>Price</td>
                <td>Quantity</td>
                <td>Total</td>
            </tr>
            <?php while ($item = mysqli_fetch_assoc($items_result)) { ?>
                <tr class="item">
                    <td><?php echo $item['name']; ?></td>
                    <td>₱<?php echo number_format($item['price'], 2); ?></td>
                    <td><?php echo $item['quantity']; ?></td>
                    <td>₱<?php echo number_format($item['price'] * $item['quantity'], 2); ?></td>
                </tr>
            <?php } ?>
            <!-- Tax Row -->
            <tr class="tax-row">
                <td colspan="3">Tax (5%):</td>
                <td>₱<?php echo number_format($tax, 2); ?></td>
            </tr>
            <!-- Grand Total Row -->
            <tr class="total">
                <td></td>
                <td colspan="3">Total (Excluding Tax): ₱<?php echo number_format($total_without_tax, 2); ?></td>
            </tr>
            <tr class="total">
                <td></td>
                <td colspan="3">Grand Total: ₱<?php echo number_format($order['total_with_tax'], 2); ?></td>
            </tr>
        </table>
    </div>
    <script>
        window.print(); // Automatically print the invoice
    </script>
</body>

</html>
