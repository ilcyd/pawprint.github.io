<?php 
include 'includes/session.php';

if(isset($_POST['id'])){
    $id = $_POST['id'];

    $sql = "SELECT * FROM category WHERE id='$id'";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0) {
        // Fetch data
        $row = mysqli_fetch_assoc($result);
        echo json_encode($row);
    } else {
        echo "No data found";
    }

    // Close connection
    mysqli_close($conn);
}
?>
