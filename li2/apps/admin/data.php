<?php

namespace apps\admin;

class data extends \apps\AdminControl {

    //用户增长数
    public function increase() {
        $this->setTitle('用户增长');
        $pagesize = 20;
        $curpage = isset($_GET ['page']) ? intval($_GET ['page']) : 1;
        $where = ' WHERE 1=1';
        $condition = array('begindate' => '', 'enddate' => '');
        $begindate = isset($_GET ['begindate']) ? $_GET ['begindate'] : $condition ['begindate'];
        $enddate = isset($_GET ['enddate']) ? $_GET ['enddate'] : $condition ['enddate'];
        if ($begindate && $enddate) {
            $condition ['begindate'] = $begindate;
            $condition ['enddate'] = $enddate;
            $where .= " AND (FROM_UNIXTIME(reg_time,'%Y-%m-%d')>='" . ($begindate) . "' AND FROM_UNIXTIME(reg_time,'%Y-%m-%d')<='" . ($enddate) . "')";
        }

        $selarr = array('COUNT(uid) AS num', 'FROM_UNIXTIME(reg_time,"%Y-%m-%d") AS reg_time');
        $order = ' ORDER BY reg_time DESC';
        $groupby = ' GROUP BY FROM_UNIXTIME(reg_time,"%Y-%m-%d")';
        $res = \Common\Pager::getList('user_info', $where, $selarr, $order, $curpage, $pagesize, 1, $groupby);
        $data = $list = array();
        foreach ($res ['data'] as $row) {
            $list [] = $row;
        }
        $data['total'] = \Model\User\UserInfo::get_total_users();

        $this->assign('condition', $condition);
        $this->assign('data', $data);
        $this->assign('list', $list);
        $this->assign('pager', $res ['pager']);
        $this->template('increase.php');
    }

    //用户活跃数
    public function active() {
        $this->setTitle('用户活跃');
        $pagesize = 20;
        $curpage = isset($_GET ['page']) ? intval($_GET ['page']) : 1;
        $where = ' WHERE 1=1';
        $condition = array('begindate' => '', 'enddate' => '');
        $begindate = isset($_GET ['begindate']) ? $_GET ['begindate'] : $condition ['begindate'];
        $enddate = isset($_GET ['enddate']) ? $_GET ['enddate'] : $condition ['enddate'];
        if ($begindate && $enddate) {
            $condition ['begindate'] = $begindate;
            $condition ['enddate'] = $enddate;
            $where .= " AND (FROM_UNIXTIME(log.login_time,'%Y-%m-%d')>='" . ($begindate) . "' AND FROM_UNIXTIME(log.login_time,'%Y-%m-%d')<='" . ($enddate) . "')";
        }

        $selarr = array('COUNT(DISTINCT log.uid) AS num', 'FROM_UNIXTIME(log.login_time,"%Y-%m-%d") AS login_time');
        $order = ' ORDER BY login_time DESC';
        $groupby = ' GROUP BY FROM_UNIXTIME(log.login_time,"%Y-%m-%d")';
        $res = \Common\Pager::getList(' user_login_logs AS log', $where, $selarr, $order, $curpage, $pagesize, 1, $groupby);

        $total_users = \Model\User\UserInfo::get_total_users();
        $data = $list = array();
        $total = $total_per = 0;
        foreach ($res ['data'] as $row) {
            $row ['num_per'] = sprintf("%.2f", $row ['num'] * 100 / $total_users) . '%';
            $list [] = $row;
        }
        $total = \Model\User\UserInfo::get_total_logins();

        $data['total'] = $total;
        $total_per = floatval($total * 100 / $total_users);
        $data['total_per'] = sprintf("%.2f", $total_per) . '%';
        $this->assign('condition', $condition);
        $this->assign('data', $data);
        $this->assign('list', $list);
        $this->assign('pager', $res ['pager']);
        $this->template('active.php');
    }

