<?php
include 'connection.php';

// Array of free placeholder/stock image URLs for car parts
$carPartImages = [
    'air-filter.jpg' => 'https://images.unsplash.com/photo-1558618666-fcd25c85cd64?w=400&h=300&fit=crop',
    'brake-pads.jpg' => 'https://images.unsplash.com/photo-1609630875171-b1321377ee65?w=400&h=300&fit=crop',
    'oil-filter.jpg' => 'https://images.unsplash.com/photo-1486262715619-67b85e0b08d3?w=400&h=300&fit=crop',
    'spark-plug.jpg' => 'https://images.unsplash.com/photo-1609630875171-b1321377ee65?w=400&h=300&fit=crop',
    'battery.jpg' => 'https://images.unsplash.com/photo-1558618047-3c8c76ca7d13?w=400&h=300&fit=crop',
    'radiator.jpg' => 'https://images.unsplash.com/photo-1486262715619-67b85e0b08d3?w=400&h=300&fit=crop',
    'alternator.jpg' => 'https://images.unsplash.com/photo-1558618666-fcd25c85cd64?w=400&h=300&fit=crop',
    'starter.jpg' => 'https://images.unsplash.com/photo-1609630875171-b1321377ee65?w=400&h=300&fit=crop',
    'clutch.jpg' => 'https://images.unsplash.com/photo-1486262715619-67b85e0b08d3?w=400&h=300&fit=crop',
    'suspension.jpg' => 'https://images.unsplash.com/photo-1558618047-3c8c76ca7d13?w=400&h=300&fit=crop'
];

function downloadImage($url, $filename) {
    $uploadDir = 'uploads/parts/';
    $filepath = $uploadDir . $filename;
    
    // Create directory if it doesn't exist
    if (!file_exists($uploadDir)) {
        mkdir($uploadDir, 0777, true);
    }
    
    // Download image using cURL
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36');
    
    $imageData = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);
    
    if ($httpCode == 200 && $imageData !== false) {
        file_put_contents($filepath, $imageData);
        return true;
    }
    return false;
}

echo "<h2>Updating Product Images...</h2>";

// Get all products
$result = mysqli_query($conn, "SELECT product_id, part_name, part_image FROM products_tbl");

while ($product = mysqli_fetch_assoc($result)) {
    $productName = strtolower(str_replace(' ', '-', $product['part_name']));
    $newImageName = $productName . '-' . $product['product_id'] . '.jpg';
    
    // Use a generic car part image from Unsplash (free to use)
    $imageUrl = 'https://source.unsplash.com/400x300/?' . urlencode('car parts automotive');
    
    echo "Updating image for: " . $product['part_name'] . "...<br>";
    
    if (downloadImage($imageUrl, $newImageName)) {
        // Update database with new image name
        $stmt = mysqli_prepare($conn, "UPDATE products_tbl SET part_image = ? WHERE product_id = ?");
        mysqli_stmt_bind_param($stmt, "si", $newImageName, $product['product_id']);
        mysqli_stmt_execute($stmt);
        echo "✓ Updated: " . $newImageName . "<br>";
    } else {
        echo "✗ Failed to download image for: " . $product['part_name'] . "<br>";
    }
    
    // Small delay to avoid overwhelming the server
    sleep(1);
}

echo "<br><strong>Image update process completed!</strong>";
mysqli_close($conn);
?>