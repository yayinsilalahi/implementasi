<?php

use PHPUnit\Framework\TestCase;

require_once __DIR__ . '/../src/login.php';

class LoginTest extends TestCase
{
  private $conn;

  // Setup untuk koneksi database sebelum setiap tes
  protected function setUp(): void
  {
    $this->conn = new mysqli("localhost", "root", "", "evaluasi_implementasi"); // Ganti dengan konfigurasi database yang sesuai
    if ($this->conn->connect_error) {
      die("Connection failed: " . $this->conn->connect_error);
    }
  }

  // Cleanup setelah tes selesai
  protected function tearDown(): void
  {
    $this->conn->close();
  }

  // Test Login Berhasil
  public function testLoginBerhasil()
  {
    $login = new Login($this->conn);

    // Simulasi login dengan email dan password yang valid
    $email = 'yay@gmail.com'; // Ganti dengan data email yang valid dari database Anda
    $password = '252525'; // Ganti dengan password yang valid

    // Asumsikan hasil login sukses
    $result = $login->loginUser($email, $password);

    $this->assertEquals("Login berhasil.", $result);
  }

  // Test Login User Not Found
  public function testLoginUserNotFound()
  {
    $login = new Login($this->conn);

    // Simulasi login dengan email yang tidak terdaftar
    $email = 'nonexistent@example.com'; // Email yang tidak ada dalam database
    $password = 'password'; // Password yang tidak sesuai (tidak relevan karena user tidak ditemukan)

    // Harus mengembalikan pesan "Email tidak ditemukan."
    $result = $login->loginUser($email, $password);

    $this->assertEquals("Email tidak ditemukan.", $result);
  }

  // Test Login Password Wrong
  public function testLoginPasswordWrong()
  {
    $login = new Login($this->conn);

    // Simulasi login dengan email yang benar tetapi password salah
    $email = 'yay@gmail.com'; // Ganti dengan email yang terdaftar dalam database
    $password = '121212'; // Password yang salah

    // Harus mengembalikan pesan "Password salah."
    $result = $login->loginUser($email, $password);

    $this->assertEquals("Password salah.", $result);
  }
}
