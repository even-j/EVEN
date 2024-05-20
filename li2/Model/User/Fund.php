<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Model\User;

use Common\Cache;
use Common\Query;

class Fund {
    /**
     * 插入资金流水记录
     * @param type $uid
     * @param type $type
     * @param type $in_or_out －1：支出，1：收入
     * @param type $money  金额，单位：分
     * @param type $status 
     * @param type $table_name
     * @param type $rec_id
     * @param type $card_id
     * @return type
     */
    private static function addRecord($uid,$type,$in_or_out,$money,$status,$table_name = '',$rec_id = 0,$card_id = 0,$remark=''){
        
        $inarr['uid'] = intval($uid);
        $inarr['rtime'] = time();
        $inarr['type'] = intval($type);
        $inarr['in_or_out'] = intval($in_or_out);
        $inarr['money'] = floatval($money);;
        $inarr['table_name'] = \App::t($table_name);
        $inarr['rec_id'] = intval($rec_id);
        $inarr['status'] = intval($status);
        $inarr['card_id'] = intval($card_id);
        $user_row = \Model\User\UserInfo::getinfo($uid);
        $inarr['balance'] = $user_row['balance'];
        $inarr['frozen'] = $user_row['frozen'];
        $inarr['send'] = $user_row['send'];
        $inarr['creditor'] = $user_row['creditor'];
        $inarr['debt'] = $user_row['debt'];
        $inarr['remark'] =  \App::t($remark);
        $res = \Common\Query::insert('user_fund_record', $inarr);
        return $res;
    }
    /**
     * 充值
     * @param type $uid
     * @param type $money
     * @return type
     */
    public static function recharge($recharge_id){
        $sql = 'select uid,money,status from user_recharge_record where recharge_id='. intval($recharge_id).' for update';
        $recharge_row = \Common\Query::sqlselone($sql);
        if($recharge_row && $recharge_row['status'] == 0){
            //获取赠送配置
//            $param_site_base = \Model\Admin\Params::get ( 'site_base' );
//            $recharge_money = intval($recharge_row['money']);
//            $send_money = $recharge_money * floatval($param_site_base['recharge_send_per'])/100;//分
//            if(floatval($param_site_base['recharge_send_max']) > 0 && $send_money > floatval($param_site_base['recharge_send_max'])*100){
//                $send_money = floatval($param_site_base['recharge_send_max'])*100;
//            }
            $res = \Model\User\Recharge::updateSuccessStatus($recharge_id);

            if($res){
                //余额
                $sql = 'update user_info set balance=balance+'.$recharge_row['money'].' where uid='.intval($recharge_row['uid']);
                $res = \Common\Query::sqlquery($sql);
                if(empty($res)){
                    return array(0,'修改余额错误');
                }
                //充值赠送
//                $sql = 'update user_info set send=send+'.$send_money.' where uid='.intval($recharge_row['uid']);
//                $res = \Common\Query::sqlquery($sql);
//                if(empty($res)){
//                    return array(0,'修改赠送金额错误');
//                }
                \Model\User\UserInfo::removeCache($recharge_row['uid']);
                //充值流水
                $res = self::addRecord($recharge_row['uid'], 1, 1, $recharge_row['money'],1);
                if(empty($res)){
                    return array(0,'添加流水记录错误');
                }
                //赠送流水
//                $res = self::addRecord($recharge_row['uid'], 100, 1, $send_money,1);
//                if(empty($res)){
//                    return array(0,'添加赠送流水记录错误');
//                }
                return array(1,'充值成功');
            }
            else{
                return array(0,'充值记录状态更新错误');
            }
        }
        else{
            return array(0,'已充值成功');
        }
        
    }
    /**
     * 线下充值
     * @param type $uid
     * @param type $money
     * @return type
     */
    public static function recharge_offline($recharge_id){
        $sql = 'select uid,money,status from user_recharge_offline where id='. intval($recharge_id).' for update';
        $recharge_row = \Common\Query::sqlselone($sql);
        if($recharge_row && $recharge_row['status'] == 0){
            //获取赠送配置
//            $param_site_base = \Model\Admin\Params::get ( 'site_base' );
//            $recharge_money = intval($recharge_row['money']);
//            $send_money = $recharge_money * floatval($param_site_base['recharge_send_per'])/100;//分
//            if(floatval($param_site_base['recharge_send_max']) > 0 && $send_money > floatval($param_site_base['recharge_send_max'])*100){
//                $send_money = floatval($param_site_base['recharge_send_max'])*100;
//            }
            $res = \Model\User\RechargeOffline::updateSuccessStatus($recharge_id);
            if($res){
                //余额
                $sql = 'update user_info set balance=balance+'.$recharge_row['money'].' where uid='.intval($recharge_row['uid']);
                $res = \Common\Query::sqlquery($sql);
                if(empty($res)){
                    return array(0,'修改余额错误');
                }
                //充值赠送
//                $sql = 'update user_info set send=send+'.$send_money.' where uid='.intval($recharge_row['uid']);
//                $res = \Common\Query::sqlquery($sql);
//                if(empty($res)){
//                    return array(0,'修改赠送金额错误');
//                }
                \Model\User\UserInfo::removeCache($recharge_row['uid']);
                //充值流水
                $res = self::addRecord($recharge_row['uid'], 1, 1, $recharge_row['money'],1);
                if(empty($res)){
                    return array(0,'添加流水记录错误');
                }
                //赠送流水
//                $res = self::addRecord($recharge_row['uid'], 100, 1, $send_money,1);
//                if(empty($res)){
//                    return array(0,'添加流水记录错误');
//                }
                return array(1,'充值成功');
            }
            else{
                return array(0,'充值记录状态更新错误');
            }
        }
        else{
            return array(0,'已充值成功');
        }
        
    }
    /**
     * 线下充值返利
     * @param type $uid
     * @param type $money
     * @return type
     */
    public static function recharge_offline_rebate($uid,$money){
        //余额
        $sql = 'update user_info set balance=balance+'.$money.' where uid='.intval($uid);
        $res = \Common\Query::sqlquery($sql);
        if(empty($res)){
            return array(0,'修改余额错误');
        }
        \Model\User\UserInfo::removeCache($uid);
        //充值流水
        $res = self::addRecord($uid, 400, 1, $money,1);
        if(empty($res)){
            return array(0,'添加流水记录错误');
        }
        return array(1,'充值成功');
    }
    
