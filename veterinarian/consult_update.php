<?php
// Include your database connection file
include 'includes/session.php'; // Ensure this file contains the $conn object for database access

// Check if form data is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
 // Retrieve and sanitize form data
 $pet_id = isset($_POST['pet_id']) ? intval($_POST['pet_id']) : 0;
 $owner_id = isset($_POST['owner_id']) ? intval($_POST['owner_id']) : 0;
 $weight = isset($_POST['weight']) ? doubleval($_POST['weight']) : 0.0;
 $temperature = isset($_POST['temperature']) ? floatval($_POST['temperature']) : 0.0;
 $cbc = isset($_POST['cbc']) ? htmlspecialchars($_POST['cbc']) : '';
 $chw = isset($_POST['chw']) ? htmlspecialchars($_POST['chw']) : '';
 $ana = isset($_POST['ana']) ? htmlspecialchars($_POST['ana']) : '';
 $bab = isset($_POST['bab']) ? htmlspecialchars($_POST['bab']) : '';
 $ehr = isset($_POST['ehr']) ? htmlspecialchars($_POST['ehr']) : '';
 $diagnosis = isset($_POST['diagnosis']) ? htmlspecialchars($_POST['diagnosis']) : '';
 $prescription = isset($_POST['prescription']) ? htmlspecialchars($_POST['prescription']) : '';

 // Validate data (basic validation)
 if (
  $pet_id <= 0 || $weight <= 0 || $temperature <= 0 || empty($cbc) || empty($chw) ||
  empty($ana) || empty($bab) || empty($ehr) || empty($diagnosis) || empty($prescription)
 ) {
  $_SESSION['message'] = 'All fields are required.';
  header('Location: ' . $_SERVER['HTTP_REFERER']); // Redirect back to the form page
  exit;
 }

 // Prepare an update query for the consultation table
 $updateQuery = "DELETE consultation WHERE pet_id = ?";

 // Prepare and execute the statement for the consultation table
 if ($stmt = $conn->prepare($updateQuery)) {
  $stmt->bind_param('ddsssssssi', $weight, $temperature, $cbc, $chw, $ana, $bab, $ehr, $diagnosis, $prescription, $pet_id);
  if ($stmt->execute()) {
   // Prepare an insert query for the consult_records table
   $insertQuery = "INSERT INTO consult_records (owner_id, pet_id, weight, temperature, cbc, chw, ana, bab, ehr, diagnosis, prescription) 
                            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

   if ($stmtInsert = $conn->prepare($insertQuery)) {
    $stmtInsert->bind_param('iiddsssssss', $owner_id, $pet_id, $weight, $temperature, $cbc, $chw, $ana, $bab, $ehr, $diagnosis, $prescription);
    if ($stmtInsert->execute()) {
     // Handle disease records
     $diseaseList = explode(',', $diagnosis); // Split the diagnoses by comma
     foreach ($diseaseList as $disease) {
      $disease = trim($disease);
      if (!empty($disease)) {
       // Check if the disease already exists
       $checkDiseaseQuery = "SELECT id, count FROM disease_records WHERE name = ?";
       if ($checkStmt = $conn->prepare($checkDiseaseQuery)) {
        $checkStmt->bind_param('s', $disease);
        $checkStmt->execute();
        $checkResult = $checkStmt->get_result();

        if ($checkRow = $checkResult->fetch_assoc()) {
         // If the disease exists, increment the count
         $updateDiseaseQuery = "UPDATE disease_records SET count = count + 1 WHERE id = ?";
         if ($updateStmt = $conn->prepare($updateDiseaseQuery)) {
          $updateStmt->bind_param('i', $checkRow['id']);
          if (!$updateStmt->execute()) {
           $_SESSION['message'] = 'Error executing update disease statement: ' . $updateStmt->error;
          }
          $updateStmt->close();
         } else {
          $_SESSION['message'] = 'Error preparing update disease statement: ' . $conn->error;
         }
        } else {
         // Insert a new disease record
         $insertDiseaseQuery = "INSERT INTO disease_records (name, count) VALUES (?, 1)";
         if ($insertStmt = $conn->prepare($insertDiseaseQuery)) {
          $insertStmt->bind_param('s', $disease);
          if (!$insertStmt->execute()) {
           $_SESSION['message'] = 'Error executing insert disease statement: ' . $insertStmt->error;
          }
          $insertStmt->close();
         } else {
          $_SESSION['message'] = 'Error preparing insert disease statement: ' . $conn->error;
         }
        }
        $checkStmt->close();
       } else {
        $_SESSION['message'] = 'Error preparing check disease statement: ' . $conn->error;
       }
      }
     }

     // Handle prescription records
     $prescriptionList = explode(',', $prescription); // Split the prescriptions by comma
     foreach ($prescriptionList as $prescriptionItem) {
      $prescriptionItem = trim($prescriptionItem);
      if (!empty($prescriptionItem)) {
       // Check if the prescription already exists
       $checkPrescriptionQuery = "SELECT id, count FROM prescription_records WHERE name = ?";
       if ($checkStmt = $conn->prepare($checkPrescriptionQuery)) {
        $checkStmt->bind_param('s', $prescriptionItem);
        $checkStmt->execute();
        $checkResult = $checkStmt->get_result();

        if ($checkRow = $checkResult->fetch_assoc()) {
         // If the prescription exists, increment the count
         $updatePrescriptionQuery = "UPDATE prescription_records SET count = count + 1 WHERE id = ?";
         if ($updateStmt = $conn->prepare($updatePrescriptionQuery)) {
          $updateStmt->bind_param('i', $checkRow['id']);
          if (!$updateStmt->execute()) {
           $_SESSION['message'] = 'Error executing update prescription statement: ' . $updateStmt->error;
          }
          $updateStmt->close();
         } else {
          $_SESSION['message'] = 'Error preparing update prescription statement: ' . $conn->error;
         }
        } else {
         // Insert a new prescription record
         $insertPrescriptionQuery = "INSERT INTO prescription_records (name, count) VALUES (?, 1)";
         if ($insertStmt = $conn->prepare($insertPrescriptionQuery)) {
          $insertStmt->bind_param('s', $prescriptionItem);
          if (!$insertStmt->execute()) {
           $_SESSION['message'] = 'Error executing insert prescription statement: ' . $insertStmt->error;
          }
          $insertStmt->close();
         } else {
          $_SESSION['message'] = 'Error preparing insert prescription statement: ' . $conn->error;
         }
        }
        $checkStmt->close();
       } else {
        $_SESSION['message'] = 'Error preparing check prescription statement: ' . $conn->error;
       }
      }
     }

     $_SESSION['message'] = 'Pet health information updated and recorded successfully.';
    } else {
     $_SESSION['message'] = 'Error executing insert consult_records statement: ' . $stmtInsert->error;
    }
    $stmtInsert->close();
   } else {
    $_SESSION['message'] = 'Error preparing insert consult_records statement: ' . $conn->error;
   }
  } else {
   $_SESSION['message'] = 'Error executing update consultation statement: ' . $stmt->error;
  }
  $stmt->close();
 } else {
  $_SESSION['message'] = 'Error preparing update consultation statement: ' . $conn->error;
 }

 // Close connection

 // Redirect back to the form page with a message
 header('Location: ' . $_SERVER['HTTP_REFERER']);
 exit;
}
?>