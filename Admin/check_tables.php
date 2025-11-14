<?php
include 'connection.php';

$tables = mysqli_query($conn, "SHOW TABLES");
echo "<h3>Available Tables:</h3>";
while($row = mysqli_fetch_array($tables)) {
    echo "- " . $row[0] . "<br>";
}
?>