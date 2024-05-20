<?php

namespace apps\admin;

use apps\admin\ad;

class finance extends \apps\AdminControl {

    //提现管理
    public function tixian() {
        $this->setTitle('提现管理');
        $pagesize = 20;
        $curpage = isset($_GET['page']) ? intval($_GET['page']) : 1;
        $where = ' WHERE 1=1 ';
        if (!empty($_GET['uid'])) {
            $where .= ' and record.uid=' . intval($_GET['uid']);
        }
        if (!empty($_GET['true_name'])) {
            $where .= " and info.true_name = '" . \App::t($_GET['true_name']) . "'";
        }
        if (!empty($_GET['mobile'])) {
            $where .= " and info.mobile = '" . \App::t($_GET['mobile']) . "'";
        }
        if (!empty($_GET['card_no'])) {
            $where .= " and card.card_no = '" . \App::t($_GET['card_no']) . "'";
        }
        if (isset($_GET['status']) && $_GET['status'] != '') {
            $where .= " and record.status= " . intval($_GET['status']);
        }

        $selarr = array('record.withdraw_id', 'record.uid', 'record.money', 'record.status', 'record.rtime', 'info.true_name', 'info.mobile', 'card.province_name', 'card.city_name', 'card.card_no', 'card.bank_name');
        $table_name = 'user_withdraw_record record left join user_info info on record.uid=info.uid left join user_bankcard card on record.card_id=card.card_id';
        $order = ' ORDER BY record.withdraw_id DESC';
        $res = \Common\Pager::getList($table_name, $where, $selarr, $order, $curpage, $pagesize);
        $this->assign('list', $res['data']);
        $this->assign('pager', $res['pager']);
        $this->template('tixian.php');
    }

    //提现操作确认
    public function tixianChangeStatus() {
        $withdraw_id = isset($_POST['withdraw_id']) ? intval($_POST['withdraw_id']) : 0;
        $status = isset($_POST['status']) ? $_POST['status'] : 0;
        $record = \Model\User\Withdraw::getRecordById($withdraw_id);
        $uid = $record['uid'];

        $result = array('code' => 0, 'msg' => '操作失败');
        if (!$record) {
            $result['msg'] = '该记录不存在';
            exit(json_encode($result));
        }

        if ($status == 2) {//完成转账
            $moneywith = $record['money'];
            \Common\Query::commitstart();
            //修改状态
            $res = \Model\User\Withdraw::changeRecordStatus0ById(2, $withdraw_id);
            if (!$res) {
                \Common\Query::rollback();
                $result['msg'] = '状态修改错误';
                exit(json_encode($result));
            }
            //解冻
            $res = \Model\User\Fund::withdrawUnfrozen($uid, $moneywith);
            if ($res[0] == 0) {
                \Common\Query::rollback();
                $result['msg'] = $res[1];
                exit(json_encode($result));
            }
            //提现
            $res = \Model\User\Fund::withdraw($uid, $moneywith, $withdraw_id);
            if ($res[0] == 0) {
                \Common\Query::rollback();
                $result['msg'] = $res[1];
                exit(json_encode($result));
            }
            \Common\Query::commit();


            //消息通知
            $user_info = \Model\User\UserInfo::getinfo($uid);
            $true_name = $user_info ? $user_info['true_name'] : '';
            $card = \Model\User\BankCard::getByUid($uid, $record['card_id']);
            $card_no = '';
            if ($card['card_no']) {
                $card_no = substr($card['card_no'], strlen($card['card_no']) - 4, 4);
            }
            $banktype = $card['bank_name'];
            $money = strval(abs(floatval($record['money']) / 100));
            //$msg = '您好，'.$true_name.'！您的【'.$banktype.'尾号为'.$card_no.'的银行卡】在'.SITE_NAME.'的提现申请成功，提现金额「'.$money.'」元。请等待银行处理，';
            $msg = \Model\Sys\SmsTemplet::withdrawSuccess($money);
//            $hour = intval(date('H',time()));
//            if($hour>=0 && $hour<8){
//                $msg .= '预计在24小时内到账。';
//            }
//            if($hour>=8 && $hour<18){
//                $msg .= '预计在2个小时之内到账。';
//            }
//            else{
//                $msg .= '预计在次日24:00前到账。';
//            }
            \Model\Api\Sms::smsSend($user_info['mobile'], $msg);
            //\Common\wechatSms::txmsg($uid, $msg);
            $result['code'] = 1;
        } elseif ($status == 3) {
            $moneywith = $record['money'];
            \Common\Query::commitstart();
            $res = \Model\User\Withdraw::changeRecordStatus0ById(3, $withdraw_id);
            if (!$res) {
                \Common\Query::rollback();
                $result['msg'] = '状态修改错误';
                exit(json_encode($result));
            }
            //解冻
            $res = \Model\User\Fund::withdrawUnfrozen($uid, $moneywith);
            if ($res[0] == 0) {
                \Common\Query::rollback();
                $result['msg'] = $res[1];
                exit(json_encode($result));
            }
            \Common\Query::commit();
            //消息通知
            $user_info = \Model\User\UserInfo::getinfo($uid);
            $money = strval(abs(floatval($record['money']) / 100));
            $msg = \Model\Sys\SmsTemplet::withdrawRefuse('');
            \Model\Api\Sms::smsSend($user_info['mobile'], $msg);
            $result['code'] = 1;
        }

        exit(json_encode($result));
    }

