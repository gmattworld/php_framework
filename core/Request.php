<?php

  namespace app\core;

  class  Request {
    public function getPath()
    {
        //$path = $_SERVER['REQUEST_URI'] ?? '/';
      $path = $_SERVER['PATH_INFO'] ?? '/';
      $position = strpos($path, '?');
      if($position === false){
        return $path;
      }
      return substr($path, 0, $position);
    }

    public function getFullPath()
    {
      //$path = $_SERVER['REQUEST_URI'] ?? '/';
      return $_SERVER['REQUEST_SCHEME'].'://'.$_SERVER['HTTP_HOST'].$this->getPath();
    }

    public function method()
    {
      return strtolower($_SERVER['REQUEST_METHOD']);
    }

    public function isApi($path)
    {
        return strpos($path, '/api') !== false;
    }

    public function isGet()
    {
      return $this->method() === 'get';
    }

    public function isPost()
    {
      return $this->method() === 'post';
    }

    public function isPut()
    {
      return $this->method() === 'put';
    }

    public function isDelete()
    {
      return $this->method() === 'delete';
    }

    public function getBody(){
        $body = [];

        if ($this->method() === 'get'){
            foreach ($_GET as $key => $value) {
                $body[$key] = filter_input(INPUT_GET, $key, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            }
        }

        if ($this->method() === 'post' || $this->method() === 'put'){
            if(Application::$app->router->isApi){
                $json = file_get_contents('php://input');
                $body = json_decode($json);
            } else {
                foreach ($_POST as $key => $value) {
                    $body[$key] = filter_input(INPUT_POST, $key, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
                }
            }
        }
        return $body;
    }
  }