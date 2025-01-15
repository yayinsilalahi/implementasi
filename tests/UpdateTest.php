<?php

use PHPUnit\Framework\TestCase;

require_once __DIR__ . '/../src/update.php';

class UpdateTest extends TestCase
{
  private $dbConnection;
  private $updateHandler;
  private $userId;

  protected function setUp(): void
  {
    // Simulasi koneksi database menggunakan MySQLi untuk testing
    $this->dbConnection = new mysqli('localhost', 'root', '', 'evaluasi_implementasi');
    $this->updateHandler = new Update($this->dbConnection);
    $this->userId = 13; // ID pengguna yang akan diuji
  }

  // Test case: Update Profile (berhasil)
  public function testUpdateProfileSuccess()
  {
    $newUsername = 'user';
    $result = $this->updateHandler->updateUsername($this->userId, $newUsername);
    $this->assertTrue($result, "Username update failed");

    // Verifikasi bahwa username telah berubah
    $userData = $this->updateHandler->getUserData($this->userId);
    $this->assertEquals($newUsername, $userData['name'], "Username was not updated correctly");
  }

  // Test case: Update Profile with empty data
  public function testUpdateProfileEmpty()
  {
    $newUsername = ''; // Mengirimkan username kosong
    $result = $this->updateHandler->updateUsername($this->userId, $newUsername);
    $this->assertFalse($result, "Username update should fail with empty value");

    // Verifikasi bahwa username tetap tidak berubah
    $userData = $this->updateHandler->getUserData($this->userId);
    $this->assertNotEquals($newUsername, $userData['name'], "Username should not be updated with empty value");
  }

  // Test case: Update Profile (berhasil) password
  public function testUpdatePasswordSuccess()
  {
    $newPassword = '212121';
    $result = $this->updateHandler->updatePassword($this->userId, $newPassword);
    $this->assertTrue($result, "Password update failed");

    // Verifikasi bahwa password telah berubah
    $userData = $this->updateHandler->getUserData($this->userId);
    $this->assertTrue(password_verify($newPassword, $userData['password']), "Password was not updated correctly");
  }

  // Test case: Update Profile with empty password
  public function testUpdatePasswordEmpty()
  {
    $newPassword = ''; // Mengirimkan password kosong
    $result = $this->updateHandler->updatePassword($this->userId, $newPassword);
    $this->assertFalse($result, "Password update should fail with empty value");

    // Verifikasi bahwa password tetap tidak berubah
    $userData = $this->updateHandler->getUserData($this->userId);
    $this->assertNotEquals($newPassword, $userData['password'], "Password should not be updated with empty value");
  }

  protected function tearDown(): void
  {
    $this->dbConnection->close();
  }
}
