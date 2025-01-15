<?php

require_once 'koneksi.php';

class Register
{
    private $conn;

    public function __construct($dbConnection)
    {
        $this->conn = $dbConnection;
    }

    public function registerUser($name, $email, $password, $confirmPassword)
    {
        // Validasi password
        if ($password !== $confirmPassword) {
            return "Password tidak cocok.";
        }

        // Cek apakah email sudah terdaftar
        $stmt = $this->conn->prepare("SELECT id FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            return "Email sudah terdaftar.";
        }

        // Enkripsi password
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        // Insert data pengguna
        $stmt = $this->conn->prepare("INSERT INTO users (name, email, password) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $name, $email, $hashedPassword);

        if ($stmt->execute()) {
            return "Pendaftaran berhasil.";
        } else {
            return "Terjadi kesalahan, coba lagi.";
        }
    }
}
