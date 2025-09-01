<?php
include 'includes/session.php';

// Get the species ID from the GET request
$species_id = isset($_GET['species_id']) ? (int) $_GET['species_id'] : 0;

// Prepare the SQL query based on the species ID
// Use category 3 to include vaccines for all species if needed
$sql = "
    SELECT id, name 
    FROM vaccine_types 
    WHERE cat_id = ? OR cat_id = 3
";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $species_id);
$stmt->execute();
$result = $stmt->get_result();

// Fetch all vaccines
$vaccines = [];
while ($row = $result->fetch_assoc()) {
 $vaccines[] = $row;
}


// Output the vaccines as JSON
echo json_encode($vaccines);
?>