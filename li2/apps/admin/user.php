<?php

namespace apps\admin;

use Common\Query;

class user extends \apps\AdminControl {

    //put your code here
    public function view() {
        $this->setTitle('用户管理');
        $pagesize = 20;
        $curpage = isset($_GET ['page']) ? intval($_GET ['page']) : 1;
        $where = ' WHERE `user`.status!=3';
        if (!empty($_GET ['uid'])) {
            $where .= is_numeric($_GET ['uid']) ? ' and `user`.uid=' . intval($_GET ['uid']) : " and `user`.true_name like '%" . $_GET ['uid'] . "%'";
        }
        if (!empty($_GET ['mobile'])) {
            $where .= " and `user`.mobile like '%" . \App::t($_GET ['mobile']) . "%'";
        }
//        if (isset($_GET ['is_audit']) && $_GET ['is_audit'] != '') {
//            $where .= " and bank.is_audit= " . intval($_GET ['is_audit']);
//        }
        //实名认证
        if (isset($_GET ['is_realname']) && $_GET ['is_realname'] !== '') {
            $where .= $_GET ['is_realname'] ? " and `user`.true_name !='' " : " and `user`.true_name is null";
        }

        //银行卡绑定
        if (isset($_GET ['is_bankbind']) && $_GET ['is_bankbind'] !== '') {
            $where .= $_GET ['is_bankbind'] ? " and `bank`.card_id !='' " : " and `bank`.card_id is null";
        }

        //免费体验
        if (isset($_GET ['is_free']) && $_GET ['is_free'] !== '') {
            $where .= $_GET ['is_free'] ? " and `up`.pz_type =4 " : " and `up`.pz_type !=4";
        }

        //按日配资
        if (isset($_GET ['is_day']) && $_GET ['is_day'] !== '') {
            $where .= $_GET ['is_day'] ? " and `up`.pz_type =1 " : " and `up`.pz_type !=1";
        }
        //按月配资
        if (isset($_GET ['is_month']) && $_GET ['is_month'] !== '') {
            $where .= $_GET ['is_month'] ? " and `up`.pz_type =2 " : " and `up`.pz_type !=2";
        }

        //状态
        if (isset($_GET ['status']) && $_GET ['status'] !== '') {
            if ($_GET ['status'] == '0') {
                $where .= " and `user`.status!=1";
            } elseif ($_GET ['status'] == '1') {
                $where .= " and `user`.status=1";
            }
        }

        //代理手机号
        if (isset($_GET ['agent_mobile']) && $_GET ['agent_mobile'] !== '') {
            $where .= " and (`agent`.mobile='" . $_GET ['agent_mobile'] . "')";
        }
        
        if (!empty($_GET ['group_id'])) {
            $where .= " and `user`.group_id =" . intval($_GET ['group_id']) ;
        }

        $selarr = array('distinct `user`.*');
        $order = ' ORDER BY `user`.uid DESC';
        $res = \Common\Pager::getList('user_info AS `user` ', $where, $selarr, $order, $curpage, $pagesize, 1, '');
        if (isset($_GET ['agent_mobile']) && $_GET ['agent_mobile'] != '') {
            $res = \Common\Pager::getList('user_info AS `user` left join user_info agent on `user`.introducer_id=agent.uid', $where, $selarr, $order, $curpage, $pagesize, 1, '');
        }
        if ((isset($_GET ['is_bankbind']) && $_GET ['is_bankbind'] != '') ) {
           $res = \Common\Pager::getList('user_info AS `user` LEFT JOIN user_bankcard AS bank ON `user`.uid=bank.uid ', $where, $selarr, $order, $curpage, $pagesize, 1, ' GROUP BY `user`.uid');
        }
        if ((isset($_GET ['is_free']) && $_GET ['is_free'] != '') || (isset($_GET ['is_day']) && $_GET ['is_day'] != '') || (isset($_GET ['is_month']) && $_GET ['is_month'] != '')) {
            $res = \Common\Pager::getList('user_info AS `user` LEFT JOIN user_bankcard AS bank ON `user`.uid=bank.uid LEFT JOIN user_peizi up ON `user`.uid=up.uid ', $where, $selarr, $order, $curpage, $pagesize, 1, ' GROUP BY `user`.uid');
        }
        //$res = \Common\Pager::getList('user_info AS `user` LEFT JOIN user_bankcard AS bank ON `user`.uid=bank.uid LEFT JOIN user_peizi up ON `user`.uid=up.uid LEFT JOIN user_peizi_touzi ut ON up.pz_id=ut.pz_id left join user_info agent on `user`.introducer_id=agent.uid', $where, $selarr, $order, $curpage, $pagesize, 1, ' GROUP BY `user`.uid');
        $list = array();
        $status = array(0 => '<span class="red">不可用</span>', 1 => '<span class="green">可用</span>', 2 => '<span class="grayc">冻结</span>');
        $bank_status = array(0 => '<span class="red">待审核</span>', 1 => '<span class="green">已绑定</span>', 2 => '<span class="red">审核未通过</span>');
        foreach ($res ['data'] as $row) {
            if ((isset($_GET ['is_bankbind']) && $_GET ['is_bankbind'] != '') ) {
                if($_GET ['is_bankbind'] == 0)
                {
                    $row ['bank_status']='未设置';
                }
                else if($_GET ['is_bankbind'] == 1)
                {
                     $row ['bank_status']='<span class="green">已绑定</span>';
                }
            }
            else{
                $bank_card = \Model\User\BankCard::getByUid($row ['uid']);
                $row ['bank_status'] = $bank_card ? $bank_status [$bank_card ['is_audit']] : '未设置';
            }
            $user= \Model\User\UserInfo::getinfo($row ['introducer_id']);
            $row ['true_name'] = $row ['true_name'] ? $row ['true_name'] : '未设置';
            $row ['id_card'] = $row ['id_card'] ? substr_replace($row ['id_card'], '******', 6, 8) : '未设置';
            //$row ['bank_status'] = $bank_card ? $bank_status [$row ['is_audit']] : '未设置';            
            $row ['user_status'] = $status [$row ['status']];
            $row ['agent_mobile']=$user['mobile'];
            $list [] = $row;
        }
        $group_list= \Model\User\Group::getList();
        $this->assign('where', $where);
        $this->assign('list', $list);
        $this->assign('group_list',$group_list);
        $this->assign('pager', $res ['pager']);
        $this->template('index.php');
    }