    //个人资产情况预览
    public function info() {
        $uid = isset($_GET ['uid']) ? intval($_GET ['uid']) : 0;
        $user = \Model\User\UserInfo::getinfo($uid);
        $recharge = \Model\User\Fund::getZhichangByUid(1, $uid) + \Model\User\Fund::getZhichangByUid(14, $uid);
        $tixian = \Model\User\Fund::getZhichangByUid(2, $uid) + \Model\User\Fund::getZhichangByUid(15, $uid);
        $gl_fee = \Model\User\Fund::getZhichangByUid(10, $uid) - \Model\User\Fund::getZhichangByUid(11, $uid);
        $yltq = \Model\User\Fund::getZhichangByUid(12, $uid);
        $bk = \Model\User\Fund::getZhichangByUid(7, $uid); //补亏
        $inserest = \Model\User\Fund::getZhichangByUid(8, $uid) - \Model\User\Fund::getZhichangByUid(9, $uid) - \Model\User\Fund::getZhichangByUid(16, $uid);
        $ylfc = \Model\User\Fund::getZhichangByUid(17, $uid) - \Model\User\Fund::getZhichangByUid(18, $uid); //盈利分成收入-盈利分成支出
        $unback_touzi = \Model\P2p\Peizi::getUnbackTouzi($uid); //未返还的投资(配资人已结束，但资金未还给投资人)

        $user['recharge'] = $recharge; //充值
        $user['tixian'] = $tixian; //提现
        $user['gl_fee'] = $gl_fee; //总管理费
        $user['yltq'] = $yltq; //总盈利提取
        $user['yingkui'] = $recharge + ($yltq - $bk) + $ylfc - $user['balance'] - $tixian - $gl_fee - $user['frozen'] - $bk - $inserest - $unback_touzi; //盈亏：总充值+总盈利+盈利分成-余额-总充值-总管理费-冻结资金-补亏-利息-支付利息-未返还的投资
        $this->assign('user', $user);
        $this->template('info.php');
    }

    public function recharge() {
        $this->setTitle('充值管理');
        $pagesize = 20;
        $curpage = isset($_GET['page']) ? intval($_GET['page']) : 1;
        $where = ' WHERE 1=1 ';
        if (!empty($_GET['uid'])) {
            $where .= ' and record.uid=' . intval($_GET['uid']);
        }
        if (!empty($_GET['true_name'])) {
            $where .= " and info.true_name = '" . \App::t($_GET['true_name']) . "'";
        }
        if (isset($_GET['status']) && $_GET['status'] != '') {
            $where .= " and record.status= " . intval($_GET['status']);
        }

        $selarr = array('record.recharge_id','record.order_id', 'record.uid', 'record.money', 'record.status', 'record.rtime', 'record.plat', 'info.true_name', 'info.mobile');
        $table_name = 'user_recharge_record record left join user_info info on record.uid=info.uid ';
        $order = ' ORDER BY record.recharge_id DESC';
        $res = \Common\Pager::getList($table_name, $where, $selarr, $order, $curpage, $pagesize);
        $this->assign('list', $res['data']);
        $this->assign('pager', $res['pager']);
        $this->template('recharge.php');
    }

