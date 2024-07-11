<?php
// Database credentials
$servername = "localhost";
$username = "kali`";
$password = "your_password";
$dbname = "url_shortener";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (isset($_GET['code'])) {
    $short_code = $conn->real_escape_string($_GET['code']);

    // Retrieve the long URL from the database
    $stmt = $conn->prepare("SELECT long_url FROM urls WHERE short_code = ?");
    $stmt->bind_param("s", $short_code);
    $stmt->execute();
    $stmt->bind_result($long_url);
    if ($stmt->fetch()) {
        header("Location: $long_url");
        exit();
    } else {
        echo "URL not found.";
    }
}

$conn->close();
?>

