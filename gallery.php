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

// Fetch photos from database
$result = $conn->query("SELECT id, filename, caption FROM photos");

$photos = [];
while ($row = $result->fetch_assoc()) {
    $photos[] = $row;
}

$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Photo Gallery</title>
    <style>
        .photo {
            text-align: center;
            margin: 20px;
        }
        .photo img {
            max-width: 100%;
        }
        .nav {
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="photo">
        <img id="photo" src="" alt="">
        <p id="caption"></p>
        <a id="delete-link" href="">Delete</a>
    </div>
    <div class="nav">
        <button onclick="prevPhoto()">Left</button>
        <button onclick="nextPhoto()">Right</button>
    </div>

    <script>
        let photos = <?php echo json_encode($photos); ?>;
        let currentPhotoIndex = 0;

        function showPhoto(index) {
            let photo = photos[index];
            document.getElementById('photo').src = photo.filename;
            document.getElementById('caption').innerText = photo.caption;
            document.getElementById('delete-link').href = 'delete.php?id=' + photo.id;
        }

        function prevPhoto() {
            currentPhotoIndex = (currentPhotoIndex > 0) ? currentPhotoIndex - 1 : photos.length - 1;
            showPhoto(currentPhotoIndex);
        }

        function nextPhoto() {
            currentPhotoIndex = (currentPhotoIndex < photos.length - 1) ? currentPhotoIndex + 1 : 0;
            showPhoto(currentPhotoIndex);
        }

        showPhoto(currentPhotoIndex);
    </script>
</body>
</html>

