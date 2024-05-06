<?php
require_once __DIR__ . "/../core/model.php";

class ModelsProduct extends Model
{
 public function getAllProds()
 {
  $query = "SELECT * FROM products";
  $result = $this->db->query($query);
  if (!$result) {
   die("Invalid query " . $this->db->error);
  }
  return $result;
 }

 private function getLastId()
 {
  $sql = "SELECT MAX(id) as max_id FROM products";
  $result = $this->db->query($sql);
  $row = $result->fetch_assoc();
  return (int)$row['max_id'];
 }

 public function createProduct()
 {
  $max_id = $this->getLastId();
  $query = "INSERT INTO products VALUES ($max_id,'funda de celular', 10, 20)";
  $result = $this->db->query($query);
  if (!$result) {
   die("Invalid query " . $this->db->error);
  }
  return $result;
 }
}
