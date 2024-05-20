<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
namespace Model\Sys;

use Common\Cache;
use Common\Query;

class Area {
    /**
     * 获得省份列表
     * @return type
     */
    public static function getProvinces(){
        $rows = \Common\Query::select('areas', array('province'=>0,'status'=>1),array(),array('`order`'));
        return $rows;
    }
    /**
     * 获得城市列表
     * @param type $province
     * @return type
     */
    public static function getCitys($province = 0){
        $where['city'] = 0;
        $where['status'] = 1;
        if(intval($province) > 0){
            $where['province'] = intval($province);
        }
        else{
            $where['province'] = array('gt',0);
        }
        $rows = \Common\Query::select('areas', $where,array(),array('`order`'));
        return $rows;
    }
}

