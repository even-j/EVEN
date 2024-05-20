<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Model\Business;

use Common\Cache;
use Common\Query;

class Fund {
    /**
     * 插入资金流水记录
     * @param type $uid
     * @param type $type
     * @param type $in_or_out －1：支出，1：收入
     * @param type $money  金额，单位：分
     * @param type $status 
     * @param type $table_name
     * @param type $rec_id
     * @param type $card_id
     * @return type
     */
    private static function addRecord($uid,$type,$in_or_out,$money,$status,$table_name = '',$rec_id = 0,$card_id = 0){
        
        $inarr['uid'] = intval($uid);
        $inarr['rtime'] = time();
        $inarr['type'] = intval($type);
        $inarr['in_or_out'] = intval($in_or_out);
        $inarr['money'] = floatval($money);;
        $inarr['table_name'] = \App::t($table_name);
        $inarr['rec_id'] = intval($rec_id);
        $inarr['status'] = intval($status);
        $inarr['card_id'] = intval($card_id);
        $user_row = \Model\User\UserInfo::getinfo($uid);
        $inarr['balance'] = $user_row['balance'];
        $inarr['frozen'] = $user_row['frozen'];
        $inarr['creditor'] = $user_row['creditor'];
        $inarr['debt'] = $user_row['debt'];
        
        $res = \Common\Query::insert('bus_fund_record', $inarr);
        return $res;
    }
    /**
     * 充值
     * @param type $uid
     * @param type $money
     * @return type
     */
    public static function recharge($recharge_id){
        $sql = 'select uid,money,status from bus_recharge_record where recharge_id='. intval($recharge_id).' for update';
        $recharge_row = \Common\Query::sqlselone($sql);
        if($recharge_row && $recharge_row['status'] == 0){
            $res = \Model\User\Recharge::updateSuccessStatus($recharge_id);

            if($res){
                $sql = 'update user_info set balance=balance+'.$recharge_row['money'].' where uid='.intval($recharge_row['uid']);
                $res = \Common\Query::sqlquery($sql);
                if(empty($res)){
                    return array(0,'修改余额错误');
                }
                \Model\User\UserInfo::removeCache($recharge_row['uid']);
                $res = self::addRecord($recharge_row['uid'], 1, 1, $recharge_row['money'],1);
                if(empty($res)){
                    return array(0,'添加流水记录错误');
                }
                return array(1,'充值成功');
            }
            else{
                return array(0,'充值记录状态更新错误');
            }
        }
        else{
            return array(0,'已充值成功');
        }
        
    }
    /**
     * 提现
     * @param type $uid
     * @param type $money
     * @return type
     */
    public static function withdraw($uid,$money,$card_id){
        //判断余额
        $user = \Model\User\UserInfo::getinfo($uid);
        $balance = $user? $user['balance']:0;
        if($balance<$money){
            return array(0,'余额不足');
        }
        //修改余额
        $sql = 'update user_info set balance=balance-'.floatval($money).' where uid='.intval($uid);
        $res = \Common\Query::sqlquery($sql);
        if(empty($res)){
            return array(0,'修改余额错误');
        }
        \Model\User\UserInfo::removeCache($uid);
        //添加流水记录
        $res = self::addRecord($uid, 2, -1, $money, 1,'',0,$card_id);
        if(empty($res)){
            return array(0,'添加流水记录错误');
        }
        return array(1,'成功');
    }
    
    /**
     * 资金流水类型
     * @param type $type
     */
    public static function fundTypeName($type){
        $name = '';
        switch ($type){
            case 1:
                $name = '充值';
                break;
            case 2:
                $name = '提现';
                break;
            
        }
        return $name;
    }
    
    /**
     * 得到提现待处理条数
     * @return type
     */
    public static function getWithdrawCount(){
        $sql = 'select count(withdraw_id) total from bus_withdraw_record where status<2';
        $row = \Common\Query::sqlselone($sql);
        return $row?$row['total']:0;
    }
    
	
    /**
     * 根据ID获取交易记录
     * @param type $fund_id
     * @return type
     */
    public static function getRecordById($fund_id){
    	$res = \Common\Query::select('bus_fund_record',array('fund_id'=>$fund_id));
    	return $res ? $res[0] : array();
    }
    
 	/**
     * 根据ID改变交易状态
     * @param type $fund_id
     * @return type
     */
    public static function changeRecordStatusById($status,$fund_id){
    	return \Common\Query::update('bus_fund_record', array('status'=>$status),array('fund_id'=>$fund_id));
    }
    
 	/**
     * 根据获取统计用户资产信息
     * @param type $uid
     * @param type $type
     * @return type
     */
    public static function getZhichangByUid($type,$uid=0){
    	$where = array('type'=>$type);
    	if($uid>0){
    		$where['uid'] = $uid;
    	}
    	$res = \Common\Query::selone('bus_fund_record',$where ,array('IFNULL(sum(money),0) AS total'));
    	return $res ? $res['total'] : array();
    }
    
   /* 根据ID获取用户资金记录
     * @param type $pz_id
     * @return array
     */
    public static function getFundListById($pz_id,$uid){
    	$sql = "select * from bus_fund_record where uid=" . $uid . " and table_name='user_peizi' and rec_id=" . $pz_id;
		$fundList = \Common\Query::sqlsel ( $sql );
    }
    
  
    
}