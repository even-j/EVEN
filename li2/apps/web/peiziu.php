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

class peiziu extends \apps\UserControl {

    //put your code here
    public function peizi() {
        $deposit = isset($_GET ['deposit']) ? floatval($_GET ['deposit']) : 0;
        $pz_ratio = isset($_GET ['risk']) ? intval($_GET ['risk']) : 5;
        $pz_type = isset($_GET ['pz_type']) ? intval($_GET ['pz_type']) : 1;
        $duration = isset($_GET ['duration']) ? intval($_GET ['duration']) : 1;
        $trade_time = isset($_GET ['trade_time']) ? intval($_GET ['trade_time']) : 0;

        $title = '';
        if ($pz_type == 1) {
            $title = '按天配资';
        } elseif ($pz_type == 2) {
            $title = '按月配资';
        } elseif ($pz_type == 4) {
            $title = '免费体验';
        }
        $this->setTitle($title . '—' . SITE_TITLE);
        $error_msg = '';
        if (!\Model\User\UserInfo::checkBindInfo($this->uid)) {
            //$this->fontRedirect('实名身份信息未绑定，请先绑定实名信息', \App::URL('web/user/account'),3);
            $error_msg = '实名身份信息未绑定，请先绑定实名信息 <a href="' . \App::URL('web/user/account') . '" style="font-size:14px;color:blue">绑定实名</a>';
        }

        if (($pz_type == 1 || $pz_type == 2) && $deposit == 0) {
            $error_msg = '参数错误';
        }
        if ($pz_type == 4) { //免费体验
            $row_tmp = \Common\Query::select('user_peizi', array('uid' => $this->uid, 'pz_type' => 4));
            if ($row_tmp) {
                $error_msg = '您已经免费体验过，不能再次体验!';
            }
        }
        $var ['pz_type'] = $pz_type;
        $var ['pz_ratio'] = $pz_ratio;
        $var ['deposit'] = $deposit;
        $var ['duration'] = $duration;
        $var ['trade_time'] = $trade_time;
        $this->assign('var', $var);
        $this->assign('error_msg', $error_msg);
        $this->assign('params', $params);
        $this->assign('user', $this->user);
        $this->template('peizi.php');
    }

