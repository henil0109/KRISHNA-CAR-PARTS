<?php
// Create simple SVG placeholder images
$uploadDir = 'uploads/parts/';

// Create directory if it doesn't exist
if (!file_exists($uploadDir)) {
    mkdir($uploadDir, 0777, true);
}

// Create a simple SVG placeholder
$svgContent = '<?xml version="1.0" encoding="UTF-8"?>
<svg width="400" height="300" xmlns="http://www.w3.org/2000/svg">
  <rect width="400" height="300" fill="#2c3e50"/>
  <rect x="10" y="10" width="380" height="280" fill="none" stroke="#34495e" stroke-width="2"/>
  <text x="200" y="140" font-family="Arial, sans-serif" font-size="18" fill="#ecf0f1" text-anchor="middle">Car Part</text>
  <text x="200" y="170" font-family="Arial, sans-serif" font-size="14" fill="#bdc3c7" text-anchor="middle">Krishna Car Parts</text>
</svg>';

// Save as placeholder.svg
file_put_contents($uploadDir . 'placeholder.svg', $svgContent);

// Create different colored placeholders for variety
$colors = [
    ['#e74c3c', '#c0392b'], // Red
    ['#3498db', '#2980b9'], // Blue  
    ['#2ecc71', '#27ae60'], // Green
    ['#f39c12', '#e67e22'], // Orange
    ['#9b59b6', '#8e44ad'], // Purple
];

for ($i = 1; $i <= 5; $i++) {
    $color = $colors[($i-1) % count($colors)];
    $svgContent = '<?xml version="1.0" encoding="UTF-8"?>
<svg width="400" height="300" xmlns="http://www.w3.org/2000/svg">
  <rect width="400" height="300" fill="' . $color[0] . '"/>
  <rect x="10" y="10" width="380" height="280" fill="none" stroke="' . $color[1] . '" stroke-width="2"/>
  <text x="200" y="140" font-family="Arial, sans-serif" font-size="18" fill="white" text-anchor="middle">Car Part ' . $i . '</text>
  <text x="200" y="170" font-family="Arial, sans-serif" font-size="14" fill="#ecf0f1" text-anchor="middle">Krishna Car Parts</text>
</svg>';
    
    file_put_contents($uploadDir . 'placeholder' . $i . '.svg', $svgContent);
}

echo "Created placeholder images successfully!<br>";
echo "- placeholder.svg<br>";
echo "- placeholder1.svg to placeholder5.svg<br>";
?>