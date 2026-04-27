<?php
// Auto-setup script — runs once to create all tables on Railway/cloud MySQL
// Access: https://your-app.railway.app/setup.php
// DELETE this file after first run!

$host     = getenv('MYSQLHOST')     ?: 'localhost';
$username = getenv('MYSQLUSER')     ?: 'root';
$password = getenv('MYSQLPASSWORD') ?: '';
$database = getenv('MYSQLDATABASE') ?: 'KCP_db';
$port     = (int)(getenv('MYSQLPORT') ?: 3306);

$conn = mysqli_connect($host, $username, $password, '', $port);
if (!$conn) { die("Cannot connect: " . mysqli_connect_error()); }

$sqls = [
"CREATE DATABASE IF NOT EXISTS `$database` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci",
"USE `$database`",
"SET FOREIGN_KEY_CHECKS=0",

"CREATE TABLE IF NOT EXISTS admin_tbl (
  admin_id INT NOT NULL AUTO_INCREMENT,
  admin_name VARCHAR(255) NOT NULL,
  admin_email VARCHAR(255) NOT NULL,
  admin_password VARCHAR(255) NOT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (admin_id),
  UNIQUE KEY uq_admin_email (admin_email)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4",

"INSERT IGNORE INTO admin_tbl (admin_name,admin_email,admin_password) VALUES ('Administrator','admin@krishnacarparts.com','admin123')",

"CREATE TABLE IF NOT EXISTS users_tbl (
  user_id INT NOT NULL AUTO_INCREMENT,
  name VARCHAR(255) NOT NULL,
  email VARCHAR(255) NOT NULL,
  phone VARCHAR(20) DEFAULT NULL,
  password VARCHAR(255) NOT NULL,
  profile_image VARCHAR(255) DEFAULT NULL,
  address TEXT DEFAULT NULL,
  city VARCHAR(100) DEFAULT NULL,
  state VARCHAR(100) DEFAULT NULL,
  pincode VARCHAR(10) DEFAULT NULL,
  status ENUM('active','inactive') DEFAULT 'active',
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (user_id),
  UNIQUE KEY uq_user_email (email)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4",

"CREATE TABLE IF NOT EXISTS categories_tbl (
  category_id INT NOT NULL AUTO_INCREMENT,
  category_name VARCHAR(255) NOT NULL,
  description TEXT DEFAULT NULL,
  category_image VARCHAR(255) DEFAULT NULL,
  status ENUM('active','inactive') DEFAULT 'active',
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (category_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4",

"INSERT IGNORE INTO categories_tbl (category_name,description,status) VALUES
  ('Engine Parts','Engine components including pistons rings gaskets and timing belts','active'),
  ('Brake System','Brake pads discs calipers and master cylinders for all vehicles','active'),
  ('Suspension & Steering','Shock absorbers struts tie rods and ball joints','active'),
  ('Electrical Components','Batteries alternators starters and sensors','active'),
  ('Filters','Air oil fuel and cabin filters for routine maintenance','active'),
  ('Exhaust System','Exhaust pipes mufflers catalytic converters and clamps','active'),
  ('Transmission & Clutch','Clutch kits transmission filters and gearbox parts','active'),
  ('Cooling System','Radiators water pumps thermostats and cooling fans','active'),
  ('Body & Exterior','Bumpers mirrors lights handles and exterior accessories','active'),
  ('Interior Accessories','Seat covers floor mats steering covers and dashboard accessories','active')",

"CREATE TABLE IF NOT EXISTS brands_tbl (
  brand_id INT NOT NULL AUTO_INCREMENT,
  brand_name VARCHAR(255) NOT NULL,
  country VARCHAR(100) DEFAULT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (brand_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4",

"INSERT IGNORE INTO brands_tbl (brand_name,country) VALUES
  ('Maruti Suzuki','India'),('Hyundai','South Korea'),('Tata Motors','India'),
  ('Honda','Japan'),('Toyota','Japan'),('Mahindra','India'),
  ('Ford','USA'),('Volkswagen','Germany'),('Kia','South Korea'),('Renault','France')",

"CREATE TABLE IF NOT EXISTS cars_tbl (
  car_id INT NOT NULL AUTO_INCREMENT,
  brand_id INT NOT NULL,
  car_name VARCHAR(255) NOT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (car_id),
  KEY fk_brand (brand_id),
  CONSTRAINT fk_brand FOREIGN KEY (brand_id) REFERENCES brands_tbl (brand_id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4",

"INSERT IGNORE INTO cars_tbl (brand_id,car_name) VALUES
  (1,'Swift'),(1,'Alto'),(1,'Baleno'),(1,'Dzire'),
  (2,'i20'),(2,'Creta'),(2,'Verna'),(2,'Grand i10'),
  (3,'Nexon'),(3,'Harrier'),(3,'Safari'),(3,'Altroz'),
  (4,'City'),(4,'Amaze'),(4,'WR-V'),
  (5,'Fortuner'),(5,'Innova Crysta'),(5,'Glanza'),
  (6,'Thar'),(6,'Scorpio'),(6,'XUV700'),
  (7,'EcoSport'),(7,'Figo'),
  (8,'Polo'),(8,'Vento'),
  (9,'Seltos'),(9,'Sonet'),
  (10,'Kwid'),(10,'Kiger')",

"CREATE TABLE IF NOT EXISTS models_tbl (
  model_id INT NOT NULL AUTO_INCREMENT,
  car_id INT NOT NULL,
  model_name VARCHAR(255) NOT NULL,
  model_year VARCHAR(20) DEFAULT NULL,
  status ENUM('active','inactive') DEFAULT 'active',
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (model_id),
  KEY fk_car_model (car_id),
  CONSTRAINT fk_car_model FOREIGN KEY (car_id) REFERENCES cars_tbl (car_id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4",

"INSERT IGNORE INTO models_tbl (car_id,model_name,model_year) VALUES
  (1,'Swift LXI','2018-2024'),(1,'Swift VXI','2019-2024'),(1,'Swift ZXI','2020-2024'),
  (2,'Alto 800','2012-2024'),(2,'Alto K10','2014-2024'),
  (3,'Baleno Sigma','2016-2024'),(3,'Baleno Delta','2017-2024'),
  (5,'i20 ERA','2014-2024'),(5,'i20 Sportz','2016-2024'),(5,'i20 Asta','2018-2024'),
  (6,'Creta EX','2015-2024'),(6,'Creta SX','2018-2024'),
  (7,'Verna EX','2017-2024'),(7,'Verna SX','2019-2024'),
  (9,'Nexon XE','2017-2024'),(9,'Nexon XZ','2019-2024'),(9,'Nexon XZ+','2020-2024'),
  (10,'Harrier XE','2019-2024'),(10,'Harrier XZ','2020-2024'),
  (13,'City V','2014-2024'),(13,'City ZX','2016-2024'),
  (14,'Amaze S','2016-2024'),(14,'Amaze VX','2018-2024'),
  (16,'Fortuner G','2016-2024'),(16,'Fortuner Legender','2020-2024'),
  (17,'Innova Crysta G','2016-2024'),(17,'Innova Crysta ZX','2019-2024'),
  (20,'Thar LX','2020-2024'),(20,'Thar AX','2021-2024'),
  (21,'Scorpio S3','2014-2024'),(21,'Scorpio N','2022-2024'),
  (22,'XUV700 MX','2021-2024'),(22,'XUV700 AX7','2022-2024'),
  (26,'Seltos HTX','2019-2024'),(26,'Seltos GTX+','2020-2024'),
  (27,'Sonet HTE','2020-2024'),(27,'Sonet HTX','2021-2024')",

"CREATE TABLE IF NOT EXISTS products_tbl (
  product_id INT NOT NULL AUTO_INCREMENT,
  part_name VARCHAR(255) NOT NULL,
  part_description TEXT DEFAULT NULL,
  part_number VARCHAR(100) DEFAULT NULL,
  category_id INT DEFAULT NULL,
  model_id INT DEFAULT NULL,
  brand VARCHAR(100) DEFAULT NULL,
  price DECIMAL(10,2) NOT NULL DEFAULT 0.00,
  original_price DECIMAL(10,2) DEFAULT NULL,
  stock INT NOT NULL DEFAULT 0,
  reorder_level INT DEFAULT 10,
  part_image VARCHAR(255) DEFAULT NULL,
  specifications TEXT DEFAULT NULL,
  warranty VARCHAR(100) DEFAULT '6 months',
  weight DECIMAL(8,2) DEFAULT NULL,
  is_featured TINYINT(1) DEFAULT 0,
  status ENUM('active','inactive') DEFAULT 'active',
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (product_id),
  KEY fk_product_category (category_id),
  KEY fk_product_model (model_id),
  CONSTRAINT fk_product_category FOREIGN KEY (category_id) REFERENCES categories_tbl (category_id) ON DELETE SET NULL,
  CONSTRAINT fk_product_model FOREIGN KEY (model_id) REFERENCES models_tbl (model_id) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4",

"INSERT IGNORE INTO products_tbl (part_name,part_description,part_number,category_id,model_id,brand,price,original_price,stock,reorder_level,part_image,warranty,is_featured,status) VALUES
  ('Timing Belt Kit','High-quality timing belt kit with tensioner','TBK-001',1,1,'Gates',2499,2999,50,10,'timing-belt.jpg','1 year',1,'active'),
  ('Brake Pads Front Set','Ceramic front brake pads low dust formula','BP-005',2,2,'Brembo',1499,1799,60,15,'brake-pads.jpg','1 year',1,'active'),
  ('Shock Absorber Front Pair','Gas-filled front shock absorbers','SA-010',3,9,'Monroe',5999,7200,30,8,'shock-absorber.jpg','2 years',1,'active'),
  ('Car Battery 55Ah','Maintenance-free sealed lead acid battery','CB-016',4,NULL,'Exide',4999,5999,45,10,'car-battery.jpg','3 years',1,'active'),
  ('Oil Filter','Premium oil filter for engine protection','OF-019',5,NULL,'Bosch',299,350,200,50,'oil-filter.jpg','3 months',1,'active'),
  ('Air Filter','High-flow replacement air filter','AF-020',5,NULL,'K&N',899,1100,150,30,'air-filter.jpg','6 months',1,'active'),
  ('Cabin Air Filter Carbon','Activated carbon cabin air filter','CA-022',5,NULL,'Bosch',599,749,130,30,'cabin-filter.jpg','6 months',1,'active'),
  ('Clutch Kit 3-Piece','Complete clutch kit with disc pressure plate','CK-027',7,1,'LUK',8999,10999,20,5,'clutch-kit.jpg','1 year',1,'active'),
  ('Radiator Aluminum','Full aluminum radiator for maximum cooling','RAD-030',8,20,'Nissens',7999,9999,15,4,'radiator.jpg','2 years',1,'active'),
  ('LED Headlight Assembly','Bright LED headlight assembly replacement','LH-035',9,NULL,'Osram',3999,5000,35,8,'led-headlight.jpg','1 year',1,'active'),
  ('Seat Cover Set Full Car','Universal fabric seat cover for 5-seater','SCV-040',10,NULL,'Autocraft',1999,2500,50,12,'seat-cover.jpg','6 months',1,'active'),
  ('Rubber Floor Mat Set','Anti-skid premium rubber floor mat set','FM-041',10,NULL,'Krosslink',799,999,100,25,'floor-mat.jpg','1 year',1,'active'),
  ('Spark Plug Set 4pcs','Iridium spark plugs for better ignition','SP-004',1,1,'NGK',1299,1599,80,20,'spark-plug.jpg','1 year',1,'active'),
  ('Engine Mount','Front engine mount for reduced vibration','EM-002',1,20,'Bosch',1899,2200,35,8,'engine-mount.jpg','6 months',0,'active'),
  ('Master Cylinder','OEM replacement brake master cylinder','MC-008',2,16,'ATE',4999,5999,20,5,'master-cylinder.jpg','2 years',0,'active')",

"CREATE TABLE IF NOT EXISTS orders_tbl (
  order_id INT NOT NULL AUTO_INCREMENT,
  user_id INT NOT NULL,
  order_number VARCHAR(20) NOT NULL,
  total_amount DECIMAL(10,2) NOT NULL,
  shipping_name VARCHAR(255) NOT NULL,
  shipping_phone VARCHAR(20) NOT NULL,
  shipping_email VARCHAR(255) NOT NULL,
  shipping_address TEXT NOT NULL,
  payment_method VARCHAR(50) NOT NULL DEFAULT 'COD',
  payment_status ENUM('pending','paid','failed') DEFAULT 'pending',
  order_status ENUM('pending','confirmed','processing','shipped','delivered','cancelled') DEFAULT 'pending',
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (order_id),
  UNIQUE KEY uq_order_number (order_number),
  KEY idx_user_id (user_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4",

"CREATE TABLE IF NOT EXISTS order_items_tbl (
  item_id INT NOT NULL AUTO_INCREMENT,
  order_id INT NOT NULL,
  product_id INT NOT NULL,
  quantity INT NOT NULL DEFAULT 1,
  price DECIMAL(10,2) NOT NULL,
  PRIMARY KEY (item_id),
  KEY fk_oi_order (order_id),
  KEY fk_oi_product (product_id),
  CONSTRAINT fk_oi_order FOREIGN KEY (order_id) REFERENCES orders_tbl (order_id) ON DELETE CASCADE,
  CONSTRAINT fk_oi_product FOREIGN KEY (product_id) REFERENCES products_tbl (product_id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4",

"CREATE TABLE IF NOT EXISTS wishlist_tbl (
  wishlist_id INT NOT NULL AUTO_INCREMENT,
  user_id INT NOT NULL,
  product_id INT NOT NULL,
  added_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (wishlist_id),
  UNIQUE KEY uq_wishlist (user_id,product_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4",

"CREATE TABLE IF NOT EXISTS inquiries_tbl (
  inquiry_id INT NOT NULL AUTO_INCREMENT,
  name VARCHAR(255) NOT NULL,
  email VARCHAR(255) NOT NULL,
  phone VARCHAR(20) DEFAULT NULL,
  subject VARCHAR(500) NOT NULL,
  message TEXT NOT NULL,
  reply TEXT DEFAULT NULL,
  status ENUM('open','replied','closed') DEFAULT 'open',
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (inquiry_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4",

"SET FOREIGN_KEY_CHECKS=1"
];

$ok = 0; $fail = 0;
foreach ($sqls as $sql) {
    if (mysqli_select_db($conn, $database) === false && strpos($sql,'CREATE DATABASE') === false && strpos($sql,'USE') !== 0) {
        mysqli_select_db($conn, $database);
    }
    if (mysqli_query($conn, $sql)) { $ok++; } else { $fail++; echo "<p style='color:red'>ERR: ".mysqli_error($conn)."<br><small>".htmlspecialchars(substr($sql,0,80))."</small></p>"; }
}

echo "<!DOCTYPE html><html><head><title>KCP Setup</title><style>body{font-family:sans-serif;max-width:600px;margin:60px auto;padding:20px;background:#0b0d10;color:#f0f0f0}.ok{color:#00ffe5}.btn{display:inline-block;margin-top:20px;padding:12px 24px;background:#ff3b2f;color:#fff;border-radius:8px;text-decoration:none;font-weight:bold}</style></head><body>";
echo "<h2>&#9989; Database Setup Complete</h2>";
echo "<p class='ok'>Statements executed: <strong>$ok</strong></p>";
if ($fail) echo "<p style='color:#ff3b2f'>Failed: $fail</p>";
echo "<hr>";
echo "<p><strong>Admin Login:</strong><br>Email: admin@krishnacarparts.com<br>Password: admin123</p>";
echo "<p><a class='btn' href='/KRISHNA-CAR-PARTS/User/index.php'>&#127968; Go to User Site</a>&nbsp;&nbsp;";
echo "<a class='btn' style='background:#1a73e8' href='/KRISHNA-CAR-PARTS/Admin/login.php'>&#128274; Admin Panel</a></p>";
echo "<p style='color:#ff3b2f;font-size:12px;margin-top:30px'>&#9888; DELETE setup.php from your server after setup is complete!</p>";
echo "</body></html>";
?>
