// home.php
<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
</head>
<body>
    <h1>Selamat datang, <?php echo htmlspecialchars($_SESSION['user_name']); ?>!</h1>
    <!-- <form method="post" action="update_profile.php">
        <button type="submit">Edit Profil</button>
    </form> -->

    <a href="/implementasi/update.php"> Edit Profil </a>
    <br>
    <form method="post" action="logout.php">
        <button type="submit">Logout</button>
    </form>
</body>
</html>