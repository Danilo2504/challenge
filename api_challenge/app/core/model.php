<?php
class Model
{
 public $db;

 public function __construct()
 {
  $this->db = $this->createConnection();
 }

 private function createConnection()
 {
  $connection = new mysqli(
   DATABASE['ServerName'],
   DATABASE['UserName'],
   DATABASE['Password'],
   DATABASE['DataBase']
  );

  if ($connection->connect_error) {
   die("Connection failed: " . $connection->connect_error);
  }

  return $connection;
 }
}
