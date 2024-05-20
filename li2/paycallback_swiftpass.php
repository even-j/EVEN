<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
set_time_limit(0);
define('SCRIPT_START_TIME', microtime());
header("Content-Type: text/html; charset=utf-8");
date_default_timezone_set('Asia/Shanghai');
error_reporting(E_ERROR);
$_GET['app'] = 'pay';
$_GET['mod'] = 'swiftpass';
$_GET['ac'] = 'notify';
define('SITEROOT', dirname(__FILE__) . DIRECTORY_SEPARATOR);
define('APP_PATH', SITEROOT . 'apps' . DIRECTORY_SEPARATOR);
define('PUBLIC_PATH', SITEROOT . 'public' . DIRECTORY_SEPARATOR);
define('PLUGIN', SITEROOT . 'Plugin' . DIRECTORY_SEPARATOR);
require_once SITEROOT . 'App.php';
\core\FontController::getInstance()->rout();
