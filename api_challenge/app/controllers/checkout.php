<?php
require_once  __DIR__ . "/../models/checkout.php";

class CheckoutController
{
 public function index()
 {
  $model = new ModelsCheckout();
  $result = $model->getAllCheckouts();

  http_response_code(200);
  echo json_encode($result);
 }
}
