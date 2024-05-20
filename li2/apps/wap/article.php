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

namespace apps\wap;

class article extends \core\Controller {

    //put your code here
    public function view() {
        parent::view();
        $pid = isset($_GET['pid']) ? intval($_GET['pid']) : 12;
        $menuList = \Model\Admin\ArticleType::getMenuList();
        $data = \Model\Admin\ArticleType::getArticleTypeById($pid);
        if (!$data) {
            $this->fontRedirect('该内容未审核或不存在！', '/');
        }
        $type = \Model\Admin\ArticleType::getArticleTypeById($data['pid']);

        $title = $type ? $data['name'] . '_' . $type['name'] : $data['name'];
        $this->setTitle($title . '—' . SITE_NAME);
        $pagesize = 10;
        if (!$data['is_page']) {//列表
            $page = isset($_GET ['page']) ? intval($_GET ['page']) : 1;
            $where = ' pid=' . $pid;
            $selarr = '`id`,`title`,`addtime`';
            $order = '`addtime` DESC';
            $res = \Model\Sys\Common::getTableRrcordList('article', $selarr, $where, $order, $page, $pagesize);
            $rowcount = \Model\Sys\Common::getTableRecordCount('article', $where);
            $this->assign('rowcount',$rowcount);
            $this->assign('pagesize',$pagesize);
            $this->assign('dataList', $res);
        }
        $this->assign('pid', $pid);
        $this->assign('data', $data);
        $this->assign('menuList', $menuList);
        $this->template('page.php');
    }
    public function view_data(){
        $pagesize = 10;
        $pid = isset($_REQUEST['pid']) ? intval($_REQUEST['pid']) : 12;
        $page = isset($_REQUEST ['page']) ? intval($_REQUEST ['page']) : 1;
        $where = ' pid=' . $pid;
        $selarr = '`id`,`title`,`addtime`';
        $order = ' `addtime` DESC';
        $res = \Model\Sys\Common::getTableRrcordList('article', $selarr, $where, $order, $page, $pagesize);
        $this->assign('dataList', $res);
        $this->template('page_data.php');
    }

    //文章详细页
    public function show() {
        $id = isset($_GET['id']) ? intval($_GET['id']) : 0;
        $menuList = \Model\Admin\ArticleType::getMenuList();
        $data = \Model\Admin\Article::getArticleById($id);
        if (!$data) {
            $this->fontRedirect('该内容未审核或不存在！', '/');
        }
        $type = \Model\Admin\ArticleType::getArticleTypeById($data['pid']);
        $data['name'] = $type['name'];
        $this->setTitle($data['title'] . '—' . SITE_NAME);

        $this->assign('pid', $data['pid']);
        $this->assign('data', $data);
        $this->assign('menuList', $menuList);
        $this->template('show.php');
    }

}
