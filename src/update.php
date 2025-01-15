<?php

require_once 'koneksi.php';

class Update
{
    private $conn;

    public function __construct($dbConnection)
    {
        $this->conn = $dbConnection;
    }

    public function getUserData($userId)
    {
        $stmt = $this->conn->prepare("SELECT name, password FROM users WHERE id = ?");
        $stmt->bind_param("i", $userId);
        $stmt->execute();

        // Deklarasi variabel sebelum bind_result
        $name = '';
        $hashedPassword = '';

        $stmt->bind_result($name, $hashedPassword);
        $stmt->fetch();
        $stmt->close();

        return ['name' => $name, 'password' => $hashedPassword];
    }

    public function updateUsername($userId, $newUsername)
    {
        // Cek apakah username baru tidak kosong
        if (empty($newUsername)) {
            return false; // Jangan update jika username kosong
        }

        $stmt = $this->conn->prepare("UPDATE users SET name = ? WHERE id = ?");
        $stmt->bind_param("si", $newUsername, $userId);
        $success = $stmt->execute();
        $stmt->close();

        return $success;
    }

    public function updatePassword($userId, $newPassword)
    {
        // Cek apakah password baru tidak kosong
        if (empty($newPassword)) {
            return false; // Jangan update jika password kosong
        }

        $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
        $stmt = $this->conn->prepare("UPDATE users SET password = ? WHERE id = ?");
        $stmt->bind_param("si", $hashedPassword, $userId);
        $success = $stmt->execute();
        $stmt->close();

        return $success;
    }
}
