<?php
include ('includes/session.php');

// Initialize the options variable
$options = "<option value=''>Select Municipality</option>";

try {
    if (isset($_POST['province_id'])) {
        $provinceId = $_POST['province_id'];

        // Prepare and execute query to fetch municipalities based on the selected province
        $stmt = $conn->prepare("SELECT * FROM municipalities WHERE province_id = ?");
        $stmt->bind_param("i", $provinceId);
        $stmt->execute();
        $result = $stmt->get_result();

        // Generate the HTML options for municipalities dropdown
        while ($row = $result->fetch_assoc()) {
            $options .= "<option value='" . $row['municipality_id'] . "'>" . $row['municipality_name'] . "</option>";
        }

        echo $options;
    }
} catch (Exception $e) {
    // Handle any errors
    echo "<option value=''>Error fetching municipalities</option>";
}
?>