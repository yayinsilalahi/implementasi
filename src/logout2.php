<?php

class Logout
{
  private $headers = [];
  private $sessionDestroyed = false;

  public function execute(): void
  {
    session_start();
    session_unset();
    session_destroy();
    $this->sessionDestroyed = true; // Tandai sesi dihancurkan

    $this->headers[] = 'Location: login_form.php'; // Header redirect
  }

  public function getHeaders(): array
  {
    return $this->headers;
  }

  public function isSessionDestroyed(): bool
  {
    return $this->sessionDestroyed; // Beri akses ke status sesi
  }
}
