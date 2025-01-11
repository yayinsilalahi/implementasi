<?php
include 'koneksi.php';

// Login Pengguna
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['login'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT id, name, password FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();
    if ($stmt->num_rows > 0) {
        $stmt->bind_result($id, $name, $hashed_password);
        $stmt->fetch();
        if (password_verify($password, $hashed_password)) {
            session_start();
            $_SESSION['user_id'] = $id;
            $_SESSION['user_name'] = $name;
            header('Location: home.php');
        } else {
            echo "Password salah.";
        }
    } else {
        echo "Email tidak ditemukan.";
    }
    $stmt->close();
}

?>

<!-- <!DOCTYPE html>
<html>
<head>
    <title>Manajemen Pengguna</title>
</head>
<body>
    <h1>Login</h1>
    <form method="post">
        <input type="email" name="email" placeholder="Email" required><br>
        <input type="password" name="password" placeholder="Password" required><br>
        <button type="submit" name="login">Login</button>
    </form>

    <a href="/implementasi/register.php">Belum Punya Akun? Daftar Sekarang</a>
</body>
</html> -->

<!DOCTYPE html>
<html lang="en">

<head>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet" />
    <title>Manajemen Pengguna</title>
    <style>
        body,
        html {
            margin: 0;
            padding: 0;
            height: 100%;
            font-family: Arial, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            background: linear-gradient(to left, #ffffff 50%, #0d6efd 50%);
        }

        .container {
            display: flex;
            width: 100%;
            max-width: 1200px;
            height: 100%;
        }

        .left {
            width: 50%;
            height: 100%;
            display: flex;
            justify-content: center;
            align-items: center;
            position: relative;
            margin-right: 150px;
        }

        .form-container {
            background-color: #fff;
            padding: 40px;
            border-radius: 10px;
            width: 100%;
            max-width: 400px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .form-container h1 {
            margin: 0;
            font-size: 28px;
            font-weight: bold;
            text-align: center;
            margin-bottom: 20px;
        }

        .form-container p {
            text-align: center;
            color: #666;
            margin-bottom: 20px;
        }

        .form-container input[type="email"],
        .form-container input[type="password"] {
            width: calc(100% - 30px);
            padding: 15px;
            margin: 6px 0;
            margin-left: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
        }


        .form-container button {
            width: calc(100% - 30px);
            padding: 15px;
            background-color: #0d6efd;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            margin-top: 6px;
            margin-left: 20px;
            box-sizing: border-box;
        }

        .form-container button:hover {
            background-color: #0d6efd;
        }

        .right {
            width: 50%;
            height: 100%;
            display: flex;
            justify-content: center;
            align-items: center;
            position: relative;
            margin-left: 150px;
        }

        .left img {
            max-width: 80%;
            height: auto;
            border-radius: 10px;
        }
    </style>
</head>

<body>
    <div class="left">
        <div class="form-container">
            <h1>Login</h1>
            <p>Welcome to our page</p>
            <form method="post">
                <input type="email" name="email" placeholder="Email" required><br>
                <input type="password" name="password" placeholder="Password" required><br>
                <button type="submit" name="login">Login</button>
            </form>
        </div>
    </div>
    <div class="right">
        <img src="image/robotcute2.png" alt="Robot Cute">
    </div>
</body>

</html>