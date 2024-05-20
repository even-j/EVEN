<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Model\Peizi;

use Common\Cache;
use Common\Query;

class Peizi {

    /**
     * 计算管理费和保证金
     * @param type $pz_money
     * @param type $pz_ratio
     */
    public static function calc($uid, $pz_money, $pz_ratio) {
        $pz_money = empty($pz_money) ? 1 : floatval($pz_money);
        $pz_ratio = empty($pz_ratio) ? 1 : intval($pz_ratio);

        //配资系数
        $alarm_rate = 96; // 警戒线 总配资的96%
        $stop_rate = 94; // 止损线 总配资的94%
        $manage_cost_money = 1990; //帐户管理费 1990分/天/万
        $minLimitMoney = 100000; //最低额度
        $maxLimitMoney = 500000000; //最高额度
        $maxLimitRatio = 10; //最大配资比例
        $maxLimitTimes = 31; //最大配资期限 天
        $params = \Model\Admin\Params::get('peizi');
        if ($params) {
            $alarm_rate = intval($params ['alarm_rate' . $pz_ratio]);
            $stop_rate = intval($params ['stop_rate' . $pz_ratio]);
            $manage_cost_money = floatval($params ['manage_cost_money' . $pz_ratio]);
            $minLimitMoney = intval($params ['minLimitMoney']);
            $maxLimitMoney = intval($params ['maxLimitMoney']);
//            $maxLimitRatio = intval($params ['maxLimitRatio']);
//            $maxLimitTimes = intval($params ['maxLimitTimes']);
        }

        if (floatval($pz_money) * 100 > $maxLimitMoney) {
            return array(0, '超出最高策略限制');
        }
        if (floatval($pz_money) * 100 < $minLimitMoney) {
            return array(0, '超出最低策略限制');
        }
        if (intval($pz_ratio) > $maxLimitRatio) {
            return array(0, '超出最高策略比例10倍');
        }

        $pz_money_fen = floatval($pz_money) * 10000; //元
        $arr ['bond'] = intval($pz_money_fen / $pz_ratio) * 100; //初始保证金(分)
        $arr ['alarm_money'] = intval(($pz_money_fen - $arr ['bond'] / 100) + ($arr ['bond'] / 100) * ($alarm_rate / 100)) * 100; //亏损警戒线(分)
        $arr ['stop_money'] = intval(($pz_money_fen - $arr ['bond'] / 100) + ($arr ['bond'] / 100) * ($stop_rate / 100)) * 100; //亏损止损线(分)
        $arr ['manage_cost_day'] = floatval($pz_money) * $manage_cost_money; //每天账户管理费（分/天）
        return array(1, $arr);
    }

