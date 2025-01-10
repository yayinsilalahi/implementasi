<?php
// Koneksi ke server MySQL
// $server_conn = new mysqli($host, $username, $password);
// if ($server_conn->connect_error) {
//     die("Koneksi ke server gagal: " . $server_conn->connect_error);
// }

// // Membuat database jika belum ada
// $server_conn->query("CREATE DATABASE IF NOT EXISTS $dbname");
// $server_conn->close();

// Koneksi ke database
$host = 'localhost';
$username = 'root';
$password = '';
$dbname = 'evaluasi_implementasi';
$conn = new mysqli($host, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Buat tabel pengguna jika belum ada
$sql = "CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(50) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL
)";
$conn->query($sql);
?>