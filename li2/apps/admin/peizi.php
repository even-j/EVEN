<?php

namespace apps\admin;

class peizi extends \apps\AdminControl {

    //按天配资
    public function view() {
        $this->setTitle('配资记录');
        $pagesize = 20;
        $condition = array();
        $condition['pz_type'] = isset($_GET ['pz_type']) ? $_GET ['pz_type'] : '';
        $condition['mobile'] = isset($_GET ['mobile']) ? $_GET ['mobile'] : '';
        $condition['true_name'] = isset($_GET ['true_name']) ? $_GET ['true_name'] : '';
        $condition['order_id'] = isset($_GET ['order_id']) ? $_GET ['order_id'] : '';
        $condition['uid'] = isset($_GET ['uid']) ? $_GET ['uid'] : '';
        $condition['sp_user'] = isset($_GET ['sp_user']) ? $_GET ['sp_user'] : '';
        $condition['status'] = isset($_GET ['status']) ? $_GET ['status'] : '';
        $curpage = isset($_GET ['page']) ? intval($_GET ['page']) : 1;
        $where = ' WHERE pz_type in (1,2,4)';
        if (!empty($condition['pz_type'])) {
            $where .= ' and pz.pz_type=' . intval($condition['pz_type']);
        }
        if (!empty($condition['mobile'])) {
            $where .= ' and u.mobile=' . $condition['mobile'];
        }
        if (!empty($condition['true_name'])) {
            $where .= " and u.true_name='" . $condition['true_name']."'";
        }
        if (!empty($condition['order_id'])) {
            $pz_id = substr($condition['order_id'], 8);
            $where .= ' and pz.pz_id=' . intval($pz_id);
        }
        if (!empty($condition['uid'])) {
            $where .= ' and pz.uid=' . intval($condition['uid']);
        }
        if (!empty($condition['sp_user'])) {
            $where .= " and pz.sp_user='" . \App::t($condition['sp_user']) . "'";
        }
        if ($condition['status'] == '') {
            $where .= ' and (pz.status>0)';
        } else {
            $where .= ' and pz.status=' . intval($condition['status']);
        }
        $selarr = array('pz.*', 'u.mobile', 'u.true_name');
        $order = ' ORDER BY pz_time DESC';
        $res = \Common\Pager::getList('user_peizi pz left join user_info u on pz.uid=u.uid', $where, $selarr, $order, $curpage, $pagesize, 1);

        $this->assign('list', $res['data']);
        $this->assign('pager', $res ['pager']);
        $this->assign('condition', $condition);
        $this->template('view.php');
    }

    //实盘资金划拨
    public function fund() {
        $this->setTitle('实盘资金划拨');
        $pagesize = 20;
        $condition['order_id'] = isset($_GET ['order_id']) ? $_GET ['order_id'] : '';
        $condition['status'] = isset($_GET ['status']) ? $_GET ['status'] : '1';
        $condition['begindate'] = isset($_GET ['begindate']) ? $_GET ['begindate'] : '';
        $condition['enddate'] = isset($_GET ['enddate']) ? $_GET ['enddate'] : '';
        $condition['pz_type'] = isset($_GET ['pz_type']) ? intval($_GET ['pz_type']) : 0;
        $curpage = isset($_GET ['page']) ? intval($_GET ['page']) : 1;
        $nine_hours_later = time()+9*3600;
        $tomorrow = time()+24*3600;
        while(\Model\Sys\Common::isHoliday($tomorrow)){
            $nine_hours_later += 24*3600;//加上节假日
            $tomorrow += 24*3600;
        }
        $where = ' WHERE pz.pz_type in(1,2) and start_time<' . $nine_hours_later;
        if (!empty($condition['order_id'])) {
            $pz_id = substr($condition['order_id'], 8);
            $where .= ' and pz.pz_id=' . intval($pz_id);
        }
        if ($condition['status'] == '') {
            $where .= ' and (pz.status>0)';
        } else if ($condition['status'] == '1') {
            $where .= ' and pz.status=1';
        } else {
            $where .= ' and pz.status>1';
        }
        if ($condition['begindate'] && $condition['enddate']) {
            $where .= " AND (FROM_UNIXTIME(pz.pz_time,'%Y-%m-%d')>='" . ($condition['begindate']) . "' AND FROM_UNIXTIME(pz.pz_time,'%Y-%m-%d')<='" . ($condition['enddate']) . "')";
        }
        if (!empty($condition['pz_type'])) {
            $where .= " and pz.pz_type=" . intval($condition['pz_type']);
        }
        $selarr = array('pz.*', 'u.true_name');
        $order = ' ORDER BY pz.pz_time DESC';
        $res = \Common\Pager::getList('user_peizi pz left join user_info u on pz.uid=u.uid', $where, $selarr, $order, $curpage, $pagesize, 1);

        $this->assign('list', $res['data']);
        $this->assign('pager', $res ['pager']);
        $this->assign('condition', $condition);
        $this->template('fund.php');
    }