    //查看用户信息
    public function info() {
        $uid = isset($_GET ['uid']) ? intval($_GET ['uid']) : 0;
        $user = \Model\User\UserInfo::getinfo($uid);
        $bank_card = \Model\User\BankCard::getByUid($uid);
        $user ['bank_card'] = $bank_card;
        $this->assign('user', $user);
        $this->template('info.php');
    }

    //修改用户信息
    public function edit() {
        $this->setNavtitle('修改用户信息');
        $uid = isset($_GET ['uid']) ? intval($_GET ['uid']) : 0;
        $user = \Model\User\UserInfo::getinfo($uid);
        $bank_card = \Model\User\BankCard::getByUid($uid);
        $user ['bank_card'] = $bank_card;
        $bankList = \Model\Sys\AccountBank::getBanks();
        $province = \Model\Sys\Area::getProvinces();
        $bank_status = array(0 => '待审核', 1 => '审核通过', 2 => '审核未通过');
        //$status = array(0=>'停用',1=>'启用');
        //$this->assign('status',$status);
        //推荐人
        $introducer = array();
        if ($user['introducer_id']) {
            $introducer = \Model\User\UserInfo::getinfo($user['introducer_id']);
        }
        
        //分组信息
        $group_list= \Model\User\Group::getList();
        $this->assign('group_list',$group_list);
        
        $this->assign('bank_status', $bank_status);
        $this->assign('bankList', $bankList);
        $this->assign('province', $province);
        $this->assign('user', $user);
        $this->assign('introducer', $introducer);
        $this->template('edit.php');
    }

    //修改用户信息
    public function doEdit() {
        if ($_POST) {
            $res = 0;
            $uid = isset($_POST ['uid']) ? intval($_POST ['uid']) : 0;
            $id_card = isset($_POST ['id_card']) ? \App::t($_POST ['id_card']) : '';
            $true_name = isset($_POST ['true_name']) ? \App::t($_POST ['true_name']) : '';
            $mobile = isset($_POST ['mobile']) ? \App::t($_POST ['mobile']) : '';
            $group_id=isset($_POST ['group_id']) ? \App::t($_POST ['group_id']) : 1;
            
            //银行卡信息
            $is_audit = isset($_POST ['is_audit']) ? intval($_POST ['is_audit']) : 0;
            $bank_name = isset($_POST ['bank_name']) ? \App::t($_POST ['bank_name']) : '';
            $province_id = isset($_POST ['province_id']) ? intval($_POST ['province_id']) : 0;
            $city_id = isset($_POST ['city_id']) ? intval($_POST ['city_id']) : 0;
            $card_no = isset($_POST ['card_no']) ? \App::t($_POST ['card_no']) : '';
            $province_name = isset($_POST ['province_name']) ? \App::t($_POST ['province_name']) : '';
            $city_name = isset($_POST ['city_name']) ? \App::t($_POST ['city_name']) : '';
            $card_id = isset($_POST ['card_id']) ? intval($_POST ['card_id']) : 0;
            //$status = isset($_POST['status']) ? intval($_POST['status']) : 0;
            $demo = isset($_POST ['demo']) ? \App::t($_POST ['demo']) : '';
            $bank_card = \Model\User\BankCard::getByUid($uid);

            if ($uid && $id_card && $true_name && $mobile) { //修改身份信息
                $res2 = \Model\User\UserInfo::bindInfo($uid, $true_name, $id_card, $mobile);
            }

            if ($province_id && $city_id && $card_no && $bank_name) {

                if ($bank_card) { //修改银行卡信息
                    $updarr = array();
                    $updarr ['is_audit'] = $is_audit;
                    $updarr ['bank_name'] = $bank_name;
                    $updarr ['province_id'] = $province_id;
                    $updarr ['city_id'] = $city_id;
                    $updarr ['card_no'] = $card_no;
                    $updarr ['province_name'] = $province_name;
                    $updarr ['city_name'] = $city_name;
                    if ($is_audit == 2) {
                        $updarr ['demo'] = $demo;
                    }
                    //$updarr['status'] = $status;
                    $res = \Model\User\BankCard::edit($updarr, $card_id);
                } else {
                    $res = \Model\User\BankCard::add($uid, $province_id, $province_name, $city_id, $city_name, $card_no, $bank_name);
                }
            }
            /* else {
              $this->fontRedirect ( '参数错误！', '/index.php?app=admin&mod=user&ac=view' );
              } */

            $introducer_mobile = isset($_POST ['introducer_mobile']) ? \App::t($_POST ['introducer_mobile']) : '';
            if ($introducer_mobile) {
                //更新推荐人
                $introducer = \Model\User\UserInfo::getByMobile($introducer_mobile);
                if ($introducer) {
                    $updarr = array(
                        'uid' => $uid,
                        'introducer_id' => $introducer['uid']
                    );
                    $res = \Model\User\UserInfo::modifyUserInfo($updarr);
                }
            } else {
                //删除推荐人
                $updarr = array(
                    'uid' => $uid,
                    'introducer_id' => 0
                );
                $res = \Model\User\UserInfo::modifyUserInfo($updarr);
            }
            //更新其它
            $level = isset($_POST ['level']) ? intval($_POST ['level']) : '';
            $updarr = array(
                'uid' => $uid,
                'level' => $level,
                'vip_start_time' => date('Y-m-d H:i:s'),
                'vip_end_time' => date('Y-m-d H:i:s', strtotime('+6 month')),
                'group_id'=>$group_id
            );
           
            $res = \Model\User\UserInfo::modifyUserInfo($updarr);

            if ($res > 0 || $res2 > 0) {
                $this->fontRedirect('用户信息已更新', '/index.php?app=admin&mod=user&ac=view&uid=' . $uid);
            } else {
                $this->fontRedirect('用户信息更新失败', '/index.php?app=admin&mod=user&ac=view');
            }
        }
    }