    public static function get_profit($profit_id){
        $sql = 'select uid,pz_id,money,status from user_peizi_getprofit where id='. intval($profit_id).' for update';
        $profit_row = \Common\Query::sqlselone($sql);
        if($profit_row && $profit_row['status'] == 0){
            $res = \Model\Peizi\GetProfit::updateSuccessStatus($profit_id);
            if($res){
                //余额
                $sql = 'update user_info set balance=balance+'.$profit_row['money'].' where uid='.intval($profit_row['uid']);
                $res = \Common\Query::sqlquery($sql);
                if(empty($res)){
                    return array(0,'修改余额错误');
                }
                \Model\User\UserInfo::removeCache($profit_row['uid']);
                //盈利提取流水
                $res = self::addRecord($profit_row['uid'], 300, 1, $profit_row['money'],1,'user_peizi',$profit_row['pz_id']);
                if(empty($res)){
                    return array(0,'添加流水记录错误');
                }
                return array(1,'盈利提取成功');
            }
            else{
                return array(0,'充值记录状态更新错误');
            }
        }
        else{
            return array(0,'盈利提取成功');
        }
    }
    /**
     * 注册管理费赠送
     * @param type $uid
     * @param type $send_money 分
     * @return type
     */
    public static function regist($uid,$send_money){
        $send_money = floatval($send_money);
        //充值赠送
        $sql = 'update user_info set send=send+'.$send_money.' where uid='.intval($uid);
        $res = \Common\Query::sqlquery($sql);
        if(empty($res)){
            return array(0,'修改赠送金额错误');
        }
        \Model\User\UserInfo::removeCache($uid);
        
        //赠送流水
        $res = self::addRecord($uid, 103, 1, $send_money,1);
        if(empty($res)){
            return array(0,'添加赠送流水记录错误');
        }
        return array(1,'赠送成功');
    }
    /**
     * 签到管理费赠送
     * @param type $uid
     * @param type $send_money 分
     * @return type
     */
    public static function sign($uid,$send_money){
        $send_money = floatval($send_money);
        //充值赠送
        $sql = 'update user_info set send=send+'.$send_money.' where uid='.intval($uid);
        $res = \Common\Query::sqlquery($sql);
        if(empty($res)){
            return array(0,'修改赠送金额错误');
        }
        \Model\User\UserInfo::removeCache($uid);
        
        //赠送流水
        $res = self::addRecord($uid, 104, 1, $send_money,1);
        if(empty($res)){
            return array(0,'添加赠送流水记录错误');
        }
        return array(1,'赠送成功');
    }
    /**
     * 实名认证管理费赠送
     * @param type $uid
     * @param type $send_money 分
     * @return type
     */
    public static function send_sfz($uid,$send_money){
        $send_money = floatval($send_money);
        //充值赠送
        $sql = 'update user_info set send=send+'.$send_money.' where uid='.intval($uid);
        $res = \Common\Query::sqlquery($sql);
        if(empty($res)){
            return array(0,'修改赠送金额错误');
        }
        \Model\User\UserInfo::removeCache($uid);
        
        //赠送流水
        $res = self::addRecord($uid, 105, 1, $send_money,1);
        if(empty($res)){
            return array(0,'添加赠送流水记录错误');
        }
        return array(1,'赠送成功');
    }
    /**
     * 银行卡绑定管理费赠送
     * @param type $uid
     * @param type $send_money 分
     * @return type
     */
    public static function send_bank($uid,$send_money){
        $send_money = floatval($send_money);
        //充值赠送
        $sql = 'update user_info set send=send+'.$send_money.' where uid='.intval($uid);
        $res = \Common\Query::sqlquery($sql);
        if(empty($res)){
            return array(0,'修改赠送金额错误');
        }
        \Model\User\UserInfo::removeCache($uid);
        
        //赠送流水
        $res = self::addRecord($uid, 106, 1, $send_money,1);
        if(empty($res)){
            return array(0,'添加赠送流水记录错误');
        }
        return array(1,'赠送成功');
    }
    /**
     * 首资策略管理费赠送
     * @param type $uid
     * @param type $send_money 分
     * @return type
     */
    public static function send_peizi($uid,$send_money,$rec_id){
        $send_money = floatval($send_money);
        //充值赠送
        $sql = 'update user_info set send=send+'.$send_money.' where uid='.intval($uid);
        $res = \Common\Query::sqlquery($sql);
        if(empty($res)){
            return array(0,'修改赠送金额错误');
        }
        \Model\User\UserInfo::removeCache($uid);
        
        //赠送流水
        $res = self::addRecord($uid, 107, 1, $send_money,1,'user_peizi',$rec_id);
        if(empty($res)){
            return array(0,'添加赠送流水记录错误');
        }
        return array(1,'赠送成功');
    }
    /**
     * 首资策略追加管理费赠送
     * @param type $uid
     * @param type $send_money 分
     * @return type
     */
    public static function send_add($uid,$send_money,$rec_id){
        $send_money = floatval($send_money);
        //充值赠送
        $sql = 'update user_info set send=send+'.$send_money.' where uid='.intval($uid);
        $res = \Common\Query::sqlquery($sql);
        if(empty($res)){
            return array(0,'修改赠送金额错误');
        }
        \Model\User\UserInfo::removeCache($uid);
        
        //赠送流水
        $res = self::addRecord($uid, 108, 1, $send_money,1,'user_peizi',$rec_id);
        if(empty($res)){
            return array(0,'添加赠送流水记录错误');
        }
        return array(1,'赠送成功');
    }
    /**
     * 首资补亏管理费赠送
     * @param type $uid
     * @param type $send_money 分
     * @return type
     */
    public static function send_fill($uid,$send_money,$rec_id){
        $send_money = floatval($send_money);
        //充值赠送
        $sql = 'update user_info set send=send+'.$send_money.' where uid='.intval($uid);
        $res = \Common\Query::sqlquery($sql);
        if(empty($res)){
            return array(0,'修改赠送金额错误');
        }
        \Model\User\UserInfo::removeCache($uid);
        
        //赠送流水
        $res = self::addRecord($uid, 109, 1, $send_money,1,'user_peizi',$rec_id);
        if(empty($res)){
            return array(0,'添加赠送流水记录错误');
        }
        return array(1,'赠送成功');
    }
    /**
     * 首资提盈管理费赠送
     * @param type $uid
     * @param type $send_money 分
     * @return type
     */
    public static function send_profit($uid,$send_money,$rec_id){
        $send_money = floatval($send_money);
        //充值赠送
        $sql = 'update user_info set send=send+'.$send_money.' where uid='.intval($uid);
        $res = \Common\Query::sqlquery($sql);
        if(empty($res)){
            return array(0,'修改赠送金额错误');
        }
        \Model\User\UserInfo::removeCache($uid);
        
        //赠送流水
        $res = self::addRecord($uid, 110, 1, $send_money,1,'user_peizi',$rec_id);
        if(empty($res)){
            return array(0,'添加赠送流水记录错误');
        }
        return array(1,'赠送成功');
    }
    /**
     * 首资提盈管理费赠送
     * @param type $uid
     * @param type $send_money 分
     * @return type
     */
    public static function send_recharge($uid,$send_money){
        $send_money = floatval($send_money);
        //充值赠送
        $sql = 'update user_info set send=send+'.$send_money.' where uid='.intval($uid);
        $res = \Common\Query::sqlquery($sql);
        if(empty($res)){
            return array(0,'修改赠送金额错误');
        }
        \Model\User\UserInfo::removeCache($uid);
        
        //赠送流水
        $res = self::addRecord($uid, 111, 1, $send_money,1);
        if(empty($res)){
            return array(0,'添加赠送流水记录错误');
        }
        return array(1,'赠送成功');
    }
    /**
     * 管理费赠送
     * @param type $uid
     * @param type $send_money 分
     * @return type
     */
    public static function send($uid,$send_money){
        $send_money = floatval($send_money);
        //充值赠送
        $sql = 'update user_info set send=send+'.$send_money.' where uid='.intval($uid);
        $res = \Common\Query::sqlquery($sql);
        if(empty($res)){
            return array(0,'修改赠送金额错误');
        }
        \Model\User\UserInfo::removeCache($uid);
        
        //赠送流水
        $res = self::addRecord($uid, 100, 1, $send_money,1);
        if(empty($res)){
            return array(0,'添加赠送流水记录错误');
        }
        return array(1,'赠送成功');
    }
    /**
     * 管理费赠送扣除
     * @param type $uid
     * @param type $send_money 分
     * @return type
     */
    public static function sendMinus($uid,$money){
        //判断余额
        $user = \Model\User\UserInfo::getinfo($uid);
        $send = $user? $user['send']:0;
        if(round($send,2)<round($money,2)){
            return array(0,'赠送管理费不足');
        }
        //充值赠送扣除
        $sql = 'update user_info set send=send-'.$money.' where uid='.intval($uid);
        $res = \Common\Query::sqlquery($sql);
        if(empty($res)){
            return array(0,'修改赠送金额错误');
        }
        \Model\User\UserInfo::removeCache($uid);
        
        //赠送扣除流水
        $res = self::addRecord($uid, 102, -1, $money,1);
        if(empty($res)){
            return array(0,'添加赠送扣除流水记录错误');
        }
        return array(1,'扣除成功');
    }
    /**
     * 提现
     * @param type $uid
     * @param type $money
     * @return type
     */
    public static function withdraw($uid,$money,$card_id){
        //判断余额
        $user = \Model\User\UserInfo::getinfo($uid);
        $balance = $user? $user['balance']:0;
        if(round($balance,2)<round($money,2)){
            return array(0,'余额不足');
        }
        //修改余额
        $sql = 'update user_info set balance=balance-'.floatval($money).' where uid='.intval($uid);
        $res = \Common\Query::sqlquery($sql);
        if(empty($res)){
            return array(0,'修改余额错误');
        }
        \Model\User\UserInfo::removeCache($uid);
        //添加流水记录
        $res = self::addRecord($uid, 2, -1, $money, 1,'',0,$card_id);
        if(empty($res)){
            return array(0,'添加流水记录错误');
        }
        return array(1,'成功');
    }
    /**
     * 投资支出
     * @param type $uid
     * @param type $money
     * @param type $table_name
     * @param type $rec_id
     * @return type
     */
    public static function creditor_out($uid,$money,$rec_id,$table_name='user_peizi_touzi'){
        //判断余额
        $user = \Model\User\UserInfo::getinfo($uid);
        $balance = $user? $user['balance']:0;
        if(round($balance,2)<round($money,2)){
            return array(0,'余额不足');
        }
        //修改余额，投资债权
        $sql = 'update user_info set balance=balance-'.floatval($money).',creditor=creditor+'.  floatval($money).' where uid='.intval($uid);
        $res = \Common\Query::sqlquery($sql);
        if(empty($res)){
            return array(0,'修改余额，投资债权错误');
        }
        \Model\User\UserInfo::removeCache($uid);
        //添加流水记录
        $res = self::addRecord($uid, 3, -1, $money, 1,$table_name,$rec_id);
        if(empty($res)){
            return array(0,'添加流水记录错误');
        }
        return array(1,'成功');
    }
    /**
     * 投资返回
     * @param type $uid
     * @param type $money
     * @param type $table_name
     * @param type $rec_id
     * @return type
     */
    public static function creditor_in($uid,$money,$rec_id,$table_name='user_peizi_touzi'){
        //判断债权余额
        $user = \Model\User\UserInfo::getinfo($uid);
        $creditor = $user? $user['creditor']:0;
        if(round($creditor,2)<round($money,2)){
            return array(0,'债权余额不足');
        }
        //修改余额，投资债权
        $sql = 'update user_info set balance=balance+'.floatval($money).',creditor=creditor-'.  floatval($money).' where uid='.intval($uid);
        $res = \Common\Query::sqlquery($sql);
        if(empty($res)){
            return array(0,'修改余额，投资债权错误');
        }
        \Model\User\UserInfo::removeCache($uid);
        //添加流水记录
        $res = self::addRecord($uid, 4, 1, $money, 1,$table_name,$rec_id);
        if(empty($res)){
            return array(0,'添加流水记录错误');
        }
        return array(1,'成功');
    }
    /**
     * 冻结保证金
     * @param type $uid
     * @param type $money
     * @param type $table_name
     * @param type $rec_id
     * @return type
     */
    public static function bond($uid,$money,$rec_id,$table_name='user_peizi'){
        //判断余额
        $user = \Model\User\UserInfo::getinfo($uid);
        $balance = $user? $user['balance']:0;
        if(round($balance,2)<round($money,2)){
            return array(0,'余额不足');
        }
        //修改余额，冻结保证金
        $sql = 'update user_info set balance=balance-'.floatval($money).',frozen=frozen+'.  floatval($money).' where uid='.intval($uid);
        $res = \Common\Query::sqlquery($sql);
        if(empty($res)){
            return array(0,'修改余额，冻结保证金错误');
        }
        \Model\User\UserInfo::removeCache($uid);
        //添加流水记录
        $res = self::addRecord($uid, 5, -1, $money, 1,$table_name,$rec_id);
        if(empty($res)){
            return array(0,'添加流水记录错误');
        }
        return array(1,'成功');
    }
    /**
     * 解冻保证金
     * @param type $uid
     * @param type $money
     * @param type $rec_id
     * @param type $table_name
     * @return type
     */
    public static function bondBack($uid,$money,$rec_id,$table_name='user_peizi'){
        //判断冻结资金
        $user = \Model\User\UserInfo::getinfo($uid);
        $frozen = $user? $user['frozen']:0;
        if(round($frozen,2)<round($money,2)){
            return array(0,'冻结资金不足');
        }
        //修改余额，解冻保证金
        $sql = 'update user_info set balance=balance+'.floatval($money).',frozen=frozen-'.  floatval($money).' where uid='.intval($uid);
        $res = \Common\Query::sqlquery($sql);
        if(empty($res)){
            return array(0,'修改余额，解冻保证金错误');
        }
        \Model\User\UserInfo::removeCache($uid);
        //添加流水记录
        $res = self::addRecord($uid, 6, 1, $money, 1,$table_name,$rec_id);
        if(empty($res)){
            return array(0,'添加流水记录错误');
        }
        return array(1,'成功');
    }
    /**
     * 补亏
     * @param type $uid
     * @param type $money
     * @param type $rec_id
     * @param type $table_name
     * @return type
     */
    public static function fillLoss($uid,$money,$rec_id,$table_name='user_peizi'){
        //判断余额
        $user = \Model\User\UserInfo::getinfo($uid);
        $balance = $user? $user['balance']:0;
        if(round($balance,2)<round($money,2)){
            return array(0,'余额不足');
        }
        //修改余额
        $sql = 'update user_info set balance=balance-'.floatval($money).' where uid='.intval($uid);
        $res = \Common\Query::sqlquery($sql);
        if(empty($res)){
            return array(0,'修改余额错误');
        }
        \Model\User\UserInfo::removeCache($uid);
        //修改配资补亏金额
        $sql = 'update user_peizi set fill_loss_money=fill_loss_money+'.floatval($money).' where pz_id='.intval($rec_id);
        $res = \Common\Query::sqlquery($sql);
        if(empty($res)){
            return array(0,'修改配资补亏金额错误');
        }
        //添加流水记录
        $res = self::addRecord($uid, 7, -1, $money, 1,$table_name,$rec_id);
        if(empty($res)){
            return array(0,'添加流水记录错误');
        }
        return array(1,'成功');
    }
    
