<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
namespace Model\Pay;

use Common\Cache;
use Common\Query;

class PaySet {
    public static function getSet($code){
        $row = \Common\Query::selone('pay_set', array('status'=>1,'code'=>$code));
        return $row;
    }
    
    public static function getList(){
        $rows = \Common\Query::select('pay_set', array('status'=>1),array(),array('sortno'));
        return $rows;
    }
    
    public static function getAccountList($uid){
        $user_info= \Model\User\UserInfo::getinfo($uid);
        $rows = \Common\Query::select('finance_account', array('status'=>1),array(),array('sortno'));
        $list=array();
        foreach($rows as $row)
        {
            $group_id=$row['group_id'];
            $group_arr= explode(',', $group_id);
            if($user_info['group_id'] && in_array($user_info['group_id'], $group_arr))
            {
                $list[]=$row;
            }
        }
        return $list;
    }
    
    public static function getAccount($id){
        $row = \Common\Query::selone('finance_account', array('status'=>1,'id'=>$id));
        return $row;
    }
    
    
}

