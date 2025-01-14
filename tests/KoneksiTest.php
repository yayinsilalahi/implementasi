<?php

use PHPUnit\Framework\TestCase;

class KoneksiTest extends TestCase
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
    $tempConn = new mysqli(
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

  public function testDatabaseConnection()
  {
    // Buat koneksi ke database test
    $conn = new mysqli(
      $this->dbConfig['host'],
      $this->dbConfig['username'],
      $this->dbConfig['password'],
      $this->dbConfig['dbname']
    );

    // Debugging output
    if ($conn->connect_error) {
      echo "Debugging Error: " . $conn->connect_error . "\n";
    } else {
      echo "Koneksi berhasil ke database " . $this->dbConfig['dbname'] . "\n";
    }

    // Tambahkan debugging untuk atribut penting
    echo "Host: " . $this->dbConfig['host'] . "\n";
    echo "Username: " . $this->dbConfig['username'] . "\n";
    echo "Database: " . $this->dbConfig['dbname'] . "\n";

    // Assertion untuk memeriksa koneksi
    $this->assertTrue($conn->ping(), "Koneksi gagal: Server MySQL tidak merespons.");
    $conn->close();
  }

  public function testTableCreation()
  {
    // Koneksi ke database
    $conn = new mysqli(
      $this->dbConfig['host'],
      $this->dbConfig['username'],
      $this->dbConfig['password'],
      $this->dbConfig['dbname']
    );

    // Jalankan script dari koneksi.php untuk membuat tabel
    $sql = "CREATE TABLE IF NOT EXISTS users (
            id INT AUTO_INCREMENT PRIMARY KEY,
            name VARCHAR(50) NOT NULL,
            email VARCHAR(100) NOT NULL UNIQUE,
            password VARCHAR(255) NOT NULL
        )";
    $result = $conn->query($sql);

    // Pastikan tabel berhasil dibuat
    $this->assertTrue($result, "Pembuatan tabel gagal");

    // Pastikan tabel 'users' ada di database
    $checkTable = $conn->query("SHOW TABLES LIKE 'users'");
    $this->assertEquals(1, $checkTable->num_rows, "Tabel 'users' tidak ditemukan setelah pembuatan.");

    // Tutup koneksi
    $conn->close();
  }

  protected function tearDown(): void
  {
    // Hapus database testing setelah pengujian selesai
    $conn = new mysqli(
      $this->dbConfig['host'],
      $this->dbConfig['username'],
      $this->dbConfig['password']
    );
    $conn->query("DROP DATABASE IF EXISTS " . $this->dbConfig['dbname']);
    $conn->close();
  }
}
