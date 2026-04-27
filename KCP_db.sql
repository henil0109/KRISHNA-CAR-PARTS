-- ============================================================
-- KRISHNA CAR PARTS (KCP) - Complete Database Schema & Data
-- Database: KCP_db
-- ============================================================

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

CREATE DATABASE IF NOT EXISTS `KCP_db` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE `KCP_db`;

-- ============================================================
-- admin_tbl
-- ============================================================
DROP TABLE IF EXISTS `admin_tbl`;
CREATE TABLE `admin_tbl` (
  `admin_id`       INT NOT NULL AUTO_INCREMENT,
  `admin_name`     VARCHAR(255) NOT NULL,
  `admin_email`    VARCHAR(255) NOT NULL,
  `admin_password` VARCHAR(255) NOT NULL,
  `created_at`     TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`admin_id`),
  UNIQUE KEY `uq_admin_email` (`admin_email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Admin: admin@krishnacarparts.com / admin123
INSERT INTO `admin_tbl` (`admin_name`,`admin_email`,`admin_password`) VALUES
('Administrator','admin@krishnacarparts.com','admin123');

-- ============================================================
-- users_tbl
-- ============================================================
DROP TABLE IF EXISTS `users_tbl`;
CREATE TABLE `users_tbl` (
  `user_id`       INT NOT NULL AUTO_INCREMENT,
  `name`          VARCHAR(255) NOT NULL,
  `email`         VARCHAR(255) NOT NULL,
  `phone`         VARCHAR(20) DEFAULT NULL,
  `password`      VARCHAR(255) NOT NULL,
  `profile_image` VARCHAR(255) DEFAULT NULL,
  `address`       TEXT DEFAULT NULL,
  `city`          VARCHAR(100) DEFAULT NULL,
  `state`         VARCHAR(100) DEFAULT NULL,
  `pincode`       VARCHAR(10) DEFAULT NULL,
  `status`        ENUM('active','inactive') DEFAULT 'active',
  `created_at`    TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  `updated_at`    TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`user_id`),
  UNIQUE KEY `uq_user_email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ============================================================
-- categories_tbl
-- ============================================================
DROP TABLE IF EXISTS `categories_tbl`;
CREATE TABLE `categories_tbl` (
  `category_id`    INT NOT NULL AUTO_INCREMENT,
  `category_name`  VARCHAR(255) NOT NULL,
  `description`    TEXT DEFAULT NULL,
  `category_image` VARCHAR(255) DEFAULT NULL,
  `status`         ENUM('active','inactive') DEFAULT 'active',
  `created_at`     TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`category_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `categories_tbl` (`category_name`,`description`,`status`) VALUES
('Engine Parts',          'Engine components including pistons, rings, gaskets, and timing belts','active'),
('Brake System',          'Brake pads, discs, calipers, and master cylinders for all vehicles','active'),
('Suspension & Steering', 'Shock absorbers, struts, tie rods, and ball joints','active'),
('Electrical Components', 'Batteries, alternators, starters, and sensors','active'),
('Filters',               'Air, oil, fuel, and cabin filters for routine maintenance','active'),
('Exhaust System',        'Exhaust pipes, mufflers, catalytic converters, and clamps','active'),
('Transmission & Clutch', 'Clutch kits, transmission filters, and gearbox parts','active'),
('Cooling System',        'Radiators, water pumps, thermostats, and cooling fans','active'),
('Body & Exterior',       'Bumpers, mirrors, lights, handles, and exterior accessories','active'),
('Interior Accessories',  'Seat covers, floor mats, steering covers, and dashboard accessories','active');

-- ============================================================
-- brands_tbl  (Car Manufacturers)
-- ============================================================
DROP TABLE IF EXISTS `brands_tbl`;
CREATE TABLE `brands_tbl` (
  `brand_id`   INT NOT NULL AUTO_INCREMENT,
  `brand_name` VARCHAR(255) NOT NULL,
  `country`    VARCHAR(100) DEFAULT NULL,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`brand_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `brands_tbl` (`brand_name`,`country`) VALUES
('Maruti Suzuki','India'),
('Hyundai','South Korea'),
('Tata Motors','India'),
('Honda','Japan'),
('Toyota','Japan'),
('Mahindra','India'),
('Ford','USA'),
('Volkswagen','Germany'),
('Kia','South Korea'),
('Renault','France');

-- ============================================================
-- cars_tbl  (Specific car names linked to a brand)
-- ============================================================
DROP TABLE IF EXISTS `cars_tbl`;
CREATE TABLE `cars_tbl` (
  `car_id`     INT NOT NULL AUTO_INCREMENT,
  `brand_id`   INT NOT NULL,
  `car_name`   VARCHAR(255) NOT NULL,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`car_id`),
  KEY `fk_brand` (`brand_id`),
  CONSTRAINT `fk_brand` FOREIGN KEY (`brand_id`) REFERENCES `brands_tbl` (`brand_id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `cars_tbl` (`brand_id`,`car_name`) VALUES
(1,'Swift'),(1,'Alto'),(1,'Baleno'),(1,'Dzire'),
(2,'i20'),(2,'Creta'),(2,'Verna'),(2,'Grand i10'),
(3,'Nexon'),(3,'Harrier'),(3,'Safari'),(3,'Altroz'),
(4,'City'),(4,'Amaze'),(4,'WR-V'),
(5,'Fortuner'),(5,'Innova Crysta'),(5,'Glanza'),
(6,'Thar'),(6,'Scorpio'),(6,'XUV700'),
(7,'EcoSport'),(7,'Figo'),
(8,'Polo'),(8,'Vento'),
(9,'Seltos'),(9,'Sonet'),
(10,'Kwid'),(10,'Kiger');

-- ============================================================
-- models_tbl  (Variants linked to cars_tbl)
-- ============================================================
DROP TABLE IF EXISTS `models_tbl`;
CREATE TABLE `models_tbl` (
  `model_id`   INT NOT NULL AUTO_INCREMENT,
  `car_id`     INT NOT NULL,
  `model_name` VARCHAR(255) NOT NULL,
  `model_year` VARCHAR(20) DEFAULT NULL,
  `status`     ENUM('active','inactive') DEFAULT 'active',
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`model_id`),
  KEY `fk_car_model` (`car_id`),
  CONSTRAINT `fk_car_model` FOREIGN KEY (`car_id`) REFERENCES `cars_tbl` (`car_id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `models_tbl` (`car_id`,`model_name`,`model_year`) VALUES
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
(27,'Sonet HTE','2020-2024'),(27,'Sonet HTX','2021-2024');

-- ============================================================
-- products_tbl
-- ============================================================
DROP TABLE IF EXISTS `products_tbl`;
CREATE TABLE `products_tbl` (
  `product_id`       INT NOT NULL AUTO_INCREMENT,
  `part_name`        VARCHAR(255) NOT NULL,
  `part_description` TEXT DEFAULT NULL,
  `part_number`      VARCHAR(100) DEFAULT NULL,
  `category_id`      INT DEFAULT NULL,
  `model_id`         INT DEFAULT NULL,
  `brand`            VARCHAR(100) DEFAULT NULL,
  `price`            DECIMAL(10,2) NOT NULL DEFAULT 0.00,
  `original_price`   DECIMAL(10,2) DEFAULT NULL,
  `stock`            INT NOT NULL DEFAULT 0,
  `reorder_level`    INT DEFAULT 10,
  `part_image`       VARCHAR(255) DEFAULT NULL,
  `specifications`   TEXT DEFAULT NULL,
  `warranty`         VARCHAR(100) DEFAULT '6 months',
  `weight`           DECIMAL(8,2) DEFAULT NULL,
  `is_featured`      TINYINT(1) DEFAULT 0,
  `status`           ENUM('active','inactive') DEFAULT 'active',
  `created_at`       TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`product_id`),
  KEY `fk_product_category` (`category_id`),
  KEY `fk_product_model` (`model_id`),
  CONSTRAINT `fk_product_category` FOREIGN KEY (`category_id`) REFERENCES `categories_tbl` (`category_id`) ON DELETE SET NULL,
  CONSTRAINT `fk_product_model`    FOREIGN KEY (`model_id`)    REFERENCES `models_tbl` (`model_id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `products_tbl`
  (`part_name`,`part_description`,`part_number`,`category_id`,`model_id`,`brand`,`price`,`original_price`,`stock`,`reorder_level`,`part_image`,`warranty`,`is_featured`,`status`)
VALUES
('Timing Belt Kit',         'High-quality timing belt kit with tensioner and idler pulley','TBK-001',1,1,  'Gates',      2499,2999,50,10,'timing-belt.jpg',      '1 year',1,'active'),
('Engine Mount',            'Front engine mount for reduced vibration',                   'EM-002', 1,20, 'Bosch',      1899,2200,35, 8,'engine-mount.jpg',     '6 months',0,'active'),
('PCV Valve',               'Positive crankcase ventilation valve OEM replacement',       'PCV-003',1,NULL,'Bosch',      599, 799,75,18,'pcv-valve.jpg',        '1 year',0,'active'),
('Spark Plug Set 4pcs',     'Iridium spark plugs for better ignition and fuel efficiency','SP-004', 1,1,  'NGK',       1299,1599,80,20,'spark-plug.jpg',       '1 year',1,'active'),
('Brake Pads Front Set',    'Ceramic front brake pads with low dust formula',             'BP-005', 2,2,  'Brembo',    1499,1799,60,15,'brake-pads.jpg',       '1 year',1,'active'),
('Brake Disc Front',        'Vented front brake disc for superior heat dissipation',      'BD-006', 2,20, 'Zimmermann',2799,3200,40,10,'brake-disc.jpg',       '1 year',0,'active'),
('Brake Caliper',           'Remanufactured front brake caliper assembly',                'BC-007', 2,NULL,'Cardone',   3499,4200,25, 5,'brake-caliper.jpg',   '1 year',0,'active'),
('Master Cylinder',         'OEM replacement brake master cylinder with reservoir',       'MC-008', 2,16, 'ATE',       4999,5999,20, 5,'master-cylinder.jpg', '2 years',0,'active'),
('Brake Fluid DOT4',        'High performance brake fluid DOT4 specification 500ml',      'BF-009', 2,NULL,'Motul',      499, 599,100,25,'brake-fluid.jpg',     NULL,0,'active'),
('Shock Absorber Front Pair','Gas-filled front shock absorbers for smooth comfortable ride','SA-010',3,9, 'Monroe',    5999,7200,30, 8,'shock-absorber.jpg',  '2 years',1,'active'),
('Ball Joint Lower',        'Lower ball joint with boot for improved handling',           'BJ-011', 3,1,  'Moog',      1299,1599,55,12,'ball-joint.jpg',       '1 year',0,'active'),
('Strut Mount Front',       'Front strut mount assembly with bearing plate',              'SM-012', 3,2,  'SKF',       1899,2300,35, 8,'strut-mount.jpg',      '1 year',0,'active'),
('Coil Spring Front',       'Heavy-duty front coil spring OEM specification',             'CS-013', 3,20, 'Eibach',    3499,4200,25, 6,'coil-spring.jpg',     '2 years',0,'active'),
('Sway Bar Link Front',     'Front sway bar stabilizer link kit',                         'SBL-014',3,NULL,'Moog',       799, 999,70,15,'sway-bar.jpg',        '1 year',0,'active'),
('CV Joint Outer',          'Outer CV joint with boot and clamp kit',                     'CVJ-015',3,1,  'GKN',       3999,4999,22, 5,'cv-joint.jpg',        '1 year',0,'active'),
('Car Battery 55Ah',        'Maintenance-free sealed lead acid battery 55Ah',             'CB-016', 4,NULL,'Exide',     4999,5999,45,10,'car-battery.jpg',     '3 years',1,'active'),
('Alternator 65A',          'Remanufactured alternator 65 ampere output',                 'ALT-017',4,1,  'Bosch',     8999,11000,15, 4,'alternator.jpg',     '1 year',0,'active'),
('Starter Motor',           'High-torque starter motor for easy cold starts',             'STM-018',4,16, 'Denso',     6999,8500,18, 4,'starter-motor.jpg',   '1 year',0,'active'),
('Oil Filter',              'Premium oil filter for complete engine lubrication protection','OF-019',5,NULL,'Bosch',      299, 350,200,50,'oil-filter.jpg',      '3 months',1,'active'),
('Air Filter',              'High-flow replacement air filter for improved performance',   'AF-020',5,NULL,'K&N',        899,1100,150,30,'air-filter.jpg',      '6 months',1,'active'),
('Fuel Filter Inline',      'Inline fuel filter for clean fuel delivery to engine',        'FF-021',5,NULL,'Mahle',      699, 850,120,30,'fuel-filter.jpg',     '6 months',0,'active'),
('Cabin Air Filter Carbon', 'Activated carbon cabin air filter for fresh air inside',     'CA-022',5,NULL,'Bosch',      599, 749,130,30,'cabin-filter.jpg',    '6 months',1,'active'),
('Exhaust Pipe Section',    'Stainless steel exhaust pipe section universal fit',          'EP-023',6,NULL,'Bosal',     2999,3600,30, 8,'exhaust-pipe.jpg',    '2 years',0,'active'),
('Muffler Performance',     'Performance muffler for reduced noise and back pressure',    'MUF-024',6,2,  'Walker',    4499,5500,20, 5,'muffler.jpg',         '2 years',0,'active'),
('Catalytic Converter',     'OEM catalytic converter for emission standards compliance',  'CC-025', 6,1,  'Bosal',    12999,15999,10, 3,'catalytic-converter.jpg','3 years',0,'active'),
('Exhaust Manifold Gasket', 'Exhaust manifold gasket set for leak-free sealing',          'EG-026',6,NULL,'Elring',     399, 499,90,20,'exhaust-gasket.jpg',  '1 year',0,'active'),
('Clutch Kit 3-Piece',      'Complete clutch kit with disc, pressure plate, and bearing', 'CK-027',7,1,  'LUK',       8999,10999,20, 5,'clutch-kit.jpg',      '1 year',1,'active'),
('Clutch Cable',            'OEM replacement clutch cable for manual transmission cars',  'CCB-028',7,2,  'Valeo',      999,1299,50,12,'clutch-cable.jpg',     '1 year',0,'active'),
('Automatic Trans Filter',  'Automatic transmission oil filter with gasket',              'TF-029', 7,NULL,'Mahle',     1299,1599,40,10,'transmission-filter.jpg','1 year',0,'active'),
('Radiator Aluminum',       'Full aluminum radiator for maximum cooling efficiency',      'RAD-030',8,20, 'Nissens',   7999,9999,15, 4,'radiator.jpg',        '2 years',1,'active'),
('Water Pump with Gasket',  'OEM replacement water pump assembly with gasket',            'WP-031', 8,1,  'Continental',2999,3599,30, 8,'water-pump.jpg',     '1 year',0,'active'),
('Engine Thermostat',       'Engine thermostat with housing for correct temp regulation', 'TH-032', 8,NULL,'Wahler',    1299,1599,55,12,'thermostat.jpg',      '1 year',0,'active'),
('Electric Cooling Fan',    'Electric radiator cooling fan assembly with motor',          'CF-033', 8,9,  'Bosch',     4999,6200,22, 5,'cooling-fan.jpg',     '1 year',0,'active'),
('Radiator Hose Upper',     'Upper radiator coolant hose silicone reinforced',            'RH-034', 8,NULL,'Gates',      699, 899,80,20,'radiator-hose.jpg',   '1 year',0,'active'),
('LED Headlight Assembly',  'Bright LED headlight assembly one side replacement',         'LH-035', 9,NULL,'Osram',     3999,5000,35, 8,'led-headlight.jpg',   '1 year',1,'active'),
('Side Mirror Right',       'Electric power folding side mirror right side',              'SMR-036',9,2,  'OEM',       2999,3800,28, 6,'side-mirror.jpg',     '1 year',0,'active'),
('LED Tail Light',          'LED tail light assembly replacement with wiring',            'TL-037', 9,9,  'OEM',       2499,3200,30, 8,'tail-light.jpg',      '1 year',0,'active'),
('Fog Light Kit',           'Front fog light kit universal fit with wiring harness',      'FL-038', 9,NULL,'Osram',     1999,2500,45,10,'fog-light.jpg',       '1 year',0,'active'),
('Interior Door Handle',    'Interior door handle replacement grey color',                'DH-039', 9,NULL,'OEM',        499, 649,80,20,'door-handle.jpg',     '6 months',0,'active'),
('Seat Cover Set Full Car', 'Universal fabric seat cover complete set for 5-seater',     'SCV-040',10,NULL,'Autocraft',1999,2500,50,12,'seat-cover.jpg',      '6 months',1,'active'),
('Rubber Floor Mat Set',    'Anti-skid premium rubber floor mat set full car coverage',   'FM-041',10,NULL,'Krosslink',  799, 999,100,25,'floor-mat.jpg',      '1 year',1,'active'),
('Steering Wheel Cover',    'Leather steering wheel cover universal size medium',         'SC-042',10,NULL,'Speedwav',   449, 599,120,30,'steering-cover.jpg', '6 months',0,'active'),
('Dashboard Cover Mat',     'Custom fit dashboard cover mat with anti-glare finish',     'DC-043',10,NULL,'Autocraft', 1299,1599,40,10,'dashboard-cover.jpg', '1 year',0,'active'),
('Leather Gear Knob',       'Universal leather gear shift knob with chrome ring',         'GK-044',10,NULL,'Speedwav',   599, 799,90,20,'gear-knob.jpg',       '6 months',0,'active');

-- ============================================================
-- orders_tbl
-- ============================================================
DROP TABLE IF EXISTS `order_items_tbl`;
DROP TABLE IF EXISTS `orders_tbl`;
CREATE TABLE `orders_tbl` (
  `order_id`        INT NOT NULL AUTO_INCREMENT,
  `user_id`         INT NOT NULL,
  `order_number`    VARCHAR(20) NOT NULL,
  `total_amount`    DECIMAL(10,2) NOT NULL,
  `shipping_name`   VARCHAR(255) NOT NULL,
  `shipping_phone`  VARCHAR(20) NOT NULL,
  `shipping_email`  VARCHAR(255) NOT NULL,
  `shipping_address`TEXT NOT NULL,
  `payment_method`  VARCHAR(50) NOT NULL DEFAULT 'COD',
  `payment_status`  ENUM('pending','paid','failed') DEFAULT 'pending',
  `order_status`    ENUM('pending','confirmed','processing','shipped','delivered','cancelled') DEFAULT 'pending',
  `created_at`      TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  `updated_at`      TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`order_id`),
  UNIQUE KEY `uq_order_number` (`order_number`),
  KEY `idx_user_id` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ============================================================
-- order_items_tbl
-- ============================================================
CREATE TABLE `order_items_tbl` (
  `item_id`    INT NOT NULL AUTO_INCREMENT,
  `order_id`   INT NOT NULL,
  `product_id` INT NOT NULL,
  `quantity`   INT NOT NULL DEFAULT 1,
  `price`      DECIMAL(10,2) NOT NULL,
  PRIMARY KEY (`item_id`),
  KEY `fk_oi_order`   (`order_id`),
  KEY `fk_oi_product` (`product_id`),
  CONSTRAINT `fk_oi_order`   FOREIGN KEY (`order_id`)   REFERENCES `orders_tbl`   (`order_id`) ON DELETE CASCADE,
  CONSTRAINT `fk_oi_product` FOREIGN KEY (`product_id`) REFERENCES `products_tbl` (`product_id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ============================================================
-- wishlist_tbl
-- ============================================================
DROP TABLE IF EXISTS `wishlist_tbl`;
CREATE TABLE `wishlist_tbl` (
  `wishlist_id` INT NOT NULL AUTO_INCREMENT,
  `user_id`     INT NOT NULL,
  `product_id`  INT NOT NULL,
  `added_at`    TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`wishlist_id`),
  UNIQUE KEY `uq_wishlist` (`user_id`,`product_id`),
  KEY `fk_wl_product` (`product_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ============================================================
-- inquiries_tbl
-- ============================================================
DROP TABLE IF EXISTS `inquiries_tbl`;
CREATE TABLE `inquiries_tbl` (
  `inquiry_id` INT NOT NULL AUTO_INCREMENT,
  `name`       VARCHAR(255) NOT NULL,
  `email`      VARCHAR(255) NOT NULL,
  `phone`      VARCHAR(20) DEFAULT NULL,
  `subject`    VARCHAR(500) NOT NULL,
  `message`    TEXT NOT NULL,
  `reply`      TEXT DEFAULT NULL,
  `status`     ENUM('open','replied','closed') DEFAULT 'open',
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`inquiry_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

SET FOREIGN_KEY_CHECKS = 1;
-- END OF KCP_db.sql