    public function fundedit() {
        $this->setTitle('实盘资金划拨');
        $this->setNavtitle('实盘资金划拨');
        $pz_id = isset($_GET['pz_id']) ? intval($_GET['pz_id']) : 0;
        $pz_row = \Common\Query::selone('user_peizi', array('pz_id' => intval($pz_id)));
        $this->assign('pz_row', $pz_row);
        $this->template('fundedit.php');
    }

    public function doFundEdit() {
        $pz_id = isset($_POST['pz_id']) ? intval($_POST['pz_id']) : 0;
        $sp_user = isset($_POST['sp_user']) ? \App::t($_POST['sp_user']) : '';
        $sp_pwd = isset($_POST['sp_pwd']) ? \App::t($_POST['sp_pwd']) : '';
        $status = isset($_POST['status']) ? intval($_POST['status']) : 0;
        $peizi_row = \Model\Peizi\Peizi::getById($pz_id);
        $url = '/index.php?app=admin&mod=peizi&ac=fundedit&pz_id=' . $pz_id;
        if (empty($pz_id)) {
            $this->fontRedirect('参数错误', 'back', 2);
            exit();
        }
        if ($peizi_row['status'] == $status) {
            $this->fontRedirect('状态值未变化', 'back', 2);
            exit();
        }
        if (empty($sp_user)) {
            $this->fontRedirect('证券账户不能为空', $url, 2);
            exit();
        }
        if (empty($sp_pwd)) {
            $this->fontRedirect('证券密码不能为空', $url, 2);
            exit();
        }
        \Common\Query::commitstart();
        //状态修改
        $udpin['sp_user'] = $sp_user;
        $udpin['sp_pwd'] = $sp_pwd;
        $udpin['huabo_time'] = time();
        $udpin['trade_balance'] = $peizi_row['trade_money_total'];
        $udpin['update_time'] = time();
        $udpin['status'] = 2;

        $res = \Common\Query::update('user_peizi', $udpin, array('pz_id' => $pz_id, 'status' => 1));
        if (!$res) {
            \Common\Query::rollback();
            $this->fontRedirect('状态修改失败', $url, 2);
            exit();
        }

        //支付管理费
        $res = \Model\Peizi\Peizi::payManageCost($peizi_row);
        if ($res[0] == 0) {
            \Common\Query::rollback();
            $this->fontRedirect($res[1], $url, 2);
            exit();
        }

        //资金委托进股市
        if ($peizi_row['pz_type'] == 3 || $peizi_row['pz_type'] == 5) {//p2p
            $res = \Model\User\Fund::tradeIn($peizi_row['uid'], $peizi_row['trade_money_total'], $peizi_row['pz_id']);
            if ($res[0] == 0) {
                \Common\Query::rollback();
                $this->fontRedirect($res[1], $url, 2);
                exit();
            }
        }
        //赠送管理费
        $row_count = \Common\Query::sqlselone("select count(fund_id) total from user_fund_record where uid=".$peizi_row['uid']." and type=107");
        if(intval($row_count['total']) <=0){
            $params_send = \Model\Admin\Params::get('manage_send');
            $res = \Model\User\Fund::send_peizi($peizi_row['uid'], floatval($params_send['peizi'])*100,$pz_id);
            if ($res[0] == 0) {
                \Common\Query::rollback();
                $this->fontRedirect($res[1], $url, 2);
                exit();
            }
        }

        \Common\Query::commit();
        //短信通知
        $user = \Model\User\UserInfo::getinfo($peizi_row['uid']);
        \Model\Api\Sms::smsSend($user['mobile'], \Model\Sys\SmsTemplet::peiziFundReceive(''));
        $this->fontRedirect('提交成功', $url, 2);
        exit();
    }

