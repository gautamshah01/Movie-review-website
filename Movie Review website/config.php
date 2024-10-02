<?php
$host = 'localhost';
$db = 'movie_app'; // Ensure this matches your database name
$user = 'root'; // Default WAMP user
$pass = ''; // Default password is usually empty

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
