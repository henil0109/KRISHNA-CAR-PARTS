<?php
// Download a simple placeholder image
$url = "https://via.placeholder.com/300x300/cccccc/666666?text=No+Image";
$image_data = file_get_contents($url);

if($image_data) {
    file_put_contents('assets/images/placeholder.jpg', $image_data);
    echo "✓ Downloaded placeholder.jpg to assets/images/";
} else {
    echo "✗ Failed to download placeholder image";
}
?>