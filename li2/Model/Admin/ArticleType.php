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
class ArticleType {
	/**
	 * 获取栏目列表信息
	 * @return array
	 */
	public static function getArticleTypeList($pid=0) {
		$cate_list = array();
		$p_list = \Common\Query::select('article_type',array ('pid' => $pid,'is_use'=>1),array(),array('`order`'));
		foreach ($p_list as $parent){
			$parent['child'] = self::getArticleTypeList($parent['id']);
			$cate_list[] = $parent;
		}
		unset($p_list);
		return $cate_list;
	}
	
	/**
	 * 获取栏目menu信息
	 * @return array
	 */
	public static function getMenuList($pid=1) {
		$menu_list = \Common\Query::select('article_type',array ('pid' => $pid,'is_use'=>1),array('`id`','`name`'),array('`order`'));
		return $menu_list;
	}
	
	/**
	 * 根据编号获取栏目信息
	 * @param string $id
	 * @return array
	 */
	public static function getArticleTypeById($id) {
		return \Common\Query::selone('article_type',array ('id' => $id));
	}
	
	/**
	 * 根据地址获取栏目信息
	 * @param string $id
	 * @return array
	 */
	public static function getArticleTypeByUrl($ac) {
		return \Common\Query::sqlselone('SELECT name,title,tags,description FROM article_type WHERE `link` like "%'.$ac.'"');
	}
	//
	/**
	 * 修改栏目信息
	 * @param array $arr
	 * @return array
	 */
	public static function editArticleType($arr,$isorder=0) {
		$inarr = array();
		if($isorder){
			$inarr = array('order'=>$arr['order']);
		}else{
			$inarr = array ('name' => $arr ['name'],'pid' => $arr ['pid'],'order'=>$arr['order'],'is_use'=>$arr['is_use'],'is_page'=>$arr['is_page'],'contents'=>$arr['contents'],'tags'=>$arr['tags'],'description'=>$arr['description'],'link'=>$arr['link'],'title'=>$arr['title']);
		}
		$id = \Common\Query::update ( 'article_type', $inarr, array ('id' => $arr ['id'] ) );
		return array ('code' => $id, 'msg' => '修改成功' );
	}
	
	/**
	 * 添加栏目
	 * @param array $arr
	 * @return array
	 */
	public static function addArticleType($arr) {
		$inarr = array ('name' => $arr ['name'], 'pid' => $arr ['pid'],'order'=>$arr['order'],'is_use'=>$arr['is_use'],'is_page'=>$arr['is_page'],'contents'=>$arr['contents'],'tags'=>$arr['tags'],'description'=>$arr['description'],'link'=>$arr['link'],'title'=>$arr['title']);
		$id = \Common\Query::insert ( 'article_type', $inarr );
		return array ('code' => $id, 'msg' => '添加成功' );
	}
	
	/**
	 * 删除栏目
	 * @param array $arr
	 * @return array
	 */
	public static function delArticleType($arr) {
		$id = \Common\Query::delete('article_type',array ('id' =>$arr['id']));
		return array ('code' => $id, 'msg' => '删除成功' );
	}
}
