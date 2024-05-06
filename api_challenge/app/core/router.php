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

  private function getMatchRouterByMethod()
  {
    $method = $_SERVER['REQUEST_METHOD'];
    $request_uri =  parse_url($_SERVER['REQUEST_URI']);
    $url = str_replace('api_challenge/', '', $request_uri['path']);
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
      http_response_code(404);
      echo "404 Not Found";
    } else {
      if (is_callable($this->matchRouter[0]['handler']))
        call_user_func($this->matchRouter[0]['handler']);
      else
        $this->runController($this->matchRouter[0]['handler']);
    }
  }

  private function add(string $method, string $path, $handler)
  {
    $this->router[] = ['method' => $method, 'path' => $path, 'handler' => $handler];

    return $this;
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
      http_response_code(404);
      echo "404 Not Found";
    }
    if (isset($parts[1])) {
      $method = $parts[1];
      if (!method_exists($controller, $method)) {
        http_response_code(404);
        echo "404 Not Found";
      }
    } else {
      $method = 'index';
    }
    if (is_callable([$controller, $method])) {
      return call_user_func([$controller, $method]);
    } else {
      http_response_code(404);
      echo "404 Not Found";
    }
  }
}