    /**
     * 支付利息
     * @param type $uid
     * @param type $money
     * @param type $rec_id
     * @param type $table_name
     * @return type
     */
    public static function interestPay($uid,$money,$rec_id,$table_name='user_peizi'){
        //判断余额
        $user = \Model\User\UserInfo::getinfo($uid);
        $balance = $user? $user['balance']:0;
        if(round($balance,2)<round($money,2)){
            return array(0,'余额不足');
        }
        //修改余额
        $sql = 'update user_info set balance=balance-'.floatval($money).' where uid='.intval($uid);
        $res = \Common\Query::sqlquery($sql);
        if(empty($res)){
            return array(0,'修改余额错误');
        }
        \Model\User\UserInfo::removeCache($uid);
        //添加流水记录
        $res = self::addRecord($uid, 8, -1, $money, 1,$table_name,$rec_id);
        if(empty($res)){
            return array(0,'添加流水记录错误');
        }
        return array(1,'成功');
    }
    /**
     * 退回利息
     * @param type $uid
     * @param type $money
     * @param type $rec_id
     * @param type $table_name
     * @return type
     */
    public static function interestBack($uid,$money,$rec_id,$table_name='user_peizi'){
        //修改余额
        $sql = 'update user_info set balance=balance+'.floatval($money).' where uid='.intval($uid);
        $res = \Common\Query::sqlquery($sql);
        if(empty($res)){
            return array(0,'修改余额错误');
        }
        \Model\User\UserInfo::removeCache($uid);
        //添加流水记录
        $res = self::addRecord($uid, 9, 1, $money, 1,$table_name,$rec_id);
        if(empty($res)){
            return array(0,'添加流水记录错误');
        }
        return array(1,'成功');
    }
    
