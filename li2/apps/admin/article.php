<?php

namespace apps\admin;

class article extends \apps\AdminControl {

    //文章管理
    public function view() {
        $this->setTitle('文章管理');
        $page = isset($_GET ['page']) ? intval($_GET ['page']) : 1;
        $where = ' WHERE 1=1';
        if (!empty($_GET ['title'])) {
            $where .= " and `title` like '%" . \App::t($_GET ['title']) . "%'";
        }

        $pid = isset($_GET['pid']) ? intval($_GET['pid']) : 0;
        if ($pid > 0) {
            $child = \Model\Admin\ArticleType::getMenuList($pid);
            foreach ($child as $item) {
                $pid .= ',' . $item['id'];
            }
        }
        if (isset($_GET['pid']) && $_GET['pid'] != 0) {
            $where .= " and `pid` in ( " . $pid . " )";
        }
        if (isset($_GET['status']) && $_GET['status'] != '') {
            $where .= " and `status`= " . intval($_GET['status']);
        }

        if (isset($_GET['flag']) && $_GET['flag'] != '') {
            $where .= " and findAdmin_in_set('" . \App::t($_GET['flag']) . "',flag)";
        }

        $selarr = array('`id`', '`uid`', '`pid`', '`title`', '`order`', '`status`', '`addtime`', '`flag`');
        $order = ' ORDER BY `order` ASC,`addtime` DESC';
        $res = \Common\Pager::getList('article', $where, $selarr, $order, $page, 20);

        $dataList = array();
        $status = array(
            1 => '<span class="green">已发布</span>',
            2 => '<span class="blue">草稿</span>',
            3 => '<span class="red">等待审核</span>',
        );

        $flagArr = array(
            'index' => '首页',
            'recommend' => '推荐',
            'top' => '置顶',
        );

        foreach ($res ['data'] as $data) {
            $flag = '';
            if ($data['flag']) {
                foreach (explode(',', $data['flag']) as $key => $val) {
                    $flag .= '<span class="flag' . $key . '">[' . $flagArr[$val] . ']</span>&nbsp;';
                }
            }
            $data['flag'] = $flag;
            $data['cate'] = \Model\Admin\ArticleType::getArticleTypeById($data['pid']);
            $data['user'] = $data['uid'] > 0 ? \Model\Admin\User::getAdminInfo(array('admin_id' => $data['uid'])) : array('real_name' => '管理员');
            $data['o_status'] = $status[$data['status']];
            $dataList[] = $data;
        }

        $cateList = \Model\Admin\ArticleType::getArticleTypeList();

        $this->assign('flagArr', $flagArr);
        $this->assign('cateList', $cateList);
        $this->assign('pager', $res ['pager']);
        $this->assign('dataList', $dataList);
        $this->template('view.php');
    }

    //文章添加
    public function add() {
        $this->edit();
    }

    //文章编辑
    public function edit() {
        $id = isset($_GET['id']) ? intval($_GET['id']) : '0';
        $nav_title = $id > 0 ? '编辑文章' : '添加文章';
        $data = \Model\Admin\Article::getArticleById($id);
        if ($data['flag']) {
            $data['flag'] = explode(',', $data['flag']);
        }

        $cateList = \Model\Admin\ArticleType::getArticleTypeList();
        $status = array(
            1 => '发布',
            2 => '草稿',
            3 => '等待审核',
        );

        $flagArr = array(
            'index' => '首页',
            'recommend' => '推荐',
            'top' => '置顶',
        );

        $this->assign('flagArr', $flagArr);
        $this->assign('status', $status);
        $this->assign('cateList', $cateList);
        $this->assign('nav_title', $nav_title);
        $this->assign('data', $data);
        $this->template('edit.php');
    }

    //文章编辑处理
    public function doEdit() {
        $url = '/index.php?app=admin&mod=article&ac=view';
        if ($_POST) {
            $id = isset($_POST['id']) ? intval($_POST['id']) : 0;
            $title = isset($_POST['title']) ? $_POST['title'] : '';
            $order = isset($_POST['order']) ? intval($_POST['order']) : 0;
            $pid = isset($_POST['pid']) ? intval($_POST['pid']) : 0;
            $uid = $this->adminid;
            $contents = isset($_POST['contents']) ? htmlspecialchars($_POST['contents']) : '';
            $flag = isset($_POST['flag']) ? implode(',', $_POST['flag']) : '';
            $tags = isset($_POST['tags']) ? ($_POST['tags']) : '';
            $description = isset($_POST['description']) ? ($_POST['description']) : '';
            $status = isset($_POST['status']) ? intval($_POST['status']) : 1;
            $addtime = isset($_POST['addtime']) ? strtotime($_POST['addtime']) : time();

            $arr = array(
                'title' => $title,
                'order' => $order,
                'pid' => $pid,
                'uid' => $uid,
                'contents' => $contents,
                'flag' => $flag,
                'tags' => $tags,
                'description' => $description,
                'status' => $status,
                'addtime'=>$addtime
            );
            $res = array();
            if ($id > 0) {//编辑
                $arr['id'] = $id;
                $res = \Model\Admin\Article::editArticle($arr);
            } else {//新增
                $res = \Model\Admin\Article::addArticle($arr);
            }

            if ($res['code'] > 0) {
                $this->fontRedirect($res['msg'], $url);
            } else {
                $this->fontRedirect('操作失败！', $url);
            }
        } else {
            $this->fontRedirect('提交方式不正确', $url);
        }
    }

    //文章删除
    public function del() {
        $id = isset($_GET['id']) ? intval($_GET['id']) : '0';
        $url = '/index.php?app=admin&mod=article&ac=view';
        if ($id > 1) {
            $res = \Model\Admin\Article::delArticle(array('id' => $id));
            $this->sysRedirect($url);
        } else {
            $this->fontRedirect('删除失败', $url);
        }
    }

    //ajax 排序
    public function ajaxSort() {
        $res = array('code' => 0, 'msg' => '操作失败');
        if ($_POST) {
            $ids = isset($_POST['ids']) ? array_filter(explode(',', $_POST['ids'])) : array();
            $order = isset($_POST['order']) ? explode(',', $_POST['order']) : array();

            if ($ids && $order) {
                foreach ($ids as $key => $id) {
                    \Model\Admin\Article::editArticle(array('id' => $id, 'order' => $order[$key]), 1);
                }
                $res['code'] = 1;
            }
        } else {
            $res['msg'] = '参数非法提交';
        }
        exit(json_encode($res));
    }

    //ajax 删除
    public function ajaxDel() {
        $res = array('code' => 0, 'msg' => '操作失败');
        if ($_POST) {
            $ids = isset($_POST['id']) ? array_filter(explode(',', $_POST['id'])) : array();
            if ($ids) {
                foreach ($ids as $id) {
                    \Model\Admin\Article::delArticle(array('id' => $id));
                }
                $res['code'] = 1;
            }
        } else {
            $res['msg'] = '参数非法提交';
        }
        exit(json_encode($res));
    }

}

?>