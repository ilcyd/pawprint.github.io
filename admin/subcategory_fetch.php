<?php
include 'includes/session.php';

$output = '';

if (isset($_POST['category_id'])) {
    $category_id = $_POST['category_id'];

    // Prepare SQL query to select subcategories based on category_id
    $sql = "SELECT * FROM subcategory WHERE category_id = '$category_id'";
    $result = mysqli_query($conn, $sql);

    // Check if there are any subcategories
    if (mysqli_num_rows($result) > 0) {
        // Loop through each subcategory and append options to $output
        while ($row = mysqli_fetch_assoc($result)) {
            $output .= "<option value='" . $row['id'] . "' class='append_items'>" . $row['name'] . "</option>";
        }
    } else {
        $output = "<option value='0'>No subcategories found</option>";
    }

    // Close database connection
    mysqli_close($conn);
}

echo json_encode($output);