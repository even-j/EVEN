<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of App
 *
 * @author Administrator
 */

namespace core;

class FontController {

    //put your code here
    protected $_body;
    static $_instance;

    public static function getInstance() {
        if (!(self::$_instance instanceof self)) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }

    private function __construct() {
        \core\net\Url::getInstance()->dataFilters();
    }

    public function setBody($body) {
        $this->_body = $body;
    }

    public function rout() {
        $app = \App::get('currentapp');
        $controller = \App::get('currentcontroller');
        $actions = \App::get('currentactions');
        try {
            $rc = new \ReflectionClass('\apps\\' . $app . '\\' . $controller);
        } catch (\Exception $e) {
            echo ('Not Fong Method:' . $controller);
            exit();
        }
        if ($rc->implementsInterface('\core\IController')) {
            if ($rc->hasMethod($actions)) {
                try {
                    $controller = $rc->newInstance();
                    $method = $rc->getMethod($actions);
                    $method->invoke($controller);
                } catch (\Exception $e) {
                    echo ('Not Fong Method:' . $controller);
                    exit();
                }
            } else {
                throw new \core\FontException('Not Fong Action:' . $actions, 404);
            }
        } else {
            throw new \core\FontException($controller . ' not Interface', 404);
        }
    }

}
