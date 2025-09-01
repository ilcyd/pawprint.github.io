<?php
include("includes/session.php");
$sql = "SELECT open_time, close_time FROM settings LIMIT 1";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    echo json_encode($row);
} else {
    echo json_encode(["start_time" => "08:00:00", "end_time" => "22:00:00"]); // default values
}

?>
