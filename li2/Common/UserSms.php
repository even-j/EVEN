<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * 短信验证
 *
 * @author Administrator
 */

namespace Common;

class UserSms {
    /**
     * 验证手机号码是否正确
     * @param type $mobile 手机号码
     * @param type $code 验证码
     * @return boolean
     */
    public static function check($mobile, $code) {
        $arr = Query::selone('sys_sms', array('mobile' => $mobile));
        if (isset($arr['codes']) && $arr['codes'] == $code) {
            Query::delete('sys_sms', array('mobile' => $mobile));
            return true;
        }
        return false;
    }
}
