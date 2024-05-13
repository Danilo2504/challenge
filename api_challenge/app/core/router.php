<?php
class Router
{
  protected $router = [];
  protected $matchRouter = [];

  public function get(string $path, $handler)
  {
    $this->add('GET', $path, $handler);
  }

  public function post(string $path, $handler)
  {
    $this->add('POST', $path, $handler);
  }

  private function add(string $method, string $path, $handler)
  {
    $url = $_ENV['BASE_PATH'] . $path;
    $this->router[] = ['method' => $method, 'path' => $url, 'handler' => $handler];

    return $this;
  }

  private function getMatchRouterByMethod()
  {
    $method = $_SERVER['REQUEST_METHOD'];
    $url = $_SERVER['REQUEST_URI'];
    foreach ($this->router as $value) {
      if ($value['method'] === $method && $value['path'] === $url) {
        array_push($this->matchRouter, $value);
      }
    }
  }

  public function run()
  {
    $this->getMatchRouterByMethod();
    if (!$this->matchRouter || empty($this->matchRouter)) {
      http_response_code(400);
      echo json_encode('Signature Verification Exception');
    } else {
      if (is_callable($this->matchRouter[0]['handler']))
        call_user_func($this->matchRouter[0]['handler']);
      else
        $this->runController($this->matchRouter[0]['handler']);
    }
  }

  private function runController($controller)
  {
    $parts = explode('@', $controller);
    $file = __DIR__ . "/../controllers/" . $parts[0] . '.php';
    if (file_exists($file)) {
      require_once($file);
      $controller = ucfirst($parts[0]) . "Controller";

      if (class_exists($controller))
        $controller = new $controller();
    } else {
      http_response_code(400);
      echo json_encode('Signature Verification Exception');
    }
    if (isset($parts[1])) {
      $method = $parts[1];
      if (!method_exists($controller, $method)) {
        http_response_code(400);
        echo json_encode('Signature Verification Exception');
      }
    } else {
      $method = 'index';
    }
    if (is_callable([$controller, $method])) {
      return call_user_func([$controller, $method]);
    } else {
      http_response_code(400);
      echo json_encode('Signature Verification Exception');
    }
  }
}
