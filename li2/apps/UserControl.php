<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of UserControl
 *
 * @author fjlh
 */

namespace apps;

class UserControl extends \core\Controller {

    //put your code here
    public function __construct() {
        parent::__construct();
        if (!$this->uid) {
            $url=  htmlentities(trim($_SERVER["REQUEST_URI"])) ;
            if(!isset($_SESSION)){
                session_start();
            }
            $c_uid = isset($_SESSION['uid'])?$_SESSION['uid']:0;
            //$c_uid = \core\net\NCookie::get('uid');
            if($c_uid>0){
            	\Model\User\UserInfo::logout($c_uid);
            }
            if(\App::isMobile()){
                $this->sysRedirect(\App::URL('wap/member/login',array('url'=>rawurlencode($url))));
            }
            else{
                $this->sysRedirect(\App::URL('web/member/login',array('url'=>rawurlencode($url))));
            }
        }
    }

}
