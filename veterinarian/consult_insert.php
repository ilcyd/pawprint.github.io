<?php
include 'includes/session.php';
include 'includes/header.php';

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $consultation_id = $_POST['consult_id'];
    $owner_id = $_POST['owner_id'];
    $pet_id = $_POST['pet_id'];
    $vet_id = $_POST['vet_id'];
    $weight = $_POST['weight'];
    $temperature = $_POST['temperature'];
    $cbc = $_POST['cbc'];
    $chw = $_POST['chw'];
    $ana = $_POST['ana'];
    $bab = $_POST['bab'];
    $ehr = $_POST['ehr'];
    $diagnosis = $_POST['diagnosis'];
    $prescription = $_POST['prescription'];

    // Prepare an insert statement
    $stmt = $conn->prepare("INSERT INTO consult_records (owner_id, pet_id, vet_id, weight, temperature, cbc, chw, ana, bab, ehr, diagnosis, prescription, date_recorded)
VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, NOW())");
    $stmt->bind_param("iiiddsssssss", $owner_id, $pet_id, $vet_id, $weight, $temperature, $cbc, $chw, $ana, $bab, $ehr, $diagnosis, $prescription);
    
    // Execute the statement
    if ($stmt->execute()) {
        // Prepare a delete statement
        $delete_stmt = $conn->prepare("DELETE FROM consultation WHERE consult_id = ?");
        $delete_stmt->bind_param("i", $consultation_id);

        // Execute the delete statement
        if ($delete_stmt->execute()) {
            echo "<script>alert('Consultation record inserted and original consultation deleted successfully!'); window.location.href='pet_records.php?pet_id=$pet_id&owner_id=$owner_id';</script>";
            exit();
        } else {
            echo "<script>alert('Error deleting original consultation: " . $delete_stmt->error . "'); window.history.back();</script>";
        }

        $delete_stmt->close();
    } else {
        echo "<script>alert('Error inserting data: " . $stmt->error . "'); window.history.back();</script>";
    }

}

