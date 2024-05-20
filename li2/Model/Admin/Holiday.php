<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Model\Admin;

/**
 * Description of Holiday
 *
 * @author Administrator
 */
class Holiday {
	/**
	 * 修改节假日信息
	 * @param array $arr
	 * @return array
	 */
	public static function editHoliday($arr) {
		return \Common\Query::update ( 'admin_holiday', array ('hdate' => $arr ['hdate']), array ('id' => $arr ['id'] ) );
	}
	
	/**
	 * 添加节假日
	 * @param array $arr
	 * @return array
	 */
	public static function addHoliday($arr) {
		$inarr = array ('hdate' => $arr ['hdate']);
		return \Common\Query::insert ( 'admin_holiday', $inarr );
	}
	
	/**
	 * 删除节假日
	 * @param array $arr
	 * @return array
	 */
	public static function delHoliday($arr) {
		return \Common\Query::delete('admin_holiday',array ('id' =>$arr['id']));
	}
	
	/**
	 * 获取节假日列表
	 * @return array
	 */
	public static function getHoliday() {
		return \Common\Query::select('admin_holiday');
	}
}
