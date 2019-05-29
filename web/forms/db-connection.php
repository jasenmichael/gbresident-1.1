<?php
set_time_limit(0);
ini_set("memory_limit","-1");

$servername = "10.14.72.12";
$username = "aurorab2_gb";
$password = "aurorab2_gb";
$db = 'aurorab2_gb';
// Create connection
$conn = new mysqli($servername, $username, $password, $db);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 
// echo "Connected successfully";
