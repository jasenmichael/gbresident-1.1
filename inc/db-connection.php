<?php
set_time_limit(0);
ini_set("memory_limit", "-1");

if (file_exists("../../env.php")) {
    $env = "production";
    include("../../env.php");
}  else{
    $env = "development";
}

$servername = ($env = "development" ? $DB['DB_HOST'] : getenv('DB_HOST'));

$username = ($env = "development" ? $DB['DB_USER'] : getenv('DB_USER'));

$password = "d94ce7a6";
$db = 'heroku_4fafaa7172f3435';
// Create connection
$conn = new mysqli($servername, $username, $password, $db);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 
// echo "Connected successfully";
