<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace apps\crontab;

/**
 * Description of calu
 *
 * @author fjlh
 */
class mcost extends \apps\ViewsControl {
    //put your code here
    /**
     * 每天自动收取管理费
     */
    public function day() {
        //早上8：00执行
        \Model\Peizi\Peizi::payManageCostDay();
    }
    /**
     * 按天配资管理费不足的短信通知，通知明天不够管理费
     */
    public function notice(){
        //早上9：00执行
        $site_base = \Model\Admin\Params::get ( 'site_base' );
        $where = ' WHERE pz.manage_cost_day>u.balance+u.send and u.level=0';
        $tomorrow = time() + 20*3600;//执行通知的时间+20小时
        $sql = 'select pz.manage_cost_day,u.mobile from (SELECT sum(manage_cost_day)  manage_cost_day,uid from user_peizi WHERE pz_type in(1,2) and status=2 and manage_cost_time<'.$tomorrow.' GROUP BY uid) pz LEFT JOIN user_info u on pz.uid=u.uid '.$where;
        $rows = \Common\Query::sqlsel($sql);
        $content = '';//'您的配资今天结束后就已到期，账户余额不足以续费，如果要延期配资，请您及时充值！';
        foreach ($rows as $row){
            \Model\Api\Sms::smsSend($row['mobile'], $content);
        }
    }
}
