<?php

class db
{
  private $conn;

  /**
   * Class constructor.
   */
  public function __construct()
  {
    $this->conn = new mysqli('localhost', 'root', '', 'php-auth');
  }

  public function get_conn()
  {
    return $this->conn;
  }
}