<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
namespace Model\Peizi;

use Common\Cache;
use Common\Query;

class Add {
    /**
     * 配资追加记录
     * @param type $pz_id
     * @param type $add_bond
     * @return type
     */
    public static function add($pz_id,$add_money,$add_bond,$alarm_money,$stop_money){
        $inarr['pz_id'] = $pz_id;
        $inarr['add_time'] = time();
        $inarr['add_money'] = $add_money;
        $inarr['add_bond'] = $add_bond;
        $inarr['alarm_money'] = $alarm_money;
        $inarr['stop_money'] = $stop_money;
        $inarr['status'] = 0;
        $res = \Common\Query::insert('user_peizi_add', $inarr);
        return $res;
    }
    /**
     * 得到配资待追加的实盘金
     * @return type
     */
    public static function getWaitMoney($pz_id){
        $sql = 'select sum(add_money) total from user_peizi_add where status=0 and pz_id='.  intval($pz_id);
        $row = \Common\Query::sqlselone($sql);
        return $row?$row['total']:0;
    }
    public static function getWaitCount($pz_type = array(1)){
        if(!is_array($pz_type)){
            $pz_type = explode(',', $pz_type);
        }
        $sql = 'select count(ad.add_id) total from user_peizi_add ad left join user_peizi pz on ad.pz_id=pz.pz_id where ad.status=0 and pz.pz_type in('. implode(',', $pz_type).')';
        $row = \Common\Query::sqlselone($sql);
        return $row?$row['total']:0;
    }
    /**
     * 得到配资追加等待划拔记录数-按天
     * @return type
     */
    public static function getWaitCount_day(){
        $sql = 'select count(ad.add_id) total from user_peizi_add ad left join user_peizi pz on ad.pz_id=pz.pz_id where ad.status=0 and pz.pz_type=1';
        $row = \Common\Query::sqlselone($sql);
        return $row?$row['total']:0;
    }
    /**
     * 得到配资追加等待划拔记录数-按月
     * @return type
     */
    public static function getWaitCount_month(){
        $sql = 'select count(ad.add_id) total from user_peizi_add ad left join user_peizi pz on ad.pz_id=pz.pz_id where ad.status=0 and pz.pz_type=2';
        $row = \Common\Query::sqlselone($sql);
        return $row?$row['total']:0;
    }
}
