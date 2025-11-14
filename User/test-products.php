<?php
include '../Admin/connection.php';

echo "<h2>Testing Products Database</h2>";

// Test 1: Check if products exist
$result = mysqli_query($conn, "SELECT COUNT(*) as count FROM products_tbl");
$row = mysqli_fetch_assoc($result);
echo "<p>Total products in database: " . $row['count'] . "</p>";

// Test 2: Show first 5 products
$result = mysqli_query($conn, "SELECT p.*, c.category_name, m.model_name FROM products_tbl p LEFT JOIN categories_tbl c ON p.category_id = c.category_id LEFT JOIN models_tbl m ON p.model_id = m.model_id LIMIT 5");

echo "<h3>First 5 products:</h3>";
while($product = mysqli_fetch_assoc($result)) {
    echo "<div style='border:1px solid #ccc; padding:10px; margin:5px;'>";
    echo "<strong>" . $product['part_name'] . "</strong><br>";
    echo "Category: " . $product['category_name'] . "<br>";
    echo "Model: " . $product['model_name'] . "<br>";
    echo "Price: ₹" . $product['price'] . "<br>";
    echo "</div>";
}

// Test 3: Check categories
$result = mysqli_query($conn, "SELECT COUNT(*) as count FROM categories_tbl");
$row = mysqli_fetch_assoc($result);
echo "<p>Total categories: " . $row['count'] . "</p>";

// Test 4: Check models
$result = mysqli_query($conn, "SELECT COUNT(*) as count FROM models_tbl");
$row = mysqli_fetch_assoc($result);
echo "<p>Total models: " . $row['count'] . "</p>";
?>