    public function del() {
        $uid = isset($_GET ['uid']) ? intval($_GET ['uid']) : 0;
        $res = \Model\User\UserInfo::del($uid);
        if ($res > 0) {
            $this->fontRedirect('删除成功', '/index.php?app=admin&mod=user&ac=view');
        } else {
            $this->fontRedirect('删除失败', '/index.php?app=admin&mod=user&ac=view');
        }
    }

//    public function modpwd(){
//        $this->setNavtitle ( '修改密码' );
//		$mobile = isset ( $_GET ['mobile'] ) ? intval ( $_GET ['mobile'] ) : '';
//		$this->assign ( 'mobile', $mobile );
//		$this->template ( 'modpwd.php' );
//    }
    public function domodpwd() {
        $this->setTitle('修改密码');
        $msg = '';
        $mobile = $_GET['mobile'];
        if ($_POST) {
            if (empty($mobile)) {
                $mobile = $_POST['mobile'];
            }
            $pwd = $_POST ['pwd'];
            $repwd = $_POST ['repwd'];
            if ($pwd != $repwd) {
                $msg = '两次密码输入不一样！';
            }
            $res = \Model\User\UserInfo::pwdReset($mobile, $pwd);
            if ($res [0] != 1) {
                $msg = '密码修改失败！';
            } else {
                $msg = '密码修改成功';
            }
        }
        $this->assign('mobile', $mobile);
        $this->assign('msg', $msg);
        $this->template('modpwd.php');
    }

    public function dofrozen() {
        $uid = isset($_GET ['uid']) ? intval($_GET ['uid']) : 0;
        $res = \Model\User\UserInfo::frozen($uid);
        if ($res > 0) {
            $this->fontRedirect('冻结成功', 'back');
        } else {
            $this->fontRedirect('冻结失败', 'back');
        }
    }

    public function dounfrozen() {
        $uid = isset($_GET ['uid']) ? intval($_GET ['uid']) : 0;
        $res = \Model\User\UserInfo::unfrozen($uid);
        if ($res > 0) {
            $this->fontRedirect('解冻成功', 'back');
        } else {
            $this->fontRedirect('解冻失败', 'back');
        }
    }

    //给用户发短信
    public function telmsg() {
        $this->setNavtitle('发送短信');
        $uid = isset($_GET ['uid']) ? intval($_GET ['uid']) : 0;
        $user = \Model\User\UserInfo::getinfo($uid);
        $this->assign('user', $user);
        $this->template('telmsg.php');
    }

    //给用户发短信
    public function sendTelmsg() {
        $mobile = isset($_POST ['mobile']) ? $_POST ['mobile'] : '';
        $con = isset($_POST ['con']) ? $_POST ['con'] : '';
        if ($mobile != '' && $con != '') {
            $res = \Model\Api\Sms::smsSend($mobile, $con);
            if ($res) {
                $this->fontRedirect('发送成功', 'back', 3);
            } else {
                $this->fontRedirect('发送失败', 'back', 3);
            }
        } else {
            $this->fontRedirect('发送失败', 'back', 3);
        }
    }

