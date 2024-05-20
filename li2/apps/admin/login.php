<?php

namespace apps\admin;
class login extends \apps\ViewsControl  {
    
     //put your code here
    public function view() {
    	 $uid =\Model\Admin\User::checks();
    	 if($uid){
    	 	$this->sysRedirect('/index.php?app=admin&mod=index&ac=view');
    	 }
         $this->template ( 'login.php' );
    }
    
    //用户登陆
    public function doLogin(){
    	$msg = '';
    	if ($_POST){
    		$user = $_POST['username'];
    		$pwd = $_POST['pwd'];
    		$res = \Model\Admin\User::login($user, $pwd);
    		$msg = $res['msg'];
    		if($res['code']){
    			$this->sysRedirect('/index.php?app=admin&mod=index&ac=view');
    		}else{
    			$msg = '用户登陆失败：'.$res['msg'];
    		}
    	}
    	$this->assign('msg', $msg);
    	$this->template('login.php');
    }
    
    //用户退出
    public function logout(){
            \Model\Admin\User::logout();
   			$this->template('login.php');
    }
        
    /*public function adduser(){
        $user = $_GET['user'];
        $pwd = $_GET['pwd'];
        $res = \Model\Admin\User::adduser($user, $pwd);
        var_dump($res);
    }*/
            
}

?>