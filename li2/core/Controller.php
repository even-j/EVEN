<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Controller
 *
 * @author Administrator
 */

namespace core;

abstract class Controller implements IController {

    //put your code here
    protected $views;
    protected $user = array();
    protected $uid = 0;
    protected $tVar;

    public function __construct() {
        $app = \App::get('currentapp');
        $mod = \App::get('currentcontroller');
        $ac = \App::get('currentactions');
        
        $this->views = new View();
        $this->user = \Model\User\UserInfo::checkuser();
        $this->uid = isset($this->user['uid']) ? intval($this->user['uid']) : 0;
        $this->assign('title', SITE_NAME);
        $site_base = unserialize(SITE_BASE);
        $this->setKeywords ( $site_base['site_keywords']);
        $this->setDescription (  $site_base['site_description']);


        $ISHTTPS=false;
        if ( !empty($_SERVER['HTTPS']) && strtolower($_SERVER['HTTPS']) !== 'off') 
        {
            $ISHTTPS= true;
        } 
        elseif ( isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] === 'https' ) 
        {
            $ISHTTPS= true;
        } 
        elseif ( !empty($_SERVER['HTTP_FRONT_END_HTTPS']) && strtolower($_SERVER['HTTP_FRONT_END_HTTPS']) !== 'off')
         {
            $ISHTTPS= true;
        }
        $this->assign('ISHTTPS',$ISHTTPS);
        
        //判断是否是代理链接 开始
        $is_intro_link = false;
        $intid = '';
        if(stripos($_SERVER['REQUEST_URI'], '/index.php/intid/')!==FALSE){
            $is_intro_link = true;
            $intid = str_replace('/index.php/intid/', '', $_SERVER['REQUEST_URI']);
        }
        //记录介绍人的id
        if(isset($_GET['intid'])){
            $is_intro_link = true;
            $intid = $_GET['intid'];
        }
        if($is_intro_link){
            if(!isset($_SESSION)){
                session_start();
            }
            $_SESSION['intid'] = $intid;
            if(\App::isMobile()){
                $this->sysRedirect(\App::URL('wap/member/register'));
            }
            else{
                $this->sysRedirect(\App::URL('web/member/register'));
            }
        }
        //判断是否是代理链接 结束
        //手机跳转
        if(\App::isMobile() && strtolower($app) == 'web' && strtolower($mod) == 'index' && strtolower($ac) == 'view'){
            $this->sysRedirect(\App::URL('wap/Index/view'));
        }
        /**  http--https 跳转处理 开始*/
        
        if(($_SERVER['HTTP_HOST'] == 'pay.qhqyl.top') && $app =='web' && $mod =='index' && $ac =='view'){
            exit;//支付域名，不让访问
        }
        $jumpToHttps = false;
        
        //注册页面
        /*if($app=='web' && $mod =='member' && ($ac == 'register' || $ac == 'doregister' || $ac == 'codeValidate' || $ac == 'regValidate') ){
            $jumpToHttps = true;
        }else if($app=='web' && $mod =='member' && ($ac =='login' || $ac =='dologin')){//登录页面
            $jumpToHttps = true;
        }elseif($app=='web' && $mod =='member' && ($ac =='recoverValidate' || $ac =='findpwd' || $ac =='findpwd2' || $ac =='findpwd3' || $ac =='findpwd4' || $ac =='recover_login_pwd_1' || $ac =='recover_login_pwd_2' || $ac =='recover_login_pwd_3' || $ac =='getValidateCode' || $ac =='makeCertPic')){ //找回密码
        	$jumpToHttps = true;
        }else if($app=='web' && $mod =='user' && ($ac =='bank' || $ac =='bankinfoveried' || $ac =='cardIsExist' || $ac =='bankok' || $ac =='ajaxregion')){//银行卡绑定     
            $jumpToHttps = true;
        }else if($app=='web' && $mod =='recharge' && $ac =='doShiming'){//银行卡实名  
            $jumpToHttps = true;
        }else if($app=='web' && $mod =='user' && ($ac =='sfz' || $ac =='doindentity' || $ac =='sfzok' || $ac =='checkId')){//身份证
            $jumpToHttps = true;
        }else if($app=='web' && $mod =='user' && ($ac =='login_password' || $ac =='modifyLoginPwd' || $ac =='passwordok' || $ac =='modPwdValidate')){//修改密码
            $jumpToHttps = true;
        }*/

        /*$url = $_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
        if(isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on'){
            if(!$jumpToHttps){
                $this->sysRedirect('http://'.$url );
            }
        }else{
            if($jumpToHttps){
                $this->sysRedirect('https://'.$url);
            }
        }*/
        /**  http--https 跳转处理 结束*/
    }

    public function view() {
        ;
    }

    protected function template($file) {
        $this->assign('tapp', \App::get('currentapp'));
        $this->assign('tmod', \App::get('currentcontroller'));
        $this->assign('tac', \App::get('currentactions'));
        $this->views->tVar = $this->tVar;
        echo $this->views->render($file);
    }

    protected function assign($key, $value='') {
        if (is_array($key)) {
            $this->tVar = array_merge($this->tVar, $key);
        } elseif (is_object($key)) {
            foreach ($key as $key => $val)
                $this->tVar[$key] = $val;
        } else {
            $this->tVar[$key] = $value;
        }
    }
    
 	protected function setRefferto($title) {
        $this->assign('refferto', $title);
    }
    
    protected function setNavtitle($navtitle) {
        $this->assign('nav_title', $navtitle);
    }

    protected function setTitle($title) {
        $this->assign('title', $title);
    }

    protected function setKeywords($keywords) {
        $this->assign('keywords', $keywords);
    }

    protected function setDescription($description) {
        $this->assign('description', $description);
    }

    /**
     * 前端js跳转
     * @param string $msg 提示信息
     * @param string $uri 网址 传"back",返回到上一页
     * @param int $time 延迟时间
     */
    protected function fontRedirect($msg, $uri, $time = 3) {
        $this->views->msg = $msg;
        $this->views->uri = $uri;
        $this->views->time = $time;
        $this->views->style = array('index.css');
        echo $this->views->render('sys_js_redirect.php');
        exit();
    }

    /**
     * header跳转
     * @param string $url 网址
     */
    protected function sysRedirect($url) {
        ob_clean();
        header("location:" . $url);
        exit();
    }

}

?>
