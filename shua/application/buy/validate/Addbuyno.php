<?php
namespace app\buy\validate;

use think\Validate;

class Addbuyno extends Validate
{
    protected $rule = [
       // 'wwid'                          =>      'unique:user_buyno',//注册买号
        'mobile'                        =>      'max:11',
        'type'=> 'max:2',
        'mobile'                        =>      '/^1[0-9]{1}[0-9]{9}$/'//注册账号验证
    ];
    protected $message = [
        'wwid'                          =>      '此旺旺ID已被注册',
        'mobile.max:11'                 =>      '手机号码最多不能超过11个字符',
        'mobile./^1[0-9]{1}[0-9]{9}$/'  =>      '手机号码格式不正确'
    ];
}