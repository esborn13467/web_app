<?php
// db.php

$servername = "localhost";
$username = "kali";  // Replace with your new username
$password = "your_password";  // Replace with your new password
$dbname = "term_project";

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    die("Connection failed: " . $e->getMessage());  // Die with error message if connection fails
}
?>

