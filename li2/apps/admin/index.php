<?php

namespace apps\admin;

class index extends \apps\AdminControl {

    //put your code here
    public function view() {
        $modules = \Common\Query::select('admin_module', array('is_use' => 1), array(), array('sortno'));
        $menu_data = \Common\Query::select('admin_menu', array('is_use' => 1), array(), array('sortno'));
        $menus = array();
        foreach ($menu_data as $row) {
            $arr = explode('=', str_replace('&ac', '', $row ['url']));
            $pur_name = $arr [2] . '_' . $arr [3];
            if (in_array($pur_name, $this->purview)) {
                $menus [$row ['module_id']] [] = $row;
            }
        }
        $this->assign('modules', $modules);
        $this->assign('menus', $menus);
        $this->template('index.php');
    }

    public function main() {
        //$sql = "UPDATE `admin_menu` SET `purview`='system_doSiteBase|网站基本设置,system_doPay|支付接口设置,system_doSms|短信接口设置' WHERE (`menu_id`='7');";
        //\Common\Query::sqlsel($sql);

        $data = array();
        $total = \Model\User\UserInfo::get_total_users();
        $data ['total'] = $total; //总用户数
        //注册用户数
        $data ['reg_yesterday'] = \Model\User\UserInfo::get_total_users_by_day();
        $data ['reg_week'] = \Model\User\UserInfo::get_total_users_by_day(7);
        $data ['reg_month'] = \Model\User\UserInfo::get_total_users_by_day(1, 'reg_time', 0);

        //登陆用户数及百分比
        $data ['login_yesterday'] = \Model\User\UserInfo::get_total_users_by_day(1, 'last_login_time');
        $data ['login_week'] = \Model\User\UserInfo::get_total_users_by_day(7, 'last_login_time');
        $data ['login_month'] = \Model\User\UserInfo::get_total_users_by_day(1, 'last_login_time', 0);
        $data ['login_yesterday_per'] = sprintf('%.2f', (($data ['login_yesterday'] / $total) * 100)) . '%';
        $data ['login_week_per'] = sprintf('%.2f', (($data ['login_week'] / $total) * 100)) . '%';
        $data ['login_month_per'] = sprintf('%.2f', (($data ['login_month'] / $total)) * 100) . '%';

        //配资用户数及百分比
        $pz_info = \Model\Peizi\Peizi::get_peizi_users();
        $data ['pz_user'] = $pz_info ['pz_user'];
        $data ['pz_user_per'] = sprintf('%.2f', ($data ['pz_user'] / $total * 100)) . '%';

        $data ['pz_money'] = $pz_info ['pz_money'] / 100 / 10000;
        $data ['profit_loss_money'] = sprintf('%.2f', $pz_info ['profit_loss_money'] / 100);

        //投资用户数及百分比
//        $tz_info = \Model\P2p\Touzi::get_touzi_users();
//        $data ['tz_user'] = $tz_info ['tz_user'];
//        $data ['tz_user_per'] = sprintf('%.2f', ($data ['tz_user'] / $total * 100)) . '%';
//        $data ['tz_money'] = $tz_info ['tz_money'] / 100 / 10000;
//        $data ['earned_interest'] = sprintf('%.2f', $tz_info ['earned_interest'] / 100);

        //配资和P2P数据
        $data['free_pz'] = \Model\Peizi\Peizi::get_peizi_users_by_type(4);
        $data['day_pz'] = \Model\Peizi\Peizi::get_peizi_users_by_type();
        $data['month_pz'] = \Model\Peizi\Peizi::get_peizi_users_by_type(2);


        //财务数据
        $recharge = \Common\Query::selone('v_recharge_record', array('status'=>1), array('sum(money) money')) ;
        $recharge = $recharge?$recharge['money']:0 ;//\Model\User\Fund::getZhichangByUid(1) + \Model\User\Fund::getZhichangByUid(14); //总充值
        $recharge_send = \Model\User\Fund::getZhichangByUid(100); //充值赠送
        $tixian = \Common\Query::selone('user_withdraw_record', array('status'=>2), array('sum(money) money')) ;
        $tixian = $tixian?$tixian['money']:0;//\Model\User\Fund::getZhichangByUid(2) + \Model\User\Fund::getZhichangByUid(15); //总提现
        //$unback_touzi = \Model\P2p\Peizi::getUnbackTouzi(); //未返还的投资(配资人已结束，但资金未还给投资人)

        $gl_fee = \Model\User\Fund::getZhichangByUid(10) - \Model\User\Fund::getZhichangByUid(11); //总管理费（支付－退回）
        $bk = \Model\User\Fund::getZhichangByUid(7); //补亏
        $frozen = \Model\User\UserInfo::getTotalByType('frozen');
        $balance = \Model\User\UserInfo::getTotalByType('balance');

        $data ['recharge'] = $recharge;
        $data ['recharge_send'] = $recharge_send;
        $data ['unback_touzi'] = $unback_touzi;
        $data ['tixian'] = $tixian;
        $data ['gl_fee'] = $gl_fee;
        $data ['frozen'] = $frozen;
        $data ['balance'] = $balance;
        //待办
        $data ['wait_peizi'] = \Model\Peizi\Peizi::getPeiziWaitCount(array(1,2));
        $data ['wait_fillloss'] = \Model\Peizi\FillLoss::getWaitCount(array(1,2));
        $data ['wait_peizi_add'] = \Model\Peizi\Add::getWaitCount(array(1,2));
        $data['get_profit'] = \Model\Peizi\GetProfit::getWaitCount();//盈利提取
        $data ['wait_userend'] = \Model\Peizi\Peizi::getPeiziUserendCount(array(1,2));
        $data ['wait_account'] = \Model\Admin\TradeAccount::getCanuseAccountCount();
        $data ['wait_nobalance'] = \Model\Peizi\Peizi::getNoManageCost();
        $data ['wait_withdraw'] = \Model\User\Fund::getWithdrawCount();
        $data ['wait_bankcard'] = \Model\User\BankCard::getBankCardCountByStatus();
        $data ['wait_question'] = \Model\Wenda\Question::getTotalByStatus();
        //免费体验
        $data ['wait_account_free'] = \Model\Admin\TradeAccount::getCanuseAccountCount_free();
        $data ['wait_userend4'] = \Model\Peizi\Peizi::getPeiziUserendCount(4);
        $data ['wait_free_end'] = \Model\Peizi\Peizi::getFreeEndWaitCount();

//        //按月配资
//        $data ['wait_peizi_month'] = \Model\Peizi\Peizi::getPeiziWaitCount(2); //资金划拔
//        $data ['wait_peizi_add_month'] = \Model\Peizi\Add::getWaitCount_month();
//        $data ['wait_fillloss_month'] = \Model\Peizi\FillLoss::getWaitCount(2); //补亏
//        $data ['wait_userend_month'] = \Model\Peizi\Peizi::getPeiziUserendCount(2); //结束

        //线下充值
        $data['recharge_offline'] = \Model\User\RechargeOffline::rechargeOfflineCount();

        $this->assign('data', $data);
        $this->template('main.php');
    }

