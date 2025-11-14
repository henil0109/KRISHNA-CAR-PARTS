<?php
include 'connection.php';

// Simple placeholder images
$images = [
    'engine.jpg', 'spark-plug.jpg', 'oil-filter.jpg', 'air-filter.jpg', 'timing-belt.jpg',
    'brake-pad.jpg', 'brake-disc.jpg', 'shock-absorber.jpg', 'battery.jpg', 'alternator.jpg',
    'headlight.jpg', 'bumper.jpg', 'mirror.jpg', 'seat-cover.jpg', 'floor-mat.jpg',
    'clutch.jpg', 'radiator.jpg', 'muffler.jpg', 'fuel-filter.jpg', 'transmission.jpg'
];

$sql = "SELECT product_id, part_name FROM products_tbl WHERE part_image IS NULL OR part_image = ''";
$result = mysqli_query($conn, $sql);

$count = 0;
while($row = mysqli_fetch_assoc($result)) {
    $image = $images[$count % count($images)];
    
    $update = "UPDATE products_tbl SET part_image = '$image' WHERE product_id = " . $row['product_id'];
    mysqli_query($conn, $update);
    
    echo "✓ Updated: " . $row['part_name'] . " -> $image<br>";
    $count++;
}

echo "<br><strong>Done! Updated $count products with placeholder images.</strong>";
?>