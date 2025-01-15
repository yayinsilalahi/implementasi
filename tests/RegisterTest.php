<?php

use PHPUnit\Framework\TestCase;

require_once __DIR__ . '/../src/register.php';

class RegisterTest extends TestCase
{
  private $db;
  private $register;

  public function setUp(): void
  {
    // Membuat koneksi ke database untuk pengujian
    $this->db = new mysqli('localhost', 'root', '', 'evaluasi_implementasi');
    $this->register = new Register($this->db);
  }

  public function testRegisterBerhasil()
  {
    $message = $this->register->registerUser('John Doe', 'john.doe@example.com', 'password123', 'password123');
    $this->assertEquals("Pendaftaran berhasil.", $message);
  }

  public function testRegisterPasswordMismatch()
  {
    $message = $this->register->registerUser('John Doe', 'john.doe@example.com', 'password123', 'differentpassword');
    $this->assertEquals("Password tidak cocok.", $message);
  }

  public function testRegisterDuplikatEmail()
  {
    $this->register->registerUser('John Doe', 'john.doe@example.com', 'password123', 'password123');
    $message = $this->register->registerUser('Jane Doe', 'john.doe@example.com', 'password123', 'password123');
    $this->assertEquals("Email sudah terdaftar.", $message);
  }

  public function tearDown(): void
  {
    $this->db->query("DELETE FROM users WHERE email = 'john.doe@example.com'");
    $this->db->close();
  }
}
