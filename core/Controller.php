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

use engine\core\View;

/**
 * Class Controller
 * @package app\core
 * @author Hanriel
 */
abstract class Controller
{

    public $route;
    public $view;
    public $acl;
    /**
     * Конфигурации сайта
     * @var array|mixed
     */
    public $config;

    /**
     * Controller constructor.
     * @param $route
     */
    public function __construct($route)
    {
        $this->config = require 'app/config.php';
        $this->route = $route;
        if (!$this->checkAcl()) {
            View::errorCode(403);
        }
        $this->view = new View($route);
        $this->model = $this->loadModel($route[0]);
    }

    /**
     * @param $name 'Имя модели'
     * @return Model
     */
    public function loadModel($name)
    {
        $path = 'app\models\\' . ucfirst($name);
        if (class_exists($path)) {
            return new $path;
        }
        return null;
    }

    /**
     * Cписок контроля доступа
     * @return bool
     */
    public function checkAcl()
    {
        return (
            $this->isAcl('all') ||
            isset($_SESSION['account']['id']) && $this->isAcl('authorize') ||
            !isset($_SESSION['account']['id']) && $this->isAcl('guest') ||
            isset($_SESSION['admin']) && $this->isAcl('admin')
        );
    }

    /**
     * Cписок контроля доступа
     * @param $key
     * @return bool
     */
    public function isAcl($key)
    {
        return in_array($this->route[1], $this->acl[$key]);
    }

}