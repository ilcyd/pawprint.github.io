<?php
// Include session.php for session handling
include ('includes/session.php');

// Initialize output array
$output = array('error' => false);

// Check if 'id' is set in POST data
if (isset($_POST['id'])) {
    // Sanitize the received ID to prevent SQL injection
    $id = filter_var($_POST['id'], FILTER_SANITIZE_NUMBER_INT);

    // Check if the user is logged in
    if (isset($_SESSION['user'])) {
        // User is logged in, delete the item from the database cart
        $query = "DELETE FROM cart WHERE id = ?";
        $statement = mysqli_prepare($conn, $query);

        if (!$statement) {
            $output['error'] = true;
            $output['message'] = 'MySQL prepare error: ' . mysqli_error($conn);
        } else {
            mysqli_stmt_bind_param($statement, 'i', $id);
            $result = mysqli_stmt_execute($statement);

            if ($result) {
                // Return a JSON response indicating success
                $output['message'] = 'Item removed from cart successfully.';
            } else {
                // Return a JSON response indicating error
                $output['error'] = true;
                $output['message'] = 'Failed to remove item from cart: ' . mysqli_stmt_error($statement);
            }
        }
    } else {
        // User is not logged in, delete the item from the session cart
        if (isset($_SESSION['cart'])) {
            foreach ($_SESSION['cart'] as $key => $row) {
                if ($row['productid'] == $id) {
                    unset($_SESSION['cart'][$key]);
                    $output['message'] = 'Item removed from cart successfully.';
                    break;
                }
            }
        }
    }
} else {
    // Return a JSON response indicating missing ID
    $output['error'] = true;
    $output['message'] = 'Item ID not provided.';
}

// Set content type header
header('Content-Type: application/json');

// Output the JSON response
echo json_encode($output);

// Stop further execution
exit();
