<?php
require_once __DIR__ . "/../core/model.php";

class ModelsProduct extends Model
{
 public function getAllProducts()
 {
  $query = "SELECT * FROM products";
  $response = $this->db->query($query);
  if (!$response) {
   die("Invalid query " . $this->db->error);
  }
  $result = $response->fetch_all(MYSQLI_ASSOC);
  $this->db->close();
  return $result;
 }

 private function getLastId()
 {
  $sql = "SELECT MAX(id) as max_id FROM products";
  $response = $this->db->query($sql);

  if (!$response) {
   die("Invalid query " . $this->db->error);
  }

  $result = $response->fetch_assoc();
  $last_id = $result['max_id'];
  return (int)$last_id;
 }

 public function getProduct($id)
 {
  $query = $this->db->prepare("SELECT * FROM products WHERE id=?");
  $query->bind_param('i', $id);

  if (!$query->execute()) {
   die("Invalid query " . $this->db->error);
  }

  $result = $query->get_result()->fetch_assoc();
  $query->close();
  return $result;
 }

 public function createProduct($product)
 {
  $max_id = $this->getLastId() + 1;
  $data = [
   "name" => $product->name,
   "price" => (int)$product->price,
   "stock" => (int)$product->stock,
  ];

  $query = $this->db->prepare("INSERT INTO products (id, name, price, stock) VALUES (?, ?, ?, ?)");

  $query->bind_param('isii', $max_id, $data["name"], $data["price"], $data["stock"]);

  if (!$query->execute()) {
   die("Invalid query " . $this->db->error);
  }
  $query->close();
  return true;
 }
}
