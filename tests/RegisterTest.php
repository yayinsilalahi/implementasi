<?php

namespace Acer\Tests;

use PHPUnit\Framework\TestCase;

class RegisterTest extends TestCase
{
  private $dbConfig;

  protected function setUp(): void
  {
    // Konfigurasi database untuk testing
    $this->dbConfig = [
      'host' => 'localhost',
      'username' => 'root',
      'password' => '',
      'dbname' => 'evaluasi_implementasi_test', // gunakan database test
    ];

    // Koneksi awal untuk memastikan database test ada
    $tempConn = new \mysqli(
      $this->dbConfig['host'],
      $this->dbConfig['username'],
      $this->dbConfig['password']
    );

    if ($tempConn->connect_error) {
      $this->fail("Koneksi awal gagal: " . $tempConn->connect_error);
    }

    // Buat database untuk testing jika belum ada
    $tempConn->query("CREATE DATABASE IF NOT EXISTS " . $this->dbConfig['dbname']);
    $tempConn->close();
  }

  // Close the connection after each test
  protected function tearDown(): void
  {
    // Ensure the connection is closed
    if ($this->dbConfig) {
      $this->dbConfig->close();
    }
  }

  // Test case: Register success
  public function testRegisterSuccess()
  {
    $_POST['register'] = true;
    $_POST['name'] = 'John Doe';
    $_POST['email'] = 'johndoe@example.com';
    $_POST['password'] = 'password123';
    $_POST['confirm_password'] = 'password123';

    // Prepare the database interaction and insert data
    $stmt = $this->dbConfig->prepare("INSERT INTO users (name, email, password) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $_POST['name'], $_POST['email'], password_hash($_POST['password'], PASSWORD_DEFAULT));
    $stmt->execute();

    // Assert if the data was successfully inserted
    $this->assertTrue($stmt->affected_rows > 0);
  }

  // Test case: Register with empty data
  public function testRegisterEmptyData()
  {
    $_POST['register'] = true;
    $_POST['name'] = '';
    $_POST['email'] = '';
    $_POST['password'] = '';
    $_POST['confirm_password'] = '';

    // Start output buffering to capture the output from register.php
    ob_start();
    include '../src/register.php';  // Include register.php from the src folder
    $output = ob_get_clean(); // Get the output

    // Assert the output contains the expected error message for empty data
    $this->assertStringContainsString('Password tidak cocok.', $output);
    // $this->assertStringContainsString('Kesalahan: Email sudah terdaftar.', $output);
  }

  // Test case: Register with duplicate data
  public function testRegisterDuplicateData()
  {
    // Insert initial data
    $_POST['register'] = true;
    $_POST['name'] = 'John Doe';
    $_POST['email'] = 'johndoe@example.com';
    $_POST['password'] = 'password123';
    $_POST['confirm_password'] = 'password123';

    // Insert the first data row
    $stmt = $this->dbConfig->prepare("INSERT INTO users (name, email, password) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $_POST['name'], $_POST['email'], password_hash($_POST['password'], PASSWORD_DEFAULT));
    $stmt->execute();

    // Attempt to insert duplicate email
    $_POST['email'] = 'johndoe@example.com';  // Using the same email
    ob_start();
    include '../src/register.php';  // Include register.php from the src folder
    $output = ob_get_clean();

    // Assert the output contains the expected error message for duplicate email
    $this->assertStringContainsString('Kesalahan: Email sudah terdaftar.', $output);
  }
}
