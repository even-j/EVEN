<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
namespace Model\Peizi;

use Common\Cache;
use Common\Query;

class GetProfit {
    public static function getById($profit_id){
        $res = \Common\Query::selone('user_peizi_getprofit', array('id'=>$profit_id));
        return $res;
    }
    /**
     * 盈利提取记录
     * @param type $uid
     * @param type $pz_id
     * @param type $money
     * @return type
     */
    public static function add($uid,$pz_id,$money){
        $inarr['uid'] = $uid;
        $inarr['pz_id'] = $pz_id;
        $inarr['add_time'] = time();
        $inarr['money'] = $money;
        $inarr['status'] = 0;
        $res = \Common\Query::insert('user_peizi_getprofit', $inarr);
        return $res;
    }
    /**
     * 盈利提取记录数
     * @return type
     */
    public static function getWaitCount(){
        $sql = 'select count(id) total from user_peizi_getprofit where status=0';
        $row = \Common\Query::sqlselone($sql);
        return $row?$row['total']:0;
    }
    
    /**
     * 
     * @param type $profit_id
     * @return type
     */
    public static function updateSuccessStatus($profit_id){
        $updarr['status'] =1;
        $updarr['update_time'] =time();
        $res = \Common\Query::update('user_peizi_getprofit', $updarr, array('id'=>$profit_id,'status'=>0));
        return $res;
        
    }
    
    public static function updateRefuseStatus($profit_id){
        $updarr['status'] =2;
        $updarr['update_time'] =time();
        return \Common\Query::update('user_peizi_getprofit', $updarr, array('id'=>$profit_id,'status'=>0));
    }
}
