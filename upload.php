<?php
// Enable error reporting
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Database credentials
$servername = "localhost";
$username = "kali";
$password = "your_password";
$dbname = "photo_gallery";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $caption = $conn->real_escape_string($_POST['caption']);
    $file = $_FILES['file'];

    // Validate file type
    $allowed = array('jpeg', 'jpg', 'png');
    $ext = pathinfo($file['name'], PATHINFO_EXTENSION);
    if (!in_array(strtolower($ext), $allowed)) {
        die("Only JPEG and PNG files are allowed.");
    }

    // Save file to server
    $targetDir = "uploads/";
    $targetFile = $targetDir . basename($file['name']);
    if (move_uploaded_file($file['tmp_name'], $targetFile)) {
        // Save file information to database
        $stmt = $conn->prepare("INSERT INTO photos (filename, caption) VALUES (?, ?)");
        $stmt->bind_param("ss", $targetFile, $caption);
        $stmt->execute();
        echo "File uploaded successfully.";
    } else {
        echo "Failed to upload file.";
    }
}

$conn->close();
?>

