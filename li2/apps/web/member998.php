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

namespace apps\web;

class member extends \core\Controller {

    //put your code here
    public function login() {
        $this->setTitle('用户登陆—' . SITE_NAME);
        $url = isset($_GET['url']) ? str_replace('amp;', '', html_entity_decode(htmlentities($_GET['url'], ENT_COMPAT, 'UTF-8'))) : \App::URL('web/user/account');
        $this->assign('refer', $url);
        $this->template('login.php');
    }

    public function login_tg() {
        $this->setTitle('用户登陆—' . SITE_NAME);
        $url = isset($_GET['url']) ? str_replace('amp;', '', html_entity_decode(htmlentities($_GET['url'], ENT_COMPAT, 'UTF-8'))) : \App::URL('web/user/account');
        $this->assign('refer', $url);
        $this->template('login_tg.php');
    }

    //验证码验证
    public function recoverValidate() {
        $res = array('msg' => '成功', 'status' => 0);
        if ($_POST) {
            $mobile = isset($_POST['mobile']) ? \App::t($_POST['mobile']) : '';
            $code = isset($_POST['certCode']) ? \App::t($_POST['certCode']) : '';
            $ret = \Model\User\UserInfo::checkUserIsExist($mobile);
            if (!$ret) {
                $res['status'] = 1;
                $res['msg'] = '您输入的手机号码不存在!';
            }
            if (strtolower($_SESSION['checkCode']) != $code) {
                $res['msg'] = '图片验证码错误';
                $res['status'] = 2;
            }
        }
        exit(json_encode($res));
    }

    public function register() {
        $this->setTitle('用户注册—' . SITE_NAME);
        $this->template('register.php');
    }

    public function register_tg() {
        $this->setTitle('注册');
        $this->template('register_tg.php');
    }
    public function register_tg2() {
        $this->setTitle('注册');
        $this->template('register_tg2.php');
    }
    public function register_tg3()
    {
        $this->setTitle('注册');
        $this->template('register_tg3.php');
    }
    public function register_tg360() {
        $this->setTitle('用户注册—' . SITE_NAME);
        $this->template('register_tg360.php');
    }

    public function findpwd() {
        $this->setTitle('找回密码—' . SITE_NAME);
        $this->template('findpwd.php');
    }

    public function findpwd2() {
        $mobile = isset($_POST['account']) ? \App::t($_POST['account']) : '';
        $valid_cash = isset($_POST['valid_cash']) ? \App::t($_POST['valid_cash']) : '';
        $res = \Common\Cache::get('findpwd_' . $valid_cash);
        if (empty($res) || $res != $mobile) {
            $this->fontRedirect('超时，禁止操作!', \App::URL('web/member/findpwd'));
        }
        if (!$mobile) {
            $this->fontRedirect('找回密码手机号不存在!', \App::URL('web/member/findpwd'));
        }
        $this->setTitle('验证身份_' . SITE_NAME);
        $this->assign('mobile', $mobile);
        $this->template('findpwd2.php');
    }

    public function findpwd3() {
        $this->setTitle('找回密码—' . SITE_NAME);
        $this->template('findpwd3.php');
    }

    public function resetpwd() {
        $mobile = isset($_POST['account']) ? \App::t($_POST['account']) : '';
        $password = isset($_POST['password']) ? \App::t($_POST['password']) : '';
        $res = \Model\User\UserInfo::pwdReset($mobile, $password);
        if ($res[0] == 0) {
            exit(json_encode(array('code' => 0, 'msg' => '密码设置错误')));
        }
        exit(json_encode(array('code' => 1, 'msg' => '设置成功')));
    }

    //用户登陆
    public function dologin() {
        if ($_POST) {
            $mobile = isset($_POST['username']) ? \App::t($_POST['username']) : '';
            if (intval($mobile) == 0) {
                $res = array('code' => 0, 'msg' => '手机格式错误');
                exit(json_encode($res));
            }
            $password = isset($_POST['password']) ? $_POST['password'] : '';
            $ret = \Model\User\UserInfo::login($mobile, $password);
            $res = array('code' => 0, 'msg' => '');
            if ($ret[0] == 0) {
                $res['msg'] = $ret[1];
            } else {
                $res['code'] = 1;
            }
            
            exit(json_encode($res));
        }
    }

    //用户退出
    public function logout() {
        \Model\User\UserInfo::logout($this->uid);
        $this->sysRedirect('/');
    }

