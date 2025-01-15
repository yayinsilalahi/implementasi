<?php

require_once 'koneksi.php';

class Login
{
    private $conn;

    public function __construct($dbConnection)
    {
        $this->conn = $dbConnection;
    }

    public function loginUser($email, $password)
    {
        // Cek apakah email ada di database
        $stmt = $this->conn->prepare("SELECT id, name, password FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->store_result();

        // Mendeklarasikan variabel untuk hasil binding
        $id = $name = $hashedPassword = null;

        if ($stmt->num_rows > 0) {
            // Binding hasil ke variabel
            $stmt->bind_result($id, $name, $hashedPassword);
            $stmt->fetch();

            // Cek jika password hash ditemukan
            if ($hashedPassword === null) {
                return "Password tidak ditemukan untuk email ini.";
            }

            // Verifikasi password
            if (password_verify($password, $hashedPassword)) {
                // Login berhasil, simpan session
                session_start();
                $_SESSION['user_id'] = $id;
                $_SESSION['user_name'] = $name;
                return "Login berhasil.";
            } else {
                return "Password salah.";
            }
        } else {
            return "Email tidak ditemukan.";
        }

        $stmt->close();
    }
}
