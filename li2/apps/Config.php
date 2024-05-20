<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Config
 *
 * @author Administrator
 */


namespace apps;

class Config {

    private $config;
    static $_instance;

    public static function getInstance() {
        if (!(self::$_instance instanceof self)) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }

    private function __construct() {
        $this->config = array(
            'db' => array('type' => 'DbMysqli', 'config' => array('dbhost' => '127.0.0.1', 'dbuser' => 'root', 'dbpw' => '111111', 'dbname' => 'li2', 'port' => 3306, 'charset' => 'utf8')),
            'cache' => array('type' => 'dbcache', 'config' => array('table' => 'cache_data')),
            //'cache'=>array('type'=>'memcache','config'=>array(1=>array('host'=>'localhost','port'=>'11211','weight'=>0))),
            'logspath' => array('type' => 'file', 'path' => SITEROOT.'logs'),
            'tempt' => array('cache' => 0, 'cachepath' => SITEROOT.'cache'.DIRECTORY_SEPARATOR.'template'),
            'mail' => array('email_sendtype' => 'smtp', 'email_host' => 'smtp.163.com', 'email_port' => 22, 'email_ssl' => '', 'email_account' => 'aa', 'email_password' => '123', 'email_sender_name' => '', 'email_sender_email' => '', 'email_reply_account' => ''),
            'wechat' => array('AppId' => 'wxc0e7f87da1a991fd', 'AppSecret' => '791e9c9bfa4dafedf49ca0247d6ae823', 'token' => 'funiu123123', 'appkey' => '9xeHKQj57adP9F5xAxjuXdc7trOrH173R7TIYLGY5Eq'),
            'cookie' => array('path' => '', 'domain' => ''),
            'showapi' => array('status'=>1,'appid' =>'60468','key'=>'5976ca1440c5481db94bf397e347e671'),//status 0：停用，1：启用
            'regist' => array('status'=>0,'hours' =>'2'),//是否启用注册相同IP过滤status 0：停用，1：启用
            'pay_xinqidian' => array('uid'=>'60053','key'=>'5448b3250cf54a1dbe9c457732e97543'),
            'pay_yintai' => array('uid'=>'1642','key'=>'61e38d3c27ad4966bf3b8d0e839a41a5'),
            'free_profit_to' => 'send',
            'regist_pic_verify' =>1,//注册发送短信是否有图形验证码，0－无，1－有
        	'rewrite' => 0,
        	'router' => array(
                    'web/article/view' =>  '/news/list-[pid].html',
                    'web/article/show' =>  '/news/[pid]-[id].html',
//                    'web/peizi/free' => '/peizi/free',
//                    'web/peizi/daywin1' => '/peizi/daywin',
//                    'web/peizi/earn1' => '/peizi/earn',
//                    'web/peizi/earn2' => '/peizi/earn-show-[pz_id].html',
//                    'web/peizi/p2p' => '/peizi/p2p',
//                    'web/peizi/p2p_fc' => '/peizi/p2p_fc',
//                    'web/peizi/month' => '/peizi/month',
//                    'web/peizi/qihuo' => '/peizi/qihuo',
//                    'web/user/account' => '/user/account',
//                    'web/user/p2p_touzi' => '/user/p2p-touzi',
//                    'web/user/p2p_peizi' => '/user/p2p-peizi',
//                    'web/user/peizi' => '/user/peizi',
//                    'web/user/fund' => '/user/fund',
//                    'web/user/login_password' => '/user/login_password',
//                    'web/user/recharge' => '/user/recharge',
//                    'web/user/withdrawl' => '/user/withdrawl',
//                    'web/user/account' => '/user/account',
//                    'web/message/view' => '/message',
//                    'web/article/view' => '/about/pid-[pid].html',
//                    'web/article/show' => '/about/id-[id].html',
//                    'web/article/help' => '/help',
//                    'web/article/search' => '/help/search',
//                    'web/article/detail' => '/help/[pid]-[id].html',
//                    'web/question/view' => '/question/type-[type]',
//                    'web/question/show' => '/question/id-[id].html',
//                    'web/question/ask' => '/question/ask',
//                    'web/question/askType' => '/question/typeid-[typeid].html',
//                    'web/member/logout' => '/member/logout',
//                    'web/member/register' => '/member/register',
//                    'web/member/login' => '/member/login',
//                    'web/member/findpwd' => '/member/findpwd',
//                    'web/member/findpwd2' => '/member/findpwd2',
//                    'web/member/findpwd3' => '/member/findpwd3',
//                    'web/member/findpwd4' => '/member/findpwd4',
//                    'web/member/makeCertPic' => '/member/make-cert-pic',
            )	
        );
    }

    public function __get($name) {
        if(array_key_exists($name, $this->config)){
            return $this->config[$name];
        }
        $cachearr=\Common\Cache::get('system_config');
        if(isset($cachearr[$name])){
            return $cachearr[$name];
        }
        $carr=array();
        $arr=  \Common\Query::select('system_config');
        foreach ($arr as $value) {
            $carr[$value['key']]=$value['value'];
        }
        \Common\Cache::save('system_config', $carr);
        return isset($carr[$name])?$carr[$name]:false;
    }

}
