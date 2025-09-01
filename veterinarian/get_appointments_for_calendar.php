<?php
include 'includes/session.php';

$userid = $user['id']; // Get the vet user ID

// SQL query to fetch appointments
$sql = "SELECT a.appointment_id, a.date_created, a.date, a.start_time, a.end_time, 
        CONCAT(u.firstname, ' ', u.lastname) AS owner_name, 
        p.pet_name, a.status, a.id
        FROM appointments a
        INNER JOIN users u ON a.owner_id = u.id
        INNER JOIN pets p ON a.pet_id = p.pet_id
        WHERE a.vet_id = $userid AND a.delete_flag = 0";

$stmt = $conn->prepare($sql);
$stmt->execute();
$result = $stmt->get_result();

$appointments = [];

while ($row = $result->fetch_assoc()) {
    // Determine the status of the appointment
    $statusText = '';
    $statusClass = '';

    switch ($row['status']) {
        case 0:
            $statusText = 'Pending';
            $statusClass = 'secondary';
            break;
        case 1:
            $statusText = 'Approved';
            $statusClass = 'success';
            break;
        case 2:
            $statusText = 'Done';
            $statusClass = 'info'; // Custom class for "Done" appointments
            break;
    }

    // Format the event for FullCalendar
    $appointments[] = [
        'id' => $row['id'],
        'title' => $row['owner_name'] . ' - ' . $row['pet_name'],
        'start' => $row['date'] . 'T' . $row['start_time'], // Ensure this is in the correct format
        'end' => $row['date'] . 'T' . $row['end_time'],
        'status' => $statusText,
        'classNames' => ['bg-' . $statusClass], // FullCalendar uses classNames for custom styling
    ];
    
}

// Return data as JSON
echo json_encode(['events' => $appointments]);
?>
