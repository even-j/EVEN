<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of fileCache
 *
 * @author Administrator
 */
namespace core\cache;
class fileCache {
    //put your code here
    private static $_instance;
    private $cachepath;

    public static function getInstance($arr) {
        $key = md5(json_encode($arr));
        if (!isset(self::$_instance[$key]) || !(self::$_instance[$key] instanceof self)) {
            self::$_instance[$key] = new self($arr);
        }
        return self::$_instance[$key];
    }

    private function __construct($arr) {
        $this->cachepath=$arr['cachepath'];
        
    }
    private function getPath($key){
        $f1=  substr($key, 0, 1);
        $f2=  substr($key, 1, 1);
        $path=$this->cachepath.DIRECTORY_SEPARATOR.$f1.DIRECTORY_SEPARATOR;
        if(!is_dir($path)){
            mkdir($path);
        }
        $path.=$f2.DIRECTORY_SEPARATOR;
        if(!is_dir($path)){
            mkdir($path);
        }
        return $path.$key.'.php';
        //echo $this->cachepath.'==>';
    }

    public function save($key,$value,$expretime=0) {
        $path=$this->getPath($key);
        $expretime=$expretime?time()+$expretime:0;
        $value=  serialize($value);
        $data="===expretime{$expretime}expretime===".$value;
        return file_put_contents($path, $data);
    }

    public function get($key) {
        $path=$this->getPath($key);
        if(!file_exists($path)){
            return '';
        }
        
        $cons=  file_get_contents($path);
        if(preg_match('#===expretime([\d]+)expretime===(.+)#ims', $cons, $matches)){
            if($matches[1]>=time()){
                return unserialize($matches[2]);
            }
        }
        return '';
    }
    public function rm($key){
        $path=$this->getPath($key);
        unlink($path);
    }

    public function getallkey() {
        return array();
    }
}