    public function rechargeoffline() {
        $this->setTitle('线下充值管理');
        $pagesize = 20;
        $curpage = isset($_GET['page']) ? intval($_GET['page']) : 1;
        $where = ' WHERE 1=1 ';
        if (!empty($_GET['uid'])) {
            $where .= ' and record.uid=' . intval($_GET['uid']);
        }
        if (!empty($_GET['mobile'])) {
            $where .= " and info.mobile = '" . \App::t($_GET['mobile']) . "'";
        }
        if (!empty($_GET['true_name'])) {
            $where .= " and info.true_name = '" . \App::t($_GET['true_name']) . "'";
        }
        if (isset($_GET['status']) && $_GET['status'] != '') {
            $where .= " and record.status= " . intval($_GET['status']);
        }

        $selarr = array('record.id', 'record.uid', 'record.money', 'record.name', 'record.status', 'record.add_time', 'record.update_time', 'record.channel', 'info.true_name', 'info.mobile');
        $table_name = 'user_recharge_offline record left join user_info info on record.uid=info.uid ';
        $order = ' ORDER BY record.id DESC';
        $res = \Common\Pager::getList($table_name, $where, $selarr, $order, $curpage, $pagesize);
        $this->assign('list', $res['data']);
        $this->assign('pager', $res['pager']);
        $this->template('rechargeoffline.php');
    }

    public function offlineedit() {
        $this->setTitle('线下充值');
        $this->setNavtitle('线下充值');
        $id = isset($_GET['id']) ? intval($_GET['id']) : 0;
        $row = \Common\Query::selone('user_recharge_offline', array('id' => intval($id)));
        $user = \Model\User\UserInfo::getinfo($row['uid']);
        $this->assign('row', $row);
        $this->assign('user', $user);
        $this->template('offlineedit.php');
    }

    public function doofflineedit() {
        $id = isset($_POST['id']) ? intval($_POST['id']) : 0;
        $money = isset($_POST['money']) ? floatval($_POST['money']) * 100 : 0;

        $url = '/index.php?app=admin&mod=finance&ac=rechargeoffline';
        if (empty($id)) {
            $this->fontRedirect('参数错误', 'back', 2);
            exit();
        }
        if (empty($money)) {
            $this->fontRedirect('金额不能为空', $url, 2);
            exit();
        }
        $udpin['money'] = $money;


        $res = \Common\Query::update('user_recharge_offline', $udpin, array('id' => $id));
        if (!$res) {
            $this->fontRedirect('提交失败', $url, 2);
        }
        $this->fontRedirect('提交成功', $url, 2);
    }

    public function offlinepass() {
        $url = '/index.php?app=admin&mod=finance&ac=rechargeoffline';
        $id = isset($_GET['id']) ? intval($_GET['id']) : 0;
        $money = isset($_GET['money']) ? floatval($_GET['money'])*100 : 0;
        $recharge_row = \Model\User\RechargeOffline::getById($id);
        \Common\Query::commitstart();
        //返利
        if($money>0){
            $res = \Model\User\Fund::recharge_offline_rebate($recharge_row['uid'], $money);
            if ($res[0] == 0) {
                \Common\Query::rollback();
                $this->fontRedirect($res[1], $url, 2);
                exit();
            }
        }
        //状态修改
        $res = \Model\User\Fund::recharge_offline($id);
        if ($res[0] == 0) {
            \Common\Query::rollback();
            $this->fontRedirect('提交失败', $url, 2);
            exit();
        }
        //赠送管理费
        $row_count = \Common\Query::sqlselone("select count(fund_id) total from user_fund_record where uid=" . $recharge_row['uid'] . " and type=111");
        if (intval($row_count['total']) <= 0) {
            $params_send = \Model\Admin\Params::get('manage_send');
            $res = \Model\User\Fund::send_recharge($recharge_row['uid'], floatval($params_send['recharge']) * 100);
            if ($res[0] == 0) {
                \Common\Query::rollback();
                $this->fontRedirect($res[1], $url, 2);
                exit();
            }
        }
        
        \Common\Query::commit();
        //短信通知
        $row = \Model\User\RechargeOffline::getById($id);
        $user = \Model\User\UserInfo::getinfo($row['uid']);
        \Model\Api\Sms::smsSend($user['mobile'], \Model\Sys\SmsTemplet::rechargeSuccess(''));
        $this->fontRedirect('提交成功', $url, 2);
        exit();
    }

