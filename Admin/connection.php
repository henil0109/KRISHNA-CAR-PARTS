<?php
// Supports both local XAMPP and Railway/cloud MySQL via environment variables
$host     = getenv('MYSQLHOST')     ?: getenv('DB_HOST')     ?: 'localhost';
$username = getenv('MYSQLUSER')     ?: getenv('DB_USER')     ?: 'root';
$password = getenv('MYSQLPASSWORD') ?: getenv('DB_PASSWORD') ?: '';
$database = getenv('MYSQLDATABASE') ?: getenv('DB_NAME')     ?: 'KCP_db';
$port     = (int)(getenv('MYSQLPORT') ?: getenv('DB_PORT') ?: 3306);

$conn = mysqli_connect($host, $username, $password, $database, $port);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

mysqli_set_charset($conn, "utf8mb4");
// No closing ?> tag intentionally
