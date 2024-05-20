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
class Role {
	/**
	 * 获取角色列表信息
	 * @return array
	 */
	public static function getRoleList() {
		return \Common\Query::select('admin_user_role');
	}
	
	/**
	 * 根据编号获取角色信息
	 * @param string $id
	 * @return array
	 */
	public static function getRoleById($id) {
		return \Common\Query::selone('admin_user_role',array ('id' => $id));
	}
	
	/**
	 * 修改角色信息
	 * @param array $arr
	 * @return array
	 */
	public static function editRole($arr) {
		$where = array ('purview' => $arr ['purview'], 'module' => $arr ['module'],'order'=>$arr['order']);
		if($arr ['id']>1){
			$where['name'] = $arr ['name'];
		}
		$id = \Common\Query::update ( 'admin_user_role', $where, array ('id' => $arr ['id'] ) );
		return array ('code' => $id, 'msg' => '修改成功' );
	}
	
	/**
	 * 添加角色
	 * @param array $arr
	 * @return array
	 */
	public static function addRole($arr) {
		$inarr = array ('name' => $arr ['name'], 'purview' => $arr ['purview'], 'module' => $arr ['module'],'order'=>$arr['order'], 'addtime' => time () );
		$id = \Common\Query::insert ( 'admin_user_role', $inarr );
		return array ('code' => $id, 'msg' => '添加成功' );
	}
	
	/**
	 * 删除角色
	 * @param array $arr
	 * @return array
	 */
	public static function delRole($arr) {
		$id = \Common\Query::delete('admin_user_role',array ('id' =>$arr['id']));
		return array ('code' => $id, 'msg' => '删除成功' );
	}
}
