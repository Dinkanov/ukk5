<?php

include 'fungsi.php';

// Jika sudah login, redirect ke index
if (isLoggedIn()) {
    header("Location: index.php");
    exit();
}

// Proses login jika ada request POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Ambil data user berdasarkan username
    $user = $koneksi->query("SELECT * FROM users WHERE username = '$username'")->fetch_assoc();
    
    // Verifikasi password
    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['user_role'] = $user['role'];
        header("Location: index.php");
        exit();
    }
    $error = "Login gagal!";
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Login</title>

    <!-- INTERNAL CSS -->
    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background: linear-gradient(135deg, #ffd7e8, #dbe9ff);
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        h2 {
            text-align: center;
            color: #444;
            margin-bottom: 20px;
        }

        .login-box {
            background: white;
            padding: 35px;
            width: 340px;
            border-radius: 15px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.1);
            border: 2px solid #f7bbd3;
        }

        form {
            display: flex;
            flex-direction: column;
            gap: 15px;
        }

        label {
            color: #444;
            font-weight: bold;
            font-size: 14px;
        }

        input {
            padding: 12px;
            border-radius: 8px;
            border: 1.5px solid #aac7ff;
            outline: none;
            font-size: 14px;
            transition: 0.2s;
        }

        input:focus {
            border-color: #7aa6ff;
            box-shadow: 0 0 5px rgba(122,166,255,0.6);
        }

        button {
            padding: 12px;
            border: none;
            background: #ff9fc6;
            color: white;
            font-size: 16px;
            border-radius: 10px;
            cursor: pointer;
            transition: 0.2s;
            font-weight: bold;
        }

        button:hover {
            background: #ff87b7;
        }

        .error {
            text-align: center;
            color: red;
            margin-bottom: 10px;
            font-weight: bold;
        }
    </style>
</head>

<body>

    <div class="login-box">

        <h2>LOGIN</h2>

        <?php if (isset($error)) echo "<p class='error'>$error</p>"; ?>

        <form method="post">
            <label>Username</label>
            <input type="text" name="username" required>

            <label>Password</label>
            <input type="password" name="password" required>

            <button type="submit">Login</button>
        </form>
    </div>

</body>
</html>