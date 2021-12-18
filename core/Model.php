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
 * Class Model
 * @package engine\core
 */
abstract class Model
{
    /**
     * Конфигурации сайта
     * @var array
     */
    public array $config;

    /**
     * Model constructor
     */
    public function __construct()
    {
        $this->config = require 'content/config.php';
    }
}