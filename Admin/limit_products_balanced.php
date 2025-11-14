<?php
include 'connection.php';

// Get categories and their product counts
$categories = mysqli_query($conn, "SELECT DISTINCT category_id FROM products_tbl");
$cat_ids = [];
while($row = mysqli_fetch_assoc($categories)) {
    $cat_ids[] = $row['category_id'];
}

$products_per_category = floor(50 / count($cat_ids));
$extra = 50 % count($cat_ids);

// Keep balanced products from each category
$keep_ids = [];
foreach($cat_ids as $i => $cat_id) {
    $limit = $products_per_category + ($i < $extra ? 1 : 0);
    $products = mysqli_query($conn, "SELECT product_id FROM products_tbl WHERE category_id = $cat_id LIMIT $limit");
    while($row = mysqli_fetch_assoc($products)) {
        $keep_ids[] = $row['product_id'];
    }
}

// Delete products not in keep list
$keep_list = implode(',', $keep_ids);
$sql = "DELETE FROM products_tbl WHERE product_id NOT IN ($keep_list)";
mysqli_query($conn, $sql);

$remaining = mysqli_query($conn, "SELECT COUNT(*) as count FROM products_tbl");
$count = mysqli_fetch_assoc($remaining)['count'];

echo "✓ Now you have $count products balanced across all categories.";
?>