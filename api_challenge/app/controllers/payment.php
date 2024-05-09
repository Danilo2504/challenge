<?php
require_once  __DIR__ . "/../models/payment.php";

class PaymentController
{
 public function index()
 {
  $model = new ModelsPayment();
  $result = $model->getAllPayments();

  http_response_code(200);
  echo json_encode($result);
 }
}