    //群发短信编辑
    public function sms() {
        $this->setNavtitle('群发短信');
        $where = ' WHERE 1=1';
        if (!empty($_GET ['uid'])) {
            $where .= is_numeric($_GET ['uid']) ? ' and `user`.uid=' . intval($_GET ['uid']) : " and `user`.true_name like '%" . $_GET ['uid'] . "%'";
        }
        if (!empty($_GET ['mobile'])) {
            $where .= " and `user`.mobile like '%" . \App::t($_GET ['mobile']) . "%'";
        }
        if (isset($_GET ['is_audit']) && $_GET ['is_audit'] != '') {
            $where .= " and bank.is_audit= " . intval($_GET ['is_audit']);
        }
        //实名认证
        if (isset($_GET ['is_realname']) && $_GET ['is_realname'] != '') {
            $where .= $_GET ['is_realname'] ? " and `user`.true_name !='' " : " and `user`.true_name is null";
        }

        //银行卡绑定
        if (isset($_GET ['is_bankbind']) && $_GET ['is_bankbind'] != '') {
            $where .= $_GET ['is_bankbind'] ? " and `bank`.card_id !='' " : " and `bank`.card_id is null";
        }

        //免费体验
        if (isset($_GET ['is_free']) && $_GET ['is_free'] != '') {
            $where .= $_GET ['is_free'] ? " and `up`.pz_type =4 " : " and `up`.pz_type !=4";
        }

        //按日配资
        if (isset($_GET ['is_day']) && $_GET ['is_day'] != '') {
            $where .= $_GET ['is_day'] ? " and `up`.pz_type =1 " : " and `up`.pz_type !=1";
        }

        //p2p配资
        if (isset($_GET ['is_p2p_pz']) && $_GET ['is_p2p_pz'] != '') {
            $where .= $_GET ['is_p2p_pz'] ? " and `up`.pz_type =3 " : " and `up`.pz_type !=3";
        }

        //操盘贷
        if (isset($_GET ['is_cpd']) && $_GET ['is_cpd'] != '') {
            $where .= $_GET ['is_cpd'] ? " and `up`.pz_type =5 " : " and `up`.pz_type !=5";
        }

        //p2p投注
        if (isset($_GET ['is_p2p_tz']) && $_GET ['is_p2p_tz'] != '') {
            $where .= $_GET ['is_p2p_tz'] ? " and `ut`.tz_id !='' " : " and `ut`.tz_id is null";
        }

        //投操盘
        if (isset($_GET ['is_tcp']) && $_GET ['is_tcp'] != '') {
            $where .= $_GET ['is_tcp'] ? " and (`ut`.fencheng_money=0)" : " and `ut`.fencheng_money>0 ";
        }

        if (isset($_GET ['status']) && $_GET ['status'] != '') {
            $where .= " and `up`.pz_type >0";
        }
        $sql = "SELECT `user`.mobile FROM user_info AS `user` LEFT JOIN user_bankcard AS bank ON `user`.uid=bank.uid LEFT JOIN user_peizi up ON `user`.uid=up.uid LEFT JOIN user_peizi_touzi ut ON up.pz_id=ut.pz_id " . $where . " GROUP BY `user`.uid ";
        $users = \Common\Query::sqlsel($sql);
        $mobile = '';
        foreach ($users as $key => $user) {
            $mobile .= $user ['mobile'] . ',';
        }
        $this->assign('mobile', $mobile);
        $this->template('sms.php');
    }

    //群发短信
    public function dosms() {
        $content = isset($_POST ['content']) ? $_POST ['content'] : '';
        $mobile = isset($_POST ['mobile']) ? $_POST ['mobile'] : '';
        $users = $mobile ? array_filter(explode(',', $mobile)) : array();
        if ($content) {
            $msg = '';
            foreach ($users as $key => $mobile) {
                if ($mobile) {
                    $info = \Model\Api\Sms::smsSend($mobile, $content) ? '<span style="color:green;">短信发送成功</span>' : '<span style="color:red;">短信发送失败</span>';
                    $msg .= ($key + 1) . '、手机用户：【' . $mobile . '】' . $info . '！<br/>';
                }
            }
            exit($msg);
        } else {
            $this->fontRedirect('群内内容不能为空', 'back', 3);
        }
    }

    //获得城市
    public function ajaxregion() {
        if ($_GET) {
            $provinceId = $_GET ['provinceId'] ? intval($_GET ['provinceId']) : 0;
            $citys = \Model\Sys\Area::getCitys($provinceId);
            exit(json_encode($citys));
        }
    }

    //检查用户名是否存在
    public function ajaxCheckUserName() {
        $res = array('status' => 0);
        if ($_POST) {
            $user_name = $_POST ['user_name'];
            if (\Model\Admin\User::checkname($user_name)) {
                $res ['status'] = 1;
            }
        }
        exit(json_encode($res));
    }

    //添加用户
    public function add() {
        $this->setTitle('添加用户');
        $this->template('add.php');
    }

    //添加用户
    public function doadd() {
        if ($_POST) {
            $id_card = isset($_POST ['id_card']) ? \App::t($_POST ['id_card']) : '';
            $true_name = isset($_POST ['true_name']) ? \App::t($_POST ['true_name']) : '';
            $mobile = isset($_POST ['mobile']) ? \App::t($_POST ['mobile']) : '';
            $password = isset($_POST ['password']) ? \App::t($_POST ['password']) : '';
            $res = \Model\User\UserInfo::add($mobile, $password, $true_name, $id_card);
            if ($res > 0) {
                $this->fontRedirect('用户添加成功', '/index.php?app=admin&mod=user&ac=view');
            } else {
                $this->fontRedirect('用户添加失败', '/index.php?app=admin&mod=user&ac=view');
            }
        }
    }

