<?php
include 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    $stmt = $conn->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();

    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user'] = $user;
        header("Location: index.php");
        exit;
    } else {
        $_SESSION['error'] = "Invalid username or password";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    <style>
        body {
            margin: 0;
            height: 100vh;
            background: linear-gradient(#e6c9a8, #d2b48c); /* badami */
            display: flex;
            justify-content: center;
            align-items: center;
            font-family: Arial, sans-serif;
            color: #000;
        }

        .login-box {
            background: #f8f1e4;
            padding: 30px;
            border-radius: 15px;
            width: 360px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.25);
        }

        h2 {
            text-align: center;
            color: #000;
            margin-bottom: 25px;
            font-weight: bold;
        }

        input {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #a1866f;
            border-radius: 6px;
            color: #000;
            background: #fffaf2;
        }

        input::placeholder {
            color: #000;
            opacity: 0.7;
        }

        button {
            width: 100%;
            padding: 10px;
            background: #c19a6b;
            border: none;
            border-radius: 6px;
            color: #000;
            font-weight: bold;
            cursor: pointer;
        }

        button:hover {
            background: #b08968;
        }

        p {
            text-align: center;
            margin-top: 15px;
            color: #000;
        }

        a {
            color: #000;
            font-weight: bold;
            text-decoration: none;
        }

        a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>

<div class="login-box">
    <h2>Login to Secure Blog</h2>

    <?php if(isset($_SESSION['error'])): ?>
        <p style="color:red"><?= $_SESSION['error']; unset($_SESSION['error']); ?></p>
    <?php endif; ?>

    <form method="post">
        <input type="text" name="username" placeholder="Username" required>
        <input type="password" name="password" placeholder="Password" required>
        <button type="submit">Login</button>
    </form>

    <p>Don’t have an account? <a href="register.php">Register here</a></p>
</div>

</body>
</html>
