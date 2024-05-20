<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of db
 *
 * @author Administrator
 */
namespace core\cache;
class dbCache {
    //put your code here
    //put your code here
    private static $_instance;
    private $cachetable;

    public static function getInstance($arr) {
        if (!isset(self::$_instance) || !(self::$_instance instanceof self)) {
            self::$_instance = new self($arr);
        }
        return self::$_instance;
    }

    private function __construct($arr) {
        $this->cachetable=$arr['table'];
    }
    public function save($key,$value,$expretime=0) {
        $expretime=$expretime?time()+$expretime:0;
        $value=  serialize($value);
        return \Common\Query::insert($this->cachetable, array('ckey'=>$key,'cvalue'=>$value,'expretime'=>$expretime), true);
    }

    public function get($key) {
        $where=array('ckey'=>$key,'expretime'=>array('gt',time()));

        $arr=  \Common\Query::selone($this->cachetable,$where);
        if(is_array($arr)&&!empty($arr)){
            return unserialize($arr['cvalue']);
        }
        return '';
    }
    public function rm($key){
        \Common\Query::delete($this->cachetable, array('ckey'=>$key));
    }

    public function getallkey() {
        $nline=  time();
        $arr=  \Common\Query::select($this->cachetable, array('expretime'=>array('gt',$nline)),array('ckey'));
        return \App::getSubValue($arr, 'ckey');
    }
}
