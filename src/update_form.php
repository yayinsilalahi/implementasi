<?php
require_once 'update.php';
session_start();

if (!isset($_SESSION['user_id'])) {
  header('Location: login.php');
  exit;
}

$userId = $_SESSION['user_id'];
$updateHandler = new Update($conn);
$userData = $updateHandler->getUserData($userId);

// Handle form submissions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  if (isset($_POST['update_username'])) {
    $newUsername = $_POST['new_username'];
    if ($updateHandler->updateUsername($userId, $newUsername)) {
      $_SESSION['user_name'] = $newUsername;
      header('Location: update_form.php');
      exit;
    } else {
      $error = "Gagal memperbarui username.";
    }
  }

  if (isset($_POST['update_password'])) {
    $newPassword = $_POST['new_password'];
    if ($updateHandler->updatePassword($userId, $newPassword)) {
      header('Location: update_form.php');
      exit;
    } else {
      $error = "Gagal memperbarui password.";
    }
  }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Pengaturan Akun</title>
  <link href="https://fonts.googleapis.com/css2?family=Akshar&display=swap" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet" />
  <style>
    body {
      margin: 0;
      font-family: 'Akshar', sans-serif;
      height: 100vh;
      display: flex;
      background-color: #0D6EFD;
    }

    .container {
      flex: 1;
      display: flex;
      flex-direction: row;
      justify-content: center;
      align-items: center;
    }

    .left-section {
      width: 50%;
      margin-left: -130px;
      height: 100vh;
      background-color: white;
      display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: center;
    }

    .left-section h1 {
      color: #0D6EFD;
      font-size: 48px;
      margin: 0;
    }

    .left-section button {
      background-color: #0D6EFD;
      color: white;
      border: none;
      border-radius: 20px;
      padding: 10px 20px;
      font-size: 18px;
      cursor: pointer;
      margin-top: 10px;
    }

    .left-section img {
      width: 380px;
      margin-top: 70px;
    }

    .left-section a {
      text-decoration: none;
    }

    .left-section i {
      color: red;
      font-size: 20px;
      margin-top: 80px;
      display: flex;
      align-items: center;
      cursor: pointer;
    }

    .right-section {
      flex: 1;
      background-color: #0D6EFD;
      display: flex;
      flex-direction: column;
      padding: 20px;
      border-radius: 10px;
      border: 2px solid;
      border-color: white;
      width: 500px;
      height: 80vh;
      margin-left: 200px;
      justify-content: center;
    }

    .right-section label {
      color: white;
      font-size: 18px;
      margin-bottom: 5px;
    }

    .right-section .input-group {
      display: flex;
      flex-direction: column;
      margin-bottom: 20px;
      position: relative;
    }

    .right-section .input-group input {
      border: none;
      border-radius: 30px;
      padding: 10px 20px;
      font-size: 18px;
      width: 100%;
      margin-bottom: 10px;
    }

    .right-section .input-group button {
      align-self: flex-end;
      background-color: #0056b3;
      color: white;
      border: none;
      border-radius: 20px;
      padding: 10px 20px;
      font-size: 18px;
      cursor: pointer;
    }

    .right-section .input-group .fa-eye {
      position: absolute;
      right: 20px;
      top: 40%;
      transform: translateY(-50%);
      cursor: pointer;
      color: #000;
    }
  </style>
</head>

<body>
  <div class="container">
    <div class="left-section">
      <h1>Setting</h1>
      <img src="/implementasi/gambar/robot.png" alt="Robot">
      <a href="logout.php">
        <i class="fas fa-sign-out-alt"></i>
      </a>
    </div>
    <div class="right-section">
      <div class="input-group">
        <label for="username">Username</label>
        <input type="text" id="user_id" name="name" value="<?= htmlspecialchars($userData['name']); ?>" readonly style="border-radius: 15px;">
        <button data-bs-toggle="modal" data-bs-target="#usernameModal">Ubah Username</button>
      </div>
      <div class="input-group">
        <label for="password">Password</label>
        <input type="password" id="password" value="******" readonly style="border-radius: 15px;">
        <i class="fa fa-eye" id="eye-icon"></i>
        <button data-bs-toggle="modal" data-bs-target="#passwordModal">Ubah Password</button>

      </div>
    </div>
  </div>

  <!-- Modal untuk Mengubah Username -->
  <div class="modal fade" id="usernameModal" tabindex="-1" aria-labelledby="usernameModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <form method="post" action="update_form.php">
        <div class="modal-content" style="border-radius: 20px; overflow: hidden;">
          <div class="modal-header" style="background: linear-gradient(45deg, #6a11cb, #2575fc); color: white;">
            <h5 class="modal-title" id="usernameModalLabel">
              <i class="fas fa-user-edit"></i> Ubah Nama Pengguna
            </h5>
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body" style="padding: 30px; background-color: #f8f9fa;">
            <div class="input-group">
              <label for="new-username" class="form-label" style="font-weight: bold;">Nama Pengguna Baru</label>
              <input type="text" id="new-username" name="new_username" class="form-control" placeholder="Masukkan nama pengguna baru" required>
            </div>
          </div>
          <div class="modal-footer" style="background-color: #f1f1f1;">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
            <button type="submit" class="btn btn-primary" name="update_username" style="background: linear-gradient(45deg, #6a11cb, #2575fc); border: none;">Simpan Perubahan</button>
          </div>
        </div>
      </form>
    </div>
  </div>

  <!-- Modal untuk Mengubah Password -->
  <div class="modal fade" id="passwordModal" tabindex="-1" aria-labelledby="passwordModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <form method="post" action="update_form.php">
        <div class="modal-content" style="border-radius: 20px; overflow: hidden;">
          <div class="modal-header" style="background: linear-gradient(45deg, #ff512f, #dd2476); color: white;">
            <h5 class="modal-title" id="passwordModalLabel">
              <i class="fas fa-lock"></i> Ubah Password
            </h5>
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body" style="padding: 30px; background-color: #f8f9fa;">
            <div class="input-group">
              <label for="new-password" class="form-label" style="font-weight: bold;">Password Baru</label>
              <input type="password" id="new-password" name="new_password" class="form-control" placeholder="Masukkan password baru" required>
            </div>
          </div>
          <div class="modal-footer" style="background-color: #f1f1f1;">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
            <button type="submit" class="btn btn-danger" name="update_password" style="background: linear-gradient(45deg, #ff512f, #dd2476); border: none;">Simpan Perubahan</button>
          </div>
        </div>
      </form>
    </div>
  </div>
  <!-- Script Toggle Visibility Password -->
  <script>
    const passwordField = document.getElementById('password');
    const eyeIcon = document.getElementById('eye-icon');

    eyeIcon.addEventListener('click', function() {
      if (passwordField.type === 'password') {
        passwordField.type = 'text';
        eyeIcon.classList.remove('fa-eye');
        eyeIcon.classList.add('fa-eye-slash');
      } else {
        passwordField.type = 'password';
        eyeIcon.classList.remove('fa-eye-slash');
        eyeIcon.classList.add('fa-eye');
      }
    });
  </script>


  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>