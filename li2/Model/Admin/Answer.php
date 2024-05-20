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
class Answer {
	/**
	 * 获取问题回复列表信息
	 * @return array
	 */
	public static function getAnswerList($que_id=0) {
		return \Common\Query::select('kf_answer',array ('que_id' => $que_id));
	}
	
	/**
	 * 根据编号获取问题回复信息
	 * @param string $id
	 * @return array
	 */
	public static function getAnswerById($id) {
		return \Common\Query::selone('kf_answer',array ('ans_id' => $id));
	}
	
	/**
	 * 修改问题回复信息
	 * @param array $arr
	 * @return array
	 */
	public static function editAnswer($arr) {
		$inarr = array (
			'que_id' => $arr ['que_id'],
			'content' => $arr ['content'],
			'uid'=>$arr['uid'],
			'user_name'=>$arr['user_name'],
			'user_post'=>$arr['user_post'],
		);
	
		$id = \Common\Query::update ( 'kf_answer', $inarr, array ('ans_id' => $arr ['ans_id'] ) );
		return array ('code' => $id, 'msg' => '修改成功' );
	}
	
	/**
	 * 添加问题回复
	 * @param array $arr
	 * @return array
	 */
	public static function addAnswer($arr) {
		$inarr = array (
			'que_id' => $arr ['id'],
			'content' => $arr ['content'],
			'uid'=>$arr['uid'],
			'user_name'=>$arr['user_name'],
			'user_job'=>$arr['user_job'],
			'ans_time'=>time(),
		);
		$id = \Common\Query::insert ( 'kf_answer', $inarr );
		if($id>0){
			$qid = \Common\Query::update('kf_question', array('reply_time'=>time(),'status'=>2),array('que_id'=>$arr ['id']));
		}
		return array ('code' => $id, 'msg' => '回复成功' );
	}
	
	/**
	 * 删除问题回复
	 * @param array $arr
	 * @return array
	 */
	public static function delAnswer($arr) {
		$id = \Common\Query::delete('kf_answer',array ('ans_id' =>$arr['ans_id']));
		return array ('code' => $id, 'msg' => '删除成功' );
	}
}
