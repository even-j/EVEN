<?php

namespace apps\admin;
class role extends \apps\AdminControl {
	
	//角色管理
  	public function view(){
  		$this->setTitle('角色管理');
  		$page = isset ( $_GET ['page'] ) ? intval ( $_GET ['page'] ) : 1;
    	$where = ' WHERE 1=1' ; 
		$condition = array('status'=>'','account'=>'');
		$selarr = array ('`id`','`name`','`order`', '`addtime`' );
		$order = ' ORDER BY `order` ASC';
		$res = \Common\Pager::getList ( 'admin_user_role', $where, $selarr, $order, $page, 20);

		$dataList = array();
		foreach ($res ['data'] as $data){
			$dataList[] = $data;
		}
		$this->assign('pager', $res ['pager']);
    	$this->assign('dataList', $dataList);
  		$this->template ( 'view.php' );
  	}
  	
	//角色添加
  	public function add(){
    	$this->edit();
  	}
  	
  	//角色编辑
  	public function edit(){
  		$id = isset($_GET['id']) ? intval($_GET['id']) : '0';
    	$nav_title = $id>0 ? '编辑角色' : '添加角色';
    	$data = \Model\Admin\Role::getRoleById($id);
    	$modules = \Common\Query::select('admin_module', array('is_use'=>1),array(),array('sortno'));
    	$menus = array();
    	foreach ($modules as $m){
    		$m['menu'] = \Common\Query::select('admin_menu', array('is_use'=>1,'module_id'=>$m['module_id']),array(),array('sortno'));
    		$menus[] = $m;
    	}
    	unset($modules);
    	if($id>0){
	    	$data['purview'] =  $data['purview'] ? explode(',', $data['purview']) : array();
	        $data['module'] =   $data['module'] ? explode(',', $data['module']) : array();
    	}
    	$this->assign('menus',$menus);
    	$this->assign('nav_title', $nav_title);
    	$this->assign('data', $data);
    	$this->template ( 'edit.php' );
  	}
  	
  	//角色编辑处理
  	public function doEdit(){
  		if($_POST){
  			$id = isset($_POST['id']) ? intval($_POST['id']) : 0;
			$name = isset($_POST['name']) ? $_POST['name'] : '';
			$order = isset($_POST['order']) ? intval($_POST['order']) : 0;
			$module = isset($_POST['module']) ? implode(',', $_POST['module']) : '';
			$purview = isset($_POST['purview']) ? implode(',', $_POST['purview']) : '';
			$arr = array(
				'name'=>$name,
				'order'=>$order,
				'module'=>$module,
				'purview'=>$purview
			);
			$res = array();

			if ($id>0){//编辑
				$arr['id'] = $id;
				$res = \Model\Admin\Role::editRole($arr);
			}else{//新增
				$res = \Model\Admin\Role::addRole($arr);
			}
			$url = '/index.php?app=admin&mod=role&ac=view';
			if($res['code']>0){
				$this->fontRedirect($res['msg'], $url);
			}else{
				$this->fontRedirect('操作失败！', $url);
			}
  		}else{
			$this->fontRedirect('提交方式不正确', $url);
		}
  		
  	}
  	
  	//角色删除
  	public function del(){
  		$id = isset($_GET['id']) ? intval($_GET['id']) : '0';
    	$url = '/index.php?app=admin&mod=role&ac=view';
    	if($id>1){
			$res =  \Model\Admin\Role::delRole(array('id'=>$id));
			$this->sysRedirect($url);
    	}else{
			$this->fontRedirect('删除失败', $url);
		}
  	}
}

?>