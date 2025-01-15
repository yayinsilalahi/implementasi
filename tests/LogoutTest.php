<?php

use PHPUnit\Framework\TestCase;

require_once __DIR__ . '/../src/logout2.php';

class LogoutTest extends TestCase
{
  public function testLogout()
  {
    $logout = new Logout();
    $logout->execute();

    // Verifikasi bahwa sesi dihancurkan
    $this->assertTrue($logout->isSessionDestroyed(), "Session should be destroyed");

    // Verifikasi bahwa header redirect benar
    $headers = $logout->getHeaders();
    $this->assertCount(1, $headers, "There should be one header set");
    $this->assertEquals('Location: login_form.php', $headers[0], "Header should redirect to login_form.php");
  }
}