    public function offlinerefuse() {
        $url = '/index.php?app=admin&mod=finance&ac=rechargeoffline';
        $id = isset($_GET['id']) ? intval($_GET['id']) : 0;
        $res = \Model\User\RechargeOffline::updateRefuseStatus($id);
        if (!$res) {
            $this->fontRedirect('提交失败', $url, 2);
        }
        //短信通知
        $row = \Model\User\RechargeOffline::getById($id);
        $user = \Model\User\UserInfo::getinfo($row['uid']);
        \Model\Api\Sms::smsSend($user['mobile'], \Model\Sys\SmsTemplet::rechargeRefuse(''));
        $this->fontRedirect('提交成功', $url, 2);
        exit();
    }

    public function offlinedel() {
        $url = '/index.php?app=admin&mod=finance&ac=rechargeoffline';
        $id = isset($_GET['id']) ? intval($_GET['id']) : 0;
        $res = \Common\Query::delete("user_recharge_offline", array("id" => $id));
        if (!$res) {
            $this->fontRedirect('提交失败', $url, 2);
        }
        $this->fontRedirect('提交成功', $url, 2);
        exit();
    }

    //资金流水
    public function fund() {
	 $this->setTitle('资金流水记录');
        $pagesize = 30;
        $condition['mobile'] = isset($_GET ['mobile']) ? $_GET ['mobile'] : '';
        $condition['true_name'] = isset($_GET ['true_name']) ? $_GET ['true_name'] : '';
        $condition['pz_id'] = isset($_GET ['pz_id']) ? $_GET ['pz_id'] : '';
        $condition['order_id'] = isset($_GET ['order_id']) ? $_GET ['order_id'] : '';
        $condition['uid'] = isset($_GET ['uid']) ? $_GET ['uid'] : '';
        $condition['type'] = isset($_GET ['type']) ? $_GET ['type'] : '';
        $condition['begindate'] = isset($_GET ['begindate']) ? $_GET ['begindate'] : '';
        $condition['enddate'] = isset($_GET ['enddate']) ? $_GET ['enddate'] : '';
        $curpage = isset($_GET ['page']) ? intval($_GET ['page']) : 1;
        $where = ' WHERE 1=1';
        if (!empty($condition['mobile'])) {
            $where .= " and fund.uid in(select uid from user_info where mobile='".$condition['mobile']."')";
        }
        if (!empty($condition['true_name'])) {
            $where .= " and fund.uid in(select uid from user_info where true_name='".$condition['true_name']."')";
        }
        if (!empty($condition['pz_id'])) {
            $where .= ' and pz_id=' . intval($condition['pz_id']);
        }
        if (!empty($condition['order_id'])) {
            $pz_id = substr($condition['order_id'], 8);
            $where .= ' and pz_id=' . intval($pz_id);
        }
        if ($condition['uid'] != '') {
            $where .= ' and fund.uid=' . intval($condition['uid']);
        }
        if ($condition['type'] != '') {
            $where .= ' and fund.type=' . intval($condition['type']);
        }
        if ($condition['begindate'] && $condition['enddate']) {
            $where .= " AND (FROM_UNIXTIME(rtime,'%Y-%m-%d')>='" . ($condition['begindate']) . "' AND FROM_UNIXTIME(rtime,'%Y-%m-%d')<='" . ($condition['enddate']) . "')";
        }
        $selarr = array('fund.*', 'pz.pz_time');
        $order = ' ORDER BY fund.rtime DESC';
        $res = \Common\Pager::getList('user_fund_record fund left join user_peizi pz on fund.rec_id=pz.pz_id', $where, $selarr, $order, $curpage, $pagesize, 1);

        $this->assign('list', $res['data']);
        $this->assign('pager', $res ['pager']);
        $this->assign('condition', $condition);
        $this->template('fund.php');
    }