    //追加实盘金划拨
    public function plus() {
        $this->setTitle('追加实盘金划拔');
        $pagesize = 20;
        $condition['pz_id'] = isset($_GET ['pz_id']) ? $_GET ['pz_id'] : '';
        $condition['order_id'] = isset($_GET ['order_id']) ? $_GET ['order_id'] : '';
        $condition['status'] = isset($_GET ['status']) ? $_GET ['status'] : '0';
        $condition['begindate'] = isset($_GET ['begindate']) ? $_GET ['begindate'] : '';
        $condition['enddate'] = isset($_GET ['enddate']) ? $_GET ['enddate'] : '';
        $condition['pz_type'] = isset($_GET ['pz_type']) ? intval($_GET ['pz_type']) : 0;
        $curpage = isset($_GET ['page']) ? intval($_GET ['page']) : 1;
        $where = ' WHERE pz.pz_type in(1,2)';
        if (!empty($condition['pz_id'])) {
            $where .= ' and a.pz_id=' . intval($condition['pz_id']);
        }
        if (!empty($condition['order_id'])) {
            $pz_id = substr($condition['order_id'], 8);
            $where .= ' and a.pz_id=' . intval($pz_id);
        }
        if ($condition['status'] != '') {
            $where .= ' and a.status=' . intval($condition['status']);
        }
        if ($condition['begindate'] && $condition['enddate']) {
            $where .= " AND (FROM_UNIXTIME(a.add_time,'%Y-%m-%d')>='" . ($condition['begindate']) . "' AND FROM_UNIXTIME(a.add_time,'%Y-%m-%d')<='" . ($condition['enddate']) . "')";
        }
        if (!empty($condition['pz_type'])) {
            $where .= " and pz.pz_type=" . intval($condition['pz_type']);
        }
        $selarr = array('pz.*', 'a.add_time', 'a.add_money', 'a.add_bond', 'a.status addstatus', 'a.add_id', 'a.alarm_money', 'a.stop_money', 'u.true_name');
        $order = ' ORDER BY a.add_time DESC';
        $res = \Common\Pager::getList('user_peizi_add a left join user_peizi pz on a.pz_id=pz.pz_id left join user_info u on pz.uid=u.uid', $where, $selarr, $order, $curpage, $pagesize, 1);

        $this->assign('list', $res['data']);
        $this->assign('pager', $res ['pager']);
        $this->assign('condition', $condition);
        $this->template('plus.php');
    }

    public function plusedit() {
        $this->setTitle('追加实盘金划拔');
        $this->setNavtitle('追加实盘金划拔');
        $add_id = isset($_GET['add_id']) ? intval($_GET['add_id']) : 0;
        $add_row = \Common\Query::selone('user_peizi_add', array('add_id' => intval($add_id)));
        $pz_row = \Common\Query::selone('user_peizi', array('pz_id' => intval($add_row['pz_id'])));
        $this->assign('add_row', $add_row);
        $this->assign('pz_row', $pz_row);
        $this->template('plusedit.php');
    }

    public function doPlusEdit() {
        $add_id = isset($_POST['add_id']) ? intval($_POST['add_id']) : 0;
        $status = isset($_POST['status']) ? intval($_POST['status']) : 0;
        $add_row = \Common\Query::selone('user_peizi_add', array('add_id' => $add_id));
        $peizi_row = \Model\Peizi\Peizi::getById($add_row['pz_id']);
        $url = '/index.php?app=admin&mod=peizi&ac=plusedit&add_id=' . $add_id;
        if (empty($add_id)) {
            $this->fontRedirect('参数错误', 'back', 2);
            exit();
        }
        if ($add_row['status'] == $status) {
            $this->fontRedirect('状态值未变化', 'back', 2);
            exit();
        }
        \Common\Query::commitstart();
        $udpin = array();
        $udpin['status'] = 1;
        $udpin['huabo_time'] = time();
        $res = \Common\Query::update('user_peizi_add', $udpin, array('add_id' => $add_id, 'status' => 0));
        if (!$res) {
            \Common\Query::rollback();
            $this->fontRedirect('提交失败', $url, 2);
            exit();
        }
        $res = \Model\Peizi\Peizi::doAdd($add_row['pz_id'], $add_row['add_money'], $add_row['add_bond']);
        if ($res[0] == 0) {
            \Common\Query::rollback();
            $this->fontRedirect($res[1], $url, 2);
            exit();
        }
        //赠送管理费
        $row_count = \Common\Query::sqlselone("select count(fund_id) total from user_fund_record where uid=".$peizi_row['uid']." and type=108");
        if(intval($row_count['total']) <=0){
            $params_send = \Model\Admin\Params::get('manage_send');
            $res = \Model\User\Fund::send_add($peizi_row['uid'], floatval($params_send['add'])*100,$add_row['pz_id']);
            if ($res[0] == 0) {
                \Common\Query::rollback();
                $this->fontRedirect($res[1], $url, 2);
                exit();
            }
        }
        
        \Common\Query::commit();
        //短信通知
        $user = \Model\User\UserInfo::getinfo($peizi_row['uid']);
        \Model\Api\Sms::smsSend($user['mobile'], \Model\Sys\SmsTemplet::peiziAddFundReceive(''));
        $this->fontRedirect('提交成功', $url, 2);
        exit();
    }