    /**
     * 返回的单位为分
     * @param type $uid
     * @param type $deposit 元
     * @param type $pz_ratio
     * @return type
     */
    public static function calc_month($uid,$pz_type, $deposit, $pz_ratio,$is_admin=0) {
        if(empty($deposit)){
            return array(0, '保证金不能为空');
        }
        if(empty($pz_ratio)){
            return array(0, '倍数不能为空');
        }
        if($deposit % 100 != 0 ){
            return array(0, '保证金应该为100的倍数');
        }
        //策略系数
        $minLimitMoney = 0.1; //最低额度 万元
        $maxLimitMoney = 500; //最高额度 万元
        $maxLimitRatio = 10; //最大策略比例
        $maxLimitTimes = 1; //最大策略期限 天
        $params = array();
        if($pz_type == 1){
            $params = \Model\Admin\Params::get('peizi');
        }
        elseif($pz_type == 2){
            $params = \Model\Admin\Params::get('peizi_month');
        }
        if ($params) {
            $alarm_rate = floatval($params ['alarm_rate' . $pz_ratio]);
            $stop_rate = floatval($params ['stop_rate' . $pz_ratio]);
            $manage_cost_money = floatval($params ['manage_cost_money' . $pz_ratio]);
            $minLimitMoney = floatval($params ['minLimitMoney']);
            $maxLimitMoney = floatval($params ['maxLimitMoney']);
        }
        $bond = $deposit * 100; //保证金(分)
        //非后台调用的要验证
        if(!$is_admin){
            if ($bond > $maxLimitMoney) {
                return array(0, '超出最高策略限制');
            }
            if ($bond < $minLimitMoney) {
                return array(0, '超出最低策略限制');
            }
            if (intval($pz_ratio) > $maxLimitRatio) {
                return array(0, '超出最高策略比例' . $maxLimitRatio . '倍');
            }
        }
        $money_total_fen = $bond+ $bond*$pz_ratio; //分
        $money_fen = $bond*$pz_ratio;//分
        $arr ['bond'] = $bond; //保证金(分)
        $arr ['caopan_money'] = $money_total_fen;
        $arr ['alarm_money'] = $money_fen+$bond*$alarm_rate/100; //亏损警戒线(分)
        $arr ['stop_money'] = $money_fen+$bond*$stop_rate/100; //亏损止损线(分)
        $arr ['manage_cost_day'] = floatval($money_fen) * $manage_cost_money / 100; //每天账户管理费（分/天）
        $user_row = \Model\User\UserInfo::getinfo($uid);
        if(isset($user_row['level']) && $user_row['level'] == 1){
            $arr ['manage_cost_day'] = 0;
        }
        return array(1, $arr);
    }

    public static function calc_free($uid) {
        $params = \Model\Admin\Params::get('peizi_free');
        $arr ['bond'] = $params ['baozheng_free'] * 100; //初始保证金(分)
        $arr ['caopan_money'] = floatval($params['service_cost_rate'])*100;
        $arr ['alarm_money'] = $params ['service_cost_rate'] * $params ['alarm_rate'] / 100 * 100; //亏损警戒线(分)
        $arr ['stop_money'] = $params ['service_cost_rate'] * $params ['stop_rate'] / 100 * 100; //亏损止损线(分)
        $arr ['manage_cost_day'] = $params ['manage_cost_money'] * 100; //每天账户管理费（分/天）
        return array(1, $arr);
    }

