<?php
include 'connection.php';

// Keep only first 50 products
$sql = "DELETE FROM products_tbl WHERE product_id > 50";
mysqli_query($conn, $sql);

$count = mysqli_affected_rows($conn);
echo "✓ Deleted $count products. Now you have only 50 products maximum.";
?>