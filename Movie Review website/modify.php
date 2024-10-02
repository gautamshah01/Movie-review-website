<?php
include 'config.php';
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: landing.php");
    exit();
}

// Fetch user data
$stmt = $conn->prepare("SELECT username FROM users WHERE id = ?");
$stmt->bind_param("i", $_SESSION['user_id']);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $new_username = $_POST['username'];

    // Update username in database
    $stmt = $conn->prepare("UPDATE users SET username = ? WHERE id = ?");
    $stmt->bind_param("si", $new_username, $_SESSION['user_id']);
    $stmt->execute();
    header("Location: index.php"); // Redirect after update
}

$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="style.css" />
    <title>Update Profile</title>
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #22254b;
            color: #fff;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        form {
            background: #373b69;
            padding: 2rem;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.3);
        }
        input {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: none;
            border-radius: 5px;
        }
        button {
            background: #6c63ff;
            border: none;
            padding: 10px;
            border-radius: 5px;
            color: white;
            cursor: pointer;
            width: 100%;
        }
        button:hover {
            background: #5a54e2;
        }
    </style>
</head>
<body>
    <form method="POST">
        <h2>Update Profile</h2>
        <input type="text" name="username" value="<?php echo $user['username']; ?>" required />
        <button type="submit">Update</button>
    </form>
</body>
</html>
