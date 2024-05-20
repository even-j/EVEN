<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Cache
 *
 * @author Administrator
 */
namespace Common;
class Cache {
    //put your code here
    private static function createObj() {
        $arr= \apps\Config::getInstance()->cache;
        switch ($arr['type']){
            case 'dbcache':
                return \core\cache\dbCache::getInstance($arr['config']);
                break;
            case 'memcache':
                return \core\cache\memCache::getInstance($arr['config']);
                break;
            default :
                return \core\cache\fileCache::getInstance($arr['config']);
                break;
            
        }
        return \core\cache\memCache::getInstance($arr);
    }
    /**
     * 写入缓存
     * @param type $key
     * @param type $value
     * @param type $expire
     */
    public static function save($key,$value,$expire=86400){
        if(!$value){
            return false;
        }
        return self::createObj()->save($key,$value,$expire);
    }
    /**
     * 读取缓存
     * @param type $key
     */
    public static function get($key){
        return self::createObj()->get($key);
    }
    /**
     * 删除缓存
     * @param type $key
     * @return type
     */
    public static function rm($key){
        return self::createObj()->rm($key);
    }
    /**
     * 获得缓存所有的键值
     * @return type
     */
    public static function getallkey(){
        return self::createObj()->getallkey();
    }
}
