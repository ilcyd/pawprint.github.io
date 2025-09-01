<?php
include 'includes/session.php';

if (isset($_POST['cr_id'])) {
  $cr_id = intval($_POST['cr_id']);

  $sql = "SELECT 
              cr.cr_id, 
              cr.owner_id, 
              cr.pet_id, 
              cr.weight, 
              cr.temperature, 
              cr.cbc, 
              cr.chw, 
              cr.ana, 
              cr.bab, 
              cr.ehr, 
              cr.diagnosis, 
              cr.prescription, 
              cr.date_recorded, 
              pets.pet_name, 
              CONCAT(users.firstname, ' ', users.lastname) AS owner_name
            FROM consult_records cr
            INNER JOIN pets ON cr.pet_id = pets.pet_id
            INNER JOIN users ON cr.owner_id = users.id
            WHERE cr.cr_id = ?";

  if ($stmt = $conn->prepare($sql)) {
    $stmt->bind_param('i', $cr_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($row = $result->fetch_assoc()) {
      echo "<p><strong>Consultation ID:</strong> " . htmlspecialchars($row['cr_id']) . "</p>";
      echo "<p><strong>Pet ID:</strong> " . htmlspecialchars($row['pet_id']) . "</p>";
      echo "<p><strong>Owner ID:</strong> " . htmlspecialchars($row['owner_id']) . "</p>";
      echo "<p><strong>Pet Name:</strong> " . htmlspecialchars($row['pet_name']) . "</p>";
      echo "<p><strong>Owner Name:</strong> " . htmlspecialchars($row['owner_name']) . "</p>";
      echo "<p><strong>Weight:</strong> " . htmlspecialchars($row['weight']) . " kg</p>";
      echo "<p><strong>Temperature:</strong> " . htmlspecialchars($row['temperature']) . " °C</p>";
      echo "<p><strong>CBC:</strong> " . htmlspecialchars($row['cbc']) . "</p>";
      echo "<p><strong>CHW:</strong> " . htmlspecialchars($row['chw']) . "</p>";
      echo "<p><strong>ANA:</strong> " . htmlspecialchars($row['ana']) . "</p>";
      echo "<p><strong>BAB:</strong> " . htmlspecialchars($row['bab']) . "</p>";
      echo "<p><strong>EHR:</strong> " . htmlspecialchars($row['ehr']) . "</p>";
      echo "<p><strong>Diagnosis:</strong> " . htmlspecialchars($row['diagnosis']) . "</p>";
      echo "<p><strong>Prescription:</strong> " . htmlspecialchars($row['prescription']) . "</p>";
      echo "<p><strong>Date Recorded:</strong> " . htmlspecialchars($row['date_recorded']) . "</p>";
    } else {
      echo "<p>No details found for this consultation ID.</p>";
    }
    $stmt->close();
  } else {
    echo "<p>Error preparing query.</p>";
  }
}
?>