    public function daywinadd() {
        $result ['status'] = 0;
        $result ['msg'] = '';
        $params = \Model\Admin\Params::get('peizi');
        $pz_ratio = isset($_POST ['pz_ratio']) ? intval($_POST ['pz_ratio']) : 5;
        $pz_type = isset($_POST ['pz_type']) ? intval($_POST ['pz_type']) : 1;
        $deposit = isset($_POST ['deposit']) ? intval($_POST ['deposit']) : 0;
        $duration = isset($_POST ['duration']) ? intval($_POST ['duration']) : 2;
        $trade_time = isset($_POST ['trade_time']) ? intval($_POST ['trade_time']) : 0;

        //$money = isset($_GET['money']) ?intval($_GET['money']):0;
        //$days = isset($_GET['days']) ?intval($_GET['days']):0;
        if (!\Model\User\UserInfo::checkBindInfo($this->uid)) {
            $result ['status'] = 0;
            $result ['msg'] = '用户未绑定实名信息';
            exit(json_encode($result));
        }
        if ($pz_type == 1 || $pz_type == 2 || $pz_type == 7) {
            if ($deposit == 0) {
                $result ['status'] = 0;
                $result ['msg'] = '参数错误';
                exit(json_encode($result));
            }
        } else if ($pz_type == 4) {
            $params = \Model\Admin\Params::get('peizi_free');
            $count = \Model\Peizi\Peizi::getPeiziFreeCountCurDay();
            if ($params ['status'] == 0) {
                $result ['status'] = 0;
                $result ['msg'] = '活动暂停';
                exit(json_encode($result));
            }
            if ($count >= $params ['per_day_count']) {
                $result ['status'] = 0;
                $result ['msg'] = '超出当天免费体验数';
                exit(json_encode($result));
            }
            $row_tmp = \Common\Query::select('user_peizi', array('uid' => $this->uid, 'pz_type' => 4));
            if ($row_tmp) {
                $result ['status'] = 0;
                $result ['msg'] = '您已经免费体验过，不能再次体验!';
                exit(json_encode($result));
            }
        }
        \Common\Query::commitstart();
        //判断余额
        $calc = array();
        if ($pz_type == 1) {
            $unit = 1; //按天
            $calc = \Model\Peizi\Peizi::calc_month($this->uid,$pz_type, intval($deposit), $pz_ratio);
        } 
        else if ($pz_type == 2 || $pz_type == 7) {
            $calc = \Model\Peizi\Peizi::calc_month($this->uid,$pz_type, intval($deposit), $pz_ratio);
            $unit = 3; //按月
        } else if ($pz_type == 4) {
            $unit = 1; //按天
            $calc = \Model\Peizi\Peizi::calc_free($this->uid);
        }
        if ($calc [0] == 0) {
            $result ['status'] = 0;
            $result ['msg'] = $calc [1];
            exit(json_encode($result));
        }

        $feiyong = $calc [1];
        $manage_cost_money = $feiyong ['manage_cost_day']*$duration;
        $bond = $feiyong ['bond'];
        if ($this->user ['balance'] < $bond) {
            \Common\Query::rollback();
            $result ['code'] = 0;
            $result ['msg'] = '余额不足';
            exit(json_encode($result));
        }
        if ((floatval($this->user ['balance']) + floatval($this->user ['send'])) < ($manage_cost_money + $bond)) {
            \Common\Query::rollback();
            $result ['status'] = 0;
            $result ['msg'] = '余额不足';
            exit(json_encode($result));
        }
        //添加策略记录
        $res = \Model\Peizi\Peizi::add($pz_type, $this->uid, intval($deposit), $pz_ratio, $duration, $unit,$trade_time, $sp_type );
        if ($res [0] == 0) {
            \Common\Query::rollback();
            $result ['status'] = 0;
            $result ['msg'] = $res [1];
            exit(json_encode($result));
        }
        $peizi_row = $res [1];

        //冻结保证金
        $bond = intval($peizi_row ['bond_init']);
        $res = \Model\User\Fund::bond($peizi_row ['uid'], $bond, $peizi_row ['pz_id']);
        if ($res [0] == 0) {
            \Common\Query::rollback();
            $result ['status'] = 0;
            $result ['msg'] = $res [1];
            exit(json_encode($result));
        }
        //修改策略状态
        $status = 1; //支付状态
        if ($pz_type == 4) {
            $status = 2; //免费体验状态直接为操盘中
        }
        $sql = 'update user_peizi set status=' . $status . ' where status=0 and pz_id=' . $peizi_row ['pz_id'];
        $res = \Common\Query::sqlquery($sql);
        if (empty($res)) {
            \Common\Query::rollback();
            $result ['status'] = 0;
            $result ['msg'] = '修改支付状态失败';
            exit(json_encode($result));
        }
        //成功
        \Common\Query::commit();
        $result ['status'] = 1;
        $result ['msg'] = $peizi_row ['pz_id'];
        exit(json_encode($result));
    }

    public function daywin3() {
        $this->setTitle('按日策略—' . SITE_NAME);
        $pz_id = isset($_GET ['pz_id']) ? $_GET ['pz_id'] : 0;
        $pz_type = isset($_GET ['pz_type']) ? intval($_GET ['pz_type']) : 1;
        $pz_row = \Common\Query::selone('user_peizi', array('pz_id' => $pz_id, 'uid' => $this->uid));
        if ($pz_type == 1) {
            $params = \Model\Admin\Params::get('peizi');
        } else if ($pz_type == 2) {
            $params = \Model\Admin\Params::get('peizi_month');
        }
        $var ['pz_type'] = $pz_type;
        $this->assign('var', $var);
        $this->assign('pz_row', $pz_row);
        $this->assign('params', $params);
        $this->template('daywin3.php');
    }

