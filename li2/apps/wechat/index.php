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
namespace apps\wechat;
class index extends \apps\ViewsControl {
    //put your code here
    protected $user,$waction;

    public function view(){
        $data=  Query::selcache('ts_app');
        $this->assgn('aa', $data);
        $this->template('views');
    }
    
    public function index() {
//        $str=  \Model\Wechat\check::valid();
//        echo $str;
//        exit();
        $menudata = \App::loadAppConfig('menus');
        $ACCESS_TOKEN = \Model\Wechat\Action::getInstance()->getaccess_token();
        $url = "https://api.weixin.qq.com/cgi-bin/menu/create?access_token={$ACCESS_TOKEN}";
        \core\net\Curl::curlpost($url, $menudata); //建立菜单
        //获取微信发送数据
        $postStr = $GLOBALS["HTTP_RAW_POST_DATA"]; //
        $dataarr = \Model\Wechat\Action::getInstance()->loadmsg($postStr); //解析数据
        $this->user['to'] = $dataarr['fromUsername'];
        $this->user['form'] = $dataarr['toUsername'];
        $appid = $dataarr['fromUsername'];
        $form_MsgType = $dataarr['form_MsgType'];
        if ($form_MsgType == "event") {
            $form_Event = $dataarr['form_Event'];//获取事件类型
            if ($form_Event == "subscribe") {//订阅事件
                $this->subscribe();
            } else if ($form_Event == "unsubscribe") {//取消订阅事件
                $this->unsubscribe();
            } else if ($form_Event == "CLICK") {
                $form_Key = $dataarr['form_Key'];
                $con = \Model\Wechat\Msg::getInstance()->datamsg($form_Key, $this->user['to']);
                \Model\Wechat\Action::getInstance()->response($this->user['to'], $this->user['form'], $con);
            }
        }
        if ($dataarr['form_MsgType'] == 'text') {
            $con = \Model\Wechat\Txt::getInstance()->txtmsg($dataarr['Content'], $this->user['to']);
            \Model\Wechat\Action::getInstance()->response($this->user['to'], $this->user['form'], $con);
        }
        exit();
    }

    /**
     * 用户定于欢迎页面
     * @param type $dataarr
     */
    public function subscribe() {
        //回复欢迎图文菜单
        \Model\Wechat\Action::getInstance()->subscribe($this->user['to']);
        $subscribe = \App::loadAppConfig('subscribearray');
        \Model\Wechat\Action::getInstance()->response($this->user['to'], $this->user['form'], $subscribe);
        exit;
    }

    /**
     * 用户取消订阅时候的方法
     * @param type $dataarr
     */
    public function unsubscribe() {
        \Model\Wechat\Action::getInstance()->unsubscribe($this->user['to']);
        exit();
    }
}
