<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Model\User;

use Common\Cache;
use Common\Query;

class Withdraw {
    
    
    public static function add($uid,$money,$card_id,$status=0){
        if(empty($uid) || empty($money)){
            return false;
        }
        $inarr['uid'] = intval($uid);
        $inarr['rtime'] = time();
        $inarr['money'] = floatval($money);;
        $inarr['status'] = $status;
        $inarr['card_id'] = intval($card_id);
        $res = \Common\Query::insert('user_withdraw_record', $inarr);
        return $res;
    }
    /**
     * 根据ID获取交易记录
     * @param type $fund_id
     * @return type
     */
    public static function getRecordById($withdraw_id){
    	$res = \Common\Query::select('user_withdraw_record',array('withdraw_id'=>$withdraw_id));
    	return $res ? $res[0] : array();
    }

   /**
     * 根据ID改变交易状态
     * @param type $fund_id
     * @return type
     */
    public static function changeRecordStatusById($status,$withdraw_id){
    	return \Common\Query::update('user_withdraw_record', array('status'=>$status),array('withdraw_id'=>$withdraw_id));
    }
    
    /**
     * 根据ID改变交易状态
     * @param type $fund_id
     * @return type
     */
    public static function changeRecordStatus0ById($status,$withdraw_id){
    	return \Common\Query::update('user_withdraw_record', array('status'=>$status),array('withdraw_id'=>$withdraw_id,'status'=>0));
    }
    /**
     * 根据ID改变交易状态
     * @param type $fund_id
     * @return type
     */
    public static function changeRecordStatus1ById($status,$withdraw_id){
    	return \Common\Query::update('user_withdraw_record', array('status'=>$status),array('withdraw_id'=>$withdraw_id,'status'=>1));
    }
    
}