<?php
require_once __DIR__ . "/../core/model.php";

class ModelsPayment extends Model
{
 public function createPayment($payload)
 {
  $query = $this->db->prepare("INSERT INTO payments (id, buy_date, payment_method, amount, payment_status) VALUES (?, ?, ?, ?, ?)");

  $query->bind_param('sssis', $payload['id'], $payload["buy_date"], $payload['payment_method'], $payload['amount'], $payload['payment_status']);

  if (!$query->execute()) {
   die("Invalid query " . $this->db->error);
  }
  $query->close();
  return true;
 }

 public function getAllPayments()
 {
  $query = "SELECT * FROM payments";

  $response = $this->db->query($query);
  if (!$response) {
   die("Invalid query " . $this->db->error);
  }
  $result = $response->fetch_all(MYSQLI_ASSOC);
  $this->db->close();
  return $result;
 }
}
