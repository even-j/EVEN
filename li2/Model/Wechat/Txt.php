<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of WechatTxtModel
 *
 * @author Administrator
 */

namespace Model\Wechat;

class Txt {

    //put your code here
    /**
     * 微信文字消息处理
     * @param type $con
     * @return type
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

    /**
     * 处理文本内容
     * @param type $con
     * @param type $appid
     */
    public function txtmsg($con, $OPENID) {
        $actkey = 'popact_' . $OPENID;
        $actions = \Common\Cache::get($actkey);
        if ($con == 'qx') {
            $s = new Service();
            $s->clears($OPENID);
            exit();
        }
        if (isset($actions['class']) && isset($actions['act'])) {
            call_user_func_array(array('\\Model\\Wechat\\' . $actions['class'], $actions['act']), array($con, $OPENID));
            exit();
        }
        if (strtolower($con) == 'bd' || strtolower($con) == 'bdwx' || strtolower($con) == 'wxbd' || $con == '绑定微信' || $con == '微信绑定') {
            $key = 'wechat_bind_' . $OPENID;
            $value = substr(md5(time()), 2, 6);
            \Common\Cache::save($key, $value, 600);
            $url = DOMAIN . '/index.php?app=wap&mod=login&ac=bind&id=' . $OPENID . '&p=' . $value;
            $arr = array(
                0 => array(
                    'title' => '绑定手机',
                    'desc' => '本连接10分钟内有效，请及时操作',
                    'url' => $url,
                    'pic' => DOMAIN . '/public/wechat/bwx.png'
                )
            );
            $text='<a href="'.$url.'">点这里完成手机号登录福牛网与微信绑定的设置，您将可以在非微信内访问福牛网的时候用设置的手机号和密码登录福牛网，并且账户信息与微信内访问福牛网信息同步。</a>本连接10分钟内有效，请及时操作。';
            //\Common\wechatSms::sendnewmsg(1, $arr, $OPENID);
            return $text;
        }
        if (strtolower($con) == 'xg' || strtolower($con) == 'xgbd' || strtolower($con) == 'bdxg') {
            
            $key = 'wechat_bind_' . $OPENID;
            $value = substr(md5(time()), 2, 6);
            \Common\Cache::save($key, $value, 600);
            $url = DOMAIN . '/index.php?app=wap&mod=login&ac=bind&id=' . $OPENID . '&p=' . $value;
            $arr = array(
                0 => array(
                    'title' => '修改绑定手机',
                    'desc' => '本连接10分钟内有效，请及时操作',
                    'url' => $url,
                    'pic' => DOMAIN . '/public/wechat/bwx.png'
                )
            );
            $text='<a href="'.$url.'">点这里完成修改手机号登录福牛网与微信绑定的设置。</a>本连接10分钟内有效，请及时操作。';
            return $text;
        }

        $this->other($OPENID);
    }

    /**
     * 转客服消息
     * @param type $con
     * @param type $appid
     */
    private function other($OPENID) {
        echo '<xml>
                <ToUserName><![CDATA[' . $OPENID . ']]></ToUserName>
                <FromUserName><![CDATA[gh_e360c0e6917d]]></FromUserName>
                <CreateTime>' . time() . '</CreateTime>
                <MsgType><![CDATA[transfer_customer_service]]></MsgType>
                </xml>';
        exit();
    }

}