    //补亏划拨
    public function loss() {
        $this->setTitle('补亏划拨');
        $pagesize = 20;
        $condition['pz_id'] = isset($_GET ['pz_id']) ? $_GET ['pz_id'] : '';
        $condition['order_id'] = isset($_GET ['order_id']) ? $_GET ['order_id'] : '';
        $condition['status'] = isset($_GET ['status']) ? $_GET ['status'] : '0';
        $condition['begindate'] = isset($_GET ['begindate']) ? $_GET ['begindate'] : '';
        $condition['enddate'] = isset($_GET ['enddate']) ? $_GET ['enddate'] : '';
        $condition['pz_type'] = isset($_GET ['pz_type']) ? intval($_GET ['pz_type']) : 0;
        $curpage = isset($_GET ['page']) ? intval($_GET ['page']) : 1;
        $where = ' WHERE 1=1';
        if (!empty($condition['pz_id'])) {
            $where .= ' and loss.pz_id=' . intval($condition['pz_id']);
        }
        if (!empty($condition['order_id'])) {
            $pz_id = substr($condition['order_id'], 8);
            $where .= ' and loss.pz_id=' . intval($pz_id);
        }
        if ($condition['status'] != '') {
            $where .= ' and loss.status=' . intval($condition['status']);
        }
        if ($condition['begindate'] && $condition['enddate']) {
            $where .= " AND (FROM_UNIXTIME(loss.add_time,'%Y-%m-%d')>='" . ($condition['begindate']) . "' AND FROM_UNIXTIME(loss.add_time,'%Y-%m-%d')<='" . ($condition['enddate']) . "')";
        }
        if (!empty($condition['pz_type'])) {
            $where .= " and pz.pz_type=" . intval($condition['pz_type']);
        }
        $selarr = array('pz.*', 'loss.add_time', 'loss.add_loss', 'loss.status lossstatus', 'loss.fill_id', 'u.true_name');
        $order = ' ORDER BY loss.add_time DESC';
        $res = \Common\Pager::getList('user_peizi_fillloss loss left join user_peizi pz on loss.pz_id=pz.pz_id left join user_info u on pz.uid=u.uid', $where, $selarr, $order, $curpage, $pagesize, 1);

        $this->assign('list', $res['data']);
        $this->assign('pager', $res ['pager']);
        $this->assign('condition', $condition);
        $this->template('loss.php');
    }

    public function lossedit() {
        $this->setTitle('补亏划拨');
        $this->setNavtitle('补亏划拨');
        $fill_id = isset($_GET['fill_id']) ? intval($_GET['fill_id']) : 0;
        $fill_row = \Common\Query::selone('user_peizi_fillloss', array('fill_id' => intval($fill_id)));
        $pz_row = \Common\Query::selone('user_peizi', array('pz_id' => intval($fill_row['pz_id'])));
        $this->assign('fill_row', $fill_row);
        $this->assign('pz_row', $pz_row);
        $this->template('lossedit.php');
    }

    public function doLossEdit() {
        $fill_id = isset($_POST['fill_id']) ? intval($_POST['fill_id']) : 0;
        $status = isset($_POST['status']) ? intval($_POST['status']) : 0;
        $fill_row = \Common\Query::selone('user_peizi_fillloss', array('fill_id' => $fill_id));
        $peizi_row = \Model\Peizi\Peizi::getById($fill_row['pz_id']);
        $url = '/index.php?app=admin&mod=peizi&ac=lossedit&fill_id=' . $fill_id;
        if (empty($fill_id)) {
            $this->fontRedirect('参数错误', 'back', 2);
            exit();
        }
        if ($fill_row['status'] == $status) {
            $this->fontRedirect('状态值未变化', 'back', 2);
            exit();
        }
        $udpin = array();
        $udpin['status'] = 1;
        $udpin['huabo_time'] = time();
        $res = \Common\Query::update('user_peizi_fillloss', $udpin, array('fill_id' => $fill_id, 'status' => 0));
        if ($res) {
            //赠送管理费
            $row_count = \Common\Query::sqlselone("select count(fund_id) total from user_fund_record where uid=".$peizi_row['uid']." and type=109");
            if(intval($row_count['total']) <=0){
                $params_send = \Model\Admin\Params::get('manage_send');
                \Model\User\Fund::send_fill($peizi_row['uid'], floatval($params_send['fill'])*100,$fill_row['pz_id']);
            }
            //短信通知
            $user = \Model\User\UserInfo::getinfo($peizi_row['uid']);
            \Model\Api\Sms::smsSend($user['mobile'], \Model\Sys\SmsTemplet::peiziLossFundReceive(''));
            $this->fontRedirect('提交成功', $url, 2);
            exit();
        } else {
            $this->fontRedirect('提交失败', $url, 2);
            exit();
        }
    }