    public function p2p2() {
        $this->setTitle('我要策略—' . SITE_NAME);
        $error_msg = '';
        if (!\Model\User\UserInfo::checkBindInfo($this->uid)) {
            //$this->fontRedirect('实名身份信息未绑定，请先绑定实名信息', \App::URL('web/user/account'),3);
            $error_msg = '实名身份信息未绑定，请先绑定实名信息 <a href="' . \App::URL('web/user/account') . '" style="font-size:14px;color:blue">绑定实名</a>';
        }
        $params = \Model\Admin\Params::get('p2p');
        $pz_money = isset($_GET ['pz_money']) ? $_GET ['pz_money'] : '';
        $pz_ratio = isset($_GET ['pz_ratio']) ? $_GET ['pz_ratio'] : '';
        $day_month = isset($_GET ['day_month']) ? $_GET ['day_month'] : ''; //按月1，按日2
        $days = isset($_GET ['days']) ? $_GET ['days'] : '';
        $rate = isset($_GET ['rate']) ? $_GET ['rate'] : '';
        $fencheng = isset($_GET ['fencheng']) ? $_GET ['fencheng'] : '';
        $pz_type = isset($_GET ['pz_type']) ? $_GET ['pz_type'] : '';
        if ($pz_money == '' || $pz_ratio == '' || $day_month == '' || $days == '' || $rate == '' || $fencheng == '' || $pz_type == '') {
            $this->fontRedirect('参数错误', \App::URL('web/peizi/p2p'), 2);
        }
        $var ['pz_money'] = $pz_money;
        $var ['bond'] = $pz_money * 10000 / $pz_ratio;
        if ($day_month == 3) { //月
            $var ['interest'] = round($pz_money * 10000 * $rate / 100 / 12, 2);
            $var ['service'] = round($pz_money * 10000 * $params ['service_cost_rate' . $pz_ratio] / 100 + $params ['manage_cost_money'] / 100, 2);
        } else { //天
            $var ['interest'] = round($pz_money * 10000 * $rate / 100 / 12 / 30 * $days, 2);
            $var ['service'] = round($pz_money * 10000 * $params ['service_cost_rate' . $pz_ratio] / 100 / 30 * $days + $params ['manage_cost_money'] / 100, 2);
        }
        $var ['cost'] = $var ['bond'] + $var ['interest'] + $var ['service'];
        $var ['balance'] = $this->user ['balance'] / 100;
        $var ['pz_ratio'] = $pz_ratio;
        $var ['days'] = $days;
        $var ['day_month'] = $day_month;
        $var ['rate'] = $rate;
        $var ['fencheng'] = $fencheng;
        $var ['pz_type'] = $pz_type;
        $feiyong = \Model\P2p\Peizi::calc($this->uid, $pz_money, $pz_ratio, $day_month, $days, $rate);
        $var ['alarm_money'] = $feiyong ['alarm_money'];
        $var ['stop_money'] = $feiyong ['stop_money'];

        $this->assign('var', $var);
        $this->assign('error_msg', $error_msg);
        $this->assign('user', $this->user);
        $this->template('p2p2.php');
    }

    public function p2padd() {
        $result = array();

        $pz_money = isset($_REQUEST ['pz_money']) ? $_REQUEST ['pz_money'] : '';
        $pz_ratio = isset($_REQUEST ['pz_ratio']) ? $_REQUEST ['pz_ratio'] : '';
        $day_month = isset($_REQUEST ['day_month']) ? $_REQUEST ['day_month'] : '';
        $days = isset($_REQUEST ['days']) ? $_REQUEST ['days'] : '';
        $rate = isset($_REQUEST ['rate']) ? $_REQUEST ['rate'] : '';
        $fencheng = isset($_REQUEST ['fencheng']) ? $_REQUEST ['fencheng'] : '';
        $pz_type = isset($_REQUEST ['pz_type']) ? $_REQUEST ['pz_type'] : '';
        if ($pz_money == '' || $pz_ratio == '' || $day_month == '' || $days == '' || $rate == '' || $fencheng == '' || $pz_type == '') {
            $result ['status'] = 0;
            $result ['msg'] = '参数错误';
            exit(json_encode($result));
        }
        if ($pz_type == 3) { //p2p
            $fencheng = 0;
        } else if ($pz_type == 5) { //分成
            $pz_ratio = 5;
            $rate = 5;
            $fencheng = 20;
        }
        //余额判断
        $feiyong = \Model\P2p\Peizi::calc($this->uid, $pz_money, $pz_ratio, $day_month, $days, $rate);
        if ($this->user ['balance'] < $feiyong ['bond'] + $feiyong ['interest'] + $feiyong ['service_money'] + $feiyong ['manage_money']) {
            $result ['status'] = 0;
            $result ['msg'] = '余额不足' . ($feiyong ['bond']);
            exit(json_encode($result));
        }
        \Common\Query::commitstart();
        $res = \Model\P2p\Peizi::add($this->uid, $pz_type, $pz_money, $pz_ratio, $day_month, $days, $rate, $fencheng);
        if ($res [0] == 0) {
            \Common\Query::rollback();
            $result ['status'] = 0;
            $result ['msg'] = $res [1];
            exit(json_encode($result));
        }
        $p2p_row = $res [1];
        //冻结保证金
        $res = \Model\User\Fund::bond($this->uid, $feiyong ['bond'], $p2p_row ['pz_id'], 'user_peizi');
        if ($res [0] == 0) {
            \Common\Query::rollback();
            $result ['status'] = 0;
            $result ['msg'] = $res [1];
            exit(json_encode($result));
        }
        //支付利息
        $res = \Model\User\Fund::interestPay($this->uid, $feiyong ['interest'], $p2p_row ['pz_id'], 'user_peizi');
        if ($res [0] == 0) {
            \Common\Query::rollback();
            $result ['status'] = 0;
            $result ['msg'] = $res [1];
            exit(json_encode($result));
        }
        //支付管理费
        $res = \Model\User\Fund::managecostPay($this->uid, $feiyong ['service_money'] + $feiyong ['manage_money'], $p2p_row ['pz_id'], 'user_peizi');
        if ($res [0] == 0) {
            \Common\Query::rollback();
            $result ['status'] = 0;
            $result ['msg'] = $res [1];
            exit(json_encode($result));
        }
        //实际支付管理费、利息
        $sql = 'update user_peizi set manage_cost_act=manage_cost_act+' . ($feiyong ['service_money'] + $feiyong ['manage_money'] + $feiyong ['interest']) . ' where pz_id=' . $p2p_row ['pz_id'];
        $res = \Common\Query::sqlquery($sql);
        if (!$res) {
            \Common\Query::rollback();
            $result ['status'] = 0;
            $result ['msg'] = '更新实际支付管理费、利息失败';
            exit(json_encode($result));
        }
        \Common\Query::commit();
        $result ['status'] = 1;
        $result ['msg'] = $p2p_row ['pz_id'];
        exit(json_encode($result));
    }

