<?php

// Memanggil file PHP yang mengandung logika register
require_once 'Register.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  // Mengambil data dari form
  $name = $_POST['name'];
  $email = $_POST['email'];
  $password = $_POST['password'];
  $confirmPassword = $_POST['confirm_password'];

  // Membuat koneksi
  $conn = new mysqli('localhost', 'root', '', 'evaluasi_implementasi');

  if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
  }

  // Membuat objek Register dan memanggil metode registerUser
  $register = new Register($conn);
  $message = $register->registerUser($name, $email, $password, $confirmPassword);

  // Menampilkan pesan hasil
  echo "<script>alert('$message');</script>";

  // Jika pendaftaran berhasil, arahkan ke login.php
  if ($message == "Pendaftaran berhasil.") {
    header("Location: login_form.php"); // Redirect ke halaman login
    exit(); // Pastikan script berhenti setelah redirect
  }

  // Menutup koneksi
  $conn->close();
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet" />
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
      background: linear-gradient(to right, #ffffff 50%, #0d6efd 50%);
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

    .right {
      width: 50%;
      height: 100%;
      display: flex;
      justify-content: center;
      align-items: center;
      position: relative;
      margin-left: 150px;
    }

    .form-container {
      background-color: #fff;
      padding: 40px;
      border-radius: 10px;
      width: 100%;
      max-width: 400px;
      box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
      box-sizing: border-box;
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

    .form-container input[type="text"],
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

    .form-container .register-link {
      text-align: center;
      margin-top: 10px;
      font-size: 14px;
    }

    .form-container .register-link a {
      color: #0d6efd;
      text-decoration: none;
    }

    .form-container .register-link a:hover {
      text-decoration: underline;
    }

    .left img {
      max-width: 100%;
      height: auto;
      border-radius: 10px;
    }
  </style>
</head>

<body>
  <div class="left">
    <img src="/implementasi/gambar/robotcute1.png" alt="">
  </div>

  <div class="right">
    <div class="form-container">
      <h1>Pendaftaran</h1>
      <p>Create a new account</p>
      <form method="POST" action="">
        <input type="text" name="name" placeholder="Nama" required><br>
        <input type="email" name="email" placeholder="Email" required><br>
        <input type="password" name="password" placeholder="Password" required><br>
        <input type="password" name="confirm_password" placeholder="Konfirmasi Password" required><br>
        <button type="submit" name="register">Daftar</button>
      </form>
      <div class="register-link">
        <a href="/implementasi/src/login.php">Sudah Punya Akun? Login Sekarang</a>
      </div>
    </div>
  </div>
</body>

</html>