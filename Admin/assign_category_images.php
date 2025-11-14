<?php
include 'connection.php';

// Get all categories and their products
$categories = mysqli_query($conn, "SELECT c.category_id, c.category_name FROM categories_tbl c");

echo "<h3>Assign Images by Category:</h3>";
echo "<form method='post'>";

while($cat = mysqli_fetch_assoc($categories)) {
    $product_count = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as count FROM products_tbl WHERE category_id = " . $cat['category_id']))['count'];
    
    echo "<p><strong>" . $cat['category_name'] . "</strong> ($product_count products)<br>";
    echo "Image filename: <input type='text' name='cat_" . $cat['category_id'] . "' placeholder='e.g. engine.jpg'><br></p>";
}

echo "<input type='submit' value='Update All Images'>";
echo "</form>";

if($_POST) {
    foreach($_POST as $key => $filename) {
        if(strpos($key, 'cat_') === 0 && !empty($filename)) {
            $cat_id = str_replace('cat_', '', $key);
            $sql = "UPDATE products_tbl SET part_image = '$filename' WHERE category_id = $cat_id";
            mysqli_query($conn, $sql);
            echo "✓ Updated category $cat_id with $filename<br>";
        }
    }
}
?>