    //收款账户设置
    public function account() {
        $this->setTitle('收款账户设置');
        $page = isset($_GET ['page']) ? intval($_GET ['page']) : 1;


        $where = ' WHERE 1=1 ';
        $condition = array('name' => '', 'channel' => '', 'holder' => '', 'account' => '', 'address' => '', 'status' => '', 'type' => '');
        $name = isset($_GET['name']) ? $_GET['name'] : $condition['name']; //名称
        $channel = isset($_GET['channel']) ? $_GET['channel'] : $condition['channel']; //收款渠道
        $holder = isset($_GET['holder']) ? $_GET['holder'] : $condition['holder']; //收款开户人
        $account = isset($_GET['account']) ? $_GET['account'] : $condition['account']; //收款账号
        $address = isset($_GET['address']) ? $_GET['address'] : $condition['address']; //开户地址
        $status = isset($_GET['status']) ? $_GET['status'] : $condition['status']; //状态
        $type = isset($_GET['type']) ? $_GET['type'] : $condition['type']; //收款类型


        if ($name) {
            $condition['name'] = $name;
            $where .= " AND name like '%" . $name . "%'";
        }
        if ($channel) {
            $condition['channel'] = $channel;
            $where .= " AND channel like '%" . $channel . "%'";
        }
        if ($holder) {
            $condition['holder'] = $holder;
            $where .= " AND holder like '%" . $holder . "%'";
        }
        if ($account) {
            $condition['account'] = $account;
            $where .= " AND account like '%" . $account . "%'";
        }
        if ($address) {
            $condition['address'] = $address;
            $where .= " AND address like '%" . $address . "%'";
        }
        if ($status!='') {
            $condition['status'] = $status;
            $where .= " AND status = " . $status;
        }
        if ($type!='') {
            $condition['type'] = $type;
            $where .= " AND type = " . $type;
        }
        $selarr = array('id', 'name', 'type','path', 'channel', 'holder', 'account', 'sortno', 'status','group_id');
        $order = ' ORDER BY `sortno` ASC';
        $res = \Common\Pager::getList('finance_account', $where, $selarr, $order, $page, 20);

        $status_arr = array('0' => '禁用', '1' => '启用');
        $accountType_arr = \Model\Admin\Finance::getFinanceAccountType();

        $dataList = array();
        foreach ($res ['data'] as $data) {
            $data['type_caption'] = $accountType_arr[$data['type']];
            $data['status_caption'] = $status_arr[$data['status']];
            $dataList[] = $data;
        }
        
        $this->assign('pager', $res ['pager']);
        $this->assign('status_arr', $status_arr);
        $this->assign('accountType_arr', $accountType_arr);
        $this->assign('dataList', $dataList);
        $this->assign('condition', $condition);
        $this->template('account.php');
    }

    //收款账户设置添加、编辑打开页面
    public function accountEdit() {
        $id = isset($_GET['id']) ? intval($_GET['id']) : '0'; //0表示新增
        $nav_title = $id > 0 ? '编辑账户' : '添加账户';
        $data = \Model\Admin\Finance::getAccountById($id);
        if($data)
        {
            $data['group_name']= \Model\User\Group::idToName($data['group_id']);
        }
        $accountType_arr = \Model\Admin\Finance::getFinanceAccountType();
        $status_arr = array( '1' => '启用','0' => '禁用',);

        $this->assign('data', $data);
        $this->assign('accountType_arr', $accountType_arr);
        $this->assign('status_arr', $status_arr);
        $this->assign('nav_title', $nav_title);
        $this->template('accountedit.php');
    }

