<?php
include ('includes/session.php');

if (isset($_GET['species_id'])) {
    $species_id = $_GET['species_id'];

    // Fetch vaccine types matching the species_id
    $query = "SELECT * FROM vaccine_types WHERE cat_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $species_id);
    $stmt->execute();
    $result = $stmt->get_result();

    $vaccine_types = [];
    while ($row = $result->fetch_assoc()) {
        $vaccine_types[] = [
            'id' => $row['id'], // Assuming vaccine_id is the unique identifier
            'name' => $row['name'] // Assuming vaccine_name is the name of the vaccine
        ];
    }

    // Return the vaccine types as JSON
    echo json_encode($vaccine_types);
}
?>