    /**
     * 
     * @param type $pz_type
     * @param type $uid
     * @param type $deposit 保证金 单位：元 最高30万
     * @param type $pz_ratio 策略比例 1－10
     * @param type $pz_times 策略天数 单位：天 最高30天
     */
    public static function add($pz_type, $uid, $deposit, $pz_ratio, $pz_times, $pz_times_unit = 1,$trade_time, $sp_type = 'ths') {
        $caopan_money = 0;
        if ($pz_type == 4) {
            $params = \Model\Admin\Params::get('peizi_free');
            $caopan_money = $params ['service_cost_rate']; //元
            $pz_ratio = $params ['service_cost_rate'] / $params ['baozheng_free'];
            $pz_times = $params ['free_day'];
        }
        $res = array();
        if ($pz_type == 1) {
            if(intval($pz_ratio)>6){
                return array(0, '倍数错误');
            }
            $res = self::calc_month($uid,$pz_type, $deposit, $pz_ratio);
        } else if ($pz_type == 2 || $pz_type == 7) {
            if(intval($pz_ratio)<5 || intval($pz_ratio)>10){
                return array(0, '倍数错误');
            }
            $res = self::calc_month($uid,$pz_type, $deposit, $pz_ratio);
        } else if ($pz_type == 4) {
            $res = self::calc_free($uid);
        }
        if ($res [0] == 0) {
            return $res;
        }
        $feiyong = $res [1];

        $time = time();
        $arr ['uid'] = intval($uid); //用户id
        $arr ['pz_type'] = $pz_type; //按天策略
        $arr ['pz_time'] = $time; //策略时间
        $arr ['pz_money'] = $feiyong['caopan_money']; //策略金额 单位：分
        $arr ['trade_money_total'] = $arr ['pz_money']; //总操盘资金(分)
        $arr ['pz_ratio'] = intval($pz_ratio); //策略比例（倍数）
        $arr ['bond_init'] = $feiyong ['bond']; //初始保证金(分)
        $arr ['bond_total'] = $arr ['bond_init']; //总保证金（追加后）(分)
        $arr ['alarm_money'] = $feiyong ['alarm_money']; //亏损警戒线(分)
        $arr ['stop_money'] = $feiyong ['stop_money']; //亏损止损线(分)
        $arr ['trade_days_act'] = intval($pz_times); //实际操盘周期
        $arr ['manage_cost_day'] = $feiyong ['manage_cost_day']; //每天账户管理费（分/天）
        $arr ['pz_times_unit'] = $pz_times_unit; //期限单位：天
        $arr ['pz_times'] = intval($pz_times); //策略期限
        if ($pz_type == 1 || $pz_type == 4) {//按天、免费开始、结束时间计算方法
            if (empty($trade_time)) {
                if(time() > strtotime(date('Y-m-d ').'14:50')){
                    $arr ['start_time'] = \Model\Sys\Common::getNextWorkDate($time);//计算下个交易日时间
                }
                else{
                    $arr ['start_time'] = $time;//当前时间
                }
                $arr ['end_time'] = \Model\Sys\Common::getEndDate($arr ['start_time'], $pz_times, $pz_type); //结束时间：最后一天15点
            } else {
                $arr ['start_time'] = \Model\Sys\Common::getNextWorkDate($time);//计算下个交易日时间
                $arr ['end_time'] = \Model\Sys\Common::getEndDate($arr ['start_time'], $pz_times, $pz_type); //结束时间：最后一天15点
            }
        } else if($pz_type==2) {
            if ($trade_time == 0) {
                if(time() > strtotime(date('Y-m-d ').'14:50')){
                    $arr ['start_time'] = \Model\Sys\Common::getNextWorkDate($time);//计算下个交易日时间
                }
                else{
                    $arr ['start_time'] = $time;//当前时间
                }
            }
            else{
                $arr ['start_time'] = \Model\Sys\Common::getNextWorkDate($time);//计算下个交易日时间
            }
            $arr ['end_time'] = strtotime(date('Y-m-d',strtotime('+' . $pz_times . ' month', $arr ['start_time'])-24*3600).' 15:00:00') ;//加一个月的前一天15点
        }
        $arr ['end_time_act'] = $arr ['end_time'];
        $arr ['status'] = 0; //状态：未审核
        $arr ['sp_type'] = $sp_type; //操盘证券
        $account = \Model\Trade\Account::getRandOne($pz_type);
        if ($account) {
            $arr ['sp_user'] = $account ['account']; //操盘账号
            $arr ['sp_pwd'] = $account ['pwd']; //账号密码
        }
        $arr ['trade_balance'] = $arr ['pz_money']; //当前资产
        $arr ['update_time'] = $time; //当前资产最近更新时间
        $arr ['manage_cost_time'] = $arr ['end_time']; //管理费为结束时间，一次性收取
        
        $res = \Common\Query::insert('user_peizi', $arr);
        if ($res) {
            $arr ['pz_id'] = $res;
            return array(1, $arr);
        } else {
            //更改操盘帐户状态
            if ($account) {
                \Model\Trade\Account::setCanuseState($account ['account']);
            }
            return array(0, '添加失败');
        }
    }

