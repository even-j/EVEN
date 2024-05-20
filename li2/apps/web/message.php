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
class message extends \apps\UserControl {
	//账户中心
	public function view() {
		$this->setTitle('消息中心—'.SITE_NAME);
        $this->template ( 'view.php' );
	}
	
}
