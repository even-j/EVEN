<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
namespace Model\Peizi;

use Common\Cache;
use Common\Query;

class Check {
    /**
     * 配资每天核对记录
     * @param type $pz_id
     * @param type $add_bond
     * @return type
     */
    public static function add($pz_id,$trade_balance){
        $inarr['pz_id'] = $pz_id;
        $inarr['check_time'] = time();
        $inarr['trade_balance'] = $trade_balance;
        $res = \Common\Query::insert('user_peizi_check', $inarr);
        return $res;
    }
    
}
