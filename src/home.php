<?php

namespace Acer;

session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Welcome Page</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet" />
    <style>
        body {
            margin: 0;
            font-family: 'Arial', sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background-color: #ffffff;
        }

        .container {
            text-align: center;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .header {
            width: 100%;
            display: flex;
            justify-content: flex-end;
            padding: 10px;
            box-sizing: border-box;
        }

        .header i {
            margin-left: 10px;
            font-size: 24px;
            color: #007bff;
        }

        .content {
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .text {
            text-align: left;
            margin-right: 20px;
        }

        .text h1 {
            font-size: 48px;
            margin: 0;
            font-family: 'Arial Black', sans-serif;
        }

        .text p {
            font-size: 24px;
            margin: 0;
            font-family: 'Arial', sans-serif;
        }

        .image {
            max-width: 100%;
            height: auto;
        }

        @media (max-width: 768px) {
            .content {
                flex-direction: column;
            }

            .text {
                margin-right: 0;
                margin-bottom: 20px;
            }
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="header">
            <a href="update.php">
                <i class="fas fa-cog"></i>
            </a>
            <a href="logout.php">
                <i class="fas fa-sign-out-alt"></i>
            </a>
        </div>
        <div class="content">
            <div class="text">
                <h1>SELAMAT DATANG,</h1>
                <p><?php echo htmlspecialchars($_SESSION['user_name']); ?>!</p>
            </div>
            <img src="/implementasi/gambar/gambar1.png" alt="Gambar 1">
        </div>
    </div>
</body>

</html>