    /**
     * 支付帐户管理费
     * @param type $uid
     * @param type $money
     * @param type $rec_id
     * @param type $table_name
     * @return type
     */
    public static function managecostPay($uid,$money,$rec_id,$table_name='user_peizi',$remark=''){
        //判断余额
        $user = \Model\User\UserInfo::getinfo($uid);
        $balance = $user? intval($user['balance']):0;
        $send = $user? intval($user['send']):0;
        if(round(($balance+$send),2)<round($money,2)){
            return array(0,'余额不足');
        }
        $send_minus_money = 0;//赠送的扣减金额
        $balance_minus_money = 0;//余额的扣减金额
        if($send>0){
            if($send >= $money){
                $send_minus_money = $money;
                $balance_minus_money = 0;
            }
            else{
                $send_minus_money = $send;
                $balance_minus_money = $money - $send;
            }
        }
        else{
            $send_minus_money = 0;
            $balance_minus_money = $money;
        }
        //修改赠送
        if($send_minus_money>0){
            $sql = 'update user_info set send=send-'.floatval($send_minus_money).' where uid='.intval($uid);
            $res = \Common\Query::sqlquery($sql);
            if(empty($res)){
                return array(0,'修改赠送余额错误');
            }
            \Model\User\UserInfo::removeCache($uid);
            //添加流水记录
            $res = self::addRecord($uid, 101, -1, $send_minus_money, 1,$table_name,$rec_id,0,$remark);
            if(empty($res)){
                return array(0,'添加赠送流水记录错误');
            }
        }
        //修改余额
        if($balance_minus_money > 0){
            $sql = 'update user_info set balance=balance-'.floatval($balance_minus_money).' where uid='.intval($uid);
            $res = \Common\Query::sqlquery($sql);
            if(empty($res)){
                return array(0,'修改余额错误');
            }
            \Model\User\UserInfo::removeCache($uid);
            //添加流水记录
            $res = self::addRecord($uid, 10, -1, $balance_minus_money, 1,$table_name,$rec_id,0,$remark);
            if(empty($res)){
                return array(0,'添加流水记录错误');
            }
        }
        //介绍人佣金
        if($user['introducer_id']){
            $int_user = UserInfo::getinfo($user['introducer_id']);
            $param_site_base = \Model\Admin\Params::get ( 'site_base' );
            $jsryj_per = floatval($param_site_base['jsryj_per']);
            $yongjin_money = round($money*$jsryj_per/100,0);
            if($yongjin_money > 0){
                //佣金添加
                $sql = 'update user_info set balance=balance+'.$yongjin_money.' where uid='.intval($int_user['uid']);
                $res = \Common\Query::sqlquery($sql);
                if(empty($res)){
                    return array(0,'增加介绍佣金错误');
                }
                //佣金流水
                $res = self::addRecord($int_user['uid'], 200, 1, $yongjin_money,1,$table_name,$rec_id);
                if(empty($res)){
                    return array(0,'添加介绍佣金流水记录错误');
                }
                \Model\User\UserInfo::removeCache($int_user['uid']);
            }
        }
        \Model\User\UserInfo::removeCache($uid);
        
        return array(1,'成功');
    }
    /**
     * 退回帐户管理费
     * @param type $uid
     * @param type $money
     * @param type $rec_id
     * @param type $table_name
     * @return type
     */
    public static function managecostBack($uid,$money,$rec_id,$table_name='user_peizi'){
        //修改余额
        $sql = 'update user_info set balance=balance+'.floatval($money).' where uid='.intval($uid);
        $res = \Common\Query::sqlquery($sql);
        if(empty($res)){
            return array(0,'修改余额错误');
        }
        \Model\User\UserInfo::removeCache($uid);
        //添加流水记录
        $res = self::addRecord($uid, 11, 1, $money, 1,$table_name,$rec_id);
        if(empty($res)){
            return array(0,'添加流水记录错误');
        }
        return array(1,'成功');
    }
    /**
     * 盈利提取
     * @param type $uid
     * @param type $money
     * @param type $rec_id
     * @param type $table_name
     * @return type
     */
    public static function win($uid,$money,$rec_id,$table_name='user_peizi'){
        //修改余额
        $sql = 'update user_info set balance=balance+'.floatval($money).' where uid='.intval($uid);
        $res = \Common\Query::sqlquery($sql);
        if(empty($res)){
            return array(0,'修改余额错误');
        }
        \Model\User\UserInfo::removeCache($uid);
        //添加流水记录
        $res = self::addRecord($uid, 12, 1, $money, 1,$table_name,$rec_id);
        if(empty($res)){
            return array(0,'添加流水记录错误');
        }
        return array(1,'成功');
    }
    /**
     * 免费体验盈利提取，提到赠送
     * @param type $uid
     * @param type $money
     * @param type $rec_id
     * @param type $table_name
     * @return type
     */
    public static function win_free($uid,$money,$rec_id,$table_name='user_peizi'){
        //修改余额
        $sql = 'update user_info set send=send+'.floatval($money).' where uid='.intval($uid);
        $res = \Common\Query::sqlquery($sql);
        if(empty($res)){
            return array(0,'修改赠送错误');
        }
        \Model\User\UserInfo::removeCache($uid);
        //添加流水记录
        $res = self::addRecord($uid, 12, 1, $money, 1,$table_name,$rec_id);
        if(empty($res)){
            return array(0,'添加流水记录错误');
        }
        return array(1,'成功');
    }
    /**
     * 系统后台充值
     * @param type $uid
     * @param type $money
     * @return type
     */
    public static function rechargeSys($uid,$money){
        //修改余额
        $sql = 'update user_info set balance=balance+'.floatval($money).' where uid='.intval($uid);
        $res = \Common\Query::sqlquery($sql);
        if(empty($res)){
            return array(0,'修改余额错误');
        }
        \Model\User\UserInfo::removeCache($uid);
        //添加流水记录
        $res = self::addRecord($uid, 14, 1, $money, 1);
        if(empty($res)){
            return array(0,'添加流水记录错误');
        }
        return array(1,'成功');
        
    }
    /**
     * 系统后台提现
     * @param type $uid
     * @param type $money
     * @return type
     */
    public static function withdrawSys($uid,$money){
        //判断余额
        $user = \Model\User\UserInfo::getinfo($uid);
        $balance = $user? $user['balance']:0;
        if(round($balance,2)<round($money,2)){
            return array(0,'余额不足');
        }
        //修改余额
        $sql = 'update user_info set balance=balance-'.floatval($money).' where uid='.intval($uid);
        $res = \Common\Query::sqlquery($sql);
        if(empty($res)){
            return array(0,'修改余额错误');
        }
        \Model\User\UserInfo::removeCache($uid);
        //添加流水记录
        $res = self::addRecord($uid, 15, -1, $money, 1);
        if(empty($res)){
            return array(0,'添加流水记录错误');
        }
        return array(1,'成功');
    }
    /**
     * 赚取利息
     * @param type $uid
     * @param type $money
     * @param type $rec_id
     * @param type $table_name
     * @return type
     */
    public static function interestEarn($uid,$money,$rec_id,$table_name='user_peizi'){
        //修改余额
        $sql = 'update user_info set balance=balance+'.floatval($money).' where uid='.intval($uid);
        $res = \Common\Query::sqlquery($sql);
        if(empty($res)){
            return array(0,'修改余额错误');
        }
        \Model\User\UserInfo::removeCache($uid);
        //添加流水记录
        $res = self::addRecord($uid, 16, 1, $money, 1,$table_name,$rec_id);
        if(empty($res)){
            return array(0,'添加流水记录错误');
        }
        return array(1,'成功');
    }
    /**
     * 盈利分成收入
     * @param type $uid
     * @param type $money
     * @param type $rec_id
     * @param type $table_name
     * @return type
     */
    public static function winFenchengIn($uid,$money,$rec_id,$table_name='user_peizi_touzi'){
        //修改余额
        $sql = 'update user_info set balance=balance+'.floatval($money).' where uid='.intval($uid);
        $res = \Common\Query::sqlquery($sql);
        if(empty($res)){
            return array(0,'修改余额错误');
        }
        \Model\User\UserInfo::removeCache($uid);
        //添加流水记录
        $res = self::addRecord($uid, 17, 1, $money, 1,$table_name,$rec_id);
        if(empty($res)){
            return array(0,'添加流水记录错误');
        }
        return array(1,'成功');
    }
    /**
     * 盈利分成支出
     * @param type $uid
     * @param type $money
     * @param type $rec_id
     * @param type $table_name
     * @return type
     */
    public static function winFenchengOut($uid,$money,$rec_id,$table_name='user_peizi'){
        //判断余额
        $user = \Model\User\UserInfo::getinfo($uid);
        $balance = $user? $user['balance']:0;
        if(round($balance,2)<round($money,2)){
            return array(0,'余额不足');
        }
        //修改余额
        $sql = 'update user_info set balance=balance-'.floatval($money).' where uid='.intval($uid);
        $res = \Common\Query::sqlquery($sql);
        if(empty($res)){
            return array(0,'修改余额错误');
        }
        \Model\User\UserInfo::removeCache($uid);
        //添加流水记录
        $res = self::addRecord($uid, 18, 1, $money, 1,$table_name,$rec_id);
        if(empty($res)){
            return array(0,'添加流水记录错误');
        }
        return array(1,'成功');
    }
    /**
     * 借入配资本金
     * @param type $uid
     * @param type $money
     * @param type $rec_id
     * @param type $table_name
     * @return type
     */
    public static function peiziBorrow($uid,$money,$rec_id,$table_name='user_peizi'){
        //修改余额,债务
        $sql = 'update user_info set balance=balance+'.floatval($money).',debt=debt+'.floatval($money).' where uid='.intval($uid);
        $res = \Common\Query::sqlquery($sql);
        if(empty($res)){
            return array(0,'修改余额,债务错误');
        }
        \Model\User\UserInfo::removeCache($uid);
        //添加流水记录
        $res = self::addRecord($uid, 19, 1, $money, 1,$table_name,$rec_id);
        if(empty($res)){
            return array(0,'添加流水记录错误');
        }
        return array(1,'成功');
    }
    /**
     * 退还配资本金
     * @param type $uid
     * @param type $money
     * @param type $rec_id
     * @param type $table_name
     * @return type
     */
    public static function peiziBack($uid,$money,$rec_id,$table_name='user_peizi'){
        //判断余额
        $user = \Model\User\UserInfo::getinfo($uid);
        $balance = $user? $user['balance']:0;
        if(round($balance,2)<round($money,2)){
            return array(0,'余额不足');
        }
        //修改余额,债务
        $sql = 'update user_info set balance=balance-'.floatval($money).',debt=debt-'.floatval($money).' where uid='.intval($uid);
        $res = \Common\Query::sqlquery($sql);
        if(empty($res)){
            return array(0,'修改余额,债务错误');
        }
        \Model\User\UserInfo::removeCache($uid);
        //添加流水记录
        $res = self::addRecord($uid, 20, -1, $money, 1,$table_name,$rec_id);
        if(empty($res)){
            return array(0,'添加流水记录错误');
        }
        return array(1,'成功');
    }
    /**
     * 冻结配资本金
     * @param type $uid
     * @param type $money
     * @param type $rec_id
     * @param type $table_name
     * @return type
     */
    public static function peiziFrozen($uid,$money,$rec_id,$table_name='user_peizi'){
        //判断余额
        $user = \Model\User\UserInfo::getinfo($uid);
        $balance = $user? $user['balance']:0;
        if(round($balance,2)<round($money,2)){
            return array(0,'余额不足');
        }
        //修改余额，冻结资金
        $sql = 'update user_info set balance=balance-'.floatval($money).',frozen=frozen+'.floatval($money).' where uid='.intval($uid);
        $res = \Common\Query::sqlquery($sql);
        if(empty($res)){
            return array(0,'修改余额，冻结资金错误');
        }
        \Model\User\UserInfo::removeCache($uid);
        //添加流水记录
        $res = self::addRecord($uid, 21, -1, $money, 1,$table_name,$rec_id);
        if(empty($res)){
            return array(0,'添加流水记录错误');
        }
        return array(1,'成功');
    }
    /**
     * 解冻配资本金
     * @param type $uid
     * @param type $money
     * @param type $rec_id
     * @param type $table_name
     * @return type
     */
    public static function peiziUnfrozen($uid,$money,$rec_id,$table_name='user_peizi'){
        //判断冻结资金
        $user = \Model\User\UserInfo::getinfo($uid);
        $frozen = $user? $user['frozen']:0;
        if(round($frozen,2)<round($money,2)){
            return array(0,'冻结资金不足');
        }
        //修改余额，冻结资金
        $sql = 'update user_info set balance=balance+'.floatval($money).',frozen=frozen-'.floatval($money).' where uid='.intval($uid);
        $res = \Common\Query::sqlquery($sql);
        if(empty($res)){
            return array(0,'修改余额，冻结资金错误');
        }
        \Model\User\UserInfo::removeCache($uid);
        //添加流水记录
        $res = self::addRecord($uid, 22, 1, $money, 1,$table_name,$rec_id);
        if(empty($res)){
            return array(0,'添加流水记录错误');
        }
        return array(1,'成功');
    }
    /**
     * 委托入股市
     * @param type $uid
     * @param type $money
     * @param type $rec_id
     * @param type $table_name
     * @return type
     */
    public static function tradeIn($uid,$money,$rec_id,$table_name='user_peizi'){
        
        //添加流水记录
        $res = self::addRecord($uid, 23, -1, $money, 1,$table_name,$rec_id);
        if(empty($res)){
            return array(0,'添加流水记录错误');
        }
        return array(1,'成功');
    }
    /**
     * 委托出股市
     * @param type $uid
     * @param type $money
     * @param type $rec_id
     * @param type $table_name
     * @return type
     */
    public static function tradeOut($uid,$money,$rec_id,$table_name='user_peizi'){
        
        //添加流水记录
        $res = self::addRecord($uid, 24, 1, $money, 1,$table_name,$rec_id);
        if(empty($res)){
            return array(0,'添加流水记录错误');
        }
        return array(1,'成功');
    }
    /**
     * 冻结提现
     * @param type $uid
     * @param type $money
     * @param type $table_name
     * @param type $rec_id
     * @return type
     */
    public static function withdrawFrozen($uid,$money){
        //判断余额
        $user = \Model\User\UserInfo::getinfo($uid);
        $balance = $user? $user['balance']:0;
        if(round($balance,2)<round($money,2)){
            return array(0,'余额不足');
        }
        //修改余额，冻结保证金
        $sql = 'update user_info set balance=balance-'.floatval($money).',frozen=frozen+'.  floatval($money).' where uid='.intval($uid);
        $res = \Common\Query::sqlquery($sql);
        if(empty($res)){
            return array(0,'修改余额，冻结提现金错误');
        }
        \Model\User\UserInfo::removeCache($uid);
        //添加流水记录
        $res = self::addRecord($uid, 25, -1, $money, 1);
        if(empty($res)){
            return array(0,'添加流水记录错误');
        }
        return array(1,'成功');
    }
    /**
     * 解冻提现金
     * @param type $uid
     * @param type $money
     * @param type $rec_id
     * @param type $table_name
     * @return type
     */
    public static function withdrawUnfrozen($uid,$money){
        //判断冻结资金
        $user = \Model\User\UserInfo::getinfo($uid);
        $frozen = $user? $user['frozen']:0;
        if(round($frozen,2)<round($money,2)){
            return array(0,'冻结资金不足');
        }
        //修改余额，解冻提现金
        $sql = 'update user_info set balance=balance+'.floatval($money).',frozen=frozen-'.  floatval($money).' where uid='.intval($uid);
        $res = \Common\Query::sqlquery($sql);
        if(empty($res)){
            return array(0,'修改余额，解冻提现金错误');
        }
        \Model\User\UserInfo::removeCache($uid);
        //添加流水记录
        $res = self::addRecord($uid, 26, 1, $money, 1);
        if(empty($res)){
            return array(0,'添加流水记录错误');
        }
        return array(1,'成功');
    }
    public static function peiziAdd(){
        
    }
    /**
     * 资金流水类型
     * @param type $type
     */
    public static function fundTypeName($type){
        $name = '';
        switch ($type){
            case 1:
                $name = '充值';
                break;
            case 2:
                $name = '提现';
                break;
            case 3:
                $name = '投资支出';
                break;
            case 4:
                $name = '投资返回';
                break;
            case 5:
                $name = '冻结保证金';
                break;
            case 6:
                $name = '解冻保证金';
                break;
            case 7:
                $name = '补交亏损';
                break;
            case 8:
                $name = '支付利息';
                break;
            case 9:
                $name = '返回利息';
                break;
            case 10:
                $name = '支付管理费';
                break;
            case 11:
                $name = '返回账户管理费';
                break;
            case 12:
                $name = '结束配资盈亏';
                break;
            case 13:
                $name = '追加配资';
                break;
            case 14:
                $name = '系统充值';
                break;
            case 15:
                $name = '系统扣除';
                break;
            case 16:
                $name = '赚取利息';
                break;
            case 17:
                $name = '盈利分成收入';
                break;
            case 18:
                $name = '盈利分成支出';
                break;
            case 19:
                $name = '借入配资本金';
                break;
            case 20:
                $name = '退还配资本金';
                break;
            case 21:
                $name = '冻结配资本金';
                break;
            case 22:
                $name = '解冻配资本金';
                break;
            case 23:
                $name = '委托进股市';
                break;
            case 24:
                $name = '委托出股市';
                break;
            case 25:
                $name = '提现冻结';
                break;
            case 26:
                $name = '提现解冻';
                break;
            case 100:
                $name = '管理费赠送';
                break;
            case 101:
                $name = '赠送消费';
                break;
            case 102:
                $name = '赠送扣除';
                break;
            case 103:
                $name = '注册赠送';
                break;
            case 104:
                $name = '签到赠送';
                break;
            case 105:
                $name = '实名认证赠送';
                break;
            case 106:
                $name = '绑定银行卡赠送';
                break;
            case 107:
                $name = '首次配资赠送';
                break;
            case 108:
                $name = '首次追加配资赠送';
                break;
            case 109:
                $name = '首次补亏赠送';
                break;
            case 110:
                $name = '首次提盈赠送';
                break;
            case 111:
                $name = '首次充值赠送';
                break;
            case 200:
                $name = '介绍佣金';
                break;
            case 300:
                $name = '盈利提取';
                break;
            case 400:
                $name = '充值返利';
                break;
        }
        return $name;
    }
    
