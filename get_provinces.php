<?php
include ('includes/session.php');

// Initialize the options variable
$options = "<option value=''>Select Province</option>";

try {
    // Prepare and execute query to fetch all provinces
    $stmt = $conn->prepare("SELECT * FROM provinces");
    $stmt->execute();
    $result = $stmt->get_result();

    // Generate the HTML options for provinces dropdown
    while ($row = $result->fetch_assoc()) {
        $options .= "<option value='" . $row['province_id'] . "'>" . $row['province_name'] . "</option>";
    }

    echo $options;
} catch (Exception $e) {
    // Handle any errors
    echo "<option value=''>Error fetching provinces</option>";
}
?>