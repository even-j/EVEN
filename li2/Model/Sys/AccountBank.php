<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
namespace Model\Sys;

use Common\Cache;
use Common\Query;

class AccountBank {
    /**
     * 获得银行列表
     * @return type
     */
    public static function getBanks(){
        $rows = \Common\Query::select('account_bank', array('status'=>1),array(),array('id'));
        return $rows;
    }
    
 	/**
     * 获得单个银行信息
     * @return type
     */
    public static function getBankInfo($bank_name){
        $rows = \Common\Query::selone('account_bank', array('status'=>1,'name'=>$bank_name),array(),array('id'));
        return $rows;
    }
}