    /**
     * 处理策略追加
     * @param type $pz_id
     * @param type $money 分
     * @return type
     */
    public static function doAdd($pz_id,$money, $bond) {
        $pz_money = floatval($money) / 100 ; //元
        $pz_money_fen = $money; //分
        $pz_row = self::getById($pz_id);
        if (!$pz_row) {
            return array(0, '策略记录不存在');
        }
        if ($pz_row ['status'] != 2) {
            return array(0, '策略非操盘中，不能追加');
        }
        $pz_ratio = empty($pz_row ['pz_ratio']) ? 1 : intval($pz_row ['pz_ratio']);
        $pz_bond = $bond/100;//元
        $pz_bond_fen = $bond;//分
        
        $res = array();
        if ($pz_row['pz_type'] == 1) {
            $res = self::calc_month($pz_row ['uid'],$pz_row['pz_type'], $pz_bond, $pz_ratio);
        } elseif ($pz_row['pz_type'] == 2) {
            $res = self::calc_month($pz_row ['uid'],$pz_row['pz_type'], $pz_bond, $pz_ratio);
        }
        if ($res [0] == 0) {
            return $res;
        }
        $feiyong = $res [1];

        
        $alarm_money = $feiyong ['alarm_money'];
        $stop_money = $feiyong ['stop_money'];
        $manage_cost_day = $feiyong ['manage_cost_day'];//每个月
        //计算实际剩余天数的费用
        if ($pz_row['pz_type'] == 1) {
            $manage_cost_day = \Model\Peizi\Peizi::calcAddManagerCostDay($pz_row,$manage_cost_day);
        }
        elseif ($pz_row['pz_type'] == 2) {
            $manage_cost_day = \Model\Peizi\Peizi::calcAddManagerCostMonth($pz_row,$manage_cost_day);
        }
        //更改策略参数,manage_cost_day用最初开始策略的金额、时间来计算，这样过期续费才能计算出一个月的费用，而实际收取的费用是实际剩余天数
        $sql = 'update user_peizi set pz_money=pz_money+' . $pz_money_fen . ',trade_money_total=trade_money_total+' . $pz_money_fen . ',bond_total=bond_total+' . $pz_bond_fen . ',alarm_money=alarm_money+' . $alarm_money . ',stop_money=stop_money+' . $stop_money . ',manage_cost_day=manage_cost_day+' . $feiyong ['manage_cost_day'] . ' where pz_id=' . $pz_id . ' and uid=' . intval($pz_row ['uid']);
        $res = \Common\Query::sqlquery($sql);
        if (!$res) {
            return array(0, '策略参数修改失败');
        }
        
        //支付管理费
        if($manage_cost_day>0){
            $res = \Model\Peizi\Peizi::payManageCost($pz_row, $manage_cost_day);
            if ($res [0] == 0) {
                return array(0, $res [1]);
            }
        }
        return array(1, '成功');
    }
    
    public static function calcAddDaysDay($end_time){
        $days = 0;
        $now = time();
        while ($now<$end_time){
            if(!\Model\Sys\Common::isHoliday($now)){
                $days = $days+1;//不是假期+1
            }
            $now += 24*3600;
        }
        return $days;
    }
    
    public static function calcAddDaysMonth($end_time){
        $sheng_days = \App::diffBetweenTwoDays(date('Y-m-d',$end_time), date('Y-m-d'));
        return $sheng_days;
    }
    /**
     * 计算追加的管理费用，按月策略使用。计算实际天数的费用
     * @param type $pz_row
     * @param type $manage_month 1天收取的费用 单位分
     */
    public static function calcAddManagerCostDay($pz_row,$manage_day){
        $sheng_days = self::calcAddDaysDay($pz_row['end_time']);
        $money = intval($manage_day * $sheng_days) ;
        return $money;
    }
    /**
     * 计算追加的管理费用，按月策略使用。计算实际天数的费用
     * @param type $pz_row
     * @param type $manage_month 1个月收取的费用 单位分
     */
    public static function calcAddManagerCostMonth($pz_row,$manage_month){
        $sheng_days = self::calcAddDaysMonth($pz_row['end_time']);
        $money = intval($manage_month/30 * $sheng_days) ;
        return $money;
    }

    /**
     * 通过id获取记录
     * @param type $pz_id
     * @param type $uid
     * @return type
     */
    public static function getById($pz_id, $uid = 0) {
        $where ['pz_id'] = intval($pz_id);
        if ($uid > 0) {
            $where ['uid'] = intval($uid);
        }
        $row = \Common\Query::selone('user_peizi', $where);
        return $row;
    }

