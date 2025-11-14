<?php
include 'connection.php';

$sql = "SELECT part_name, part_image FROM products_tbl LIMIT 10";
$result = mysqli_query($conn, $sql);

echo "<h3>Current Product Images:</h3>";
while($row = mysqli_fetch_assoc($result)) {
    echo $row['part_name'] . " -> " . ($row['part_image'] ?: 'No image') . "<br>";
}
?>