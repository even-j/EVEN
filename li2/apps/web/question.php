<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of index
 *
 * @author Administrator
 */
namespace apps\web;
class question extends \core\Controller {
	
	//问题列表
	public function view() {
		parent::view ();
		$this->setTitle ( '客服中心_'.SITE_NAME );
		$uid = $this->uid;
		$page = isset ( $_GET ['page'] ) ? intval ( $_GET ['page'] ) : 1;
		$where = ' WHERE is_deleted=0';
		$order = ' ORDER BY `que_time` DESC';
		$type = isset ( $_GET ['type'] ) ? $_GET ['type'] : 'new';
		
		$keyword = isset ( $_GET ['keyword'] ) ? \App::t($_GET ['keyword']) : '';
		
		if (is_numeric ( $type )) {
			if($type==4){
				$where = ' WHERE is_deleted=1';
			}else{
				$where .= " and `typeid`= " . intval ( $_GET ['type'] );
			}
		}else{
			if($type=='hot'){
				$order = ' ORDER BY `views` DESC';
			}
		}
		
		if ($type=='my'){
			if($uid>0){
				$where .= " and `uid`= " . intval ( $uid );
			}else{
				$where .= " and `uid`=-1 ";
			}
		}
		
		$arr = $uid>0 ? \Model\Wenda\Question::getTotalByUid($uid) : '';
		$my_question_num = $arr ? $arr['total'] : 0;//我的问题数量
		
		if($keyword){
			$where .= " and `content` like '%" . $keyword."%' ";
		}

		$selarr = array ('`que_id`', '`typeid`', '`content`', '`views`', '`status`', '`que_time`', '`reply_time`' );
		$res = \Common\Pager::getList ( 'kf_question', $where, $selarr, $order, $page, 10 );
		
		$dataList = array ();
		$typeArr = array (1 => '<span class="complain">咨询</span>', 2 => '<span class="advice">投诉</span>', 3 => '<span class="propose">建议</span>' );
		
		$statusArr = array (1 => '待回复', 2 => '已回复', 3 => '已解决' );
		foreach ( $res ['data'] as $data ) {
			$data ['status'] = $statusArr [$data ['status']];
			$data ['type_name'] = $typeArr [$data ['typeid']];
			$dataList [] = $data;
		}
		
		$this->assign ( 'type', $type );
		$this->assign ( 'my_question_num', $my_question_num );
		$this->assign ( 'pager', $res ['pager'] );
		$this->assign ( 'dataList', $dataList );
		$this->template ( 'index.php' );
	}
	
	//提问详情
	public function show() {
		$id = isset ( $_GET ['id'] ) ? intval ( $_GET ['id'] ) : 0;
		if($id>0){
			$typeArr = array (1 => '<span class="complain">咨询</span>', 2 => '<span class="advice">投诉</span>', 3 => '<span class="propose">建议</span>' );
		
			\Model\Wenda\Question::updateViewsById($id);//更新浏览数
			$question = \Model\Wenda\Question::getQuestionById($id);
			$user = \Model\User\UserInfo::getinfo($question['uid']);
			$question ['type_name'] = $typeArr [$question ['typeid']];
			$question['photo'] = '/public/web/images/niming.jpg';
			$question['username'] = $user ? substr_replace($user['mobile'], '******',3,6) : '游客';

			$answerList = \Model\Admin\Answer::getAnswerList($id);
			
			$this->setTitle ( \App::msubstr($question['content'],0,20).'_'.SITE_NAME );
			
			$this->assign('question',$question);
			$this->assign('answerList',$answerList);
			$this->template ( 'detail.php' );
		}
	}
	
	//选择问题类型
	public function ask() {
		$this->setTitle ( '选择问题类型_'.SITE_NAME );
		$typeid = isset($_GET ['typeid']) ? intval ( $_GET ['typeid'] ) : 1;
		$type = array (1 => '咨询', 2 => '投诉', 3 => '建议' );
		
		$this->assign ( 'type', $type );
		$this->assign ( 'typeid', $typeid );
		$this->template ( 'ask.php' );
	}
	
	//问题类型
	public function askType() {
		if (isset ( $_GET ['typeid'] )) {
			$typeid = isset ( $_GET ['typeid'] ) ? intval ( $_GET ['typeid'] ) : 1;
			$type = array (1 => '咨询', 2 => '投诉', 3 => '建议' );
			$this->setTitle ( $type [$typeid] . '_'.SITE_NAME );
			$user = \Model\User\UserInfo::getinfo($this->uid);
			$mobile = $user ? $user['mobile'] : '';
			$this->assign ( 'mobile', $mobile );
			$this->assign ( 'type', $type );
			$this->assign ( 'typeid', $typeid );
			$this->template ( 'ask_type.php' );
		} else {
			$this->sysRedirect ( \App::URL('web/question/ask') );
		}
	}
	
	//提交
	public function doQuestion() {
		if ($_POST) {
			$typeid = isset ( $_POST ['typeid'] ) ? intval ( $_POST ['typeid'] ) : 0;
			$content = isset ( $_POST ['content'] ) ? \App::t ( $_POST ['content'] ) : '';
			$advice = isset ( $_POST ['advice'] ) ? \App::t ( $_POST ['advice'] ) : '';
			$mobile = isset ( $_POST ['mobile'] ) ? \App::t ( $_POST ['mobile'] ) : '';
			$uid = $this->uid;
			
			$ip = \App::getonlineip ();
			$res = \Model\Wenda\Question::filterIp ( $ip );
			if ($res ['total']) {
				$this->fontRedirect ( '您提交的时间太过频繁，请稍后再试！！', \App::URL('web/question/askType',array('typeid'=>$typeid)));
			}
			if ($typeid && $content && $mobile) {
				$arr = array ('typeid' => $typeid, 'content' => $content, 'mobile' => $mobile, 'uid' => $uid, 'status' => 1 );
				
				//投诉内容
				if ($typeid == 2) {
					$arr ['advice'] = $advice;
				}
				$res = \Model\Wenda\Question::addQuestion ( $arr );
				if ($res ['code'] > 0) {
					$this->fontRedirect ( '您的内容已提交成功', \App::URL('web/question/view',array('type'=>'new')));
				} else {
					$this->fontRedirect ( '您的内容提交失败', \App::URL('web/question/askType',array('typeid'=>$typeid)));
				}
			} else {
				$this->fontRedirect ( '您提交的内容不能为空！', '' );
			}
		}
	}

}