    /**
     * 用户查询列表
     */
    public function search_list() {
        $this->setTitle('用户管理');
        $pagesize = 20;
        $curpage = isset($_GET ['page']) ? intval($_GET ['page']) : 1;
        $where = ' WHERE 1=1';
        if (!empty($_GET ['uid'])) {
            $where .= ' and uid=' . intval($_GET ['uid']);
        }
        if (!empty($_GET ['nick'])) {
            $where .= " and nick like '%" . \App::t($_GET ['nick']) . "%'";
        }
        if (!empty($_GET ['mobile'])) {
            $where .= " and mobile like '%" . \App::t($_GET ['mobile']) . "%'";
        }
        $selarr = array();
        $order = ' ORDER BY uid DESC';
        $res = \Common\Pager::getList('user_info', $where, $selarr, $order, $curpage, $pagesize);
        $this->assign('list', $res ['data']);
        $this->assign('pager', $res ['pager']);
        $this->template('search_list.php');
    }

//    public function exportdata() {
//        $where = ' WHERE `user`.status!=3';
//        if (!empty($_GET ['uid'])) {
//            $where .= is_numeric($_GET ['uid']) ? ' and `user`.uid=' . intval($_GET ['uid']) : " and `user`.true_name like '%" . $_GET ['uid'] . "%'";
//        }
//        if (!empty($_GET ['mobile'])) {
//            $where .= " and `user`.mobile like '%" . \App::t($_GET ['mobile']) . "%'";
//        }
//        if (isset($_GET ['is_audit']) && $_GET ['is_audit'] != '') {
//            $where .= " and bank.is_audit= " . intval($_GET ['is_audit']);
//        }
//        //实名认证
//        if (isset($_GET ['is_realname']) && $_GET ['is_realname'] != '') {
//            $where .= $_GET ['is_realname'] ? " and `user`.true_name !='' " : " and `user`.true_name is null";
//        }
//
//        //银行卡绑定
//        if (isset($_GET ['is_bankbind']) && $_GET ['is_bankbind'] != '') {
//            $where .= $_GET ['is_bankbind'] ? " and `bank`.card_id !='' " : " and `bank`.card_id is null";
//        }
//
//        //免费体验
//        if (isset($_GET ['is_free']) && $_GET ['is_free'] != '') {
//            $where .= $_GET ['is_free'] ? " and `up`.pz_type =4 " : " and `up`.pz_type !=4";
//        }
//
//        //按日配资
//        if (isset($_GET ['is_day']) && $_GET ['is_day'] != '') {
//            $where .= $_GET ['is_day'] ? " and `up`.pz_type =1 " : " and `up`.pz_type !=1";
//        }
//
//        //p2p配资
//        if (isset($_GET ['is_p2p_pz']) && $_GET ['is_p2p_pz'] != '') {
//            $where .= $_GET ['is_p2p_pz'] ? " and `up`.pz_type =3 " : " and `up`.pz_type !=3";
//        }
//
//        //操盘贷
//        if (isset($_GET ['is_cpd']) && $_GET ['is_cpd'] != '') {
//            $where .= $_GET ['is_cpd'] ? " and `up`.pz_type =5 " : " and `up`.pz_type !=5";
//            ;
//        }
//
//        //p2p投注
//        if (isset($_GET ['is_p2p_tz']) && $_GET ['is_p2p_tz'] != '') {
//            $where .= $_GET ['is_p2p_tz'] ? " and `ut`.tz_id !='' " : " and `ut`.tz_id is null";
//        }
//
//        //投操盘
//        if (isset($_GET ['is_tcp']) && $_GET ['is_tcp'] != '') {
//            $where .= $_GET ['is_tcp'] ? " and (`ut`.fencheng_money=0)" : " and `ut`.fencheng_money>0 ";
//        }
//
//        //状态
//        if (isset($_GET ['status']) && $_GET ['status'] !== '') {
//            if ($_GET ['status'] == '0') {
//                $where .= " and `user`.status!=1";
//            } elseif ($_GET ['status'] == '1') {
//                $where .= " and `user`.status=1";
//            }
//        }
//
//        //代理手机号
//        if (isset($_GET ['agent_mobile']) && $_GET ['agent_mobile'] != '') {
//            $where .= " and (`agent`.mobile='" . $_GET ['agent_mobile'] . "')";
//        }
//
//        if (isset($_GET ['status']) && $_GET ['status'] != '') {
//            $where .= " and `up`.pz_type >0";
//        }
//        $selarr = array('distinct `user`.*', 'bank.is_audit', 'agent.mobile agent_mobile');
//        $order = ' ORDER BY `user`.uid DESC, bank.card_id ASC';
//        $groupby = ' GROUP BY `user`.uid';
//        $res = \Common\Pager::getList('user_info AS `user` LEFT JOIN user_bankcard AS bank ON `user`.uid=bank.uid LEFT JOIN user_peizi up ON `user`.uid=up.uid LEFT JOIN user_peizi_touzi ut ON up.pz_id=ut.pz_id left join user_info agent on `user`.introducer_id=agent.uid', $where, $selarr, $order, 1, 100000, 0, ' GROUP BY `user`.uid');
//        $list = array();
//        $status = array(0 => '不可用', 1 => '可用', 2 => '冻结');
//        $bank_status = array(0 => '待审核', 1 => '已绑定', 2 => '审核未通过');
//        foreach ($res as $row) {
//            $bank_card = \Model\User\BankCard::getByUid($row ['uid']);
//            $row ['true_name'] = $row ['true_name'] ? $row ['true_name'] : '未设置';
//            $row ['id_card'] = $row ['id_card'] ? substr_replace($row ['id_card'], '******', 6, 8) : '未设置';
//            $row ['bank_card'] = $bank_card;
//            $row ['bank_status'] = $bank_card ? $bank_status [$row ['is_audit']] : '未设置';
//            $row ['user_status'] = $status [$row ['status']];
//            $list [] = $row;
//        }
//        $CVSData = "用户ID,手机号码,真实姓名,身份证,银行卡,可用余额,赠送余额,注册时间,注册地址,推荐人,最后登录时间,用户状态\n";
//        $CVSData = iconv('utf-8', 'gb2312', $CVSData);
//        foreach ($list as $item) {
//
//
//
//            $CVSData .= $item['uid'] . ',' .
//                    $item['mobile'] . ',' .
//                    iconv('utf-8', 'gb2312', $item['true_name'] ? $item['true_name'] : '') . ',' .
//                    $item['id_card'] . ',' .
//                    iconv('utf-8', 'gb2312', $item['bank_status'] ? $item['bank_status'] : '') . ',' .
//                    ($item['balance'] / 100) . ',' .
//                    ($item['send'] / 100) . ',' .
//                    (empty($item['reg_time']) ? '' : date('Y-m-d H:i', $item['reg_time'])) . ',' .
//                    str_replace('-', '', \App::convert_ip($item['reg_ip'])) . ',' .
//                    $item['agent_mobile'] . ',' .
//                    (empty($item['last_login_time']) ? '' : date('Y-m-d H:i', $item['last_login_time'])) . ',' .
//                    iconv('utf-8', 'gb2312', $item['user_status']) . "\n";
//        }
//        $filename = 'user_' . date('Ymd') . '.csv'; //设置文件名
//        header("Content-type:text/csv");
//        header("Content-Disposition:attachment;filename=" . $filename);
//        header('Cache-Control:must-revalidate,post-check=0,pre-check=0');
//        header('Expires:0');
//        header('Pragma:public');
//        echo $CVSData;
//    }