    //用户充值
    public function recharge() {
        $this->setTitle('用户充值');
        $pagesize = 20;
        $curpage = isset($_GET ['page']) ? intval($_GET ['page']) : 1;
        $where = ' WHERE  status=1';
        $condition = array('begindate' => '', 'enddate' => '');
        $begindate = isset($_GET ['begindate']) ? $_GET ['begindate'] : $condition ['begindate'];
        $enddate = isset($_GET ['enddate']) ? $_GET ['enddate'] : $condition ['enddate'];
        if ($begindate && $enddate) {
            $condition ['begindate'] = $begindate;
            $condition ['enddate'] = $enddate;
            $where .= " AND (FROM_UNIXTIME(rtime,'%Y-%m-%d')>='" . ($begindate) . "' AND FROM_UNIXTIME(rtime,'%Y-%m-%d')<='" . ($enddate) . "')";
        }

        $selarr = array('COUNT(DISTINCT uid) AS num', 'SUM(money) as money', 'FROM_UNIXTIME(rtime,"%Y-%m-%d") AS rtime');
        $order = ' ORDER BY rtime DESC';
        $groupby = ' GROUP BY FROM_UNIXTIME(rtime,"%Y-%m-%d")';
        $res = \Common\Pager::getList('v_recharge_record', $where, $selarr, $order, $curpage, $pagesize, 1, $groupby);

        $total_users = \Model\User\UserInfo::get_total_users();
        $data = $list = array();
        $total = $total_per = 0;
        foreach ($res ['data'] as $row) {
            $row ['num_per'] = sprintf("%.2f", $row ['num'] * 100 / $total_users) . '%';
            $row ['money'] = '¥' . number_format($row ['money'] / 100, 2);
            $list [] = $row;
        }
        $total = \Model\User\UserInfo::get_total_user_by_type();
        $data['total'] = "--";//$total;
        $total_money = \Common\Pager::getList('v_recharge_record', $where, $selarr, $order, $curpage, $pagesize, 1, '');
        $data['total_money'] = '¥' . number_format(floatval($total_money['data'][0]['money']) / 100, 2);
        $total_per = floatval($total * 100 / $total_users);
        $data['total_per'] = "--";//sprintf("%.2f", $total_per) . '%';
        $this->assign('condition', $condition);
        $this->assign('data', $data);
        $this->assign('list', $list);
        $this->assign('pager', $res ['pager']);
        $this->template('recharge.php');
    }

    //用户提现
    public function tixian() {
        $this->setTitle('用户提现');
        $pagesize = 20;
        $curpage = isset($_GET ['page']) ? intval($_GET ['page']) : 1;
        $where = ' WHERE status=2';
        $condition = array('begindate' => '', 'enddate' => '');
        $begindate = isset($_GET ['begindate']) ? $_GET ['begindate'] : $condition ['begindate'];
        $enddate = isset($_GET ['enddate']) ? $_GET ['enddate'] : $condition ['enddate'];
        if ($begindate && $enddate) {
            $condition ['begindate'] = $begindate;
            $condition ['enddate'] = $enddate;
            $where .= " AND (FROM_UNIXTIME(rtime,'%Y-%m-%d')>='" . ($begindate) . "' AND FROM_UNIXTIME(rtime,'%Y-%m-%d')<='" . ($enddate) . "')";
        }

        $selarr = array('COUNT(DISTINCT uid) AS num', 'SUM(money) as money', 'FROM_UNIXTIME(rtime,"%Y-%m-%d") AS rtime');
        $order = ' ORDER BY rtime DESC';
        $groupby = ' GROUP BY FROM_UNIXTIME(rtime,"%Y-%m-%d")';
        $res = \Common\Pager::getList('user_withdraw_record', $where, $selarr, $order, $curpage, $pagesize, 1, $groupby);

        $total_users = \Model\User\UserInfo::get_total_users();
        $data = $list = array();
        $total = $total_per = 0;
        foreach ($res ['data'] as $row) {
            $row ['num_per'] = sprintf("%.2f", $row ['num'] * 100 / $total_users) . '%';
            $row ['money'] = '¥' . number_format($row ['money'] / 100, 2);
            $list [] = $row;
        }
        $total = \Model\User\UserInfo::get_total_user_by_type(2);
        $data['total'] = "--";//$total;
        $total_money = \Common\Pager::getList('user_withdraw_record', $where, $selarr, $order, $curpage, $pagesize, 1, '');
        $data['total_money'] = '¥' . number_format(floatval($total_money['data'][0]['money']) / 100, 2);
        $total_per = floatval($total * 100 / $total_users);
        $data['total_per'] = "--";//sprintf("%.2f", $total_per) . '%';
        $this->assign('condition', $condition);
        $this->assign('data', $data);
        $this->assign('list', $list);
        $this->assign('pager', $res ['pager']);
        $this->template('tixian.php');
    }

    //配资数据
    public function peizi() {
        $this->setTitle('配资数据');
        $pagesize = 20;
        $curpage = isset($_GET ['page']) ? intval($_GET ['page']) : 1;
        $where = ' WHERE 1=1';
        $condition = array('begindate' => '', 'enddate' => '');
        $begindate = isset($_GET ['begindate']) ? $_GET ['begindate'] : $condition ['begindate'];
        $enddate = isset($_GET ['enddate']) ? $_GET ['enddate'] : $condition ['enddate'];
        if ($begindate && $enddate) {
            $condition ['begindate'] = $begindate;
            $condition ['enddate'] = $enddate;
            $where .= " AND (FROM_UNIXTIME(pz_time,'%Y-%m-%d')>='" . ($begindate) . "' AND FROM_UNIXTIME(pz_time,'%Y-%m-%d')<='" . ($enddate) . "')";
        }
        $selarr = array('COUNT(distinct uid) AS user_count', 'sum(pz_money) pz_money', 'sum(profit_loss_money) profit_loss_money', 'FROM_UNIXTIME(pz_time,"%Y-%m-%d") AS pz_time');
        $selarr_total = array('COUNT(distinct uid) AS user_count', 'sum(pz_money) pz_money', 'sum(profit_loss_money) profit_loss_money', "'合计' AS pz_time");
        $order = ' ORDER BY pz_time DESC';
        $groupby = ' GROUP BY FROM_UNIXTIME(pz_time,"%Y-%m-%d")';
        $res = \Common\Pager::getList('user_peizi', $where, $selarr, $order, $curpage, $pagesize, 1, $groupby);
        $res_total = \Common\Pager::getList('user_peizi', $where, $selarr_total, $order, $curpage, $pagesize, 0);

        $list = array_merge($res_total, $res['data']);
        $this->assign('condition', $condition);
        $this->assign('list', $list);
        $this->assign('pager', $res ['pager']);
        $this->template('peizi.php');
    }

