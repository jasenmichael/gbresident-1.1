<?php
set_time_limit(0);
ini_set("memory_limit","-1");

$servername = "us-cdbr-iron-east-02.cleardb.net";
// $servername = getenv('DB_HOST');

$username = "b38cbdfaae4f40";
$password = "d94ce7a6";
$db = 'heroku_4fafaa7172f3435';
// Create connection
$conn = new mysqli($servername, $username, $password, $db);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 
// echo "Connected successfully";