    public function bank() {
        $this->setTitle('银行卡管理');
        $pagesize = 20;
        $curpage = isset($_GET ['page']) ? intval($_GET ['page']) : 1;
        $where = ' WHERE 1=1';

        if (!empty($_GET ['mobile'])) {
            $where .= " and `user`.mobile like '%" . \App::t($_GET ['mobile']) . "%'";
        }

        $selarr = array('`bank`.*', 'user.mobile', 'user.true_name,user.id_card');
        $order = ' ORDER BY bank.card_id ASC';
        $res = \Common\Pager::getList('user_bankcard as bank left join user_info AS `user`  ON `bank`.uid=`user`.uid ', $where, $selarr, $order, $curpage, $pagesize, 1);


        $this->assign('where', $where);
        $this->assign('list', $res ['data']);
        $this->assign('pager', $res ['pager']);
        $this->template('bank.php');
    }

    //修改用户信息
    public function bankedit() {
        $this->setNavtitle('修改银行卡信息');
        $card_id = isset($_GET ['card_id']) ? intval($_GET ['card_id']) : 0;
        $bank_card = \Model\User\BankCard::getById($card_id);
        $user = \Model\User\UserInfo::getinfo($bank_card['uid']);
        $bankList = \Model\Sys\AccountBank::getBanks();
        $province = \Model\Sys\Area::getProvinces();
        $bank_status = array(0 => '待审核', 1 => '审核通过', 2 => '审核未通过');


        $this->assign('bank_status', $bank_status);
        $this->assign('bank_card', $bank_card);
        $this->assign('bankList', $bankList);
        $this->assign('province', $province);
        $this->assign('user', $user);
        $this->template('bankedit.php');
    }

    //修改用户信息
    public function doBankEdit() {
        if ($_POST) {
            $res = 0;
            //银行卡信息
            $bank_name = isset($_POST ['bank_name']) ? \App::t($_POST ['bank_name']) : '';
            $province_id = isset($_POST ['province_id']) ? intval($_POST ['province_id']) : 0;
            $city_id = isset($_POST ['city_id']) ? intval($_POST ['city_id']) : 0;
            $card_no = isset($_POST ['card_no']) ? \App::t($_POST ['card_no']) : '';
            $province_name = isset($_POST ['province_name']) ? \App::t($_POST ['province_name']) : '';
            $city_name = isset($_POST ['city_name']) ? \App::t($_POST ['city_name']) : '';
            $card_id = isset($_POST ['card_id']) ? intval($_POST ['card_id']) : 0;
            $bank_card = \Model\User\BankCard::getById($card_id);

            if ($province_id && $city_id && $card_no && $bank_name) {

                if ($bank_card) { //修改银行卡信息
                    $updarr = array();
                    $updarr ['bank_name'] = $bank_name;
                    $updarr ['province_id'] = $province_id;
                    $updarr ['city_id'] = $city_id;
                    $updarr ['card_no'] = $card_no;
                    $updarr ['province_name'] = $province_name;
                    $updarr ['city_name'] = $city_name;
                    //$updarr['status'] = $status;
                    $res = \Model\User\BankCard::edit($updarr, $card_id);
                } else {
                    $res = \Model\User\BankCard::add($uid, $province_id, $province_name, $city_id, $city_name, $card_no, $bank_name);
                }
            }
            if ($res > 0 || $res2 > 0) {
                $this->fontRedirect('银行卡信息已更新', '/index.php?app=admin&mod=user&ac=bank');
            } else {
                $this->fontRedirect('银行卡信息更新失败', '/index.php?app=admin&mod=user&ac=bank');
            }
        }
    }

    public function bankdel() {
        $card_id = isset($_GET ['card_id']) ? intval($_GET ['card_id']) : 0;
        $res = \Model\User\BankCard::del($card_id);
        if ($res > 0) {
            $this->fontRedirect('删除成功', '/index.php?app=admin&mod=user&ac=bank');
        } else {
            $this->fontRedirect('删除失败', '/index.php?app=admin&mod=user&ac=bank');
        }
    }

    public function invitation() {
        $pagesize = 20;
        $condition['mobile'] = isset($_GET['mobile']) ? \App::t($_GET['mobile']) : '';
        $curpage = isset($_GET ['page']) ? intval($_GET ['page']) : 1;
        $table = 'user_info as `user` LEFT JOIN user_info as `invit` ON `user`.uid=invit.introducer_id LEFT JOIN (select uid,sum(bond_total) bond_total from user_peizi where pz_type in (1,2) group by uid HAVING sum(bond_total)>1000000 ) inv_peizi ON `invit`.uid=inv_peizi.uid  ';
        $selarr = array('`user`.uid,`user`.mobile,`user`.true_name,`user`.`level`,`invit`.introducer_id,count(inv_peizi.uid) invit_count');
        $group = ' GROUP BY `invit`.introducer_id';
        $order = ' ORDER BY `user`.level,count(invit.uid) desc';
        $where = ' WHERE `invit`.introducer_id is NOT NULL ';
        if ($condition['mobile']) {
            $where .= " AND user.mobile='" . $condition['mobile'] . "'";
        }
        $res = \Common\Pager::getList($table, $where, $selarr, $order, $curpage, $pagesize, 1, $group);
        $this->assign('condition', $condition);
        $this->assign('list', $res['data']);
        $this->assign('pager', $res ['pager']);
        $this->template('invitation.php');
    }

