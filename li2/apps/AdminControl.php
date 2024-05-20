<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace apps;

/**
 * Description of AdminControl
 *
 * @author Administrator
 */
class AdminControl extends \core\Controller {
    //put your code here
    protected $adminid;
    protected $purview;
    public function __construct() {
        parent::__construct();
      
        if(!$this->adminid){
            $this->adminid=\Model\Admin\User::checks();
            if(!$this->adminid){
                $this->sysRedirect('/index.php?app=admin&mod=login');
            }
            
            $role = \Model\Admin\Role::getRoleById(\Model\Admin\User::getRoleId());
            $purview = $role['purview'] ? explode(',', $role['purview']) : array();
            $pur_name = \App::get('currentcontroller').'_'.\App::get('currentactions');
            //不用验证的
            $acs = array(
	            'user_ajaxregion',
	            'user_ajaxCheckUserName',
            	'trade_ajaxCheckAccount',
            );
            
            $this->purview = array_merge($acs,$purview);
            sort($this->purview);
            if(\App::get('currentcontroller')!='index' && !in_array($pur_name,  $this->purview)){
            	$url = isset($_SERVER["HTTP_REFERER"]) ? $_SERVER["HTTP_REFERER"] : '/index.php?app=admin&mod=index&ac=view';
            	$this->fontRedirect('你没有该权限操作',$url);
            }
            $this->assign('adminid', $this->adminid); 
        }
        
    }
}
