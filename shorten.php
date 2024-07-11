<?php
// Database credentials
$servername = "localhost";
$username = "kali";
$password = "your_password";
$dbname = "url_shortener";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $long_url = $conn->real_escape_string($_POST['long_url']);
    $short_code = generateShortCode();

    // Insert long URL and short code into the database
    $stmt = $conn->prepare("INSERT INTO urls (long_url, short_code) VALUES (?, ?)");
    $stmt->bind_param("ss", $long_url, $short_code);
    if ($stmt->execute()) {
        echo "Shortened URL: <a href='redirect.php?code=$short_code'>http://yourdomain.com/$short_code</a>";
    } else {
        echo "Error: " . $stmt->error;
    }
}

$conn->close();

// Function to generate a unique short code
function generateShortCode($length = 6) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $shortCode = '';
    for ($i = 0; $i < $length; $i++) {
        $shortCode .= $characters[rand(0, $charactersLength - 1)];
    }
    return $shortCode;
}
?>

