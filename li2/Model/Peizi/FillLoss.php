<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
namespace Model\Peizi;

use Common\Cache;
use Common\Query;

class FillLoss {
    /**
     * 保证金追加记录
     * @param type $pz_id
     * @param type $add_bond
     * @return type
     */
    public static function add($pz_id,$add_loss){
        $inarr['pz_id'] = $pz_id;
        $inarr['add_time'] = time();
        $inarr['add_loss'] = $add_loss;
        $inarr['status'] = 0;
        $res = \Common\Query::insert('user_peizi_fillloss', $inarr);
        return $res;
    }
    /**
     * 得到补亏等待划拔记录数
     * @return type
     */
    public static function getWaitCount($pz_type = array(1)){
        if(!is_array($pz_type)){
            $pz_type = explode(',', $pz_type);
        }
        $sql = 'select count(loss.fill_id) total from user_peizi_fillloss loss left join user_peizi pz on loss.pz_id=pz.pz_id where loss.status=0 and pz.pz_type in ('.implode(',', $pz_type).')';
        $row = \Common\Query::sqlselone($sql);
        return $row?$row['total']:0;
    }
}