    /**
     * 得到提现待处理条数
     * @return type
     */
    public static function getWithdrawCount(){
        $sql = 'select count(withdraw_id) total from user_withdraw_record where status<2';
        $row = \Common\Query::sqlselone($sql);
        return $row?$row['total']:0;
    }
    
	/**
     * 用户余额操作
     * @param type $uid
     * @param type $money
     * @param type $type
     * @param type $status
     * @param type $in_or_out 收入或支出（－1：支出，1：收入）
     * @param type $card_id
     * @return type
     */
    public static function userBalanceChange($uid,$money,$type,$status=1,$in_or_out=1,$card_id=0){
    	$balance = $in_or_out==1 ? $money : -$money;
    	\Common\Query::commitstart();
        //修改余额
        $sql = 'update user_info set balance=balance+'.intval($balance).' where uid='.intval($uid);
        $res = \Common\Query::sqlquery($sql);
        if($res){
	        //添加流水记录
	        $res = self::addRecord($uid, $type, $in_or_out, $money, $status,'',0,$card_id);
	        if(empty($res)){
	        	\Common\Query::rollback();
	            return array(0,'添加流水记录错误');
	        }
	         \Common\Query::commit();
	         \Model\User\UserInfo::removeCache($uid);
	        return array(1,'操作成功');
        }else{
        	\Common\Query::rollback();
            return array(0,'余额操作失败');
        }
        
    }
    