    //用户注册
    /*public function doregister() {
        if ($_POST) {
            $mobile = isset($_POST['mobile']) ? \App::t($_POST['mobile']) : '';
            if (intval($mobile) == 0) {
                $this->fontRedirect('手机格式错误！', \App::URL('web/member/register'));
            }
            $password = isset($_POST['password']) ? $_POST['password'] : '';
            $confirm = isset($_POST['confirm']) ? $_POST['confirm'] : '';
            if ($password != $confirm) {
                exit(json_encode(array('code' => 0, 'msg' => '两次密码不一致')));
            }
            $code = isset($_POST['smscode']) ? \App::t($_POST['smscode']) : '';
            // $ret = \Common\UserSms::check($mobile, $code);
            // if (!$ret) {
            //     exit(json_encode(array('code' => 0, 'msg' => '短信验证码错误')));
            // }
            if($code!='265751'){
                exit(json_encode(array('code' => 0, 'msg' => '短信验证码错误')));
            }
            if ($mobile && $code) {
                $intid=isset($_POST['intid']) ? $_POST['intid'] : '';
                $res = \Model\User\UserInfo::checkUserIsExist($mobile);
                if (!$res) {//验证成功
                    $ret = \Model\User\UserInfo::reg($mobile, $password,$intid);
                    if ($ret[0] > 0) {//注册成功
                        //登录
                        \Model\User\UserInfo::login($mobile, $password);
                        exit(json_encode(array('code' => 1, 'msg' => '成功')));
                        //$this->sysRedirect(\App::URL('web/user/account'));
                    } else {
                        exit(json_encode(array('code' => 0, 'msg' => $ret[1])));
                        //$this->fontRedirect('注册失败！', \App::URL('web/member/register'));
                    }
                } else {
                    exit(json_encode(array('code' => 0, 'msg' => '该手机号码已存在！')));
                    //$this->fontRedirect('该手机号码已存在！', \App::URL('web/member/register'));
                }
            } else {
                exit(json_encode(array('code' => 0, 'msg' => '手机号码或验证码有误！')));
                //$this->fontRedirect('手机号码或验证码有误！', \App::URL('web/member/register'));
            }
        }
    }*/

    //短信验证码验证
    public function codeValidate() {
        if ($_POST) {
            $mobile = isset($_POST['mobile']) ? \App::t($_POST['mobile']) : '';
            $code = isset($_POST['mobilePwd']) ? \App::t($_POST['mobilePwd']) : '';
            $ret = \Common\UserSms::check($mobile, $code);
            if (!$ret) {
                exit('手机验证码错误!');
            }
        }
    }

    //发送验证码
    public function getValidateCode_findpwd() {
        $ret = array('code' => 0, 'msg' => '验证码发送失败！');
        $mobile = isset($_POST['mobile']) ? \App::t($_POST['mobile']) : '';
        $res = \Model\User\UserInfo::checkUserIsExist($mobile);
        if (!$res) {
            exit(json_encode(array('code' => 0, 'msg' => '用户不存在！')));
        }
        if(\apps\Config::getInstance()->regist_pic_verify){
            $authcode = isset($_POST['authcode']) ? \App::t($_POST['authcode']) : '';
            if(empty($authcode)){
                exit(json_encode(array('code' => 0, 'msg' => '图形验证码错误！'))) ;
            }
            if(strtolower($authcode) != strtolower($_SESSION['checkCode'])){
                $_SESSION['checkCode'] = null;
                exit(json_encode(array('code' => 0, 'msg' => '图形验证码错误！'))) ;
            }
        }
        if ($mobile) {
            $res = \Model\Api\Sms::validSend($mobile);
            if ($res) {
                $ret['code'] = 1;
            }
        } else {
            $ret['msg'] = '手机号码不存在，发送失败！';
        }
        exit(json_encode($ret));
    }

    //短信验证码验证
    public function codeValidate_findpwd() {
        $mobile = isset($_POST['mobile']) ? \App::t($_POST['mobile']) : '';
        $code = isset($_POST['mobilePwd']) ? \App::t($_POST['mobilePwd']) : '';
        $ret = \Common\UserSms::check($mobile, $code);
        if (!$ret) {
            exit(json_encode(array('code' => 0, 'msg' => '验证码有误！')));
            //exit('手机验证码错误!');
        }
        $rand_str = \App::rand_str(32, 0);
        \Common\Cache::save('findpwd_' . $rand_str, $mobile, 600); //随机生成一个32位的值为做键，值为手机号
        exit(json_encode(array('code' => 1, 'msg' => '成功', 'data' => $rand_str)));
    }

    //手机号码验证
    public function regValidate() {
        if ($_POST) {
            $mobile = isset($_POST['mobile']) ? \App::t($_POST['mobile']) : '';
            $ret = \Model\User\UserInfo::checkUserIsExist($mobile);
            if ($ret) {
                exit(json_encode(array('code' => 0, 'msg' => '该手机号已存在!')));
                //exit('该手机号已存在!');
            } else {
                exit(json_encode(array('code' => 1, 'msg' => '')));
            }
        }
    }
    
