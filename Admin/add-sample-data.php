<?php
include 'connection.php';

// First, let's add some categories
$categories = [
    ['Engine Parts', 'Engine components and accessories'],
    ['Brake System', 'Brake pads, discs, and brake system components'],
    ['Suspension', 'Shock absorbers, springs, and suspension parts'],
    ['Electrical', 'Lights, batteries, and electrical components'],
    ['Body Parts', 'Bumpers, doors, and exterior body components'],
    ['Interior', 'Seats, dashboard, and interior accessories'],
    ['Transmission', 'Gearbox and transmission components'],
    ['Cooling System', 'Radiators, fans, and cooling components'],
    ['Exhaust System', 'Mufflers, pipes, and exhaust components'],
    ['Filters', 'Air, oil, and fuel filters']
];

echo "Adding categories...<br>";
foreach ($categories as $cat) {
    $sql = "INSERT IGNORE INTO categories_tbl (category_name, description) VALUES (?, ?)";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "ss", $cat[0], $cat[1]);
    mysqli_stmt_execute($stmt);
}

// Add some car brands and models
$cars = [
    ['Maruti Suzuki'], ['Hyundai'], ['Tata'], ['Mahindra'], ['Honda'], 
    ['Toyota'], ['Ford'], ['Volkswagen'], ['Skoda'], ['Renault']
];

echo "Adding car brands...<br>";
foreach ($cars as $car) {
    $sql = "INSERT IGNORE INTO cars_tbl (car_name) VALUES (?)";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "s", $car[0]);
    mysqli_stmt_execute($stmt);
}

// Add models for each car
$models = [
    // Maruti Suzuki models
    [1, 'Swift', 2020], [1, 'Baleno', 2021], [1, 'Alto', 2019], [1, 'Wagon R', 2020], [1, 'Dzire', 2021],
    // Hyundai models
    [2, 'i20', 2020], [2, 'Creta', 2021], [2, 'Verna', 2020], [2, 'Grand i10', 2019], [2, 'Venue', 2021],
    // Tata models
    [3, 'Nexon', 2021], [3, 'Harrier', 2020], [3, 'Tiago', 2019], [3, 'Altroz', 2021], [3, 'Safari', 2022],
    // Mahindra models
    [4, 'XUV500', 2020], [4, 'Scorpio', 2021], [4, 'Bolero', 2019], [4, 'Thar', 2022], [4, 'XUV300', 2021],
    // Honda models
    [5, 'City', 2020], [5, 'Amaze', 2021], [5, 'Jazz', 2019], [5, 'WR-V', 2020], [5, 'Civic', 2021]
];

echo "Adding car models...<br>";
foreach ($models as $model) {
    $sql = "INSERT IGNORE INTO models_tbl (car_id, model_name, model_year) VALUES (?, ?, ?)";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "isi", $model[0], $model[1], $model[2]);
    mysqli_stmt_execute($stmt);
}

