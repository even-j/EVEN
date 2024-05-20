<?php

namespace apps\admin;
class ad extends \apps\AdminControl {
    
     //put your code here
    public function view() {
    	$this->setTitle('广告管理');
    	$page = isset ( $_GET ['page'] ) ? intval ( $_GET ['page'] ) : 1;
    	$ad_type = array();
    	$ad_typeArr = \Common\Pager::getList('ad_type', '', array('id', 'type_name'), ' ORDER BY id ASC' ,1,20,0);
    	foreach ($ad_typeArr as $type){
    		$ad_type[$type['id']] = $type;
    	}
    	unset($ad_typeArr);
    	$where = ' WHERE 1=1' ; 
		$condition = array('type_id'=>'','ad_name'=>'');
		$type_id = isset($_GET['type_id']) ? $_GET['type_id'] : $condition['type_id'];
		$ad_name = isset($_GET['ad_name']) ? $_GET['ad_name'] : $condition['ad_name'];

		if ($type_id){
			$condition['type_id'] = $type_id;
			$where .= " AND type_id='".$type_id."'";
		}
    	if ($ad_name){
			$condition['ad_name'] = $ad_name;
			$where .= " AND ad_name like '%".$ad_name."%'";
		}
		$selarr = array ('id','type_id','ad_name', 'ad_pic','ad_link', 'status', 'addtime' );
		$order = ' ORDER BY type_id ASC, `order` ASC';
		$res = \Common\Pager::getList ( 'ad', $where, $selarr, $order, $page, 20);
		$status = array ( '0' => '可用', '1' => '禁用');

		$dataList = array();
		foreach ($res ['data'] as $data){
			$data['o_status'] = $data['status'] ? '<span class="red">'.$status[$data['status']].'</span>' : '<span class="green">'.$status[$data['status']].'</span>'; 
			$dataList[] = $data;
		}
		
		$this->assign('pager', $res ['pager']);
		$this->assign('ad_type', $ad_type);
    	$this->assign('dataList', $dataList);
    	$this->assign('condition', $condition);
    	$this->template ( 'index.php' );
    }
    
    //删除
    public function del(){
    	$id = isset($_GET['id']) ? $_GET['id'] : 0;
		$res =  \Model\Admin\Ad::delAd(array('id'=>$id));
		$this->sysRedirect('/index.php?app=admin&mod=ad&ac=view');
    }
    
   //添加
    public function add(){
    	$this->edit();
    }
    
    //编辑
    public function edit(){
    	$id = isset($_GET['id']) ? $_GET['id'] : 0;
    	$nav_title = $id>0 ? '编辑广告' : '添加广告';
    	$ad_type = array();
    	$status = array ('0' => '可用', '1' => '禁用');
    	$ad_typeArr = \Common\Pager::getList('ad_type', '', array('id', 'type_name'), ' ORDER BY id ASC' ,1,20,0);
    	foreach ($ad_typeArr as $type){
    		$ad_type[$type['id']] = $type;
    	}
    	unset($ad_typeArr);
    	
    	$data = \Model\Admin\Ad::getAdById($id);
    	
    	$this->assign('nav_title', $nav_title);
    	$this->assign('ad_type', $ad_type);
    	$this->assign('data', $data);
    	$this->assign('status', $status);
    	$this->template ( 'edit.php' );
    }
    
    //保存数据
    public function doEdit(){
		if ($_POST ['submit']) {
			$id = intval($_POST['id']);
			$type_id = intval($_POST['type_id']);
			$ad_name = $_POST['ad_name'];
			$ad_pic = $_POST['ad_path'];
			$ad_link = $_POST['ad_link'];
			$status = $_POST['status'];
			$order = intval($_POST['order']);
			
			//上传图片
			if(!empty($_FILES ['ad_pic'] ['name'])){
				$return = $this->upload();
				$ad_pic = $return['status'] ? $return['data']['src'] : '';
			}
			$arr =  array('type_id'=>$type_id,'ad_name'=>$ad_name,'ad_pic'=>$ad_pic, 'ad_link'=>$ad_link,'status'=>$status,'order'=>$order);
			if ($id>0){//修改
				$arr['id'] = $id;
				$res =  \Model\Admin\Ad::editAd($arr);
			}else{
				$res = \Model\Admin\Ad::addAd($arr);
			}
			$url = '/index.php?app=admin&mod=ad&ac=view';
			if($res['code']>0){
				$this->fontRedirect($res['msg'], $url);
			}else{
				$this->fontRedirect('操作失败！', $url);
			}
		}else{
			$this->fontRedirect('提交方式不正确', $url);
		}
			
  		
	}
	
	public function upload(){
		$return = array ();
		$targetFolder = SITEROOT . '/uploads/' . date ( 'ymd', time () ); // Relative to the root
		$saveFolder = '/uploads/' . date ( 'ymd', time () );
		if (! empty ( $_FILES )) {
			if (! file_exists ( $targetFolder )) { // 判断存放文件目录是否存在
				mkdir ( $targetFolder, 0777, true );
			}
			$fileName = $_FILES ['ad_pic'] ['name'];
			$tempFile = $_FILES ['ad_pic'] ['tmp_name'];
			$targetPath = $targetFolder;
			$fileParts = pathinfo ( $fileName );
			$upfileName = md5 ( uniqid () ) . '.' . $fileParts ['extension'];
			$targetFile = rtrim ( $targetPath, '/' ) . '/' . $upfileName;
			$fileTypes = array ('jpg', 'jpeg', 'gif', 'png' ); // File extensions
			$data = array ();
			if (in_array ( $fileParts ['extension'], $fileTypes )) {
				move_uploaded_file ( $tempFile, $targetFile );
				$data ['src'] = $saveFolder . '/' . $upfileName;
				$data ['attach_id'] = $upfileName;
				$data ['extension'] = strtolower ( $fileParts ['extension'] );
				$return = array ('status' => 1, 'data' => $data );
			} else {
				$return = array ('status' => 0, 'msg' => $fileParts ['extension'] . '类型的不允许上传！' );
			}
			//echo json_encode($return);exit();
		}
		return $return;
	}
	
	
}

?>