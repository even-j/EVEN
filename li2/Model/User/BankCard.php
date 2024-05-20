<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Model\User;

use Common\Cache;
use Common\Query;

class BankCard {
    /**
     * 添加银行卡
     * @param type $uid
     * @param type $province
     * @param type $city
     * @param type $card_no
     * @param type $bank_name
     * @return type
     */
    public static function add($uid,$province_id,$province_name,$city_id,$city_name,$card_no,$bank_name,$type=''){
        $inarr['uid'] = $uid;
        $inarr['province_id'] = $province_id;
        $inarr['province_name'] = $province_name;
        $inarr['city_id'] = $city_id;
        $inarr['city_name'] = $city_name;
        $inarr['card_no'] = $card_no;
        $inarr['bank_name'] = $bank_name;
        $inarr['type'] = $type;
        $inarr['card_type'] = 'cx';
        $inarr['is_audit'] = 1;
        $inarr['status'] = 1;
        $res = \Common\Query::insert('user_bankcard', $inarr);
        if($res){
            //赠送管理费
            $row_count = \Common\Query::sqlselone("select count(fund_id) total from user_fund_record where uid=".$uid." and type=106");
            if(intval($row_count['total']) <=0){
                $params_send = \Model\Admin\Params::get('manage_send');
                Fund::send_bank($uid, floatval($params_send['bank'])*100);
            }
        }
        return $res;
    }
    
	/**
     * 更新银行卡信息
     * @param type $uid
     * @param type $updarr
     * @return type
     */
    public static function edit($updarr,$card_id){
        return \Common\Query::update('user_bankcard', $updarr, array('card_id'=>$card_id));
    }
    
    /**
     * 判断用户是否已添加银行卡
     * @param type $uid
     * @return boolean
     */
    public static function checkAdd($uid){
        $row = self::getByUid($uid);
        if($row){
            return true;
        }
        return false;
    }
    /**
     * 判断银行卡号是否存在
     * @param type $card_no
     * @return boolean
     */
    public static function checkBandCardIsExist($card_no){
        $row = self::getByCardNo($card_no);
        if($row){
            return true;
        }
        return false;
    }

    /**
     * 通过用户id获得用户银行卡信息
     * @param type $uid
     * @return type
     */
    public static function getByUid($uid,$card_id=0) {
    	$where = array('uid'=>$uid,'status'=>1);
    	if($card_id>0){
    		$where['card_id'] = $card_id;
    	}
        $row = \Common\Query::selone('user_bankcard', $where);
        if($row){
            return $row;
        }
        return array();
    }
    
    /**
     * 通过id获得银行卡信息
     * @param type $card_no
     * @return type
     */
    public static function getById($card_id) {
        $row = \Common\Query::selone('user_bankcard', array('card_id'=>$card_id));
        if($row){
            return $row;
        }
        return array();
    }
    /**
     * 通过卡号获得银行卡信息
     * @param type $card_no
     * @return type
     */
    public static function getByCardNo($card_no) {
        $row = \Common\Query::selone('user_bankcard', array('card_no'=>$card_no,'status'=>1,'is_audit'=>1));
        if($row){
            return $row;
        }
        return array();
    }
    
	/**
     * 获取银行卡待审核的用户个数
     * @return int
     */
    public static function getBankCardCountByStatus(){
    	$row = \Common\Query::selone('user_bankcard', array('is_audit'=>0),array('COUNT(uid) AS total'));
        return $row ? $row['total'] : 0;
    }
    
	/**
     * 获取用户银行卡数量
     * @param type $uid
     * @return type
     */
    public static function getBankCardCountByByUid($uid) {
    	$row = \Common\Query::selone('user_bankcard', array('status'=>1,'uid'=>$uid),array('COUNT(card_id) AS total'));
        return $row ? $row['total'] : 0;
    }
    
	/**
     * 获取用户银行卡列表
     * @param type $uid
     * @return type
     */
    public static function getBankCardListByUid($uid) {
    	$sql = 'SELECT * FROM user_bankcard WHERE `uid`='.$uid.' AND `status`=1 ORDER BY is_default DESC';
    	return \Common\Query::sqlsel($sql);
    }
    
    /**
     * 银行卡默认设置
     * @param type $uid
     * @return type
     */
    public static function setBankCardDefault($uid,$card_id){
    	$updarr = array(
    		'is_default'=>1
    	);
    	\Common\Query::update('user_bankcard', array('is_default'=>0),array('uid'=>$uid,'is_default'=>1));
    	return \Common\Query::update('user_bankcard', $updarr, array('card_id'=>$card_id));
    }
    
    /**
     * 删除银行卡
     * @param type $card_id
     * @return type
     */
    public static function del($card_id){
        $res = \Common\Query::delete('user_bankcard', array('card_id'=>$card_id));
        return $res;
    }
}