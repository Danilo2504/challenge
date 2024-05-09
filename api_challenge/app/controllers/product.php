<?php
require_once  __DIR__ . "/../models/product.php";
class ProductController
{
 public function index()
 {
  $model = new ModelsProduct();
  $result = $model->getAllProducts();

  http_response_code(200);
  echo json_encode($result);
 }

 public function createProd()
 {
  $request_method = $_SERVER['REQUEST_METHOD'];
  if ($request_method === 'POST') {
   $post_data = file_get_contents('php://input');
   $data = json_decode($post_data);
   $model = new ModelsProduct();
   $result = $model->createProduct($data);

   http_response_code(200);
   echo json_encode($result);
  }
 }
}
