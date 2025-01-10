<?php
    include 'koneksi.php';

    // Update Profil
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_profile'])) {
    session_start();
    $id = $_SESSION['user_id'];
    $name = $_POST['name'];
    $password = $_POST['password'];

    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    $stmt = $conn->prepare("UPDATE users SET name = ?, password = ? WHERE id = ?");
    $stmt->bind_param("ssi", $name, $hashed_password, $id);
    if ($stmt->execute()) {
        header('Location: home.php');
    } else {
        echo "Kesalahan: " . $stmt->error;
    }
    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h1>Update Profil</h1>
    <form method="post">
        <input type="text" name="name" placeholder="Nama Baru" required><br>
        <input type="password" name="password" placeholder="Password Baru" required><br>
        <button type="submit" name="update_profile">Update</button>
    </form>
</body>
</html>