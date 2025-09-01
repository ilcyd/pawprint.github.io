<?php
// Include necessary files
include 'includes/session.php';

// Check if appointment ID is provided
if (isset($_POST['id'])) {
       $appointmentId = $_POST['id'];

       // SQL query to fetch appointment details
       $sql = "SELECT a.appointment_id, a.date, a.start_time, a.end_time, 
            CONCAT(u.firstname, ' ', u.lastname) AS owner_name, 
            p.pet_name, a.status, a.id
            FROM appointments a
            INNER JOIN users u ON a.owner_id = u.id
            INNER JOIN pets p ON a.pet_id = p.pet_id
            WHERE a.id = ? AND a.delete_flag = 0";

       // Prepare statement and bind parameters
       $stmt = $conn->prepare($sql);
       $stmt->bind_param("i", $appointmentId);
       $stmt->execute();
       $result = $stmt->get_result();

       // Check if the appointment exists
       if ($result->num_rows > 0) {
              $appointment = $result->fetch_assoc();

              // Prepare appointment details HTML
              $statusText = '';
              $statusClass = '';
              $buttonHtml = '';

              // Determine the status and prepare the button
              switch ($appointment['status']) {
                     case 0:  // Pending
                            $statusText = 'Pending';
                            $statusClass = 'bg-secondary';
                            $buttonHtml = "<button class='btn btn-success btn-sm' id='approve-btn' data-id='" . $appointment['id'] . "'>Approve</button>";
                            break;
                     case 1:  // Approved
                            $statusText = 'Approved';
                            $statusClass = 'bg-success';
                            $buttonHtml = "<button class='btn btn-info btn-sm' id='mark-done-btn' data-id='" . $appointment['id'] . "'>Mark as Done</button>";
                            break;
                     case 2:  // Done
                            $statusText = 'Done';
                            $statusClass = 'bg-info';
                            break;
                     default:  // Unknown status
                            $statusText = 'Unknown';
                            $statusClass = 'bg-danger';
                            break;
              }

              // Display appointment details
              echo "
        <p><strong>Owner Name:</strong> " . htmlspecialchars($appointment['owner_name']) . "</p>
        <p><strong>Pet Name:</strong> " . htmlspecialchars($appointment['pet_name']) . "</p>
        <p><strong>Date:</strong> " . htmlspecialchars($appointment['date']) . "</p>
        <p><strong>Start Time:</strong> " . htmlspecialchars($appointment['start_time']) . "</p>
        <p><strong>End Time:</strong> " . htmlspecialchars($appointment['end_time']) . "</p>
        <p><strong>Status:</strong> <span class='badge " . $statusClass . "'>" . $statusText . "</span></p>
        $buttonHtml
        ";
       } else {
              echo "<p>No details found for this appointment.</p>";
       }
} else {
       echo "<p>No appointment ID provided.</p>";
}