    public function top() {
        $this->template('top.php');
    }

    //弹出待办事项
    public function showWindow() {
        $res = array('status' => 0, 'msg' => '', 'num' => 0);

        $msg = '';
        $num = 0;
        //待办
        $wait_peizi = \Model\Peizi\Peizi::getPeiziWaitCount(array(1,2));
        $wait_peizi_add = \Model\Peizi\Add::getWaitCount(array(1,2));
        $wait_fillloss = \Model\Peizi\FillLoss::getWaitCount(array(1,2));
        $get_profit = \Model\Peizi\GetProfit::getWaitCount();//盈利提取
        $wait_userend = \Model\Peizi\Peizi::getPeiziUserendCount(array(1,2));
        $wait_account = \Model\Admin\TradeAccount::getCanuseAccountCount();
        $wait_nobalance = \Model\Peizi\Peizi::getNoManageCost();
        $wait_withdraw = \Model\User\Fund::getWithdrawCount();
        $wait_bankcard = \Model\User\BankCard::getBankCardCountByStatus();
        $wait_question = \Model\Wenda\Question::getTotalByStatus();
        //免费体验
        $wait_account_free = \Model\Admin\TradeAccount::getCanuseAccountCount_free();
        $wait_userend4 = \Model\Peizi\Peizi::getPeiziUserendCount(4);
        $wait_free_end = \Model\Peizi\Peizi::getFreeEndWaitCount();

//        //按月配资
//        $wait_peizi_month = \Model\Peizi\Peizi::getPeiziWaitCount(2); //资金划拔
//        $wait_peizi_add_month = \Model\Peizi\Add::getWaitCount_month(); //追加实盘金
//        $wait_fillloss_month = \Model\Peizi\FillLoss::getWaitCount(2); //补亏
//        $wait_userend_month = \Model\Peizi\Peizi::getPeiziUserendCount(2); //结束

        //线下充值
        $recharge_offline = \Model\User\RechargeOffline::rechargeOfflineCount();
        
        //邀请满5个提醒
//        $sql = "SELECT `user`.uid,`user`.mobile,`user`.true_name,`user`.`level`,`invit`.introducer_id,count(inv_peizi.uid) invit_count FROM user_info as `user` LEFT JOIN user_info as `invit` ON `user`.uid=invit.introducer_id LEFT JOIN (select uid,sum(bond_total) bond_total from user_peizi where pz_type in (1,2) group by uid HAVING sum(bond_total)>1000000 ) inv_peizi ON `invit`.uid=inv_peizi.uid WHERE `invit`.introducer_id is NOT NULL AND `user`.`level`=0 GROUP BY `invit`.introducer_id HAVING count(inv_peizi.uid)>=5";
//        $rows = \Common\Query::sqlsel($sql);
//        $vip_count = count($rows);

        if ($wait_peizi > 0) {
            $num += $wait_peizi;
            $msg .= '<li><label class="res-lab">配资资金划拔处理：</label><a href="/index.php?app=admin&mod=peizi&ac=fund&status=1" target="_blank"><span style="color:red">' . $wait_peizi . '</span></a></li>';
        }
        if ($wait_peizi_add > 0) {
            $num += $wait_peizi_add;
            $msg .= '<li><label class="res-lab">追加配资划拔处理：</label><a href="/index.php?app=admin&mod=peizi&ac=plus&status=0" target="_blank"><span style="color:red">' . $wait_peizi_add . '</span></a></li>';
        }
        if ($wait_fillloss > 0) {
            $num += $wait_fillloss;
            $msg .= '<li><label class="res-lab">补亏划拔处理：</label><a href="/index.php?app=admin&mod=peizi&ac=loss&status=0" target="_blank"><span style="color:red">' . $wait_fillloss . '</span></a></li>';
        }
        if ($get_profit > 0) {
            $num += $get_profit;
            $msg .= '<li><label class="res-lab">盈利提取：</label><a href="/index.php?app=admin&mod=system&ac=getprofit&status=0" target="_blank"><span style="color:red">' . $get_profit . '</span></a></li>';
        }
        if ($wait_userend > 0) {
            //$num += $wait_userend;
            //$msg .= '<li><label class="res-lab">申请结束配资处理：</label><a href="/index.php?app=admin&mod=peizi&ac=win&status=3" target="_blank"><span style="color:red">' . $wait_userend . '</span></a></li>';
        }
        if ($wait_account >= 0 && $wait_account < 10) {
            //$num += 1;
            //$msg .= '<li><label class="res-lab">操盘普通账号剩余：</label><a href="/index.php?app=admin&mod=trade&ac=view&type=1&status=0" target="_blank"><span style="color:red">' . $wait_account . '</span></a></li>';
        }
        if ($wait_nobalance) {
            //$num += $wait_nobalance;
            //$msg .= '<li><label class="res-lab">余额不足处理：</label><a href="/index.php?app=admin&mod=peizi&ac=mcost" target="_blank"><span style="color:red">' . $wait_nobalance . '</span></a></li>';
        }
        
        if ($wait_bankcard > 0) {
            //$num += $wait_bankcard;
            //$msg .= '<li><label class="res-lab">银行卡待审核处理：</label><a href="/index.php?app=admin&mod=user&ac=view&is_audit=0" target="_blank"><span style="color:red">' . $wait_bankcard . '</span></a></li>';
        }
        if ($wait_account_free >= 0 && $wait_account_free < 10) {
            //$num += 1;
            //$msg .= '<li><label class="res-lab">免费体验账号剩余：</label><a href="/index.php?app=admin&mod=trade&ac=view&type=2&status=0" target="_blank"><span style="color:red">' . $wait_account_free . '</span></a></li>';
        }
        if ($wait_userend4 > 0) {
            //$num += $wait_userend4;
            //$msg .= '<li><label class="res-lab">免费体验申请结束操盘：</label><a href="/index.php?app=admin&mod=peizi&ac=free&status=3" target="_blank"><span style="color:red">' . $wait_userend4 . '</span></a></li>';
        }
        if ($wait_free_end > 0) {
            //$num += $wait_free_end;
            //$msg .= '<li><label class="res-lab">免费体验到期结束：</label><a href="/index.php?app=admin&mod=peizi&ac=free&status=2" target="_blank"><span style="color:red">' . $wait_free_end . '</span></a></li>';
        }

//        if ($wait_peizi_month > 0) {
//            $num += $wait_peizi_month;
//            $msg .= '<li><label class="res-lab">按月配资资金划拔：</label><a href="/index.php?app=admin&mod=month&ac=fund&status=1" target="_blank"><span style="color:red">' . $wait_peizi_month . '</span></a></li>';
//        }
//        if ($wait_peizi_add_month > 0) {
//            $num += $wait_peizi_add_month;
//            $msg .= '<li><label class="res-lab">按月配资追加配资：</label><a href="/index.php?app=admin&mod=month&ac=plus&status=0" target="_blank"><span style="color:red">' . $wait_peizi_add_month . '</span></a></li>';
//        }
//        if ($wait_fillloss_month > 0) {
//            $num += $wait_fillloss_month;
//            $msg .= '<li><label class="res-lab">按月配资补亏划拔：</label><a href="/index.php?app=admin&mod=month&ac=loss&status=0" target="_blank"><span style="color:red">' . $wait_fillloss_month . '</span></a></li>';
//        }
//        if ($wait_userend_month > 0) {
//            $num += $wait_userend_month;
//            $msg .= '<li><label class="res-lab">按月配资结束处理：</label><a href="/index.php?app=admin&mod=month&ac=win&status=" target="_blank"><span style="color:red">' . $wait_userend_month . '</span></a></li>';
//        }

        if ($wait_withdraw > 0) {
            $num += $wait_withdraw;
            $msg .= '<li><label class="res-lab">提现处理：</label><a href="/index.php?app=admin&mod=finance&ac=tixian&status=0" target="_blank"><span style="color:red">' . $wait_withdraw . '</span></a></li>';
        }
        if ($recharge_offline > 0) {
            $num += $recharge_offline;
            $msg .= '<li><label class="res-lab">线下充值：</label><a href="/index.php?app=admin&mod=finance&ac=rechargeoffline&status=0" target="_blank"><span style="color:red">' . $recharge_offline . '</span></a></li>';
        }
        
//        if ($vip_count > 0) {
//            //$num += $vip_count;
//            $msg .= '<li><label class="res-lab">满足VIP：</label><a href="/index.php?app=admin&mod=user&ac=invitation" target="_blank"><span style="color:red">' . $vip_count . '</span></a></li>';
//        }
        
        if ($msg) {
            $res ['msg'] = $msg;
            $res ['num'] = $num;
            $res ['status'] = 1;
        }
        exit(json_encode($res));
    }

    public function left() {
        $modules = \Common\Query::select('admin_module', array('is_use' => 1), array(), array('sortno'));
        $menu_data = \Common\Query::select('admin_menu', array('is_use' => 1), array(), array('sortno'));
        $menus = array();
        foreach ($menu_data as $row) {
            $arr = explode('=', str_replace('&ac', '', $row ['url']));
            $pur_name = $arr [2] . '_' . $arr [3];
            if (in_array($pur_name, $this->purview)) {
                $menus [$row ['module_id']] [] = $row;
            }
        }
        $this->assign('modules', $modules);
        $this->assign('menus', $menus);

        $this->template('left.php');
    }

}

?>