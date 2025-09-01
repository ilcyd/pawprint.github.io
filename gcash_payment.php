<?php
include 'includes/session.php';

$line_items = [];
$total = 0;

// Initialize billing info
$billing_name = '';
$billing_email = '';
$billing_phone = '';

if (isset($_SESSION['user'])) {
    // User is logged in, fetch cart details from the database
    $user_id = $user['id'];
    $cart_query = "SELECT *, cart.quantity AS cart_quantity FROM cart LEFT JOIN products ON products.id=cart.product_id WHERE user_id='$user_id'";
    $cart_result = $conn->query($cart_query);
    $cart_result = $conn->query($cart_query);
    if ($cart_result->num_rows > 0) {
        while ($row = $cart_result->fetch_assoc()) {
            $line_item = [
                'currency' => 'PHP',
                'amount' => intval($row['price'] * 100),
                'name' => $row['name'],
                'quantity' => intval($row['cart_quantity'])
            ];
            $line_items[] = $line_item;
            $total += $row['price'] * $row['cart_quantity'] * 100;
        }
        // Set billing info from session user
        $billing_name = $user['firstname'] . ' ' . $user['lastname'];
        $billing_email = $user['email'];
        $billing_phone = $user['contact'];
    }
} else {
    // User is not logged in, fetch cart details from the session
    if (isset($_SESSION['cart'])) {
        foreach ($_SESSION['cart'] as $row) {
            $product_id = $row['productid'];
            $product_query = "SELECT * FROM products WHERE id='$product_id'";
            $product_result = $conn->query($product_query);
            if ($product_result->num_rows > 0) {
                $product = $product_result->fetch_assoc();
                $line_item = [
                    'currency' => 'PHP',
                    'amount' => intval($product['price'] * 100),
                    'name' => $product['name'],
                    'quantity' => $row['quantity']
                ];
                $line_items[] = $line_item;
                $total += $product['price'] * $row['quantity'] * 100;
            }
        }
    }
}

// Calculate the fee
$fee = intval($total * 0.026);

// Add fee as a separate line item
$line_items[] = [
    'currency' => 'PHP',
    'amount' => $fee,
    'name' => 'Transaction Fee',
    'quantity' => 1
];

// Adjust total to include the fee
$total += $fee;

// Create cURL request
$curl = curl_init();
curl_setopt_array($curl, [
    CURLOPT_URL => "https://api.paymongo.com/v1/checkout_sessions",
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => "",
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 30,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => "POST",
    CURLOPT_POSTFIELDS => json_encode([
        'data' => [
            'attributes' => [
                'cancel_url' => 'http://localhost/pawprint_final/cart_view.php',
                'billing' => [
                    'name' => $billing_name,
                    'email' => $billing_email,
                    'phone' => $billing_phone
                ],
                'description' => 'Checkout for purchase',
                'line_items' => $line_items,
                'payment_method_types' => ['gcash'],
                'reference_number' => '123123', // Replace with a unique reference number if needed
                'send_email_receipt' => false,
                'show_description' => true,
                'show_line_items' => true,
                'success_url' => 'http://localhost/pawprint_final/redirect.php',
                'statement_descriptor' => 'Your Business Name' // Replace with your business name
            ]
        ]
    ]),
    CURLOPT_HTTPHEADER => [
        "Content-Type: application/json",
        "accept: application/json",
        "authorization: Basic c2tfdGVzdF9qcGpDUGdGdWt4cm5DM1FSOHBFbk5jWTc6" // Replace with your actual API key
    ],
]);

// Execute cURL request
$response = curl_exec($curl);
$err = curl_error($curl);

// Close cURL session
curl_close($curl);

// Check for cURL errors
if ($err) {
    echo "cURL Error #:" . $err;
} else {
    // Decode cURL response
    $decoded = json_decode($response, true);
    if (isset($decoded['data']['attributes']['checkout_url'])) {
        // Redirect to the checkout URL
        $checkout_url = $decoded['data']['attributes']['checkout_url'];
        $checkout_session_id = $decoded['data']['id'];
        $_SESSION['checkout_session_id'] = $checkout_session_id;
        echo "<script>window.location.href='$checkout_url'</script>";
    } else {
        echo "Error creating checkout session. Please try again.";
        var_dump($decoded); // Debugging output to see the error response
    }
}