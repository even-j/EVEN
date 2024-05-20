<?php

namespace apps\admin;
class question extends \apps\AdminControl {
	
	//问答管理
  	public function view(){
  		$this->setTitle('问答管理');
  		$page = isset ( $_GET ['page'] ) ? intval ( $_GET ['page'] ) : 1;
    	$where = ' WHERE is_deleted=0' ; 
  		if (! empty ( $_GET ['keywords'] )) {
			$where .= " and `content` like '%" . \App::t ( $_GET ['keywords'] ) . "%'";
		}
  	 	
  		if(isset($_GET['typeid']) && $_GET['typeid']!=0){
             $where .= " and `typeid`= ".  intval($_GET['typeid']);
         }
         
		 if(isset($_GET['status']) && $_GET['status']!=''){
             $where .= " and `status`= ".  intval($_GET['status']);
         }
         
		$selarr = array ('`que_id`', '`uid`','`typeid`', '`content`', '`views`', '`status`', '`que_time`', '`reply_time`' );
		$order = ' ORDER BY `que_time` DESC';
		$res = \Common\Pager::getList ( 'kf_question', $where, $selarr, $order, $page, 20);
		
		$dataList = array();
		$status = array(
			1=>'<span class="red">待回复</span>',
			2=>'<span class="blue">已回复</span>',
			3=>'<span class="green">已解决</span>',
		);
	
		$typeArr = array(
			1=>'<span class="blue">咨询</span>',
			2=>'<span class="red">投诉</span>',
			3=>'<span class="green">建议</span>',
		);
	
		foreach ($res ['data'] as $data){
			$data['cate_name'] = $typeArr[$data['typeid']]; 
			$data['user'] = $data['uid']>0 ? \Model\User\UserInfo::getinfo($data['uid']) : array('mobile'=>'游客');
			$data['o_status'] = $status[$data['status']];
			$dataList[] = $data;
		}
		
		$this->assign('typeArr', $typeArr);
		$this->assign('pager', $res ['pager']);
    	$this->assign('dataList', $dataList);
  		$this->template ( 'view.php' );
  	}
  	
	//添加回复
  	public function add(){
  		$type = isset($_GET['type']) ? \App::t($_GET['type']) : '';
    	$this->edit($type);
  	}
  	
  	//问答编辑
  	public function edit($type=''){
  		$id = isset($_GET['id']) ? intval($_GET['id']) : '0';
    	$nav_title = $type ? '回复' : '编辑问答';
    	$data = \Model\Wenda\Question::getQuestionById($id);

    	$status = array(
			1=>'待回复',
			2=>'已回复',
			3=>'已解决',
		);
		
		$typeArr = array(
			1=>'咨询',
			2=>'投诉',
			3=>'建议',
		);
		
		$this->assign('type', $type);
		$this->assign('typeArr', $typeArr);
		$this->assign('status', $status);
    	$this->assign('nav_title', $nav_title);
    	$this->assign('data', $data);
    	$this->template ( 'edit.php' );
  	}
  	
  	//问答编辑处理
  	public function doEdit(){
  		if($_POST){
  			$id = isset($_POST['id']) ? intval($_POST['id']) : 0;
  			$type = isset($_POST['type']) ? \App::t($_POST['type']) : '';
			$typeid = isset($_POST['typeid']) ? intval($_POST['typeid']) : 0;
			$content = isset($_POST['content']) ? htmlspecialchars($_POST['content']) : '';
			$que_time = isset($_POST['que_time']) ? \App::t($_POST['que_time']) : time();
			$reply_time = isset($_POST['reply_time']) ? \App::t($_POST['reply_time']) : time();
			$views = isset($_POST['views']) ? intval($_POST['views']) : 1;
			$advice = isset($_POST['advice']) ? \App::t($_POST['advice']) : '';
			$status = isset($_POST['status']) ? intval($_POST['status']) : 1;
			
			$arr = array(
				'typeid'=>$typeid,
				'content'=>$content,
				'que_time'=>strtotime($que_time),
				'reply_time'=>strtotime($reply_time),
				'views'=>$views,
				'status'=>$status,
				'advice'=>$advice,
			);
			
			$res = array();
			if ($id>0){//编辑
				$arr['id'] = $id;
				if ($type=='huifu'){
					$uid = $this->adminid;
					$adminInfo = \Model\Admin\User::getAdminInfo(array('admin_id'=>$uid));
					$role = \Model\Admin\Role::getRoleById($adminInfo['role_id']);
					$arr['uid'] = $uid;
					$arr['user_name'] = $adminInfo['real_name'];
					$arr['user_job'] = $role['name'];
					$res = \Model\Admin\Answer::addAnswer($arr);
				}else{
					$res = \Model\Wenda\Question::editQuestion($arr);
				}
			}else{
				$arr['uid'] = 17;
				$arr['mobile'] = '15160062331';
				$res = \Model\Wenda\Question::addQuestion($arr);
			}
			$url = '/index.php?app=admin&mod=question&ac=view';
			if($res['code']>0){
				$this->fontRedirect($res['msg'], $url);
			}else{
				$this->fontRedirect('操作失败！', $url);
			}
  		}else{
			$this->fontRedirect('提交方式不正确', $url);
		}
  		
  	}
  	
  	//问答删除
  	public function del(){
  		$id = isset($_GET['id']) ? intval($_GET['id']) : '0';
    	$url = '/index.php?app=admin&mod=question&ac=view';
    	if($id>1){
			$res =  \Model\Wenda\Question::delQuestion(array('id'=>$id));
			$this->sysRedirect($url);
    	}else{
			$this->fontRedirect('删除失败', $url);
		}
  	}
  	
}

?>