    //发送验证码,推广使用，有加图形验证码
    public function getValidateCode_tg() {
        $ret = array('code' => 0, 'msg' => '验证码发送失败！');
        if ($_POST) {
            $mobile = isset($_POST['mobile']) ? \App::t($_POST['mobile']) : '';
            if(\apps\Config::getInstance()->regist_pic_verify){
                $code = isset($_POST['code']) ? \App::t($_POST['code']) : '';
                if(empty($code)){
                    exit(json_encode(array('code' => 0, 'msg' => '图形验证码错误！'))) ;
                }
                if(strtolower($code) != strtolower($_SESSION['checkCode'])){
                    $_SESSION['checkCode'] = null;
                    exit(json_encode(array('code' => 0, 'msg' => '图形验证码错误！'))) ;
                }
            }
            if ($mobile) {
                $res = \Model\Api\Sms::validSend_tg($mobile);
                if ($res) {
                    $ret['code'] = 1;
                }
            } else {
                $ret['msg'] = '手机号码不存在，发送失败！';
            }
        }
        exit(json_encode($ret));
    }
    //发送验证码,推广使用，没有图形验证码
    public function getValidateCode_tg2() {
        $ret = array('code' => 0, 'msg' => '验证码发送失败！');
        if ($_POST) {
            $mobile = isset($_POST['mobile']) ? \App::t($_POST['mobile']) : '';
            if(\apps\Config::getInstance()->regist_pic_verify){
                $code = isset($_POST['code']) ? \App::t($_POST['code']) : '';
                if(empty($code)){
                    exit(json_encode(array('code' => 0, 'msg' => '图形验证码错误！'))) ;
                }
                if(strtolower($code) != strtolower($_SESSION['checkCode'])){
                    $_SESSION['checkCode'] = null;
                    exit(json_encode(array('code' => 0, 'msg' => '图形验证码错误！'))) ;
                }
            }
            if ($mobile) {
                $res = \Model\Api\Sms::validSend($mobile);
                if ($res) {
                    $ret['code'] = 1;
                }
            } else {
                $ret['msg'] = '手机号码不存在，发送失败！';
            }
        }
        exit(json_encode($ret));
    }

    //发送验证码,有图形验证码
    public function getValidateCode() {
        $ret = array('code' => 0, 'msg' => '验证码发送失败！');
        if ($_POST) {
            $mobile = isset($_POST['mobile']) ? \App::t($_POST['mobile']) : '';
            if(\apps\Config::getInstance()->regist_pic_verify){
                // $authcode = isset($_POST['authcode']) ? \App::t($_POST['authcode']) : '';
                // if(empty($authcode)){
                //     exit(json_encode(array('code' => 0, 'msg' => '图形验证码错误！'))) ;
                // }
                // if(strtolower($authcode) != strtolower($_SESSION['checkCode'])){
                //     $_SESSION['checkCode'] = null;
                //     exit(json_encode(array('code' => 0, 'msg' => '图形验证码错误！'))) ;
                // }
            }
            if ($mobile) {
                $res = \Model\Api\Sms::validSend($mobile);
                if ($res) {
                    $ret['code'] = 1;
                }
            } else {
                $ret['msg'] = '手机号码不存在，发送失败！';
            }
        }
        exit(json_encode($ret));
    }

    //生成验证码
    public function makeCertPic() {
        $code = new \Common\ValidationCode(100, 35, 6);
        $_SESSION['checkCode'] = $code->getCheckCode();     //将验证码的值存入session中以便在页面中调用验证  
        $code->showImage();   //输出验证码  
    }

    //检测用户是否登录
    public function checkLogin() {
        $user = $this->user;
        if ($user) {
            echo 1;
        }
        echo 0;
    }

    public function check_jump(){
        $mobile = $_GET['mobile'];
        $pwd = $_GET['password'];
        $new_user = \Common\Query::sqlselone("select * from pillow.user where mobile='".$mobile."'");
        if($new_user){
            $param['mobile'] = $mobile;
            $param['password'] = $pwd;
            $param['timestamp'] = time();
            ksort($param);
            $str = '';
            foreach ($param as $key => $value) {
                $str .= $key.'='.$value.'&';
            }
            $str .= "secret=di93kdid83jvjdnb3mnfkif934jkdkd83jdod93kd84kr";
            $sign = md5($str);
            if(\App::isMobile()){
                header("Location:http://localhost:901/common/Pub/ds2d93kgd8kdslogin/mobile/".$mobile."/password/".$pwd."/timestamp/".$param['timestamp']."/sign/".$sign);
            }
            else{
                header("Location:http://localhost:901/common/Pub/ds2d93kgd8kdslogin/mobile/".$mobile."/password/".$pwd."/timestamp/".$param['timestamp']."/sign/".$sign);
            }
            exit;
        }
        else{
            if(\App::isMobile()){
                $this->sysRedirect('/index.php?app=wap&mod=user&ac=account');
            }
            else{
                $this->sysRedirect('/index.php?app=web&mod=user&ac=account');
            }
        }
    }
}
