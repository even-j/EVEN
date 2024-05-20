<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
//ini_set("display_errors", "On");
//error_reporting(E_ALL | E_STRICT);
//require_once('360_safe3.php');
/*if ($_SERVER["SERVER_NAME"] =="hypz.cn" || $_SERVER["SERVER_NAME"] =="www.hypz.cn" )
{ 
if ($_SERVER["HTTPS"] <> "on")
{
    $xredir="https://".$_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
    header("Location: ".$xredir);
}
}*/

define('SCRIPT_START_TIME', microtime());
header("Content-Type: text/html; charset=utf-8");
date_default_timezone_set('Asia/Shanghai');
error_reporting(E_ALL);
define('SITEROOT', dirname(__FILE__).DIRECTORY_SEPARATOR);
define('APP_PATH', SITEROOT.'apps'.DIRECTORY_SEPARATOR);
define('PUBLIC_PATH', SITEROOT.'public'.DIRECTORY_SEPARATOR);
define('PLUGIN', SITEROOT.'Plugin'.DIRECTORY_SEPARATOR);
require_once SITEROOT.'App.php';

$site_base = \Model\Admin\Params::get ( 'site_base' );
define('DOMAIN', $site_base['site_url']);
define('SITE_NAME', $site_base['site_name']);
define('SITE_TITLE', $site_base['site_title']);
define('SITE_LOGO', $site_base['site_logo']);
define('SITE_WEIXIN', $site_base['site_weixin']);
define('SITE_SERVICE_URL', $site_base['site_service_url']);
define('SITE_SERVICE_SCRIPT', $site_base['site_service_script']);
define('SITE_PHONE', $site_base['site_phone']);
define('SITE_QQ', $site_base['site_qq']);
define('SITE_COPYRIGHT', $site_base['site_copyright']);
define('SITE_BASE',serialize($site_base));
\core\FontController::getInstance()->rout();