    //分组管理
    public function group() {
        $this->setTitle('分组管理');
        $pagesize = 20;
        $curpage = isset($_GET ['page']) ? intval($_GET ['page']) : 1;
        $name=\App::t($_GET ['name']);
        $where = ' WHERE 1=1';

        if (!empty($name)) {
            $where .= " and name like '%" . $name . "%'";
        }
        $selarr = array();
        $order = ' ORDER BY add_time asc';
        $res = \Common\Pager::getList('`group`', $where, $selarr, $order, $curpage, $pagesize);
       
        $this->assign('name',$name);
        $this->assign('list', $res ['data']);
        $this->assign('pager', $res ['pager']);
        $this->template('group.php');
    }

    //编辑分组
    public function groupedit()
    {
        $id = isset($_GET['id']) ? intval($_GET['id']) : 0;
        $nav_title = $id > 0 ? '编辑分组' : '添加分组';
        $this->assign('nav_title', $nav_title);
        $row = \Model\User\Group::getById($id);
        $this->assign('row', $row);
        $this->template('groupedit.php');
    }
    
    //保存分组
    public function doGroupEdit()
    {
        if ($_POST) {
            
            $res = 0;
            $id = isset($_POST ['id']) ? intval($_POST ['id']) : 0;
            $name = isset($_POST ['name']) ? \App::t($_POST ['name']) : '';
            $memo = isset($_POST ['memo']) ? \App::t($_POST ['memo']) : '';
            $add_time=isset($_POST ['add_time'])? $_POST ['add_time']:date('Y-m-d H:i:s');
            
            if(empty($name))
            {
                $this->fontRedirect('名称不能为空', '/index.php?app=admin&mod=user&ac=group');
            }
            $group= \Model\User\Group::getById($id);
            
            if ($group) { //修改分组信息
                $updarr = array();
                $updarr ['name'] = $name;
                $updarr ['memo'] = $memo;
                $updarr ['add_time'] = $add_time;
                $res = \Model\User\Group::edit($updarr, $id);
            } else {
                $res = \Model\User\Group::add($name, $memo, $add_time);
            }
         
            if ($res > 0 ) {
                $this->fontRedirect('数据保存成功', '/index.php?app=admin&mod=user&ac=group');
            } else {
                $this->fontRedirect('数据保存成功', '/index.php?app=admin&mod=user&ac=group');
            }
        }
    }
    
    //删除分组
    public function groupdel() {
        $id = isset($_GET ['id']) ? intval($_GET ['id']) : 0;
        $res= \Model\User\Group::del($id);
        $this->fontRedirect($res['msg'], '/index.php?app=admin&mod=user&ac=group');
    }
 
     /**
     * 弹出用户分组
     */
    public function grouppop() {
        $search_param['group_id'] = $_GET ['group_id'];
        $search_param['group_name'] =$_GET ['group_name'];

        $data =\Common\Query::sqlsel("select * from `group` order by add_time desc");
        $this->assign('search_param',$search_param);
        $this->assign('datalist',$data);
        $this->template('grouppop.php');
    }
    