    /**
     * 用户结束操盘申请
     * @param type $uid
     * @param type $pz_id
     * @return type
     */
    public static function userEnd($uid, $pz_id) {
        $res = \Common\Query::update('user_peizi', array('status' => 3, 'user_end_time' => time()), array('uid' => intval($uid), 'pz_id' => intval($pz_id), 'status' => 2));
        return $res;
    }

    /**
     * 结束策略
     * @param type $pz_id
     * @return type
     */
    public static function end($pz_id) {
        $row = self::getById($pz_id);
        if (empty($row)) {
            return array(0, 'id错误');
        }
        //更新策略记录
        $updarr ['profit_loss_money'] = $row ['trade_balance'] - $row ['trade_money_total'] ;
        //实际返给用户的钱
        $back_money = $row ['trade_balance'] - $row ['trade_money_total'];
        //亏损多于保证金
        if (- 1 * $back_money > $row ['bond_total']) {
            $back_money = - 1 * $row ['bond_total'];
        }
        if ($row ['pz_type'] == 4) { //免费体验
            if ($back_money < 0) {
                $back_money = 0; //亏损不由用户承担
            }
        }
        $updarr ['back_money'] = $back_money;
        if ($updarr['profit_loss_money'] != $row['profit_loss_money'] || $updarr['back_money'] != $row['back_money']) {
            $res = \Common\Query::update('user_peizi', $updarr, array('pz_id' => $pz_id));
            if (!$res) {
                return array(0, '更新策略记录失败');
            }
        }
        //解冻保证金
        $res = \Model\User\Fund::bondBack($row ['uid'], $row ['bond_total'], $row ['pz_id']);
        if ($res [0] == 0) {
            return array(0, $res [1]);
        }
        //盈利提取
        if($row ['pz_type'] == 4){
            $free_profit_to = \apps\Config::getInstance()->free_profit_to;
            if($free_profit_to == 'balance'){
                //免费体验结算到余额
                $res = \Model\User\Fund::win($row ['uid'], $back_money, $row ['pz_id']);
            }
            else{
                //免费体验结算到赠送
                $res = \Model\User\Fund::win_free($row ['uid'], $back_money, $row ['pz_id']);
            }
        }
        else{
            $res = \Model\User\Fund::win($row ['uid'], $back_money, $row ['pz_id']);
        }
        
        if ($res [0] == 0) {
            return array(0, $res [1]);
        }

        return array(1, '成功');
    }

    /**
     * 获得策略类型
     * @param type $pz_type
     * @return string
     */
    public static function getPzType($pz_type) {
        $name = '';
        $pz_type = empty($pz_type) ? 1 : $pz_type;
        switch ($pz_type) {
            case 1 :
                $name = '按日策略';
                break;
            case 2 :
                $name = '按月策略';
                break;
            case 3 :
                $name = 'P2P';
                break;
            case 4 :
                $name = '免费体验';
                break;
            case 5 :
                $name = '分成策略';
                break;
            case 6 :
                $name = '免息体验';
                break;
            case 7 :
                $name = '期货策略';
                break;
        }
        return $name;
    }

    /**
     * 获得策略 记录状态
     * @param type $stauts
     * @return string
     */
    public static function getStatusName($stauts) {
        $name = '';
        switch ($stauts) {
            case 0 :
                $name = '创建';
                break;
            case 1 :
                $name = '划拔中';
                break;
            case 2 :
                $name = '操盘中';
                break;
            case 3 :
                $name = '申请结算';
                break;
            case 4 :
                $name = '已结束';
                break;
        }
        return $name;
    }

    /**
     * 获得策略 记录状态
     * @param type $stauts
     * @return string
     */
    public static function getBusStatusName($stauts) {
        $name = '';
        switch ($stauts) {
            case 0 :
                $name = '未审核';
                break;
            case 1 :
                $name = '未提取保证金';
                break;
            case 2 :
                $name = '等待支付保证金';
                break;
            case 3 :
                $name = '已支付保证金';
                break;
            case 4 :
                $name = '已分配帐号';
                break;
        }
        return $name;
    }