    //每日盈利结算
    public function daywin() {
        $this->setTitle('每日盈利结算');
        $pagesize = 20;
        $condition['order_id'] = isset($_GET ['order_id']) ? $_GET ['order_id'] : '';
        $condition['begindate'] = isset($_GET ['begindate']) ? $_GET ['begindate'] : '';
        $condition['enddate'] = isset($_GET ['enddate']) ? $_GET ['enddate'] : '';
        $curpage = isset($_GET ['page']) ? intval($_GET ['page']) : 1;
        $where = ' WHERE (pz.status=2 OR pz.status=3)';
        if (!empty($condition['order_id'])) {
            $pz_id = substr($condition['order_id'], 8);
            $where .= ' and pz.pz_id=' . intval($pz_id);
        }

        if ($condition['begindate'] && $condition['enddate']) {
            $where .= " AND (FROM_UNIXTIME(pz.pz_time,'%Y-%m-%d')>='" . ($condition['begindate']) . "' AND FROM_UNIXTIME(pz.pz_time,'%Y-%m-%d')<='" . ($condition['enddate']) . "')";
        }
        $selarr = array('pz.*', 'u.true_name');
        $order = ' ORDER BY pz.update_time DESC';
        $res = \Common\Pager::getList('user_peizi pz left join user_info u on pz.uid=u.uid', $where, $selarr, $order, $curpage, $pagesize, 1);

        $this->assign('list', $res['data']);
        $this->assign('pager', $res ['pager']);
        $this->assign('condition', $condition);
        $this->template('daywin.php');
    }

    public function daywin_up() {
        $ext = substr(strrchr($_FILES['ufile']['name'], '.'), 1);
        if ($ext != 'csv') {
            $this->fontRedirect('文件错误，只能上传csv文件', '/index.php?app=admin&mod=peizi&ac=daywin', 2);
            exit();
        }
        $fpath = SITEROOT . 'data' . DIRECTORY_SEPARATOR . 'upload' . DIRECTORY_SEPARATOR . uniqid() . '.' . $ext;
        $do = copy($_FILES['ufile']['tmp_name'], $fpath);
        if ($do) {
            echo "";
        } else {
            echo "上传文件失败<br>";
            exit();
        }
        $first_row = true;
        $handle = fopen($fpath, "r");
        \Common\Query::commitstart();
        while ($data = fgetcsv($handle, 10000, ",")) {
            if ($first_row) {
                $first_row = false;
                continue;
            }
            $data = eval('return ' . iconv('gbk', 'utf-8', var_export($data, true)) . ';');
            $account = $data[1];
            $row = \Common\Query::select('user_peizi', array('sp_user' => $account));
            if (count($row) == 0) {
                echo '账号：' . $account . '不存在，数据未处理<br>';
                continue;
            }
            if (count($row) > 1) {
                echo '账号：' . $account . '存在多条记录，数据未处理<br>';
                continue;
            }
            if ($row[0]['status'] == 2 || $row[0]['status'] == 3) {//操盘中，或申请结束状态才更新
                //更新资产
                $updarr['trade_balance'] = $data[6] * 100; //总资产
                /* if($data[6]*100>$row[0]['trade_balance']*1.2 || $data[6]*100<$row[0]['trade_balance']*0.8){
                  echo '账号：'.$account.'资产异常<br>';
                  continue;
                  } */
                $updarr['update_time'] = time();
                $updarr['profit_loss_money'] = $updarr['trade_balance'] - $row[0]['trade_money_total'] - $row[0]['fill_loss_money'];
                $res = \Common\Query::update('user_peizi', $updarr, array('sp_user' => $account));
                if (empty($res)) {
                    echo '导入失败<br>';
                    \Common\Query::rollback();
                    exit();
                }
                //添加记录
                $res = \Model\Peizi\Check::add($row[0]['pz_id'], $data[6]);
                if (empty($res)) {
                    echo '插入失败<br>';
                    \Common\Query::rollback();
                    exit();
                }
            }
            //$q="insert into records (name,classes,a_time,college,notify,receiver,r_time,handler) values ('$data[1]','$data[2]','$data[3]','$data[4]','$data[5]','$data[6]','$data[7]','$data[8]')"; 
            //mysql_query($q) or die (mysql_error()); 
        }
        \Common\Query::commit();
        fclose($handle);
        unlink($fpath);
        echo '导入成功<br>';
    }

    public function daywinedit() {
        $this->setTitle('每日盈利结算');
        $this->setNavtitle('每日盈利结算');
        $pz_id = isset($_GET['pz_id']) ? intval($_GET['pz_id']) : 0;
        $pz_row = \Common\Query::selone('user_peizi', array('pz_id' => intval($pz_id)));
        $this->assign('pz_row', $pz_row);
        $this->template('daywinedit.php');
    }

    public function doDaywinEdit() {
        $pz_id = isset($_POST['pz_id']) ? intval($_POST['pz_id']) : 0;
        $pz_row = \Model\Peizi\Peizi::getById($pz_id);
        $trade_balance = isset($_POST['trade_balance']) ? floatval($_POST['trade_balance']) * 100 : 0;
        /* if($trade_balance>$pz_row['trade_balance']*1.2 || $trade_balance<$pz_row['trade_balance']*0.8){
          $this->fontRedirect('资产值异常', 'back');
          exit();
          } */
        $url = '/index.php?app=admin&mod=peizi&ac=daywinedit&pz_id=' . $pz_id;
        if (empty($pz_id)) {
            $this->fontRedirect('参数错误', 'back');
            exit();
        }
        if (empty($trade_balance)) {
            $this->fontRedirect('参数错误', $url);
            exit();
        }

        $udpin['trade_balance'] = $trade_balance;
        $udpin['update_time'] = time();
        $udpin['profit_loss_money'] = $udpin['trade_balance'] - $pz_row['trade_money_total'] - $pz_row['fill_loss_money'];
        $res = \Common\Query::update('user_peizi', $udpin, array('pz_id' => $pz_id));
        if (!$res) {
            $this->fontRedirect('提交错误', $url, 2);
            exit();
        }
        $this->fontRedirect('提交成功', $url, 2);
    }