// Now add 50 products
$products = [
    // Engine Parts
    ['Spark Plug Set', 'High performance spark plugs for better ignition', 1, 1, 850, 25, 5, 'spark-plug.jpg'],
    ['Engine Oil Filter', 'Premium quality oil filter for engine protection', 1, 2, 450, 30, 8, 'oil-filter.jpg'],
    ['Air Filter', 'High-flow air filter for improved engine performance', 1, 3, 650, 20, 5, 'air-filter.jpg'],
    ['Timing Belt', 'Durable timing belt for precise engine timing', 1, 4, 1200, 15, 3, 'timing-belt.jpg'],
    ['Engine Mount', 'Heavy-duty engine mount for vibration control', 1, 5, 2500, 12, 2, 'engine-mount.jpg'],
    
    // Brake System
    ['Brake Pads Front', 'Ceramic brake pads for superior stopping power', 2, 6, 1800, 18, 4, 'brake-pads.jpg'],
    ['Brake Disc Rotor', 'Ventilated brake disc for better heat dissipation', 2, 7, 3200, 10, 2, 'brake-disc.jpg'],
    ['Brake Fluid DOT 4', 'High-performance brake fluid for safety', 2, 8, 320, 50, 10, 'brake-fluid.jpg'],
    ['Brake Master Cylinder', 'Reliable brake master cylinder assembly', 2, 9, 4500, 8, 2, 'master-cylinder.jpg'],
    ['Brake Caliper', 'Precision-engineered brake caliper', 2, 10, 5500, 6, 1, 'brake-caliper.jpg'],
    
    // Suspension
    ['Shock Absorber Front', 'Gas-filled shock absorber for smooth ride', 3, 11, 2800, 14, 3, 'shock-absorber.jpg'],
    ['Coil Spring', 'Heavy-duty coil spring for load support', 3, 12, 1600, 16, 4, 'coil-spring.jpg'],
    ['Strut Mount', 'Durable strut mount for suspension stability', 3, 13, 950, 22, 5, 'strut-mount.jpg'],
    ['Sway Bar Link', 'Anti-roll bar link for improved handling', 3, 14, 750, 28, 6, 'sway-bar.jpg'],
    ['Ball Joint', 'Precision ball joint for steering control', 3, 15, 1200, 20, 4, 'ball-joint.jpg'],
    
    // Electrical
    ['LED Headlight Bulb', 'Bright LED headlight for better visibility', 4, 16, 2200, 25, 5, 'led-headlight.jpg'],
    ['Car Battery 12V', 'Maintenance-free car battery', 4, 17, 4800, 12, 2, 'car-battery.jpg'],
    ['Alternator', 'High-output alternator for charging system', 4, 18, 8500, 5, 1, 'alternator.jpg'],
    ['Starter Motor', 'Reliable starter motor for engine start', 4, 19, 6200, 7, 1, 'starter-motor.jpg'],
    ['Fog Light Assembly', 'Clear fog light for better visibility', 4, 20, 1800, 18, 4, 'fog-light.jpg'],
    
    // Body Parts
    ['Front Bumper', 'OEM-quality front bumper replacement', 5, 21, 12000, 4, 1, 'front-bumper.jpg'],
    ['Side Mirror', 'Power-adjustable side mirror with indicator', 5, 22, 3500, 8, 2, 'side-mirror.jpg'],
    ['Door Handle', 'Chrome-finished exterior door handle', 5, 23, 850, 24, 5, 'door-handle.jpg'],
    ['Tail Light Assembly', 'LED tail light with clear lens', 5, 24, 2800, 12, 3, 'tail-light.jpg'],
    ['Hood Latch', 'Secure hood latch mechanism', 5, 25, 1200, 15, 3, 'hood-latch.jpg'],
    
    // Interior
    ['Seat Cover Set', 'Premium leather seat cover set', 6, 1, 4500, 10, 2, 'seat-cover.jpg'],
    ['Floor Mat Set', 'All-weather rubber floor mats', 6, 2, 1800, 20, 4, 'floor-mat.jpg'],
    ['Steering Wheel Cover', 'Ergonomic steering wheel cover', 6, 3, 650, 35, 7, 'steering-cover.jpg'],
    ['Dashboard Cover', 'UV-resistant dashboard cover', 6, 4, 1200, 18, 4, 'dashboard-cover.jpg'],
    ['Gear Knob', 'Sporty gear shift knob', 6, 5, 450, 40, 8, 'gear-knob.jpg'],
    
    // Transmission
    ['Clutch Kit', 'Complete clutch kit with pressure plate', 7, 6, 8500, 6, 1, 'clutch-kit.jpg'],
    ['Transmission Oil', 'High-grade transmission fluid', 7, 7, 850, 30, 6, 'transmission-oil.jpg'],
    ['CV Joint', 'Constant velocity joint assembly', 7, 8, 3200, 12, 2, 'cv-joint.jpg'],
    ['Drive Shaft', 'Heavy-duty drive shaft', 7, 9, 5500, 8, 1, 'drive-shaft.jpg'],
    ['Clutch Cable', 'Smooth-operating clutch cable', 7, 10, 650, 25, 5, 'clutch-cable.jpg'],
    
    // Cooling System
    ['Radiator', 'Aluminum radiator for efficient cooling', 8, 11, 6500, 8, 1, 'radiator.jpg'],
    ['Cooling Fan', 'Electric cooling fan assembly', 8, 12, 3800, 10, 2, 'cooling-fan.jpg'],
    ['Thermostat', 'Engine thermostat for temperature control', 8, 13, 450, 35, 7, 'thermostat.jpg'],
    ['Water Pump', 'Reliable water pump for coolant circulation', 8, 14, 2800, 12, 2, 'water-pump.jpg'],
    ['Radiator Hose', 'Flexible radiator hose set', 8, 15, 850, 28, 6, 'radiator-hose.jpg'],
    
    // Exhaust System
    ['Muffler', 'Performance muffler for better sound', 9, 16, 4200, 10, 2, 'muffler.jpg'],
    ['Exhaust Pipe', 'Stainless steel exhaust pipe', 9, 17, 2800, 15, 3, 'exhaust-pipe.jpg'],
    ['Catalytic Converter', 'Emission control catalytic converter', 9, 18, 12000, 4, 1, 'catalytic-converter.jpg'],
    ['Exhaust Gasket', 'Heat-resistant exhaust gasket', 9, 19, 250, 50, 10, 'exhaust-gasket.jpg'],
    ['Exhaust Clamp', 'Heavy-duty exhaust clamp', 9, 20, 180, 60, 12, 'exhaust-clamp.jpg'],
    
    // Filters
    ['Fuel Filter', 'High-efficiency fuel filter', 10, 21, 650, 25, 5, 'fuel-filter.jpg'],
    ['Cabin Air Filter', 'HEPA cabin air filter', 10, 22, 850, 30, 6, 'cabin-filter.jpg'],
    ['Hydraulic Filter', 'Power steering hydraulic filter', 10, 23, 750, 20, 4, 'hydraulic-filter.jpg'],
    ['Transmission Filter', 'Automatic transmission filter', 10, 24, 1200, 18, 3, 'transmission-filter.jpg'],
    ['PCV Valve', 'Positive crankcase ventilation valve', 10, 25, 320, 45, 9, 'pcv-valve.jpg']
];

echo "Adding products...<br>";
foreach ($products as $product) {
    $sql = "INSERT INTO products_tbl (part_name, part_description, category_id, model_id, price, stock, reorder_level, part_image) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "ssiidiis", $product[0], $product[1], $product[2], $product[3], $product[4], $product[5], $product[6], $product[7]);
    mysqli_stmt_execute($stmt);
}

echo "<h2>Sample data added successfully!</h2>";
echo "<p>Added:</p>";
echo "<ul>";
echo "<li>10 Categories</li>";
echo "<li>10 Car brands</li>";
echo "<li>25 Car models</li>";
echo "<li>50 Products</li>";
echo "</ul>";
echo "<p><a href='products_view.php'>View Products</a> | <a href='../User/browse.php'>Browse Products (User)</a></p>";

mysqli_close($conn);
?>