    /**
     * 得到策略用户数
     * @return type
     */
    public static function get_peizi_users() {
        $res = \Common\Query::sqlselone('select count(DISTINCT uid) pz_user,sum(pz_money) pz_money,sum(profit_loss_money) profit_loss_money from user_peizi');
        return $res;
    }

    /**
     * 不同类型策略用户数
     * @return type
     */
    public static function get_peizi_users_by_type($pz_type = 1) {
        $row = \Common\Query::sqlselone('select count(DISTINCT uid) total from user_peizi WHERE pz_type=' . $pz_type);
        return $row ? $row ['total'] : 0;
    }

    /**
     * 获得策略等待划拔记录数
     * @return type
     */
    public static function getPeiziWaitCount($pz_type = array(1)) {
        if(!is_array($pz_type)){
            $pz_type = explode(',', $pz_type);
        }
        $nine_hours_later = time()+9*3600;
        $tomorrow = time()+24*3600;
        while(\Model\Sys\Common::isHoliday($tomorrow)){
            $nine_hours_later += 24*3600;//加上节假日
            $tomorrow += 24*3600;
        }
        $sql = 'select count(pz_id) total from user_peizi where pz_type in(' . implode(',', $pz_type) . ') AND status=1 AND start_time<'.$nine_hours_later;
        $row = \Common\Query::sqlselone($sql);
        return $row ? $row ['total'] : 0;
    }

    /**
     * 得到用户申请结束策略记录数
     * @return type
     */
    public static function getPeiziUserendCount($pz_type = array(1)) {
        if(!is_array($pz_type)){
            $pz_type = explode(',', $pz_type);
        }
        $sql = 'select count(pz_id) total from user_peizi where pz_type in (' . implode(',', $pz_type) . ') and status=3';
        $row = \Common\Query::sqlselone($sql);
        return $row ? $row ['total'] : 0;
    }

    /**
     * 获得免费体验策略结束处理条数
     * @return type
     */
    public static function getFreeEndWaitCount() {
        $sql = 'select count(pz_id) total from user_peizi where pz_type=4 and status=2 and end_time<' . time();
        $row = \Common\Query::sqlselone($sql);
        return $row ? $row ['total'] : 0;
    }

    /**
     * 得到管理费不足的记录数
     * @return type
     */
    public static function getNoManageCost() {
        $time = time();
        $tomorrow = $time + 20*3600;//执行通知的时间+20小时
        $sql = 'SELECT count(pz.pz_id) total FROM user_peizi pz LEFT JOIN user_info u on pz.uid=u.uid where pz.status=2 and pz.pz_type in (1,2) and pz.manage_cost_day>u.balance+u.send and pz.manage_cost_time<'.$tomorrow;
        $row = \Common\Query::sqlselone($sql);
        return $row ? $row ['total'] : 0;
    }

    /**
     * 策略记录的管理费收取
     * @param type $peizi_row
     * @param type $manage_cost_money 指定收费金额，用于追加策略
     * @return type
     */
    public static function payManageCost($peizi_row, $manage_cost_money = 0) {
        $time = time();
        $manage_cost = floatval($peizi_row ['manage_cost_day'])* intval($peizi_row['pz_times']);

        if (floatval($manage_cost_money) > 0) {
            $manage_cost = floatval($manage_cost_money);
        }
        //vip不收管理费
        $res = \Model\User\UserInfo::isVip($peizi_row['uid']);
        if($res){
            $manage_cost = 0;
        }
        if ($manage_cost > 0) { //大于0才执行
            $res = \Model\User\Fund::managecostPay($peizi_row ['uid'], $manage_cost, $peizi_row ['pz_id']);
            if ($res [0] == 0) {
                return array(0, $res [1]);
            }
        }
        
        //更新策略记录 实际管理费
        $sql = 'update user_peizi set manage_cost_act=manage_cost_act+' . floatval($manage_cost) . ' where pz_id=' . $peizi_row ['pz_id'];
        $res = \Common\Query::sqlquery($sql);
        if (empty($res)) {
            return array(0, '修改实际管理费失败');
        }
        return array(1, '管理费支付成功');
    }
    
