<?php
include 'includes/session.php';

$output = '';

// Query to select categories
$sql = "SELECT * FROM category";
$result = mysqli_query($conn, $sql);

// Check if there are any categories
if (mysqli_num_rows($result) > 0) {
    // Loop through each category and append options to $output
    while ($row = mysqli_fetch_assoc($result)) {
        $output .= "<option value='" . $row['id'] . "' class='append_items'>" . $row['name'] . "</option>";
    }
} else {
    $output = "<option value='0'>No categories found</option>";
}


// Output JSON-encoded $output
echo json_encode($output);