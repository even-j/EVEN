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
class article extends \core\Controller {
	//put your code here
	public function view() {
		parent::view ();
        $pid = isset($_GET['pid']) ? intval($_GET['pid']) : 12;
        $menuList = \Model\Admin\ArticleType::getMenuList();
		$data = \Model\Admin\ArticleType::getArticleTypeById($pid);
		if (!$data){
			$this->fontRedirect('该内容未审核或不存在！', '/');
		}
		$type = \Model\Admin\ArticleType::getArticleTypeById($data['pid']);

        $title = $type ? $data['name'].'_'.$type['name'] : $data['name'];
        $this->setTitle($title.'—'.SITE_NAME);
       
        if(!$data['is_page']){//列表
        	$page = isset ( $_GET ['page'] ) ? intval ( $_GET ['page'] ) : 1;
	    	$where = ' WHERE pid='.$pid ; 
			$selarr = array ('`id`','`title`','`addtime`' );
			$order = ' ORDER BY `addtime` DESC';
			$res = \Common\Pager::getList ( 'article', $where, $selarr, $order, $page, 10);
			$dataList = array();
			foreach ($res ['data'] as $row){
				$dataList[] = $row;
			}
			
			$this->assign('pager', $res ['pager']);
	    	$this->assign('dataList', $dataList);
        }
        $this->assign('pid',$pid);
        $this->assign('data',$data);
        $this->assign('menuList',$menuList);
        $this->template ( 'page.php' );
	}
	
	//文章详细页
	public function show(){
		$id = isset($_GET['id']) ? intval($_GET['id']) : 0;
        $menuList = \Model\Admin\ArticleType::getMenuList();
        $data = \Model\Admin\Article::getArticleById($id);
		if (!$data){
			$this->fontRedirect('该内容未审核或不存在！', '/');
		}
        $type = \Model\Admin\ArticleType::getArticleTypeById($data['pid']);
        $data['name'] = $type['name'];
        $this->setTitle($data['title'].'—'.SITE_NAME);
       
        $this->assign('pid',$data['pid']);
        $this->assign('data',$data);
        $this->assign('menuList',$menuList);
        $this->template ( 'show.php' );
	}
	
	//帮助中心
	public function help(){
		$this->setTitle('帮助中心—'.SITE_NAME);
        
        $typeList = \Model\Admin\ArticleType::getArticleTypeList(6);
        $this->assign('typeList',$typeList);
        $this->template ( 'help.php' );
	}
	
	//帮助中心详细
	public function detail(){
		$pid = isset($_GET['pid']) ? intval($_GET['pid']) : 19;
		$id = isset($_GET['id']) ? intval($_GET['id']) : 34;
		$menuList = \Model\Admin\Article::getArticleList($pid);
		$type = \Model\Admin\ArticleType::getArticleTypeById($pid);
		
		if($pid==$id && $type['is_page']){
			$id = $menuList[0]['id'];
		}
		$data = \Model\Admin\Article::getArticleById($id);
		if (!$data){
			$this->fontRedirect('该内容未审核或不存在！', '/');
		}
		
        $this->setTitle($data['title'].'_帮助中心—'.SITE_NAME);

        $this->assign('id',$id);
         $this->assign('type',$type);
        $this->assign('menuList',$menuList);
        $this->assign('data',$data);
        $this->template ( 'detail.php' );
	}
	
	//帮助中心搜索页面
	public function search(){
		$keyword = isset($_GET['keyword']) ? \App::t($_GET['keyword']) : '';
		if($keyword){
			$articleList = \Model\Admin\Article::getArticleList(0,$keyword);
		}
		$title = $keyword ? $keyword.'_帮助中心搜索—'.SITE_NAME : '帮助中心搜索—'.SITE_NAME;
		$this->setTitle($title);
		$this->setKeywords('帮助中心,'.SITE_NAME.','.$keyword);
        $this->setDescription(SITE_NAME.'帮助中心搜索');
        
        $this->assign('articleList',$articleList);
        $this->assign('keyword',$keyword);
        $this->template ( 'search.php' );
	}
}



