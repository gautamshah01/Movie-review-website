<?php
session_start();

// Redirect to login if the user is not authenticated
if (!isset($_SESSION['username'])) {
    header("Location: login.html");
    exit();
}

$host = 'localhost';
$db = 'movie_app';
$user = 'root';
$pass = '';

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$userId = $_SESSION['user_id'];
$sql = "SELECT * FROM users WHERE id='$userId'";
$result = $conn->query($sql);
$user = $result->fetch_assoc();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['delete'])) {
        // Delete account
        $deleteSql = "DELETE FROM users WHERE id='$userId'";
        $conn->query($deleteSql);
        session_destroy();
        header("Location: login.html");
        exit();
    } elseif (isset($_POST['modify'])) {
        // Update user info (add more fields as needed)
        $newUsername = $_POST['new_username'];
        $newPassword = password_hash($_POST['new_password'], PASSWORD_DEFAULT);
        $updateSql = "UPDATE users SET username='$newUsername', password='$newPassword' WHERE id='$userId'";
        $conn->query($updateSql);
        // Update session username
        $_SESSION['username'] = $newUsername;
        header("Location: index.php");
        exit();
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Account Management</title>
</head>
<body>
    <header>
        <h1>Account Management</h1>
    </header>
    <main>
        <h2>Welcome, <?php echo $user['username']; ?></h2>
        <form method="POST">
            <h3>Modify Account</h3>
            <input type="text" name="new_username" placeholder="New Username" required>
            <input type="password" name="new_password" placeholder="New Password" required>
            <button type="submit" name="modify">Modify Account</button>
        </form>
        <form method="POST">
            <h3>Delete Account</h3>
            <button type="submit" name="delete">Delete Account</button>
        </form>
    </main>
</body>
</html>