    //盈利提取
    public function win() {
        $this->setTitle('结束配资');
        $pagesize = 20;
        $condition['order_id'] = isset($_GET ['order_id']) ? $_GET ['order_id'] : '';
        $condition['status'] = isset($_GET ['status']) ? $_GET ['status'] : '';
        $condition['begindate'] = isset($_GET ['begindate']) ? $_GET ['begindate'] : '';
        $condition['enddate'] = isset($_GET ['enddate']) ? $_GET ['enddate'] : '';
        $condition['pz_type'] = isset ( $_GET ['pz_type'] ) ? intval($_GET ['pz_type']) :0;
        $curpage = isset($_GET ['page']) ? intval($_GET ['page']) : 1;
        $where = ' WHERE pz.pz_type in (1,2) ';
        if (!empty($condition['order_id'])) {
            $pz_id = substr($condition['order_id'], 8);
            $where .= ' and pz.pz_id=' . intval($pz_id);
        }
        if ($condition['status'] == '') {
            $where .= ' and (pz.status>1)';
        } else {
            $where .= ' and pz.status=' . intval($condition['status']);
        }
        if ($condition['begindate'] && $condition['enddate']) {
            $where .= " AND (FROM_UNIXTIME(pz.pz_time,'%Y-%m-%d')>='" . ($condition['begindate']) . "' AND FROM_UNIXTIME(pz.pz_time,'%Y-%m-%d')<='" . ($condition['enddate']) . "')";
        }
        if(!empty($condition['pz_type'])){
            $where .= " and pz.pz_type=".intval($condition['pz_type']);
        }
        $selarr = array('pz.*', 'u.true_name');
        $order = ' ORDER BY pz.pz_time DESC';
        $res = \Common\Pager::getList('user_peizi pz left join user_info u on pz.uid=u.uid', $where, $selarr, $order, $curpage, $pagesize, 1);

        $this->assign('list', $res['data']);
        $this->assign('pager', $res ['pager']);
        $this->assign('condition', $condition);
        $this->template('win.php');
    }

    public function winedit() {
        $this->setTitle('结束配资');
        $this->setNavtitle('结束配资');
        $pz_id = isset($_GET['pz_id']) ? intval($_GET['pz_id']) : 0;
        $pz_row = \Common\Query::selone('user_peizi', array('pz_id' => intval($pz_id)));
        $this->assign('pz_row', $pz_row);
        $this->template('winedit.php');
    }

    public function doWinEdit() {
        $pz_id = isset($_POST['pz_id']) ? intval($_POST['pz_id']) : 0;
        $pz_row = \Model\Peizi\Peizi::getById($pz_id);
        $trade_balance = isset($_POST['trade_balance']) ? floatval($_POST['trade_balance']) * 100 : 0;
        /* if($trade_balance>$pz_row['trade_balance']*1.2 || $trade_balance<$pz_row['trade_balance']*0.8){
          $this->fontRedirect('资产值异常', 'back');
          exit();
          } */
        $status = isset($_POST['status']) ? intval($_POST['status']) : 0;
        $url = '/index.php?app=admin&mod=peizi&ac=winedit&pz_id=' . $pz_id;
        if (empty($pz_id)) {
            $this->fontRedirect('参数错误', 'back');
            exit();
        }
        if (empty($trade_balance)) {
            $this->fontRedirect('参数错误', $url);
            exit();
        }
        if ($pz_row['status'] == $status) {
            $this->fontRedirect('状态值未变化', 'back', 2);
            exit();
        }
        //判断是否还有补亏未划拔
        $bk_row = \Common\Query::selone('user_peizi_fillloss', array('pz_id' => $pz_id, 'status' => 0), array('count(fill_id) as total'));
        if ($bk_row && $bk_row['total'] > 0) {
            $this->fontRedirect('还有补亏记录未划拔', $url);
            exit();
        }
        //判断是否还有追加配资未划拔
        $add_row = \Common\Query::selone('user_peizi_add', array('pz_id' => $pz_id, 'status' => 0), array('count(add_id) as total'));
        if ($add_row && $add_row['total'] > 0) {
            $this->fontRedirect('还有追加配资记录未划拔', $url);
            exit();
        }
        //状态修改
        $udpin['trade_balance'] = $trade_balance;
        $udpin['update_time'] = time();
        $udpin['status'] = 4;
        \Common\Query::commitstart();

        $res = \Common\Query::update('user_peizi', $udpin, array('pz_id' => $pz_id, 'status' => array('in', array(2, 3))));
        if (!$res) {
            \Common\Query::rollback();
            $this->fontRedirect('状态修改错误', $url, 2);
            exit();
        }
        //资金委托出股市 非p2p不用
        /* $res = \Model\User\Fund::tradeOut($pz_row['uid'],$pz_row['trade_balance'],$pz_row['pz_id']);
          if($res[0] == 0){
          \Common\Query::rollback();
          $this->fontRedirect($res[1], $url,2);
          exit();
          } */
        //结束操盘计算
        $res = \Model\Peizi\Peizi::end($pz_id);
        if ($res[0] == 0) {
            \Common\Query::rollback();
            $this->fontRedirect($res[1], $url, 2);
            exit();
        }
        \Common\Query::commit();
        //短信通知
        $user = \Model\User\UserInfo::getinfo($pz_row['uid']);
        \Model\Api\Sms::smsSend($user['mobile'], \Model\Sys\SmsTemplet::peiziEnd(''));
        $this->fontRedirect('提交成功', $url, 2);
    }

