<?php
include ('includes/session.php');
// Initialize the options variable
$options = "<option value=''>Select Barangay</option>";

try {
    if (isset($_POST['municipality_id'])) {
        $municipalityId = $_POST['municipality_id'];

        // Prepare and execute query to fetch barangays based on the selected municipality
        $stmt = $conn->prepare("SELECT * FROM barangays WHERE municipality_id = ?");
        $stmt->bind_param("i", $municipalityId);
        $stmt->execute();
        $result = $stmt->get_result();

        // Generate the HTML options for barangays dropdown
        while ($row = $result->fetch_assoc()) {
            $options .= "<option value='" . $row['barangay_id'] . "'>" . $row['barangay_name'] . "</option>";
        }

        echo $options;
    }
} catch (Exception $e) {
    // Handle any errors
    echo "<option value=''>Error fetching barangays</option>";
}