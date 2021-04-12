<?php

namespace app\core;

class Router
{
    protected array $routes = [];
    public Request $request;

    public function get($path, $callback)
    {
        $this->routes['get'][$path] = $callback;
    }

    public function resolve()
    {
        $path = Application::$app->request->getPath();
        $method = Application::$app->request->getMethod();
        $callback = $this->routes[$method][$path] ?? false;

        if ($callback === false) {
            Application::$app->response->setStatusCode(404);
            return 'Not found';
        }

        if (is_string($callback)) {
            return $this->renderView($callback);
        }

        return call_user_func($callback);
    }

    public function renderView($view){
        $layoutContent = $this->layoutContent('main');
        $viewContent = $this->renderOnlyView($view);
        return str_replace('{{content}}', $viewContent, $layoutContent);
    }

    protected function layoutContent(string $layout)
    {
        ob_start();
        include_once Application::$ROOT_DIR."/views/layouts/$layout.pat.php";
        return ob_get_clean();
    }

    protected function renderOnlyView(string $view){
        ob_start();
        include_once Application::$ROOT_DIR."/views/$view.pat.php";
        return ob_get_clean();
    }
}