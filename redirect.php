<?php
include 'includes/session.php';
$user_id = $user['id'];
echo $user_id;
if (isset($_SESSION['checkout_session_id'])) {
    $payid = $_SESSION['checkout_session_id'];
    $date = date('Y-m-d');

    // Fetch the checkout session data using cURL
    $curl = curl_init();

    curl_setopt_array($curl, [
        CURLOPT_URL => "https://api.paymongo.com/v1/checkout_sessions/$payid",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "GET",
        CURLOPT_HTTPHEADER => [
            "accept: application/json",
            "authorization: Basic c2tfdGVzdF9qcGpDUGdGdWt4cm5DM1FSOHBFbk5jWTc6"
        ],
    ]);

    $response = curl_exec($curl);
    $err = curl_error($curl);

    curl_close($curl);

    if ($err) {
        echo "cURL Error #:" . $err;
        exit;
    } else {
        $checkout_session = json_decode($response, true);
    }

    // Extract necessary details from the response
    $billing = $checkout_session['data']['attributes']['billing'];
    $line_items = $checkout_session['data']['attributes']['line_items'];
    $payments = $checkout_session['data']['attributes']['payments'];

    // Example of accessing payment details
    foreach ($payments as $payment) {
        $payment_id = $payment['id'];
        $payment_status = $payment['status'];
        // Process or echo details as needed
    }
    try {
        $user_id = $user['id'];
        $sales_date = $date;
        $stmt = $conn->prepare("INSERT INTO sales (user_id, pay_id, sales_date) VALUES (?, ?, ?)");
        $stmt->bind_param("iss", $user_id, $payment_id, $sales_date);

        $stmt->execute();
        $salesid = $conn->insert_id;

        try {
            // Insert line items into details table and deduct stock from products
            foreach ($line_items as $item) {
                $product_id = getProductIdByName($item['name'], $conn); // Pass $conn as a parameter
                echo "Product ID for " . $item['name'] . ": " . $product_id . "<br>"; // Debugging
                if ($product_id !== null) {
                    $stmt = $conn->prepare("INSERT INTO details (sales_id, product_id, quantity) VALUES (?, ?, ?)");
                    $stmt->bind_param("iii", $sales_id, $product_id, $quantity);
                    $sales_id = $salesid;
                    $quantity = $item['quantity'];
                    $stmt->execute();

                    // Deduct stock from products
                    $stmt = $conn->prepare("UPDATE products SET stock = stock - ? WHERE id = ?");
                    $stmt->bind_param("ii", $quantity, $product_id);
                    $stmt->execute();
                } else {
                    echo "Product ID is null for " . $item['name'] . "<br>"; // Debugging
                }
            }

            $sql = "DELETE FROM cart WHERE user_id = $user_id";
            $result = mysqli_query($conn, $sql);

            $_SESSION['success'] = 'Transaction successful. Thank you.';
        } catch (Exception $e) {
            $_SESSION['error'] = $e->getMessage();
        }
    } catch (Exception $e) {
        $_SESSION['error'] = $e->getMessage();
    }

}

header('location: profile.php');

function getProductIdByName($name, $conn)
{ // Pass $conn as a parameter

    $stmt = $conn->prepare("SELECT id FROM products WHERE name = ?");
    $stmt->bind_param("s", $name);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        return $row['id'];
    } else {
        return null;
    }
}