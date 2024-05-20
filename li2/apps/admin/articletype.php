<?php

namespace apps\admin;
class articletype extends \apps\AdminControl {
	
	//栏目分类管理
  	public function view(){
  		$this->setTitle('栏目分类管理');
  		$page = isset ( $_GET ['page'] ) ? intval ( $_GET ['page'] ) : 1;
  		$where = ' WHERE pid=0' ; 
  		
  		if(isset($_GET['pid']) && $_GET['pid']){
             $where = ' WHERE id='.  intval($_GET['pid']);
         }
    	
  		if (! empty ( $_GET ['name'] )) {
			$where .= " and `name` like '%" . \App::t ( $_GET ['name'] ) . "%'";
		}
		 if(isset($_GET['is_use']) && $_GET['is_use']!=''){
             $where .= " and `is_use`= ".  intval($_GET['is_use']);
         }
  	 	if(isset($_GET['is_page']) && $_GET['is_page']!=''){
             $where .= " and `is_page`= ".  intval($_GET['is_page']);
         }
      
		$selarr = array ('`id`','`name`','`order`', '`pid`','`is_use`','`is_page`' );
		$order = ' ORDER BY `order` ASC, `pid` ASC';
		$parent = \Common\Pager::getList ( 'article_type', $where, $selarr, $order, $page, 30,0);
		
		$typeArr = array(
			0=>'<span class="red">列表</span>',
			1=>'<span class="green">单页</span>',
		);
		$dataList = array();
		foreach ($parent as $data){
			$data['name'] = $data['name'].' ['.$typeArr[$data['is_page']].']';
			$data['child'] = \Common\Pager::getList ( 'article_type', ' WHERE pid='.$data['id'] , $selarr, $order, $page, 30,0);
			$dataList[] = $data;
		}
		
		$cate_list = \Common\Pager::getList ( 'article_type', ' WHERE pid=0' , $selarr, $order, $page, 10,0);
		
		$this->assign('cate_list', $cate_list);
		$this->assign('typeArr', $typeArr);
    	$this->assign('dataList', $dataList);
  		$this->template ( 'view.php' );
  	}
  	
	//栏目分类添加
  	public function add(){
    	$this->edit();
  	}
  	
  	//栏目分类编辑
  	public function edit(){
  		$id = isset($_GET['id']) ? intval($_GET['id']) : '0';
  		$pid = isset($_GET['pid']) ? intval($_GET['pid']) : '0';
    	$nav_title = $id>0 ? '编辑栏目分类' : '添加栏目分类';
    	$data = \Model\Admin\ArticleType::getArticleTypeById($id);
		$cate_list = \Model\Admin\ArticleType::getArticleTypeList();
		$typeArr = array(
			0=>'<span class="red">列表</span> ',
			1=>'<span class="green">单页</span> ',
		);
		
		$this->assign('pid', $pid);
		$this->assign('typeArr', $typeArr);
		$this->assign('cate_list', $cate_list);
    	$this->assign('nav_title', $nav_title);
    	$this->assign('data', $data);
    	$this->template ( 'edit.php' );
  	}
  	
  	//栏目分类编辑处理
  	public function doEdit(){
  		$url = '/index.php?app=admin&mod=articletype&ac=view';
  		if($_POST){
  			$id = isset($_POST['id']) ? intval($_POST['id']) : 0;
			$name = isset($_POST['name']) ? $_POST['name'] : '';
			$order = isset($_POST['order']) ? intval($_POST['order']) : 0;
			$pid = isset($_POST['pid']) ? intval($_POST['pid']) : 0;
			$is_use = isset($_POST['is_use']) ? intval($_POST['is_use']) : 0;
			$is_page = isset($_POST['is_page']) ? intval($_POST['is_page']) : 0;
			$tags = isset($_POST['tags']) ? ($_POST['tags']) : '';
			$description = isset($_POST['description']) ? ($_POST['description']) : '';
			$contents = isset($_POST['contents']) ? htmlspecialchars($_POST['contents']) : '';
			$link = isset($_POST['link']) ? ($_POST['link']) : '';
			$title = isset($_POST['title']) ? ($_POST['title']) : '';
			
			
			$arr = array(
				'name'=>$name,
				'order'=>$order,
				'pid'=>$pid,
				'is_use'=>$is_use,
				'is_page'=>$is_page,
				'tags'=>$tags,
				'description'=>$description,
				'contents'=>$contents,
				'link'=>$link,
				'title'=>$title,
			);
			$res = array();

			if ($id>0){//编辑
				$arr['id'] = $id;
				$res = \Model\Admin\ArticleType::editArticleType($arr);
			}else{//新增
				$res = \Model\Admin\ArticleType::addArticleType($arr);
			}
			$data = \Model\Admin\ArticleType::getArticleTypeById($id);
			$id = $data['pid']>0 ? $data['pid'] : $id;
			if($res['code']>0){
				$this->fontRedirect($res['msg'], $url."&pid=".$id);
			}else{
				$this->fontRedirect('操作失败！', $url."&pid=".$id);
			}
			
  		}else{
			$this->fontRedirect('提交方式不正确', $url);
		}
  		
  	}
  	
  	//栏目分类删除
  	public function del(){
  		$id = isset($_GET['id']) ? intval($_GET['id']) : '0';
    	$url = '/index.php?app=admin&mod=articletype&ac=view';
    	if($id>1){
			$res =  \Model\Admin\ArticleType::delArticleType(array('id'=>$id));
			$this->sysRedirect($url);
    	}else{
			$this->fontRedirect('删除失败', $url);
		}
  	}
  	
  	//ajax 排序
  	public function ajaxSort(){
  		$res = array('code'=>0,'msg'=>'操作失败');
  		if($_POST){
  			$ids = isset($_POST['ids']) ?  array_filter(explode(',',$_POST['ids'])) : array();
  			$order = isset($_POST['order']) ? explode(',',$_POST['order']) : array();
  			
  			if($ids && $order){
  				foreach ($ids as $key=>$id){
  					\Model\Admin\ArticleType::editArticleType(array('id'=>$id,'order'=>$order[$key]),1);
  				}
  				$res['code'] = 1;
  			}
  		}else{
  			$res['msg'] = '参数非法提交';
  		}
  		exit(json_encode($res));
  	}

	//ajax 删除
  	public function ajaxDel(){
  		$res = array('code'=>0,'msg'=>'操作失败');
  		if($_POST){
  			$ids = isset($_POST['id']) ?  array_filter(explode(',',$_POST['id'])) : array();
  			
  			if($ids ){
  				foreach ($ids as $id){
  					\Model\Admin\ArticleType::delArticleType(array('id'=>$id));
  				}
  				$res['code'] = 1;
  			}
  		}else{
  			$res['msg'] = '参数非法提交';
  		}
  		exit(json_encode($res));
  	}
  	
  	
}

?>