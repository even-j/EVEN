<?php

namespace apps\admin;

use Common\Query;

class admin extends \apps\AdminControl {

    //管理员管理
    public function view() {
        $this->setTitle('管理员管理');
        $pagesize = 20;
        $curpage = isset($_GET ['page']) ? intval($_GET ['page']) : 1;
        $where = " WHERE user_name!='system'";
        $selarr = array();
        $order = ' ORDER BY addtime DESC,admin_id DESC';
        $res = \Common\Pager::getList('admin_user', $where, $selarr, $order, $curpage, $pagesize);
        $list = array();
        foreach ($res ['data'] as $row) {
            $row['role'] = \Model\Admin\Role::getRoleById($row['role_id']);
            $list [] = $row;
        }
        $this->assign('list', $list);
        $this->assign('pager', $res ['pager']);
        $this->template('view.php');
    }

    //添加管理员
    public function add() {
        $this->edit();
    }

    //编辑管理员
    public function edit() {
        $this->setTitle('编辑管理员');
        $admin_id = isset($_GET['admin_id']) ? intval($_GET['admin_id']) : 0;
        $nav_title = $admin_id > 0 ? '编辑管理员' : '添加管理员';
        $this->assign('nav_title', $nav_title);
        $adminInfo = \Model\Admin\User::getAdminInfo(array('admin_id' => $admin_id));
        $roles = \Model\Admin\Role::getRoleList();
        $shopList = \Model\Admin\BusShop::getShopList();
        $this->assign('roles', $roles);
        $this->assign('adminInfo', $adminInfo);
        $this->assign('shopList', $shopList);
        $this->template('edit.php');
    }

    //删除管理员
    public function del() {
        $admin_id = isset($_GET['admin_id']) ? intval($_GET['admin_id']) : 0;
        $url = '/index.php?app=admin&mod=admin&ac=view';
        if ($admin_id > 0 && $admin_id != 2) {
            $res = \Model\Admin\User::delAdmin($admin_id);
            $this->sysRedirect($url);
        } else {
            $this->fontRedirect('删除失败', $url);
        }
    }

    //保存数据
    public function doEdit() {
        if ($_POST ['submit']) {
            $admin_id = isset($_POST['admin_id']) ? intval($_POST['admin_id']) : 0;
            $role_id = isset($_POST['role_id']) ? intval($_POST['role_id']) : 0;
            $real_name = \App::t($_POST['real_name']);
            $user_name = \App::t($_POST['user_name']);
            $mobile = isset($_POST['mobile']) ? \App::t($_POST['mobile']) : '';
            $pwd = $_POST['pwd'];
            $shop_id = isset($_POST['shop_id']) ? intval($_POST['shop_id']) : 0;

            $arr = array('real_name' => $real_name, 'user_name' => $user_name, 'pwd' => $pwd, 'role_id' => $role_id, 'mobile' => $mobile, 'shop_id' => $shop_id);

            $url = '/index.php?app=admin&mod=admin&ac=view';
            if ($real_name && $user_name && $pwd) {
                if ($admin_id > 0) {//修改
                    $arr['admin_id'] = $admin_id;
                    $res = \Model\Admin\User::modifyAdmin($arr);
                } else {
                    $res = \Model\Admin\User::adduser($arr);
                }
                $this->fontRedirect($res['msg'], $url);
            } else {
                $this->fontRedirect('参数提交错误', $url);
            }
        }
    }

    //用户余额
    public function balance() {
        $this->setNavtitle('用户余额');
        $uid = isset($_GET ['uid']) ? intval($_GET ['uid']) : 0;
        $user = \Model\User\UserInfo::getinfo($uid);
        $this->assign('user', $user);
        $this->template('balance.php');
    }

    //用户余额操作
    public function doPay() {
        if ($_POST ['submit']) {
            $uid = isset($_POST ['uid']) ? intval($_POST ['uid']) : 0;
            $type = isset($_POST ['type']) ? intval($_POST ['type']) : 0;
            $cur_balance = isset($_POST ['cur_balance']) ? floatval($_POST ['cur_balance']) : 0;
            $balance = isset($_POST ['balance']) ? floatval($_POST ['balance']) : 0;
            $url = '/index.php?app=admin&mod=user&ac=view';
            if ($balance <= 0) {
                $this->fontRedirect('参数提交有误', $url);
            }
            if ($uid && $type) {
                if ($type == 14) {
                    $res = \Model\User\Fund::rechargeSys($uid, $balance * 100);
                    if(isset($_POST ['add_record']) && $_POST ['add_record']=='on'){
                        if($res[0]==1){
                            $r = \Model\User\RechargeOffline::add($uid, $balance * 100, '后台充值', '后台充值', 1);
                        }
                    }
                } elseif ($type == 15) {
                    $res = \Model\User\Fund::withdrawSys($uid, $balance * 100);
                    if(isset($_POST ['add_record']) && $_POST ['add_record']=='on'){
                        if($res[0]==1){
                            $card = \Model\User\BankCard::getByUid($uid);
                            \Model\User\Withdraw::add($uid, $balance * 100, $card['card_id'], 2);
                        }
                    }
                } elseif ($type == 100) {
                    $res = \Model\User\Fund::send($uid, $balance * 100);
                } elseif ($type == 102) {
                    $res = \Model\User\Fund::sendMinus($uid, $balance * 100);
                }
                $this->fontRedirect($res[1], $url);
            } else {
                $this->fontRedirect('参数提交有误', $url);
            }
        }
    }

    //修改密码
    public function password() {
        $this->setTitle('修改密码');
        $msg = '';
        if ($_POST) {
            $oldpwd = $_POST ['oldpwd'];
            $pwd = $_POST ['pwd'];
            $arr = array('admin_id' => $this->adminid, 'oldpwd' => $oldpwd, 'pwd' => $pwd);
            $res = \Model\Admin\User::changePassword($arr);
            if ($res ['code'] == '-1') {
                $msg = '密码修改失败，数据未更新！';
            } else {
                $msg = $res ['msg'];
            }
        }
        $this->assign('msg', $msg);
        $this->template('password.php');
    }

}

?>