    public static function payManageCost_auto($peizi_row) {
        $time = time();
        $todate = '';
        if ($peizi_row['pz_type'] == 2) { //按月策略，不管节假日开始收取
            $manage_cost = floatval($peizi_row ['manage_cost_day']);
            $manage_cost_time = strtotime("+1 month", $peizi_row ['manage_cost_time']);
            //vip不收管理费
            $res = \Model\User\UserInfo::isVip($peizi_row['uid']);
            if($res){
                $manage_cost = 0;
            }
            if ($manage_cost > 0) { //大于0才执行
                $res = \Model\User\Fund::managecostPay($peizi_row ['uid'], $manage_cost, $peizi_row ['pz_id'],'user_peizi', '收取至'.date('Y-m-d',$manage_cost_time));
                if ($res [0] == 0) {
                    return array(0, $res [1]);
                }
            }
            //更新策略记录 结束时间，实际结束时间，实际管理费，管理费收取时间
            $sql = 'update user_peizi set end_time=' . $manage_cost_time . ',end_time_act=' . $manage_cost_time . ',manage_cost_act=manage_cost_act+' . floatval($manage_cost) . ',manage_cost_time=' . $manage_cost_time . ' where pz_id=' . $peizi_row ['pz_id'];
            $res = \Common\Query::sqlquery($sql);
            if (empty($res)) {
                return array(0, '修改实际操盘天数，实际管理费失败');
            }
            $todate = date('Y-m-d',$manage_cost_time);
        } else {
            if (!\Model\Sys\Common::isHoliday($time)) {
                $manage_cost = floatval($peizi_row ['manage_cost_day']);
                $manage_cost_time = strtotime("+1 day", $peizi_row ['manage_cost_time']);
                //vip不收管理费
                $res = \Model\User\UserInfo::isVip($peizi_row['uid']);
                if($res){
                    $manage_cost = 0;
                }
                if ($manage_cost > 0) { //大于0才执行
                    $res = \Model\User\Fund::managecostPay($peizi_row ['uid'], $manage_cost, $peizi_row ['pz_id'],'user_peizi', '收取至'.date('Y-m-d',$manage_cost_time));
                    if ($res [0] == 0) {
                        return array(0, $res [1]);
                    }
                }
                //更新策略记录 实际操盘天数，实际管理费，管理费收取时间
                $sql = 'update user_peizi set trade_days_act=trade_days_act+1,manage_cost_act=manage_cost_act+' . floatval($manage_cost) . ',manage_cost_time=' . $manage_cost_time . ',end_time='.$manage_cost_time.' where pz_id=' . $peizi_row ['pz_id'];
                $res = \Common\Query::sqlquery($sql);
                if (empty($res)) {
                    return array(0, '修改实际操盘天数，实际管理费失败');
                }
                $todate = date('Y-m-d',$manage_cost_time);
            } else {
                //节假日，不收取费用，更新最近收取时间，避免重复判断
                $manage_cost_time = strtotime("+1 day", $peizi_row ['manage_cost_time']);
                $sql = 'update user_peizi set manage_cost_time=' . $manage_cost_time . ' where pz_id=' . $peizi_row ['pz_id'];
                $res = \Common\Query::sqlquery($sql);
                if (empty($res)) {
                    return array(0, '修改管理费时间失败');
                } else {
                    return array(2, '节假日不收取管理费，修改管理费时间成功'); //不收取费用，返回2
                }
            }
        }
        return array(1, '管理费支付成功',$todate);
    }

