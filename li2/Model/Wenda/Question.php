<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Model\Wenda;

/**
 * Description of Ad
 *
 * @author Administrator
 */
class Question {
	
	/**
	 * 根据编号获取问题信息
	 * @param string $id
	 * @return array
	 */
	public static function getQuestionById($id) {
		return \Common\Query::selone('kf_question',array ('que_id' => $id));
	}
	
	/**
	 * 更新浏览次数
	 * @param string $id
	 * @return array
	 */
	public static function updateViewsById($id){
		\Common\Query::sqlquery('UPDATE kf_question SET views=views+1 WHERE que_id='.$id);
	}
	/**
	 * 1分钟内容同IP提交的次数
	 * @param string $ip
	 * @return array
	 */
	public static function filterIp($ip){
		return \Common\Query::sqlselone("SELECT COUNT(que_id) AS total FROM kf_question where ip='".$ip."' and (UNIX_TIMESTAMP(NOW())-que_time)<60");;
	}
	
	/**
	 * 获取用户的问题数
	 * @param string $uid
	 * @return array
	 */
	public static function getTotalByUid($uid){
		return \Common\Query::sqlselone("SELECT COUNT(que_id) AS total FROM kf_question where uid='".$uid."' and is_deleted=0");
	}
	
	
	/**
	 * 获取待回复的问题数量
	 * @param string $status
	 * @return array
	 */
	public static function getTotalByStatus($status=1){
		$row = \Common\Query::sqlselone("SELECT COUNT(que_id) AS total FROM kf_question where status='".$status."' and is_deleted=0");
		return $row ? $row['total'] : 0;
	}
	/**
	 * 修改问题信息
	 * @param array $arr
	 * @return array
	 */
	public static function editQuestion($arr) {
		$inarr = array (
			'typeid' => $arr['typeid'],
			'content' => $arr['content'],
			'que_time' => $arr['que_time'],
			'reply_time' => $arr['reply_time'],
			'views' => $arr['views'],
			'status' => $arr['status'],
		);
	
		$id = \Common\Query::update ( 'kf_question', $inarr, array ('que_id' => $arr ['id'] ) );
		return array ('code' => $id, 'msg' => '修改成功' );
	}
	
	/**
	 * 添加问题
	 * @param array $arr
	 * @return array
	 */
	public static function addQuestion($arr) {
		$inarr = array (
			'typeid' => $arr['typeid'],
			'content'=> $arr['content'],
			'uid'=> $arr['uid'],
			'mobile'=> $arr['mobile'],
			'ip'=> \App::getonlineip(),
			'status'=> $arr['status'],
			'que_time'=> time(),
		);
		if(isset($arr['que_time'])){
			$inarr['que_time'] = $arr['que_time'];
		}
		if(isset($arr['views'])){
			$inarr['views'] = $arr['views'];
		}
		
		if($arr['typeid']==3 && isset($arr['advice'])){
			$inarr['advice'] = $arr['advice'];
		}
		$id = \Common\Query::insert ( 'kf_question', $inarr );
		return array ('code' => $id, 'msg' => '添加成功' );
	}
	
	/**
	 * 删除问题
	 * @param array $arr
	 * @return array
	 */
	public static function delQuestion($arr) {
		$id = \Common\Query::update ( 'kf_question', array('is_deleted'=>1), array ('que_id' => $arr ['id'] ) );
		if($id>0){
			\Common\Query::delete('kf_answer',array ('que_id' =>$arr['id']));
		}
		return array ('code' => $id, 'msg' => '删除成功' );
	}
}
