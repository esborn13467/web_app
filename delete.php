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

if (isset($_GET['id'])) {
    $id = $conn->real_escape_string($_GET['id']);
    
    // Fetch filename
    $result = $conn->query("SELECT filename FROM photos WHERE id = $id");
    if ($row = $result->fetch_assoc()) {
        $filename = $row['filename'];
        
        // Delete file from server
        if (unlink($filename)) {
            // Delete record from database
            $conn->query("DELETE FROM photos WHERE id = $id");
            echo "Photo deleted successfully.";
        } else {
            echo "Failed to delete photo file.";
        }
    } else {
        echo "Photo not found.";
    }
}

$conn->close();
?>