    public function p2p3() {
        $this->setTitle('我要策略—' . SITE_NAME);
        $params = \Model\Admin\Params::get('p2p');
        $pz_id = isset($_GET ['pz_id']) ? intval($_GET ['pz_id']) : 0;
        $p2p_row = \Model\P2p\Peizi::getRowById($pz_id, $this->uid);
        if (!$p2p_row) {
            $this->fontRedirect('该策略单号不存在', \App::URL('web/user/p2p_peizi'));
        }
        $var ['touzi_money'] = \Model\P2p\Peizi::getTouziMoney($pz_id);
        $var ['touzi_per'] = round($var ['touzi_money'] / $p2p_row ['pz_money'] * 100, 2);
        if ($p2p_row ['pz_times_unit'] == 1) {
            $var ['js_des'] = '(借款金额 x ' . $p2p_row ['service_rate'] . '% x 借款天数 /30)+' . $p2p_row ['manage_money'] / 100 . '元';
        } else {
            $var ['js_des'] = '(借款金额 x ' . $p2p_row ['service_rate'] . '% x 借款月数)+' . $p2p_row ['manage_money'] / 100 . '元';
        }

        //资金记录
        $sql = "select * from user_fund_record where uid=" . $this->uid . " and table_name='user_peizi' and rec_id=" . $pz_id;
        $fund_rows = \Common\Query::sqlsel($sql);

        $this->assign('var', $var);
        $this->assign('fund_rows', $fund_rows);
        $this->assign('p2p_row', $p2p_row);
        $this->template('p2p3.php');
    }

    public function p2p4() {
        $this->setTitle('策略详情 —' . SITE_NAME);
        $pz_id = isset($_GET ['pz_id']) ? intval($_GET ['pz_id']) : 0;
        $uid = $this->uid;
        $data = \Model\P2p\Peizi::getPeiziById($this->uid, $pz_id);
        if (!$data || ($data && $data ['pz_type'] != 3 && $data && $data ['pz_type'] != 5)) {
            $this->fontRedirect('该策略单号不存在', \App::URL('web/user/p2p_peizi'));
        }
        $status = array('0' => '未交保证金', '1' => '等待审核', '2' => '募资中', '3' => '募资已取消', '4' => '募资成功', '5' => '申请结束操盘，等待清算中', '6' => '操盘中', '7' => '已平仓结束');

        $data ['o_status'] = isset($data ['p2pstatus']) ? $status [$data ['p2pstatus']] : '未支付';

        if ($data ['p2pstatus'] == 4 && $data ['status'] == 1) { //满标未划拔
            $data ['o_status'] = '等待操盘帐号分配';
        }
        if (!$data['sp_user'] && $data ['p2pstatus'] == 6) {
            $data['o_status'] = '即将分配操盘帐号';
        }

        if ($data['status'] == 3) {
            $data ['o_status'] = '申请结束操盘，等待清算中';
        }
        if ($data ['p2pstatus'] >= 6 && $data ['status'] == 4) { //可能存在终止操盘，但不结束策略
            $cpyk = intval($data['profit_loss_money'] / 100);
            $cpyk = $cpyk > 0 ? '<span class="red">' . $cpyk . '</span>' : '<span class="green">' . $cpyk . '</span>';
            $data ['o_status'] = '已平仓结束<br/>操盘盈亏：' . $cpyk;
        }
        $var ['touzi_money'] = \Model\P2p\Peizi::getTouziMoney($pz_id);
        $var ['touzi_per'] = round($var ['touzi_money'] / $data ['pz_money'] * 100, 2);
        if ($data ['pz_times_unit'] == 1) {
            $var ['js_des'] = '(借款金额 x ' . $data ['service_rate'] . '% x 借款天数 /30)+' . $data ['manage_money'] / 100 . '元';
        } else {
            $var ['js_des'] = '(借款金额 x ' . $data ['service_rate'] . '% x 借款月数)+' . $data ['manage_money'] / 100 . '元';
        }

        //资金记录
        $fundList = \Model\User\Fund::getFundListById($pz_id, $this->uid);
        $this->assign('var', $var);
        $this->assign('fundList', $fundList);
        $this->assign('data', $data);
        $this->template('p2p4.php');
    }

