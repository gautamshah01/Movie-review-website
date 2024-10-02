<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="style.css" />
    <title>Welcome to Movie App</title>
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: #22254b;
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
    <form action="signup.php" method="POST">
        <h2>Sign Up</h2>
        <input type="text" name="username" placeholder="Username" required />
        <input type="password" name="password" placeholder="Password" required />
        <button type="submit">Sign Up</button>
    </form>
    <form action="login.php" method="POST">
        <h2>Log In</h2>
        <input type="text" name="username" placeholder="Username" required />
        <input type="password" name="password" placeholder="Password" required />
        <button type="submit">Log In</button>
    </form>
</body>
</html>
