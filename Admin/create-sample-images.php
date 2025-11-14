<?php
// Create sample product images
$uploadDir = 'uploads/parts/';

// Create directory if it doesn't exist
if (!file_exists($uploadDir)) {
    mkdir($uploadDir, 0777, true);
}

// Sample image names from our products
$imageNames = [
    'spark-plug.jpg', 'oil-filter.jpg', 'air-filter.jpg', 'timing-belt.jpg', 'engine-mount.jpg',
    'brake-pads.jpg', 'brake-disc.jpg', 'brake-fluid.jpg', 'master-cylinder.jpg', 'brake-caliper.jpg',
    'shock-absorber.jpg', 'coil-spring.jpg', 'strut-mount.jpg', 'sway-bar.jpg', 'ball-joint.jpg',
    'led-headlight.jpg', 'car-battery.jpg', 'alternator.jpg', 'starter-motor.jpg', 'fog-light.jpg',
    'front-bumper.jpg', 'side-mirror.jpg', 'door-handle.jpg', 'tail-light.jpg', 'hood-latch.jpg',
    'seat-cover.jpg', 'floor-mat.jpg', 'steering-cover.jpg', 'dashboard-cover.jpg', 'gear-knob.jpg',
    'clutch-kit.jpg', 'transmission-oil.jpg', 'cv-joint.jpg', 'drive-shaft.jpg', 'clutch-cable.jpg',
    'radiator.jpg', 'cooling-fan.jpg', 'thermostat.jpg', 'water-pump.jpg', 'radiator-hose.jpg',
    'muffler.jpg', 'exhaust-pipe.jpg', 'catalytic-converter.jpg', 'exhaust-gasket.jpg', 'exhaust-clamp.jpg',
    'fuel-filter.jpg', 'cabin-filter.jpg', 'hydraulic-filter.jpg', 'transmission-filter.jpg', 'pcv-valve.jpg'
];

// Colors for different categories
$colors = [
    '#FF6B6B', '#4ECDC4', '#45B7D1', '#96CEB4', '#FFEAA7',
    '#DDA0DD', '#98D8C8', '#F7DC6F', '#BB8FCE', '#85C1E9'
];

foreach ($imageNames as $index => $imageName) {
    $width = 400;
    $height = 300;
    
    // Create image
    $image = imagecreate($width, $height);
    
    // Get color for this category
    $colorIndex = $index % count($colors);
    $hexColor = $colors[$colorIndex];
    
    // Convert hex to RGB
    $r = hexdec(substr($hexColor, 1, 2));
    $g = hexdec(substr($hexColor, 3, 2));
    $b = hexdec(substr($hexColor, 5, 2));
    
    // Allocate colors
    $bgColor = imagecolorallocate($image, $r, $g, $b);
    $textColor = imagecolorallocate($image, 255, 255, 255);
    $borderColor = imagecolorallocate($image, 0, 0, 0);
    
    // Fill background
    imagefill($image, 0, 0, $bgColor);
    
    // Add border
    imagerectangle($image, 0, 0, $width-1, $height-1, $borderColor);
    
    // Add text
    $partName = str_replace(['-', '.jpg'], [' ', ''], $imageName);
    $partName = ucwords($partName);
    
    // Use built-in font
    $font = 5;
    $textWidth = imagefontwidth($font) * strlen($partName);
    $textHeight = imagefontheight($font);
    
    $x = ($width - $textWidth) / 2;
    $y = ($height - $textHeight) / 2;
    
    imagestring($image, $font, $x, $y, $partName, $textColor);
    
    // Add "KCP" watermark
    imagestring($image, 3, 10, 10, 'KCP', $textColor);
    
    // Save image
    $filePath = $uploadDir . $imageName;
    imagejpeg($image, $filePath, 90);
    imagedestroy($image);
    
    echo "Created: $imageName<br>";
}

echo "<h2>Sample images created successfully!</h2>";
echo "<p>Created 50 product images in the uploads/parts/ directory.</p>";
echo "<p><a href='add-sample-data.php'>Add Sample Data</a></p>";
?>