    public function doWinCancel() {
        $pz_id = isset($_GET['pz_id']) ? intval($_GET['pz_id']) : 0;
        $pz_row = \Model\Peizi\Peizi::getById($pz_id);
        $url = $_SERVER["HTTP_REFERER"]; // '/index.php?app=admin&mod=peizi&ac=win';
        if (empty($pz_id)) {
            $this->fontRedirect('参数错误', 'back');
            exit();
        }
        //状态修改
        $udpin['status'] = 2; //操盘

        $res = \Common\Query::update('user_peizi', $udpin, array('pz_id' => $pz_id, 'status' => 3));
        if (!$res) {
            $this->fontRedirect('退回失败', $url, 2);
            exit();
        }
        //短信通知
        $user = \Model\User\UserInfo::getinfo($pz_row['uid']);
        \Model\Api\Sms::smsSend($user['mobile'], \Model\Sys\SmsTemplet::peiziRequireEnd(''));
        $this->fontRedirect('退回成功', $url, 2);
    }

    //管理费不足
    public function mcost() {
        $this->setTitle('管理费不足');
        $pagesize = 20;
        $condition['order_id'] = isset($_GET ['order_id']) ? $_GET ['order_id'] : '';
        $condition['pz_type'] = isset ( $_GET ['pz_type'] ) ? intval($_GET ['pz_type']) :0;
        $curpage = isset($_GET ['page']) ? intval($_GET ['page']) : 1;
        $time = time();
        $tomorrow = $time + 20*3600;//执行通知的时间+20小时
        $where = ' where pz.status=2 and pz.pz_type in (1,2) and pz.manage_cost_day>u.balance+u.send and u.level=0 and pz.manage_cost_time<'.$tomorrow;
        if(!empty($condition['pz_type'])){
            $where .= " and pz.pz_type=".intval($condition['pz_type']);
        }
        $table = 'user_peizi pz LEFT JOIN user_info u on pz.uid=u.uid';
        $selarr = array('pz.*', 'u.true_name', 'u.mobile', 'u.balance', 'u.true_name');
        $order = '';
        $res = \Common\Pager::getList($table, $where, $selarr, $order, $curpage, $pagesize, 1);

        $this->assign('list', $res['data']);
        $this->assign('pager', $res ['pager']);
        $this->assign('condition', $condition);
        $this->template('mcost.php');
    }

    //免费体验
    public function free() {
        $this->setTitle('免费体验');
        $pagesize = 20;
        $condition['mobile'] = isset($_GET ['mobile']) ? $_GET ['mobile'] : '';
        $condition['true_name'] = isset($_GET ['true_name']) ? $_GET ['true_name'] : '';
        $condition['order_id'] = isset($_GET ['order_id']) ? $_GET ['order_id'] : '';
        $condition['status'] = isset($_GET ['status']) ? $_GET ['status'] : '';
        $condition['begindate'] = isset($_GET ['begindate']) ? $_GET ['begindate'] : '';
        $condition['enddate'] = isset($_GET ['enddate']) ? $_GET ['enddate'] : '';
        $curpage = isset($_GET ['page']) ? intval($_GET ['page']) : 1;
        $where = ' WHERE pz_type=4';
        if (!empty($condition['mobile'])) {
            $where .= ' and u.mobile=' . $condition['mobile'];
        }
        if (!empty($condition['true_name'])) {
            $where .= " and u.true_name='" . $condition['true_name']."'";
        }
        if (!empty($condition['order_id'])) {
            $pz_id = substr($condition['order_id'], 8);
            $where .= ' and pz_id=' . intval($pz_id);
        }
        if ($condition['status'] == '') {
            $where .= ' and (pz.status>1)';
        } else {
            $where .= ' and pz.status=' . intval($condition['status']);
        }
        if ($condition['begindate'] && $condition['enddate']) {
            $where .= " AND (FROM_UNIXTIME(pz_time,'%Y-%m-%d')>='" . ($condition['begindate']) . "' AND FROM_UNIXTIME(pz_time,'%Y-%m-%d')<='" . ($condition['enddate']) . "')";
        }
        $selarr = array('pz.*', 'u.true_name', 'u.mobile');
        $order = ' ORDER BY pz_time DESC';
        $res = \Common\Pager::getList('user_peizi pz left join user_info u on pz.uid=u.uid', $where, $selarr, $order, $curpage, $pagesize, 1);

        $this->assign('list', $res['data']);
        $this->assign('pager', $res ['pager']);
        $this->assign('condition', $condition);
        $this->template('free.php');
    }

