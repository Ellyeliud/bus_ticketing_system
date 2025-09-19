<?php
$servername = "localhost";
$username   = "root";   // change if different
$password   = "ellyELIUD2005";       // change if you set a password
$dbname     = "bus_ticketing_system"; // change to your DB name

$conn = new mysqli($servername, $username, $password, $dbname);

if($conn->connect_error){
    die("Connection failed: " . $conn->connect_error);
}
?>
