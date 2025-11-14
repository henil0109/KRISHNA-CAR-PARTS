<?php
include 'connection.php';

$columns = mysqli_query($conn, "DESCRIBE products_tbl");
echo "<h3>Products Table Columns:</h3>";
while($row = mysqli_fetch_array($columns)) {
    echo "- " . $row[0] . "<br>";
}
?>