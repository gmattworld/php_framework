<?php

namespace app\core;

class Router
{
    protected array $routes = [];
    public Request $request;
    public Response $response;
    public bool $isApi;

    public function __construct(Request $request, Response $response)
    {
        $this->request = $request;
        $this->response = $response;
    }

    public function get($path, $callback)
    {
        $this->routes['get'][$path] = $callback;
    }

    public function post($path, $callback)
    {
        $this->routes['post'][$path] = $callback;
    }

    public function put($path, $callback)
    {
        $this->routes['put'][$path] = $callback;
    }

    public function delete($path, $callback)
    {
        $this->routes['delete'][$path] = $callback;
    }

    public function resolve()
    {
        $path = $this->request->getPath();
        $method = $this->request->method();
        $this->isApi = $this->request->isApi($path);
        $callback = $this->routes[$method][$path] ?? false;
        if ($callback === false) {
            $this->response->setStatusCode(404);
            if ($this->isApi) {
                return json_encode(['code'=>404, 'message'=>'route not found']);
            }
            return $this->renderView('errors/_404');
        }

        if (is_string($callback)) {
            return $this->renderView($callback);
        }

        if (is_array($callback)) {
            Application::$app->controller = new $callback[0]();
            $callback[0] = Application::$app->controller;
        }

        return call_user_func($callback, $this->request);
    }

    public function renderView(string $view, array $params = [])
    {
        $layoutContent = $this->layoutContent();
        $viewContent = $this->renderOnlyView($view, $params);
        return str_replace('{{render}}', $viewContent, $layoutContent);
    }

    public function renderAPI($response)
    {
        return json_encode($response);
    }

    protected function layoutContent()
    {
        $layout = Application::$app->controller->layout;
        ob_start();
        include_once Application::$ROOT_DIR."/views/layouts/$layout.pat.php";
        return ob_get_clean();
    }

    protected function renderOnlyView(string $view, array $params)
    {
        foreach($params as $key => $value) $$key = $value;
        ob_start();
        include_once Application::$ROOT_DIR."/views/$view.pat.php";
        return ob_get_clean();
    }
}