    //收款账户设置添加、编辑页面保存数据
    public function accountDoedit() {
        $url = '/index.php?app=admin&mod=finance&ac=account';
        if ($_POST) {
            $id = isset($_POST['id']) ? intval($_POST['id']) : 0;
            $name = isset($_POST['name']) ? $_POST['name'] : '';
            $type = isset($_POST['type']) ? intval($_POST['type']) : 0;
            $channel = isset($_POST['channel']) ? $_POST['channel'] : '';
            $holder = isset($_POST['holder']) ? $_POST['holder'] : '';
            $account = isset($_POST['account']) ? $_POST['account'] : '';
            $address = isset($_POST['address']) ? $_POST['address'] : '';
            $caption = isset($_POST['caption']) ? $_POST['caption'] : '';
            $sortno = isset($_POST['sortno']) ? intval($_POST['sortno']) : '';
            $status = isset($_POST['status']) ? intval($_POST['status']) : '';
            $remark = isset($_POST['remark']) ? htmlspecialchars($_POST['remark']) : '';
            $path = $_POST['path'];
            $group_id=isset($_POST['group_id'])?$_POST['group_id']:1;
            //上传图片
            if (!empty($_FILES ['path'] ['name'])) {
                $return = $this->upload();
                $path = $return['status'] ? $return['data']['src'] : '';
            }


            $arr = array(
                'name' => $name,
                'type' => $type,
                'channel' => $channel,
                'holder' => $holder,
                'account' => $account,
                'address' => $address,
                'caption' => $caption,
                'sortno' => $sortno,
                'status' => $status,
                'remark' => $remark,
                'path' => $path,
                'group_id'=>$group_id
            );


            $res = array();
            if ($id > 0) {//编辑
                $arr['id'] = $id;
                $res = \Model\Admin\Finance::editAccount($arr);
            } else {//新增
                $res = \Model\Admin\Finance::addAccount($arr);
            }
            if ($res['code'] >=0) {
                $this->fontRedirect($res['msg'], $url);
            } else {
                $this->fontRedirect('操作失败！', $url);
            }
        } else {
            $this->fontRedirect('提交方式不正确', $url);
        }
    }

    //收款账户设置删除
    public function accountDel() {
        $id = isset($_GET['id']) ? $_GET['id'] : 0;
        $res = \Model\Admin\Finance::delAccount(array('id' => $id));
        $this->sysRedirect('/index.php?app=admin&mod=finance&ac=account');
    }

    //支付设置
    public function payset() {
        $this->setTitle('支付设置');
        $page = isset($_GET ['page']) ? intval($_GET ['page']) : 1;
        $order = ' ORDER BY `name` ASC';
        $res = \Common\Pager::getList('pay_set', $where, '', $order, $page, 20);
        $status_arr = array('0' => '停用', '1' => '启用');
        $clienttype_arr=array('1'=>'电脑','2'=>'手机','3'=>'电脑&手机');

        $dataList = array();
        foreach ($res ['data'] as $data) {
            $data['status_caption'] = $status_arr[$data['status']];
            $data['clienttype_caption'] = $clienttype_arr[$data['client_type']];
            $dataList[] = $data;
        }

        $this->assign('pager', $res ['pager']);
        $this->assign('dataList', $dataList);
        $this->assign('condition', $condition);
        $this->template('payset.php');
    }

    //支付设置添加、编辑打开页面
    public function paysetEdit() {
        $id = isset($_GET['id']) ? intval($_GET['id']) : '0'; //0表示新增
        $nav_title = $id > 0 ? '编辑支付设置' : '添加支付设置';
        $set_info= \Model\Admin\Finance::getSetInfo();
        $data = \Model\Admin\Finance::getPaysetById($id);
        $status_arr = array('0' => '停用', '1' => '启用');
        $clienttype_arr=array('1'=>'电脑','2'=>'手机','3'=>'电脑&手机');

        $this->assign('data', $data);
        $this->assign('set_info', $set_info);
        $this->assign('status_arr', $status_arr);        
        $this->assign('clienttype_arr', $clienttype_arr);
        $this->assign('nav_title', $nav_title);
        $this->template('paysetedit.php');
    }

