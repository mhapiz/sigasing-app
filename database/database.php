<?php
class Database
{
  private $host;
  private $db_name;
  private $username;
  private $password;
  public $conn;

  function __construct()
  {
    $this->host = 'localhost';
    $this->username = 'root';
    $this->password = '123';
    $this->db_name = 'praktikum_db';
  }

  // get the database connection
  public function getConnection()
  {
    $this->conn = null;

    try {
      $dsn = 'mysql:dbname=' . $this->db_name . ';host=' . $this->host;
      $this->conn = new PDO($dsn, $this->username, $this->password);

      $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (PDOException $exc) {
      echo "Connection Error" . $exc->getMessage();
    }
    return $this->conn;
  }
}
