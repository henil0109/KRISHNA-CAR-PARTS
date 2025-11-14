<?php
include 'Admin/connection.php';

echo "<h3>Debug: Product Images</h3>";

$sql = "SELECT product_id, part_name, part_image FROM products_tbl LIMIT 10";
$result = mysqli_query($conn, $sql);

while($row = mysqli_fetch_assoc($result)) {
    $imagePath = "Admin/uploads/parts/" . $row['part_image'];
    $exists = file_exists($imagePath);
    
    echo "<div style='border:1px solid #ccc; margin:10px; padding:10px;'>";
    echo "<strong>ID:</strong> " . $row['product_id'] . "<br>";
    echo "<strong>Name:</strong> " . $row['part_name'] . "<br>";
    echo "<strong>Image File:</strong> " . $row['part_image'] . "<br>";
    echo "<strong>Full Path:</strong> " . $imagePath . "<br>";
    echo "<strong>File Exists:</strong> " . ($exists ? "YES" : "NO") . "<br>";
    
    if($exists) {
        echo "<img src='" . $imagePath . "' style='max-width:200px; max-height:150px;'><br>";
    }
    echo "</div>";
}
?>