    //投资数据
    public function invest() {
        $this->setTitle('投资数据');
        $pagesize = 20;
        $curpage = isset($_GET ['page']) ? intval($_GET ['page']) : 1;
        $where = ' WHERE 1=1';
        $condition = array('begindate' => '', 'enddate' => '');
        $begindate = isset($_GET ['begindate']) ? $_GET ['begindate'] : $condition ['begindate'];
        $enddate = isset($_GET ['enddate']) ? $_GET ['enddate'] : $condition ['enddate'];
        if ($begindate && $enddate) {
            $condition ['begindate'] = $begindate;
            $condition ['enddate'] = $enddate;
            $where .= " AND (FROM_UNIXTIME(tz.tz_time,'%Y-%m-%d')>='" . ($begindate) . "' AND FROM_UNIXTIME(tz.tz_time,'%Y-%m-%d')<='" . ($enddate) . "')";
        }
        $selarr = array('COUNT(tz.tz_id) AS num', 'FROM_UNIXTIME(tz.tz_time,"%Y-%m-%d") AS tz_time', 'sum(tz_money) as tz_money');
        $selarr_total = array('COUNT(tz.tz_id) AS num', "'合计' AS tz_time", 'sum(tz_money) tz_money');
        $order = ' ORDER BY tz.tz_time DESC';
        $groupby = ' GROUP BY FROM_UNIXTIME(tz.tz_time,"%Y-%m-%d")';
        $res = \Common\Pager::getList('user_peizi_touzi AS tz LEFT JOIN user_peizi AS pz ON tz.pz_id=pz.pz_id', $where, $selarr, $order, $curpage, $pagesize, 1, $groupby);
        $res_total = \Common\Pager::getList('user_peizi_touzi AS tz LEFT JOIN user_peizi AS pz ON tz.pz_id=pz.pz_id', $where, $selarr_total, $order, $curpage, $pagesize, 0);

        $list = array_merge($res_total, $res['data']);
        /* foreach ( $res ['data'] as $row ) {
          $row ['num_per'] = sprintf("%.2f", $row ['num']*100/$total_logins).'%';
          $list [] = $row;
          } */
        $this->assign('condition', $condition);
        $this->assign('list', $list);
        $this->assign('pager', $res ['pager']);
        $this->template('invest.php');
    }
    
    //用户提现
    public function send() {

        $this->setTitle('赠送管理费');
        $pagesize = 20;
        $curpage = isset($_GET ['page']) ? intval($_GET ['page']) : 1;
        $where = ' WHERE type in(100,103,104,105,106,107,108,109,110,111) ';

        $condition = array('begindate' => date('Y-m-d',time()-7*24*3600), 'enddate' => date('Y-m-d'));
        $begindate = isset($_GET ['begindate']) ? $_GET ['begindate'] : $condition ['begindate'];
        $enddate = isset($_GET ['enddate']) ? $_GET ['enddate'] : $condition ['enddate'];
            
        if ($begindate && $enddate) {
            $condition ['begindate'] = $begindate;
            $condition ['enddate'] = $enddate;
            $where .= " AND (FROM_UNIXTIME(rtime,'%Y-%m-%d')>='" . ($begindate) . "' AND FROM_UNIXTIME(rtime,'%Y-%m-%d')<='" . ($enddate) . "')";
        }

        $selarr = array('COUNT(fund_id) AS num', 'SUM(money) as money', 'FROM_UNIXTIME(rtime,"%Y-%m-%d") AS rtime');
        $order = ' ORDER BY rtime DESC';
        $groupby = ' GROUP BY FROM_UNIXTIME(rtime,"%Y-%m-%d")';
        $res = \Common\Pager::getList('user_fund_record', $where, $selarr, $order, $curpage, $pagesize, 1, $groupby);
        $total = \Common\Pager::getList('user_fund_record', $where, $selarr, $order, $curpage, $pagesize, 1);

        $this->assign('condition', $condition);
        $this->assign('data', $data);
        $this->assign('list', $res ['data']);
        $this->assign('total',$total['data'][0]);
        $this->assign('pager', $res ['pager']);
        $this->template('send.php');
    }

}

?>