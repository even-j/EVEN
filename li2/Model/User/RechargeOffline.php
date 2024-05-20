<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Model\User;

use Common\Cache;
use Common\Query;

class RechargeOffline {
    public static function getById($recharge_id){
        $res = \Common\Query::selone('user_recharge_offline', array('id'=>$recharge_id));
        return $res;
    }

    /**
     * 
     * @param type $uid
     * @param type $money
     * @return type
     */
    
    public static function add($uid,$money,$name,$channel='',$status=0){
        //$inarr['recharge_id'] = rand(100000, 999999);
        if(floatval($money)<=0){
            return false;
        }
        if(empty($uid) || empty($money) || empty($name) || empty($channel)){
            return false;
        }
        $inarr['add_time'] = time();
        $inarr['channel'] = $channel;
        $inarr['uid'] = $uid;
        $inarr['money'] = $money;
        $inarr['name'] = $name;
        $inarr['status'] = $status;
        $res = \Common\Query::insert('user_recharge_offline', $inarr);
        return $res;
    }
    
    /**
     * 
     * @param type $recharge_id
     * @return type
     */
    public static function updateSuccessStatus($recharge_id){
        $updarr['status'] =1;
        $updarr['update_time'] =time();
        $res = \Common\Query::update('user_recharge_offline', $updarr, array('id'=>$recharge_id,'status'=>0));
        return $res;
        
    }
    
    public static function updateRefuseStatus($recharge_id){
        $updarr['status'] =2;
        $updarr['update_time'] =time();
        return \Common\Query::update('user_recharge_offline', $updarr, array('id'=>$recharge_id,'status'=>0));
    }
    
    public static function rechargeOfflineCount(){
        $sql = "select count(id) cou from user_recharge_offline where status=0";
        $res = \Common\Query::sqlselone($sql);
        return $res['cou'];
    }
    
}