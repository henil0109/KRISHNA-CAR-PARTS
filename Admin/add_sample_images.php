<?php
include 'connection.php';

// Create sample images using placeholder services (free to use)
$sampleImages = [
    'engine-oil.jpg' => 'https://picsum.photos/400/300?random=1',
    'brake-fluid.jpg' => 'https://picsum.photos/400/300?random=2', 
    'coolant.jpg' => 'https://picsum.photos/400/300?random=3',
    'transmission-oil.jpg' => 'https://picsum.photos/400/300?random=4',
    'power-steering.jpg' => 'https://picsum.photos/400/300?random=5',
    'headlight.jpg' => 'https://picsum.photos/400/300?random=6',
    'taillight.jpg' => 'https://picsum.photos/400/300?random=7',
    'mirror.jpg' => 'https://picsum.photos/400/300?random=8',
    'bumper.jpg' => 'https://picsum.photos/400/300?random=9',
    'tire.jpg' => 'https://picsum.photos/400/300?random=10'
];

function downloadPlaceholderImage($url, $filename) {
    $uploadDir = 'uploads/parts/';
    $filepath = $uploadDir . $filename;
    
    if (!file_exists($uploadDir)) {
        mkdir($uploadDir, 0777, true);
    }
    
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_TIMEOUT, 30);
    
    $imageData = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);
    
    if ($httpCode == 200 && $imageData !== false) {
        file_put_contents($filepath, $imageData);
        return true;
    }
    return false;
}

echo "<h2>Adding Sample Product Images...</h2>";

foreach ($sampleImages as $filename => $url) {
    echo "Downloading: $filename...<br>";
    
    if (downloadPlaceholderImage($url, $filename)) {
        echo "✓ Successfully downloaded: $filename<br>";
    } else {
        echo "✗ Failed to download: $filename<br>";
    }
    
    sleep(1); // Delay between downloads
}

echo "<br><strong>Sample images added successfully!</strong><br>";
echo "<a href='products_view.php'>View Products</a> | <a href='index.php'>Back to Dashboard</a>";

mysqli_close($conn);
?>