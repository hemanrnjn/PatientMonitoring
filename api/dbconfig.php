<?php

$host     = "localhost"; 
$username = "root"; // Mysql username 
$password = ""; // Mysql password 
$db_name  = "iMonitor"; // Database name 


// Connect to server and select databse.
$conn = mysqli_connect($host, $username, $password, $db_name);

// Check connection
if (mysqli_connect_errno($conn)) {
    echo "Failed to connect to MySQL: " . mysqli_connect_error();
}
?>