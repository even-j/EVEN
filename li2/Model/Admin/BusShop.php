<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Model\Admin;

use Common\Cache;
use Common\Query;

class BusShop {
    /**
     * 添加商户信息
     * @param array $arr
     * @return type
     */
    public static function add($inarr){
        $res = \Common\Query::insert('bus_shop', $inarr);
        return $res;
    }
    
	/**
     * 更新商户信息
     * @param type $shop_id
     * @param type $updarr
     * @return type
     */
    public static function edit($updarr,$shop_id){
        return \Common\Query::update('bus_shop', $updarr, array('shop_id'=>$shop_id));
    }
    

    /**
     * 通过用户id获得合作商户信息
     * @param type $uid
     * @return type
     */
    public static function getInfoByShopId($shop_id) {
    	$where = array('shop_id'=>$shop_id);
        $row = \Common\Query::selone('bus_shop', $where);
        if($row){
            return $row;
        }
        return array();
    }
    
	/**
     * 获取商户列表
     * @return type
     */
    public static function getShopList() {
    	$sql = 'SELECT * FROM bus_shop WHERE `status`=1 ORDER BY shop_id DESC';
    	return \Common\Query::sqlsel($sql);
    }
    
    public static function getShopIdByAdminid($admin_id){
        $where = array('admin_id'=>$admin_id);
        $row = \Common\Query::selone('admin_user', $where);
        return $row?$row['shop_id']:0;
    }
}