    //支付设置添加、编辑页面保存数据
    public function paysetDoedit() {
        $url = '/index.php?app=admin&mod=finance&ac=payset';
        if ($_POST) {
            $id = isset($_POST['id']) ? intval($_POST['id']) : 0;
            $code=isset($_POST['code']) ? $_POST['code'] : '';
            $controller=isset($_POST['controller']) ? $_POST['controller'] : '';
            $can_iframe=isset($_POST['can_iframe']) ? $_POST['can_iframe'] : '';
            $manner = isset($_POST['manner']) ? $_POST['manner'] : '';
            $pay_type = isset($_POST['pay_type']) ? $_POST['pay_type'] : '';
            $pay_channel = isset($_POST['pay_channel']) ? $_POST['pay_channel'] : '';
            $name = isset($_POST['name']) ? $_POST['name'] : '';
            $domain = isset($_POST['domain']) ? $_POST['domain'] : '';
            $sid = isset($_POST['sid']) ? $_POST['sid'] : '';
            $skey = isset($_POST['skey']) ? $_POST['skey'] : '';
            $status = isset($_POST['status']) ? intval($_POST['status']) : 0;
            $client_type = isset($_POST['client_type']) ? intval($_POST['client_type']) : 1;
            $terminal_id = isset($_POST['terminal_id']) ? $_POST['terminal_id'] : '';
            $server_pub_key = isset($_POST['server_pub_key']) ? $_POST['server_pub_key'] : '';
            $mem_pri_key = isset($_POST['mem_pri_key']) ? $_POST['mem_pri_key'] : '';
            $memo = isset($_POST['memo']) ? $_POST['memo'] : '';
           

            $arr = array(
                'code' => $code,
                'controller' => $controller,
                'can_iframe' => $can_iframe,
                'manner' => $manner,
                'pay_type' => $pay_type,
                'name' => $name,
                'domain' => $domain,
                'sid' => $sid,
                'skey' => $skey,
                'status' => $status,
                'client_type' => $client_type,
                'terminal_id' => $terminal_id,
                'server_pub_key' => $server_pub_key,
                'mem_pri_key' => $mem_pri_key,
                'memo' => $memo
            );

            $res = array();
            if ($id > 0) {//编辑
                $arr['id'] = $id;
                $res = \Model\Admin\Finance::editPayset($arr);
            } else {//新增
                $res = \Model\Admin\Finance::addPayset($arr);
            }
            if ($res['code'] >=0) {
                $this->fontRedirect($res['msg'], $url);
            } else {
                $this->fontRedirect('操作失败！', $url);
            }
        } else {
            $this->fontRedirect('提交方式不正确', $url);
        }
    }

    //支付设置删除
    public function paysetDel() {
        $id = isset($_GET['id']) ? $_GET['id'] : 0;
        $res = \Model\Admin\Finance::delPayset(array('id' => $id));
        $this->sysRedirect('/index.php?app=admin&mod=finance&ac=payset');
    }

    public  function upload() {
        $return = array();
        $targetFolder = SITEROOT . '/uploads/' . date('ymd', time()); // Relative to the root
        $saveFolder = '/uploads/' . date('ymd', time());
        if (!empty($_FILES)) {
            if (!file_exists($targetFolder)) { // 判断存放文件目录是否存在
                mkdir($targetFolder, 0777, true);
            }
            $fileName = $_FILES ['path'] ['name'];
            $tempFile = $_FILES ['path'] ['tmp_name'];
            $targetPath = $targetFolder;
            $fileParts = pathinfo($fileName);
            $upfileName = md5(uniqid()) . '.' . $fileParts ['extension'];
            $targetFile = rtrim($targetPath, '/') . '/' . $upfileName;
            $fileTypes = array('jpg', 'jpeg', 'gif', 'png'); // File extensions
            $data = array();
            if (in_array($fileParts ['extension'], $fileTypes)) {
                move_uploaded_file($tempFile, $targetFile);
                $data ['src'] = $saveFolder . '/' . $upfileName;
                $data ['attach_id'] = $upfileName;
                $data ['extension'] = strtolower($fileParts ['extension']);
                $return = array('status' => 1, 'data' => $data);
            } else {
                $return = array('status' => 0, 'msg' => $fileParts ['extension'] . '类型的不允许上传！');
            }
            //echo json_encode($return);exit();
        }
        return $return;
    }

}

?>