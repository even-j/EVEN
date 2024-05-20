<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Model\Business;

use Common\Cache;
use Common\Query;

class Recharge {
    /**
     * 
     * @param type $uid
     * @param type $money
     * @return type
     */
    
    public static function add($uid,$money,$pz_id){
        //$inarr['recharge_id'] = rand(100000, 999999);
        $inarr['rtime'] = time();
        $inarr['uid'] = $uid;
        $inarr['money'] = $money;
        $inarr['status'] = 0;
        $inarr['plat'] = 'yeepay';
        $inarr['pz_id'] = $pz_id;
        $res = \Common\Query::insert('bus_recharge_record', $inarr);
        return $res;
    }
    
    /**
     * 
     * @param type $recharge_id
     * @return type
     */
    public static function updateSuccessStatus($recharge_id){
        $updarr['status'] =1;
        return \Common\Query::update('bus_recharge_record', $updarr, array('recharge_id'=>$recharge_id,'status'=>0));
    }
    
    
}