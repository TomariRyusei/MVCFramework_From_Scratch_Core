<?php

namespace app\core;

use app\core\exeption\NotFoundException;

class Router
{
    public Request $requset;
    public Response $response;
    protected array $routes = [];

    public function __construct(Request $request, Response $response)
    {
        $this->requset = $request;
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

    public function resolve()
    {
        $path = $this->requset->getPath();
        $method = $this->requset->method();
        $callback = $this->routes[$method][$path] ?? false;
        if($callback === false) {
            throw new NotFoundException();
        }

        if(is_string($callback)){
            return Application::$app->view->renderView($callback);
        }

        if(is_array($callback)) {
            /** @var \app\core\Controller $controller */
            $controller = new $callback[0]();
            $controller->action = $callback[1];
            Application::$app->controller = $controller;

            // ミドルウェア実行
            $middlewares = $controller->getMiddlewares();
            foreach ($middlewares as $middleware) {
                $middleware->execute();
            }

            $callback[0] = $controller;
        }

        return call_user_func($callback, $this->requset, $this->response);
    }

    public function renderView($view, $params = [])
    {
        return Application::$app->view->renderView($view, $params);
    }

    // protected function layoutContent()
    // {
    //     // return Application::$app->view->layoutContent();
    // }

    // protected function renderOnlyView($view, $params)
    // {
    //     foreach($params as $key => $value){
    //         $$key = $value;
    //     }

    //     ob_start();
    //     include_once Application::$ROOT_DIR."/views/$view.php";
    //     return ob_get_clean();
    // }
}