<?php
include 'includes/session.php';

// Check if owner_id and pet_id are provided via POST
if (isset($_POST['owner_id']) && isset($_POST['pet_id']) && isset($_POST['id'])) {
    $ownerId = $_POST['owner_id'];
    $petId = $_POST['pet_id'];
    $vacc_id = $_POST['id'];

    // Prepare SQL statement to fetch vaccination details
    $sql = "SELECT id, schedule, next_schedule, type, status, status2 FROM vaccination WHERE id = ? AND owner_id = ? AND pet_id = ? AND delete_flag = 0";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("iii", $vacc_id, $ownerId, $petId);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc();

        // Output the vaccination details including the "Done" button
        echo '<p><strong>Schedule:</strong> ' . $row['schedule'] . ' ';

        // Display "Done" button with appropriate status and functionality
        if ($row['status'] == 0 && date('Y-m-d', strtotime($row['schedule'])) == date('Y-m-d')) {
            echo '<button class="btn btn-success btn-sm mark-done" data-vaccine-id="' . $row['id'] . '">Done</button>';
        } elseif ($row['status'] == 1) {
            echo '<span class="badge badge-success">Completed</span>';
        } else {

        }

        echo '</p>';

        // Display next schedule
        echo '<p><strong>Next Schedule:</strong> ' . $row['next_schedule'] . '';

        if ($row['status'] == 1 && $row['status2'] == 0 && date('Y-m-d', strtotime($row['next_schedule'])) == date('Y-m-d')) {
            echo '<button class="btn btn-success btn-sm mark-done2" data-vaccine-id="' . $row['id'] . '">Done</button>';
        } elseif ($row['status'] == 1 && $row['status2'] == 1) {
            echo '<span class="badge badge-success">Completed</span>';
        } else {
            // Hide the button if status is not 1
            // You can also choose to display nothing or a different message here if desired
            // echo ''; // Uncomment this line to show nothing when status is not 1 and status2 is not 1
        }
        echo '</p>';

        // Add form to select new schedule
        echo '
            <form id="updateScheduleForm">
                <input type="hidden" name="vaccine_id" value="' . $row['id'] . '">
                <input type="hidden" name="current_schedule" value="' . $row['schedule'] . '">
                <input type="hidden" name="vaccine_type" value="' . $row['type'] . '">
                <div class="form-group">
                    <label for="new_schedule">Select New Schedule:</label>
                    <input type="date" class="form-control" id="new_schedule" name="new_schedule" required>
                </div>
                <button type="submit" class="btn btn-primary">Update Schedule</button>
            </form>
        ';
    } else {
        echo "<p>No vaccination details found for this pet.</p>";
    }

    // Close statement and connection
    $stmt->close();
    $conn->close();
} else {
    echo "<p>Invalid request. Please provide owner_id and pet_id.</p>";
}
?>