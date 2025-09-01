<?php
// MySQL database credentials
$host = 'localhost';
$username = 'root';
$password = '';
$database = 'final_caps_db';

// Establish the database connection
$conn = new mysqli($host, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get all the tables
$tables = array();
$sql = "SHOW TABLES";
$result = $conn->query($sql);

while ($row = $result->fetch_row()) {
    $tables[] = $row[0];
}

$sqlScript = "";
foreach ($tables as $table) {
    // Prepare SQL script for creating table structure
    $query = "SHOW CREATE TABLE $table";
    $result = $conn->query($query);
    $row = $result->fetch_row();

    $sqlScript .= "\n\n" . $row[1] . ";\n\n";

    $query = "SELECT * FROM $table";
    $result = $conn->query($query);

    $columnCount = $result->field_count;
    
    // Prepare SQL script for dumping data for each table
    for ($i = 0; $i < $columnCount; $i ++) {
        while ($row = $result->fetch_row()) {
            $sqlScript .= "INSERT INTO $table VALUES(";
            for ($j = 0; $j < $columnCount; $j ++) {
                $row[$j] = $conn->real_escape_string($row[$j]);

                if (isset($row[$j])) {
                    $sqlScript .= '"' . $row[$j] . '"';
                } else {
                    $sqlScript .= '""';
                }
                if ($j < ($columnCount - 1)) {
                    $sqlScript .= ',';
                }
            }
            $sqlScript .= ");\n";
        }
    }
    $sqlScript .= "\n";
}

if (!empty($sqlScript)) {
    // Define the backup directory
    $backupDir = __DIR__ . '/../database/';

    // Create the database folder if it doesn't exist
    if (!file_exists($backupDir)) {
        mkdir($backupDir, 0777, true);
    }

    // Save the SQL script to a backup file
    $backup_file_name = $backupDir . $database . '_backup_' . time() . '.sql';
    $fileHandler = fopen($backup_file_name, 'w+');
    $number_of_lines = fwrite($fileHandler, $sqlScript);
    fclose($fileHandler);
    header('Location: home.php');

}

// Close connection
$conn->close();
?>
