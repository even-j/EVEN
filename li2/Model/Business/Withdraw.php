<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Model\Business;

use Common\Cache;
use Common\Query;

class Withdraw {
    
    
    public static function add($uid,$money,$card_id,$pz_id){
        
        $inarr['uid'] = intval($uid);
        $inarr['rtime'] = time();
        $inarr['money'] = floatval($money);;
        $inarr['status'] = 0;
        $inarr['card_id'] = intval($card_id);
        $inarr['pz_id'] = $pz_id;
        $res = \Common\Query::insert('bus_withdraw_record', $inarr);
        return $res;
    }
    /**
     * 根据ID获取交易记录
     * @param type $fund_id
     * @return type
     */
    public static function getRecordById($withdraw_id){
    	$res = \Common\Query::select('bus_withdraw_record',array('withdraw_id'=>$withdraw_id));
    	return $res ? $res[0] : array();
    }

   /**
     * 根据ID改变交易状态
     * @param type $fund_id
     * @return type
     */
    public static function changeRecordStatusById($status,$withdraw_id){
    	return \Common\Query::update('bus_withdraw_record', array('status'=>$status),array('withdraw_id'=>$withdraw_id));
    }
    
    
}