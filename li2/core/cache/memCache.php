<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of mem
 *
 * @author Administrator
 */

namespace core\cache;

class memCache {

    //put your code here
    private static $_instance;
    private $memcache;

    public static function getInstance($arr) {
        $key = md5(json_encode($arr));
        if (!isset(self::$_instance[$key]) || !(self::$_instance[$key] instanceof self)) {
            self::$_instance[$key] = new self($arr);
        }
        return self::$_instance[$key];
    }

    private function __construct($arr) {
        $this->memcache = new \Memcached();
        $this->setoptions();
        $this->addserver($arr);
        
    }

    private function setoptions() {
        $this->memcache->setOption(\Memcached::OPT_RECV_TIMEOUT, 1000);
        $this->memcache->setOption(\Memcached::OPT_SEND_TIMEOUT, 1000);
        $this->memcache->setOption(\Memcached::OPT_TCP_NODELAY, true);
        $this->memcache->setOption(\Memcached::OPT_SERVER_FAILURE_LIMIT, 50);
        $this->memcache->setOption(\Memcached::OPT_CONNECT_TIMEOUT, 500);
        $this->memcache->setOption(\Memcached::OPT_RETRY_TIMEOUT, 300);
        $this->memcache->setOption(\Memcached::OPT_DISTRIBUTION, \Memcached::DISTRIBUTION_CONSISTENT);
        $this->memcache->setOption(\Memcached::OPT_REMOVE_FAILED_SERVERS, true);
        $this->memcache->setOption(\Memcached::OPT_LIBKETAMA_COMPATIBLE, true);
    }

    private function addserver($arr) {
        foreach ($arr as $v) {
            $this->memcache->addServer($v['host'], $v['port'], $v['weight']);
        }
    }

    public function save($key, $value, $expretime = 86400) {
        //$key = parse_str($key);
        $expretime = $expretime ? time() + $expretime : 0;
        return $this->memcache->set($key,$value, $expretime);
    }

    public function get($key) {
        return $this->memcache->get($key);
    }

    public function rm($key) {
        return $this->memcache->delete($key);
    }

    public function getallkey() {
        return $this->memcache->getAllKeys();
    }

}
