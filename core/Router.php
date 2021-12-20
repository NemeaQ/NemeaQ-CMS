<?php
/*
=====================================================
 NemeaQ-CMS - by NemeaQ
-----------------------------------------------------
 https://hanriel.ru/
-----------------------------------------------------
 Copyright (c) 2021 NemeaQ
=====================================================
*/

namespace engine\core;

defined('_USE_NQ_CMS') or die('Direct Access to this location is not allowed.');

/**
 * Class Router
 * @package engine\core
 */
class Router
{
    /**
     * Путь Контроллера
     * @var array
     */
    protected array $routes = [];
    /**
     * Controller и Action
     * @var array
     */
    protected array $params = [];

    /**
     * Router constructor.
     */
    public function __construct()
    {
        foreach (glob('content/controllers/*.php') as $file) {
            require_once $file;
            $class = basename($file, '.php');
            if (class_exists('content\controllers\\'.$class)) {
                $obj = new ('content\controllers\\'.$class)();
                $this->addRoutes($obj->routes);
            }
        }
    }

    private function addRoutes($routes)
    {
        foreach ($routes as $key => $route) {
            $this->addRoute($key, $route);
        }
    }

    /**
     * @param $route
     * @param $params
     */
    public function addRoute($route, $params)
    {
        $route = preg_replace('/{([a-z]+):([^\}]+)}/', '(?P<\1>\2)', $route);
        $route = '#^' . $route . '$#';
        $this->routes[$route] = $params;
    }

    /**
     * @return bool
     */
    public function match()
    {
        $url = trim($_SERVER['REQUEST_URI'], '/');
        foreach ($this->routes as $route => $params) {
            if (preg_match($route, $url, $matches)) {
                foreach ($matches as $key => $match) {
                    if (is_string($key)) {
                        if (is_numeric($match)) {
                            $match = (int)$match;
                        }
                        $params[$key] = $match;
                    }
                }
                $this->params = $params;
                return true;
            }
        }
        return false;
    }

    /**
     *
     */
    public function run()
    {
        if ($this->match()) {
            $path = 'content\controllers\\' . ucfirst($this->params[0]) . 'Controller';
            if (class_exists($path)) {
                $action = $this->params[1] . 'Action';
                if (method_exists($path, $action)) {
                    $controller = new $path();
                    $controller->load($this->params);
                    $controller->$action();
                } else {
                    View::errorCode(404);
                }
            } else {
                View::errorCode(404);
            }
        } else {
            View::errorCode(404);
        }
    }

}