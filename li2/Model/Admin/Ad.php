<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Model\Admin;

/**
 * Description of Ad
 *
 * @author Administrator
 */
class Ad {
	/**
	 * 修改广告信息
	 * @param array $arr
	 * @return array
	 */
	public static function editAd($arr) {
		$id = \Common\Query::update ( 'ad', array ('type_id' => $arr ['type_id'], 'ad_name' => $arr ['ad_name'], 'ad_pic' => $arr ['ad_pic'], 'ad_link' => $arr ['ad_link'],'status'=>$arr['status'],'order'=>$arr['order'] ), array ('id' => $arr ['id'] ) );
		return array ('code' => $id, 'msg' => '修改成功' );
	}
	
/**
	 * 根据编号获取广告信息
	 * @param string $id
	 * @return array
	 */
	public static function getAdById($id) {
		return \Common\Query::selone('ad',array ('id' => $id));
	}
	/**
	 * 添加广告
	 * @param array $arr
	 * @return array
	 */
	public static function addAd($arr) {
		$inarr = array ('type_id' => $arr ['type_id'], 'ad_name' => $arr ['ad_name'], 'ad_pic' => $arr ['ad_pic'], 'ad_link' => $arr ['ad_link'],'status'=>$arr['status'],'order'=>$arr['order'], 'addtime' => time () );
		$id = \Common\Query::insert ( 'ad', $inarr );
		return array ('code' => $id, 'msg' => '添加成功' );
	}
	
	/**
	 * 删除广告
	 * @param array $arr
	 * @return array
	 */
	public static function delAd($arr) {
		$id = \Common\Query::delete('ad',array ('id' =>$arr['id']));
		return array ('code' => $id, 'msg' => '删除成功' );
	}
}
