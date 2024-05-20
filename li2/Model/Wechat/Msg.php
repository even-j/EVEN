<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of WechatMsgModel
 *
 * @author Administrator
 */

namespace Model\Wechat;

class Msg {

    //put your code here
    /**
     * 按钮触发的动作
     * @param type $type
     */
    static $_instance;

    public static function getInstance() {
        if (!(self::$_instance instanceof self)) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }

    private function __construct() {
        
    }

    public function datamsg($type, $openid) {
        if (method_exists($this, $type)) {
            return $this->$type($openid);
        }
        return '操作错误,请重试';
    }

    /**
     * 粉丝福利
     * @param type $appid
     */
    public function fn_fuli($openid) {
        $dataarr=array();
        $dataarr[0] = array(
            'title' => '粉丝福利',
            'desc' => '粉丝福利',
            'url' => Service::createurl('/index.php?app=wap&mod=index', $openid),
            'pic' => DOMAIN.'/public/wechat/fsfl.png'
        );
        $dataarr[1] = array(
            'title' => '粉丝福利',
            'desc' => '粉丝福利',
            'url' => Service::createurl('/index.php?app=wap&mod=index', $openid),
            'pic' => DOMAIN.'/public/wechat/fsflx.png'
        );
        return $dataarr;
    }

    /**
     * 买彩票
     * @param type $appid
     */
    public function fn_buy($openid) {
        $dataarr[0] = array(
            'title' => '购彩大厅',
            'desc' => '购彩大厅',
            'url' => Service::createurl('/index.php?app=wap&mod=index', $openid),
            'pic' => DOMAIN.'/public/wechat/funiu.png'
        );
        $dataarr[1] = array(
            'title' => '双色球',
            'desc' => '双色球',
            'url' => Service::createurl('/index.php?app=wap&mod=ticket&ac=view&type=ssq', $openid),
            'pic' => DOMAIN.'/public/wechat/ssq.png'
        );
        $dataarr[2] = array(
            'title' => '大乐透',
            'desc' => '大乐透',
            'url' => Service::createurl('/index.php?app=wap&mod=ticket&ac=view&type=dlt', $openid),
            'pic' => DOMAIN.'/public/wechat/dlt.png'
        );
        $dataarr[3] = array(
            'title' => '我的彩票',
            'desc' => '我的彩票',
            'url' => Service::createurl('/index.php?app=wap&mod=my', $openid),
            'pic' => DOMAIN.'/public/wechat/wdcp.png'
        );
        $dataarr[4] = array(
            'title' => '彩票开奖',
            'desc' => '彩票开奖',
            'url' => Service::createurl('/index.php?app=wap&mod=gonggao', $openid),
            'pic' => DOMAIN.'/public/wechat/kjgg.png'
        );
        return $dataarr;
    }

    /**
     * 用户中心
     * @param type $appid
     */
    public function fn_user($openid) {
        $dataarr[0] = array(
            'title' => '帐户中心',
            'desc' => '帐户中心',
            'url' => Service::createurl('/index.php?app=wap&mod=user&ac=account', $openid),
            'pic' => DOMAIN.'/public/wechat/zh.png'
        );
        
        $dataarr[1] = array(
            'title' => '帮助说明',
            'desc' => '帮助说明',
            'url' => DOMAIN.'/index.php?app=wap&mod=help&ac=useraccounthelp',
            'pic' => DOMAIN.'/public/wechat/help.png'
        );
        return $dataarr;
    }

}
