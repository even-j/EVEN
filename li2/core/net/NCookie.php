<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Cookie
 *
 * @author Administrator
 */

namespace core\net;

class NCookie {

    //put your code here
    // cookie加密键值串，可以根据自己的需要修改
    const DES_KEY = 'o89L7234kjW2Wad72SHw22lPZmEbP3dSj7TT10A5Sh60';

    public static function set($name, $value, $expire = 86400) {
        $c = \apps\Config::getInstance()->cookie;
        $value = \core\secure\Auth::encode(self::DES_KEY, $value);
        $expire = time() + $expire;
        setcookie($name, $value, $expire, $c['path'], $c['domain']);
    }

    public static function get($name) {
        if (isset($_COOKIE[$name])) {
            return \core\secure\Auth::decode(self::DES_KEY, $_COOKIE[$name]);
        }
        return '';
    }

}
