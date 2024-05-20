<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
namespace Model\Sys;

use Common\Cache;
use Common\Query;

class Common {
    /**
     * 判断日期是否为假日
     * @param type $time
     * @return boolean
     */
    public static function isHoliday($time){
        $index = date('w',$time);
        //周六、日
        if(intval($index) == 0 || intval($index)== 6){
            return true;
        }
        //节假日
        $day = date('Y-m-d',$time);
        $row = \Common\Query::selone('admin_holiday', array('hdate'=>$day));
        if($row){
            return true;
        }
        return false;
    }
    /**
     * 计算下个交易日时间
     * @param type $startDate
     * @param type $days
     */
    public static function getNextWorkDate($nowtime){
        $days = 0;
        $tomorrow = $nowtime+24*60*60;//第二天
        $nextday = $tomorrow;
        while (self::isHoliday($nextday)){
            $days++;
            $nextday = $nextday+24*60*60;
        }
        return strtotime(date('Y-m-d',$tomorrow+$days*24*3600));
    }
    /**
     * 根据开始时间和工作日计算结束时间
     * @param type $startDate
     * @param type $days
     */
    public static function getEndDate($startDate,$days,$pz_type = 0){
        $nextday = $startDate;
        if(self::isHoliday($nextday)){
            $days = $days+1;//如果开始当天是假日，天数加1，当天不算
        }
        $i = $days-1;
        while ($i>0){
            $nextday = $nextday+24*60*60;
            if(!self::isHoliday($nextday)){
                $i = $i -1;
            }
        }
        $end_hour = 15;
        if($pz_type==4){
            $end_hour = 14;
        }
        return mktime($end_hour, 0, 0, date('m',$nextday), date('d',$nextday), date('Y',$nextday));
    }
    /**
     * 获得表的分页记录
     * @param type $table_name
     * @param type $sel
     * @param type $where
     * @param type $order
     * @param type $curpage
     * @param type $pagesize
     * @return type
     */
    public static function getTableRrcordList($table_name,$sel= '*',$where = '1',$order = '1',$curpage = 1,$pagesize = 0){
        $sql = 'select '.$sel.' from '.$table_name.' ';
        $sql .= ' where '.$where.' order by '.$order;
        $limit = '';
        if($pagesize){
            $limit = strval((intval($curpage) -1)*intval($pagesize)).','.$pagesize;
            $sql .= ' limit '.$limit;
        }
        $datas = \Common\Query::sqlsel($sql);
        return $datas;
    }
    /**
    * 获取总记录数
    * @param string $table_name 表名
    * @param string $where 条件
    * @return array 
    */
   public static function getTableRecordCount($table_name,$where='1'){
        $sql = 'SELECT COUNT(*) AS total FROM '.$table_name.' where '.$where;
        $res = \Common\Query::sqlselone($sql);
        return empty($res) ? 0 :$res['total'];
   }
   /**
    * 倒计时
    * @param type $endtime
    * @return string
    */
   public static function countdown($endtime){
       
       $now = time();
       $res = '';
       $srcond = $endtime - $now;
       if($srcond<=0){
           $res='到期';
           
       }
       else{
            $days = intval($srcond/(24*60*60)) ;
            $hours = intval(($srcond - $days*24*60*60)/(60*60));
            $mintues = intval(($srcond-$days*24*60*60-$hours*(60*60))/60);
            $res='剩'.$days.'天'.$hours.'小时'.$mintues.'分';
       }
       return '<font style="color:red">'.$res.'</font>';
   }
   
   /**
    * 倒计时
    * @param type $endtime
    * @return string
    */
   public static function count($starttime,$endtime=0){
       
       $now = $endtime;
       if($now == 0){
           $now = time();
       }
       $res = '';
       $srcond = $now - $starttime;
       $days = intval($srcond/(24*60*60)) ;
       $hours = intval(($srcond - $days*24*60*60)/(60*60));
       $mintues = intval(($srcond-$days*24*60*60-$hours*(60*60))/60);
       $res=$days.'天'.$hours.'小时'.$mintues.'分';
       return $res;
   }
   /**
    * 手机显示格式化
    * @param type $mobile
    */
   public static function mobileFormat($mobile){
       $mobile = substr($mobile, 0, 3).'****'.substr($mobile, 8, 3);
       return $mobile;
   }
}

