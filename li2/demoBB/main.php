<?php

use BBPay\Demo\BBpay;

require_once './src/BBPay.php';
require_once './src/Utils.php';
error_reporting(E_ALL ^ E_DEPRECATED);

$di = new \Phalcon\Di\FactoryDefault();
$config = new \Phalcon\Config\Adapter\Ini("./config.ini");
$di->set('config', $config);
$app = new \Phalcon\Mvc\Micro($di);
/**
 * 支付回调
 */
$app->post(
    '/bbpay/notify/pay',
    function () use ($app) {
        return (new BBPay($app->config))->pay_notify();
    }
);

/**
 * 代付回调
 */
$app->post(
    '/bbpay/notify/cash',
    function () use ($app) {
        return (new BBPay($app->config))->cash_notify();
    }
);

/**
 * 代付订单反查
 */
$app->post(
    '/bbpay/cash/confirm',
    function () use ($app) {
        return (new BBPay($app->config))->cash_confirm();
    }
);


try {
    $app->notFound(function () use ($app) {
        $app->response->setStatusCode(404, "Not Found")->sendHeaders();
        echo 'This is crazy, but this page was not found!';
    });
    $app->handle($_SERVER["REQUEST_URI"]);
} catch (Exception $e) {
    echo "Exception: ", $e->getMessage();
}