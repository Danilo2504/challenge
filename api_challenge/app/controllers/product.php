<?php
require_once  __DIR__ . "/../models/product.php";
class ProductController
{
 public function index()
 {
  $model = new ModelsProduct();
  $result = $model->getAllProds();
  $data = [];

  if ($result->num_rows > 0) {
   while ($row = $result->fetch_assoc()) {
    $data[] = $row;
   }
  }

  header('Content-Type: application/json');
  http_response_code(200);
  echo json_encode($data);
 }
 public function createProd()
 {
  $request_method = $_SERVER['REQUEST_METHOD'];
  if ($request_method === 'GET') {

   $model = new ModelsProduct();
   // $result = $model->createProduct();
   $model->createProduct();
   // $data = [];
   // if ($result->num_rows > 0) {
   //  while ($row = $result->fetch_assoc()) {
   //   $data[] = $row;
   //  }
   // }
   header('Content-Type: application/json');
   http_response_code(200);
   // echo json_encode($data);
  }
 }
}
