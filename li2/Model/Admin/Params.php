<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
namespace Model\Admin;
class Params {
    private static $tablename = 'admin_params';
    /**
     * 参数保存
     * @param type $key
     * @param type $value
     * @return type
     */
    public static function save($key,$value){
        $value=  serialize($value);
        $res = \Common\Query::insert(self::$tablename, array('ckey'=>$key,'cvalue'=>$value), true);
        self::removeCache($key);
        return $res;
    }
    /**
     * 参数获取
     * @param type $key
     * @return string
     */
    public static function get($key){
        $cache_key = 'admin_params_'.$key;
        $result = \Common\Cache::get($cache_key);
        if($result){
            return $result;
        }
        $where=array('ckey'=>$key);
        $arr=  \Common\Query::selone(self::$tablename,$where);
        if(is_array($arr)&&!empty($arr)){
            $result = unserialize($arr['cvalue']);
            \Common\Cache::save($cache_key, $result);
            return $result;
        }
        return '';
    }
    /**
     * 删除缓存
     * @param type $key
     */
    public static function removeCache($key){
        $cache_key = 'admin_params_'.$key;
        \Common\Cache::rm($cache_key);
    }
    
    public static function vip($uid,$params){
        if($uid){
            $user_row = \Model\User\UserInfo::getinfo($uid);
            if($user_row['level'] == 1){
                //vip
                for ($i=1;$i<=10;$i++){
                    if(isset($params['manage_cost_money'.$i])){
                        $params['manage_cost_money'.$i] = 0;
                    }
                }
            }
        }
        return $params;
    }
}
