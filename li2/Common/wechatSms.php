<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Common;

/**
 * 发送微信服务信息
 *
 * @author Administrator
 */
class wechatSms {

    //put your code here
    /**
     * 获得用户的微信id
     * @param type $uid
     * @return type
     */
    private static function getopenid($uid) {
        $user_id = intval($uid);
        $uarr = \Model\User\UserInfo::getinfo($user_id);
        if (!is_array($uarr) || empty($uarr)) {
            return array("errcode" => 100, "errmsg" => "用户不存在");
        }
        if (!$uarr['is_atten_weixin']) {
            return array("errcode" => 101, "errmsg" => "用户还没有关注微信");
        }
        return array("errcode" => 0, 'openid' => $uarr['openid'], "errmsg" => "");
    }

    /**
     * 发送微信服务信息
     * @param type $uid
     * @param type $content
     * @return array()errcode=0 成功
     */
    public static function sendtext($uid, $content, $OPENID = '') {
        if ($OPENID == '') {
            $uarr = self::getopenid($uid);
            if ($uarr['errcode'] > 0) {
                return $uarr['errmsg'];
            }
            $OPENID = $uarr['openid'];
        }
        $json = \Model\Wechat\Action::getInstance()->sendmsg($OPENID, $content);
        return json_decode($json, 1);
    }

    /**
     * 发送客服图文信息
     * @param type $OPENID
     * @param type $dataarr
     * @return type
     */
    public function sendnewmsg($uid, $dataarr, $OPENID = '') {
        if ($OPENID == '') {
            $uarr = self::getopenid($uid);
            if ($uarr['errcode'] > 0) {
                return $uarr['errmsg'];
            }
            $OPENID = $uarr['openid'];
        }
        $json = \Model\Wechat\Action::getInstance()->sendimgmsg($OPENID, $dataarr);
        return json_decode($json, 1);
    }

    /**
     * 发送模板消息
     * @param type $user_id
     * @param type $template_id
     * @param type $url
     * @param type $data
     * @return type
     */
    public static function sendtempt($user_id, $template_id, $url, $data) {
        $uarr = self::getopenid($user_id);
        if ($uarr['errcode'] > 0) {
            return $uarr['errmsg'];
        }
        $OPENID = $uarr['openid'];
        return \Model\Wechat\Action::getInstance()->sendTempt($OPENID, $template_id, $url, $data);
    }

    /**
     * 用户消息提醒
     * @param type $user_id
     * @param type $txid
     */
    public static function txmsg($uid, $content) {
        $uarr = self::getopenid($uid);
        if ($uarr['errcode'] == 0) {
            \Model\Wechat\Action::getInstance()->sendmsg($uarr['openid'], $content);
            return true;
        }
        $uarr = \Model\User\UserInfo::getinfo($uid);
        if ($uarr['mobile']) {
            \Model\Api\Sms::smsSend($uarr['mobile'], $content);
            return true;
        }
        return FALSE;
    }

}