    /**
     * 每天收取管理费
     */
    public static function payManageCostDay() {
        header("Content-type: text/html; charset=utf-8");
        $time = time();
        $today = mktime(0, 0, 0, date('m', $time), date('d', $time), date('Y', $time));
        $sql = 'select pz.*,u.mobile  from user_peizi pz left join user_info u on pz.uid=u.uid  where (pz.pz_type=1 or pz.pz_type=2) and pz.status=2 and pz.manage_cost_time< '. $today;
        $rows = \Common\Query::sqlsel($sql);
        $msg = '';
        foreach ($rows as $row) {
            $res = \Model\User\UserInfo::isVip($row['uid']);
            if($res){
                continue;//vip跳过
            }
            \Common\Query::commitstart();
            $res = self::payManageCost_auto($row);
            if ($res[0] == 0) {
                \Common\Query::rollback();
                \App::logs('managecost.txt', '时间：' . date('Y-m-d H:i:s') . '策略id:' . $row ['pz_id'] . '收取管理费错误：' . $res [1]);
                $msg .= '时间：' . date('Y-m-d H:i:s') . '用户id:'.$row['uid'].',手机号:'.$row['mobile'].',策略id:' . $row ['pz_id'] . '收取管理费错误：' . $res [1].'<br/>';
            } else {
                \Common\Query::commit();
                \App::logs('managecost.txt', '时间：' . date('Y-m-d H:i:s') . '策略id:' . $row ['pz_id'] . '收取管理费成功');
                $msg .= '时间：' . date('Y-m-d H:i:s') . '用户id:'.$row['uid'].',手机号:'.$row['mobile'] . ',策略id:' . $row ['pz_id'] . '收取管理费成功，收取至'.$res[2].'<br/>';
                if ($res[0] == 1) { //返回2不短信通知
                    //短信通知
                    if($row['pz_type'] == 1){
                        
                        \Model\Api\Sms::smsSend($row ['mobile'], \Model\Sys\SmsTemplet::dayManageAuto($row ['manage_cost_day'] / 100));
                    }
                    elseif($row['pz_type'] == 2){
                        \Model\Api\Sms::smsSend($row ['mobile'], \Model\Sys\SmsTemplet::monthManageAuto($row ['manage_cost_day'] / 100));
                    }
                }
            }
        }
        echo $msg;
    }

    /**
     * 获取配置天数
     * @return int
     */
    public static function get_peizi_day($start_time, $end_time) {
        $start_date = date('Y-m-d', $start_time);
        $end_date = date('Y-m-d', $end_time);
        $work_days = \App::get_work_days($start_date, $end_date);
        $holidays = 0;
        $holiday_arr = \Model\Admin\Holiday::getHoliday();
        foreach ($holiday_arr as $row) {
            if ($row ['hdate'] >= $start_date && $row ['hdate'] <= $end_date) {
                $holidays ++;
            }
        }
        $days = $work_days - $holidays;
        $days = date('H:i', $start_time) > '08:01' ? $days - 1 : $days;
        return $days;
    }

    /**
     * 用户操盘后期所需的管理费
     * @return float
     */
    public static function getToPayCost($uid, $status = 2) {
        $to_pay_cost = 0;
        $where = array('uid' => $uid);
        if ($status == 2) {
            $where ['status'] = $status;
        } else {
            $where ['p2pstatus'] = $status;
        }

        $arr = \Common\Query::select('user_peizi', $where, array('start_time', 'end_time', 'manage_cost_day'), array('start_time'));
        foreach ($arr as $r) {
            $to_pay_cost += self::get_peizi_day(time(), $r ['end_time']) * floatval($r ['manage_cost_day'] / 100);
        }
        return $to_pay_cost;
    }

    /**
     * 获取当天免费体验数
     * @return type
     */
    public static function getPeiziFreeCountCurDay() {
        $time = time();
        $today = mktime(0, 0, 0, date('m', $time), date('d', $time), date('Y', $time));
        $sql = 'select count(pz_id) total from user_peizi where pz_type=4 and pz_time>' . $today;
        $row = \Common\Query::sqlselone($sql);

        return $row ? $row ['total'] : 0;
    }

    /**
     * 获得证券账号类型
     * @param type $sp_type
     * @return string
     */
    public static function getSptype($sp_type) {
        $name = '';
        switch ($sp_type) {
            case 'ths':
                $name = '同花顺';
                break;
            case 'homes':
                $name = '恒生';
                break;
        }
        return $name;
    }

}