    public function modifygroup()
    {
        $this->setTitle('用户管理');
        $pagesize = 200;
        $curpage = isset($_GET ['page']) ? intval($_GET ['page']) : 1;
        $where = ' WHERE `user`.status!=3';
        if (!empty($_GET ['uid'])) {
            $where .= is_numeric($_GET ['uid']) ? ' and `user`.uid=' . intval($_GET ['uid']) : " and `user`.true_name like '%" . $_GET ['uid'] . "%'";
        }
        if (!empty($_GET ['mobile'])) {
            $where .= " and `user`.mobile like '%" . \App::t($_GET ['mobile']) . "%'";
        }
//        if (isset($_GET ['is_audit']) && $_GET ['is_audit'] != '') {
//            $where .= " and bank.is_audit= " . intval($_GET ['is_audit']);
//        }
        //实名认证
        if (isset($_GET ['is_realname']) && $_GET ['is_realname'] !== '') {
            $where .= $_GET ['is_realname'] ? " and `user`.true_name !='' " : " and `user`.true_name is null";
        }

        //银行卡绑定
        if (isset($_GET ['is_bankbind']) && $_GET ['is_bankbind'] !== '') {
            $where .= $_GET ['is_bankbind'] ? " and `bank`.card_id !='' " : " and `bank`.card_id is null";
        }

        //免费体验
        if (isset($_GET ['is_free']) && $_GET ['is_free'] !== '') {
            $where .= $_GET ['is_free'] ? " and `up`.pz_type =4 " : " and `up`.pz_type !=4";
        }

        //按日配资
        if (isset($_GET ['is_day']) && $_GET ['is_day'] !== '') {
            $where .= $_GET ['is_day'] ? " and `up`.pz_type =1 " : " and `up`.pz_type !=1";
        }
        //按月配资
        if (isset($_GET ['is_month']) && $_GET ['is_month'] !== '') {
            $where .= $_GET ['is_month'] ? " and `up`.pz_type =2 " : " and `up`.pz_type !=2";
        }

        //状态
        if (isset($_GET ['status']) && $_GET ['status'] !== '') {
            if ($_GET ['status'] == '0') {
                $where .= " and `user`.status!=1";
            } elseif ($_GET ['status'] == '1') {
                $where .= " and `user`.status=1";
            }
        }

        //代理手机号
        if (isset($_GET ['agent_mobile']) && $_GET ['agent_mobile'] !== '') {
            $where .= " and (`agent`.mobile='" . $_GET ['agent_mobile'] . "')";
        }
        
        if (!empty($_GET ['group_id'])) {
            $where .= " and `user`.group_id =" . intval($_GET ['group_id']) ;
        }

        $selarr = array('distinct `user`.*');
        $order = ' ORDER BY `user`.uid DESC';
        $res = \Common\Pager::getList('user_info AS `user` ', $where, $selarr, $order, $curpage, $pagesize, 1, '');
        if (isset($_GET ['agent_mobile']) && $_GET ['agent_mobile'] != '') {
            $res = \Common\Pager::getList('user_info AS `user` left join user_info agent on `user`.introducer_id=agent.uid', $where, $selarr, $order, $curpage, $pagesize, 1, '');
        }
        if ((isset($_GET ['is_bankbind']) && $_GET ['is_bankbind'] != '') ) {
           $res = \Common\Pager::getList('user_info AS `user` LEFT JOIN user_bankcard AS bank ON `user`.uid=bank.uid ', $where, $selarr, $order, $curpage, $pagesize, 1, ' GROUP BY `user`.uid');
        }
        if ((isset($_GET ['is_free']) && $_GET ['is_free'] != '') || (isset($_GET ['is_day']) && $_GET ['is_day'] != '') || (isset($_GET ['is_month']) && $_GET ['is_month'] != '')) {
            $res = \Common\Pager::getList('user_info AS `user` LEFT JOIN user_bankcard AS bank ON `user`.uid=bank.uid LEFT JOIN user_peizi up ON `user`.uid=up.uid ', $where, $selarr, $order, $curpage, $pagesize, 1, ' GROUP BY `user`.uid');
        }
        //$res = \Common\Pager::getList('user_info AS `user` LEFT JOIN user_bankcard AS bank ON `user`.uid=bank.uid LEFT JOIN user_peizi up ON `user`.uid=up.uid LEFT JOIN user_peizi_touzi ut ON up.pz_id=ut.pz_id left join user_info agent on `user`.introducer_id=agent.uid', $where, $selarr, $order, $curpage, $pagesize, 1, ' GROUP BY `user`.uid');
        $list = array();
        $status = array(0 => '<span class="red">不可用</span>', 1 => '<span class="green">可用</span>', 2 => '<span class="grayc">冻结</span>');
        $bank_status = array(0 => '<span class="red">待审核</span>', 1 => '<span class="green">已绑定</span>', 2 => '<span class="red">审核未通过</span>');
        foreach ($res ['data'] as $row) {
            if ((isset($_GET ['is_bankbind']) && $_GET ['is_bankbind'] != '') ) {
                if($_GET ['is_bankbind'] == 0)
                {
                    $row ['bank_status']='未设置';
                }
                else if($_GET ['is_bankbind'] == 1)
                {
                     $row ['bank_status']='<span class="green">已绑定</span>';
                }
            }
            else{
                $bank_card = \Model\User\BankCard::getByUid($row ['uid']);
                $row ['bank_status'] = $bank_card ? $bank_status [$bank_card ['is_audit']] : '未设置';
            }
            $user= \Model\User\UserInfo::getinfo($row ['introducer_id']);
            $row ['true_name'] = $row ['true_name'] ? $row ['true_name'] : '未设置';
            $row ['id_card'] = $row ['id_card'] ? substr_replace($row ['id_card'], '******', 6, 8) : '未设置';
            //$row ['bank_status'] = $bank_card ? $bank_status [$row ['is_audit']] : '未设置';            
            $row ['user_status'] = $status [$row ['status']];
            $row ['agent_mobile']=$user['mobile'];
            $list [] = $row;
        }
        $group_list= \Model\User\Group::getList();
        $this->assign('where', $where);
        $this->assign('list', $list);
        $this->assign('group_list',$group_list);
        $this->assign('pager', $res ['pager']);
        $this->template('modifygroup.php');
    }
    //用户批量分组选择分组
    public function groupselect()
    {
        $ids= isset($_GET['ids'])?\App::t($_GET['ids']):'';
        if(empty($ids))
        {
            echo '请选择用户';
            exit;
        }
        $this->assign('ids',$ids);
        $data=\Common\Query::sqlsel("select * from `group` order by add_time asc");
        $this->assign('datalist',$data);
        return $this->template('groupselect.php');
    }
    
    //保存批量分组修改
    public function groupupdate()
    {
        $ids=isset($_POST['ids'])?\App::t($_POST['ids']):'';
        $group_id=isset($_POST['group_id'])?intval($_POST['group_id']):0;
       
        if(empty($ids) || empty($group_id))
        {
            
            exit(json_encode(array('ret'=>1,'msg'=>'获取参数失败')))  ;
        }
       
        $result= \Model\User\UserInfo::UpdateGroupId($ids, $group_id);
        exit(json_encode($result)) ;
    }
    
    public function exportdata(){
        $head = array('手机号');
        $data = \Common\Query::select('user_info', array('status'=>1), array('mobile'));
//        $data = [];
//        foreach ($rows as $row) {
//            $data[] = $row['mobile'];
//        }
        $file_name = time().rand(1000,9999).'.csv';
        $res = \Model\Sys\Excel::putCsv( SITEROOT .'logs/'.$file_name, $data, $head);
        if(!$res){
            echo json_encode(array('ret'=>1,'msg'=>'导出出错')) ;
            exit;
        }
        echo json_encode( array('ret'=>0,'msg'=>$file_name)) ;
        exit;
    }
}

?>