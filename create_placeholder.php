<?php
// Create a simple placeholder image
$width = 300;
$height = 300;
$image = imagecreate($width, $height);

$bg = imagecolorallocate($image, 200, 200, 200);
$text_color = imagecolorallocate($image, 100, 100, 100);

imagestring($image, 5, 100, 140, "No Image", $text_color);
imagestring($image, 3, 110, 160, "Available", $text_color);

imagejpeg($image, 'assets/images/placeholder.jpg');
imagedestroy($image);

echo "✓ Created placeholder.jpg in assets/images/";
?>