    public function earn2add() {

        $pz_id = isset($_GET ['pz_id']) ? intval($_GET ['pz_id']) : 0;
        $money_yuan = isset($_GET ['money']) ? floatval($_GET ['money']) : 0;
        $money_fen = $money_yuan * 100;
        $pz_row = \Model\P2p\Peizi::getRowById($pz_id);
        if ($pz_row ['p2pstatus'] != 2) {
            $result ['status'] = 0;
            $result ['msg'] = '策略记录状态错误';
            exit(json_encode($result));
        }
        \Common\Query::commitstart();
        //更新主表投资金额，防止多插入数据
        $sql = 'select has_touzi_money from user_peizi where pz_id=' . $pz_id . ' for update';
        $row = \Common\Query::sqlselone($sql);
        if ($row ['has_touzi_money'] + $money_fen <= $pz_row ['pz_money']) {
            if ($row ['has_touzi_money'] + $money_fen < $pz_row ['pz_money']) {
                $sql = 'update user_peizi set has_touzi_money=has_touzi_money+' . $money_fen . ' where pz_id=' . $pz_id;
            } else if ($row ['has_touzi_money'] + $money_fen == $pz_row ['pz_money']) {
                $sql = 'update user_peizi set has_touzi_money=has_touzi_money+' . $money_fen . ',p2pstatus=4,manbiao_time=' . time() . ' where pz_id=' . $pz_id; //同时更新满标状态,满标时间
            }
            $res = \Common\Query::sqlquery($sql);
            if (empty($res)) {
                \Common\Query::rollback();
                $result ['status'] = 0;
                $result ['msg'] = '更新主表投资金额失败';
                exit(json_encode($result));
            }
        } else {
            \Common\Query::rollback();
            $result ['status'] = 0;
            $result ['msg'] = '超出总策略金额';
            exit(json_encode($result));
        }
        //添加记录
        $res = \Model\P2p\Touzi::add($this->uid, $pz_id, $money_yuan);
        if ($res [0] == 0) {
            \Common\Query::rollback();
            $result ['status'] = 0;
            $result ['msg'] = $res [1];
            exit(json_encode($result));
        }
        $tz_row = $res [1];
        //投资支出
        $res = \Model\User\Fund::creditor_out($this->uid, $money_fen, $tz_row ['tz_id']);
        if ($res [0] == 0) {
            \Common\Query::rollback();
            $result ['status'] = 0;
            $result ['msg'] = $res [1];
            exit(json_encode($result));
        }
        \Common\Query::commit();
        $result ['status'] = 1;
        $result ['msg'] = $tz_row ['tz_id'];
        exit(json_encode($result));
    }

    public function earn3() {
        $this->setTitle('我要赚钱—' . SITE_NAME);
        $tz_id = isset($_GET ['tz_id']) ? $_GET ['tz_id'] : 0;
        $tz_row = \Model\P2p\Touzi::getRowById($tz_id, $this->uid);
        $p2p_row = \Model\P2p\Peizi::getRowById($tz_row ['pz_id']);

        $this->assign('tz_row', $tz_row);
        $this->assign('p2p_row', $p2p_row);
        $this->template('earn3.php');
    }

}
