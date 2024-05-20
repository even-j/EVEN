<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
namespace Model\Sys;

use Common\Cache;
use Common\Query;

class SmsTemplet {
    
    public static function getValidTemp(){
        $temp="您的验证码是@，关注微信公众号（同花配资）登录。";
        return $temp;
    }
    public static function regist($param){
        $text='手机服务验证码：' . $param.'，请勿告诉他人！';
        return $text;
    }
    public static function dayManageAuto($param){
        $text = '您的配资自动延期，成功收取管理费' . $param . '元！';
        return $text;
    }
    public static function monthManageAuto($param){
        $text = '您的配资自动延期，成功收取利息' . $param . '元！';
        return $text;
    }
    public static function withdrawSuccess($param){
        $text = '您的提现申请成功，提现金额' . $param . '元。请注意查收！';
        return $text;
    }
    public static function withdrawRefuse($param){
        $text = '您的提现申请被拒绝！';
        return $text;
    }
    public static function rechargeSuccess($param){
        $text = '您的线下充值已通过审核，请登录系统查看您的余额，进行后续操作！';
        return $text;
    }
    public static function rechargeRefuse($param){
        $text = '您的线下充值被拒绝！';
        return $text;
    }
    public static function peiziFundReceive($param){
        $text = '您的配资资金已到帐，请下载客户端进行交易！';
        return $text;
    }
    public static function peiziAddFundReceive($param){
        $text = '您的追加配资资金已到帐，请登录交易系统查看！';
        return $text;
    }
    public static function peiziLossFundReceive($param){
        $text = '您的补亏资金已到帐，请注意查收！';
        return $text;
    }
    public static function peiziProfitSuccess($param){
        $text = '您的盈利提取已通过审核，请注意查收！';
        return $text;
    }
    public static function peiziProfitRefuse($param){
        $text = '您的盈利提取未通过审核，请核对后再次申请！';
        return $text;
    }
    public static function peiziProfitRefuseMemo($param){
        $text = '您的交易帐户盈利为'.$param.'，不符合您要提取的盈利！';
        return $text;
    }
    public static function peiziRequireEnd($param){
        $text = '您的申请结算失败，请平仓您的交易账号后再次申请！！';
        return $text;
    }
    public static function peiziEnd($param){
        $text = '您的配资已结束！';
        return $text;
    }
    
    public static function manageNoenough($param){
        $text = '您的配资今天结束后就已到期，账户余额不足以续费，如果要延期配资，请您及时充值！';
        return $text;
    }
}