    /**
     * 根据ID获取交易记录
     * @param type $fund_id
     * @return type
     */
    public static function getRecordById($fund_id){
    	$res = \Common\Query::select('user_fund_record',array('fund_id'=>$fund_id));
    	return $res ? $res[0] : array();
    }
    
 	/**
     * 根据ID改变交易状态
     * @param type $fund_id
     * @return type
     */
    public static function changeRecordStatusById($status,$fund_id){
    	return \Common\Query::update('user_fund_record', array('status'=>$status),array('fund_id'=>$fund_id));
    }
    
 	/**
     * 根据获取统计用户资产信息
     * @param type $uid
     * @param type $type
     * @return type
     */
    public static function getZhichangByUid($type,$uid=0){
    	$where = array('type'=>$type);
    	if($uid>0){
    		$where['uid'] = $uid;
    	}
    	$res = \Common\Query::selone('user_fund_record',$where ,array('IFNULL(sum(money),0) AS total'));
    	return $res ? $res['total'] : array();
    }
    
   /* 根据ID获取用户资金记录
     * @param type $pz_id
     * @return array
     */
    public static function getFundListById($pz_id,$uid){
    	$sql = "select * from user_fund_record where uid=" . $uid . " and table_name='user_peizi' and rec_id=" . $pz_id;
		$fundList = \Common\Query::sqlsel ( $sql );
    }
    
  
    
}