    public function freeedit() {
        $this->setTitle('免费体验');
        $this->setNavtitle('免费体验');
        $pz_id = isset($_GET['pz_id']) ? intval($_GET['pz_id']) : 0;
        $pz_row = \Common\Query::selone('user_peizi', array('pz_id' => intval($pz_id)));
        $this->assign('pz_row', $pz_row);
        $this->template('freeedit.php');
    }

    public function doFreeEdit() {
        $pz_id = isset($_POST['pz_id']) ? intval($_POST['pz_id']) : 0;
        $pz_row = \Model\Peizi\Peizi::getById($pz_id);
        $trade_balance = isset($_POST['trade_balance']) ? floatval($_POST['trade_balance']) * 100 : 0;
        /* if($trade_balance>$pz_row['trade_balance']*1.2 || $trade_balance<$pz_row['trade_balance']*0.8){
          $this->fontRedirect('资产值异常', 'back');
          exit();
          } */
        $status = isset($_POST['status']) ? intval($_POST['status']) : 0;
        $url = '/index.php?app=admin&mod=peizi&ac=freeedit&pz_id=' . $pz_id;
        if (empty($pz_id)) {
            $this->fontRedirect('参数错误', 'back');
            exit();
        }
        if (empty($trade_balance)) {
            $this->fontRedirect('参数错误', $url);
            exit();
        }
        if ($pz_row['status'] == $status) {
            $this->fontRedirect('状态值未变化', 'back', 2);
            exit();
        }

        $udpin['trade_balance'] = $trade_balance;
        $udpin['update_time'] = time();
        $udpin['status'] = 4;
        \Common\Query::commitstart();
        //状态修改
        $res = \Common\Query::update('user_peizi', $udpin, array('pz_id' => $pz_id, 'status' => array('in', array(2, 3))));
        if (!$res) {
            \Common\Query::rollback();
            $this->fontRedirect('状态修改错误', $url, 2);
            exit();
        }
        //资金委托出股市 非p2p不用
        /* $res = \Model\User\Fund::tradeOut($pz_row['uid'],$pz_row['trade_balance'],$pz_row['pz_id']);
          if($res[0] == 0){
          \Common\Query::rollback();
          $this->fontRedirect($res[1], $url,2);
          exit();
          } */
        //结束操盘计算
        $res = \Model\Peizi\Peizi::end($pz_id);
        if ($res[0] == 0) {
            \Common\Query::rollback();
            $this->fontRedirect($res[1], $url, 2);
            exit();
        }
        \Common\Query::commit();
        //短信通知
        $user = \Model\User\UserInfo::getinfo($pz_row['uid']);
        \Model\Api\Sms::smsSend($user['mobile'], \Model\Sys\SmsTemplet::peiziEnd(''));
        $this->fontRedirect('提交成功', $url, 2);
    }
 
    public function invitview() {
        $this->setTitle('配资记录');
        $pagesize = 20;
        $curpage = isset ( $_GET ['page'] ) ? intval ( $_GET ['page'] ) : 1;
        $introducer_id = isset ( $_GET ['introducer_id'] ) ? intval ( $_GET ['introducer_id'] ) : 0;

        $where = ' WHERE pz.pz_type in(1,2) and pz.uid in (select uid from user_peizi where pz_type in(1,2) group by uid having sum(bond_total)>1000000) and  introducer_id='.$introducer_id;
        $selarr = array ('pz.*','u.mobile','u.true_name' );
        $order = ' ORDER BY pz.uid DESC';

        $res = \Common\Pager::getList ( 'user_peizi pz left join user_info u on pz.uid=u.uid', $where, $selarr, $order, $curpage, $pagesize, 1 );

        $this->assign ( 'list', $res['data']);
        $this->assign ( 'pager', $res ['pager'] );
        $this->assign ( 'condition', $condition);
        $this->template ( 'invitview.php' );
    }
}

?>