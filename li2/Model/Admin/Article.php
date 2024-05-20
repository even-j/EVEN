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
class Article {
	/**
	 * 获取文章列表信息
	 * @return array
	 */
	public static function getArticleList($pid=0,$keyword='') {
		$where = '1=1';
		if($pid>0){
			$where .= ' AND pid='.$pid;
		}
		if($keyword){
			$where .= " AND title like '%".$keyword."%'";
		}
		return\Common\Query::sqlsel('SELECT id,pid,title FROM article WHERE '.$where.' ORDER BY `order` ASC,id DESC');
		//return \Common\Query::select('article',array ('pid' => $pid),array('id','pid','title'),array('`order`'));
	}
	
	/**
	 * 根据编号获取文章信息
	 * @param string $id
	 * @return array
	 */
	public static function getArticleById($id) {
		return \Common\Query::selone('article',array ('id' => $id));
	}
	
	/**
	 * 修改文章信息
	 * @param array $arr
	 * @return array
	 */
	public static function editArticle($arr,$isorder=0) {
		$inarr = array();
		if($isorder){
			$inarr = array('order'=>$arr['order']);
		}else{
			$inarr = array (
				'title' => $arr ['title'],
				'pid' => $arr ['pid'],
				'order'=>$arr['order'],
				'contents'=>$arr['contents'],
				'flag'=>$arr['flag'],
				'tags'=>$arr['tags'],
				'description'=>$arr['description'],
				'status'=>$arr['status'],
                                'addtime'=>$arr['addtime']
			);
		}
	
		$id = \Common\Query::update ( 'article', $inarr, array ('id' => $arr ['id'] ) );
		return array ('code' => $id, 'msg' => '修改成功' );
	}
	
	/**
	 * 添加文章
	 * @param array $arr
	 * @return array
	 */
	public static function addArticle($arr) {
		$inarr = array (
			'title' => $arr ['title'],
			'pid' => $arr ['pid'],
			'order'=>$arr['order'],
			'contents'=>$arr['contents'],
			'flag'=>$arr['flag'],
			'tags'=>$arr['tags'],
			'uid'=>$arr['uid'],
			'description'=>$arr['description'],
			'status'=>$arr['status'],
			'addtime'=>$arr['addtime'],
			'addip'=>\App::getonlineip(),
		);
		$id = \Common\Query::insert ( 'article', $inarr );
		return array ('code' => $id, 'msg' => '添加成功' );
	}
	
	/**
	 * 删除文章
	 * @param array $arr
	 * @return array
	 */
	public static function delArticle($arr) {
		$id = \Common\Query::delete('article',array ('id' =>$arr['id']));
		return array ('code' => $id, 'msg' => '删除成功' );
	}
}
