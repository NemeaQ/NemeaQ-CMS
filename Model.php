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

namespace app\core;

/**
 * Class Model
 * @package app\core
 */
abstract class Model
{
    /**
     * Конфигурации сайта
     * @var array|mixed
     */
    public $config;

    /**
     * Model constructor
     */
    public function __construct()
    {
        $this->config = require 'app/config.php';
    }
}