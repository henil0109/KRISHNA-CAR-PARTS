<?php
// Create a simple no-image placeholder
$width = 400;
$height = 300;

$image = imagecreate($width, $height);

// Colors
$bgColor = imagecolorallocate($image, 240, 240, 240);
$textColor = imagecolorallocate($image, 100, 100, 100);
$borderColor = imagecolorallocate($image, 200, 200, 200);

// Fill background
imagefill($image, 0, 0, $bgColor);

// Add border
imagerectangle($image, 0, 0, $width-1, $height-1, $borderColor);

// Add text
$text = "No Image Available";
$font = 5;
$textWidth = imagefontwidth($font) * strlen($text);
$textHeight = imagefontheight($font);

$x = ($width - $textWidth) / 2;
$y = ($height - $textHeight) / 2;

imagestring($image, $font, $x, $y, $text, $textColor);

// Save to assets/images directory
$filePath = '../assets/images/no-image.png';
imagepng($image, $filePath);
imagedestroy($image);

echo "No-image placeholder created successfully at: $filePath";
?>