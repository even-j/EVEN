<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
namespace Model\P2p;

use Common\Cache;
use Common\Query;

class Touzi {
     /**
     * 
     * @param type $uid
     * @param type $pz_id
     * @param type $tz_money 元
     * @return type
     */
    public static function calc($uid,$pz_id,$tz_money){
        $p2p_row = \Model\P2p\Peizi::getRowById($pz_id);
        $pz_times_unit = $p2p_row['pz_times_unit'];
        $pz_times = $p2p_row['pz_times'];
        $year_rate = $p2p_row['year_rate'];
        $plan_interest = 0;
        if($pz_times_unit==3){//月
            $var['interest_one'] =  intval($tz_money * $year_rate/100/12*100)  ;
            $var['plan_interest'] =  $var['interest_one']*$pz_times  ;
        }
        else{//天
            $var['interest_one'] = intval($tz_money * $year_rate/100/12/30*$pz_times*100);
            $var['plan_interest'] = $var['interest_one'];
        }  
        if($var['interest_one']<1){
            $var['interest_one'] = 1;//至少给1分
        }
        if($var['interest_one']<1){
            $var['interest_one'] = 1;//至少给1分
            $var['plan_interest'] = 1;
        }
        return $var;
    }

    /**
     * 
     * @param type $uid
     * @param type $pz_id
     * @param type $tz_money 元
     * @return type
     */
    public static function add($uid,$pz_id,$tz_money){
        $feiyong = self::calc($uid,$pz_id,$tz_money);
        $indata['uid'] = $uid;
        $indata['pz_id'] = $pz_id;
        $indata['tz_time'] = time();
        $indata['tz_money'] = $tz_money*100;
        $indata['plan_interest'] = $feiyong['plan_interest'];
        $indata['interest_one'] = $feiyong['interest_one'];
        $indata['earned_interest'] = 0;
        $indata['fencheng_money'] = 0;
        
        $res = \Common\Query::insert('user_peizi_touzi', $indata);
        if($res){
            $indata['tz_id'] = $res;
            return array(1,$indata);
        }
        return array(0,'插入数据失败');
    }
    /**
     * 通过id获取策略记录
     * @param type $tz_id
     * @return type
     */
    public static function getRowById($tz_id,$uid = 0){
        $where['tz_id'] =$tz_id;
        if($uid>0){
            $where['uid'] = $uid;
        }
        $row = \Common\Query::selone('user_peizi_touzi', $where);
        return $row;
    }
    /**
     * 获得策略的投资记录
     * @param type $pz_id
     * @return type
     */
    public static function getRowsByPz_id($pz_id){
        $rows = \Common\Query::select('user_peizi_touzi t left join user_info u on t.uid=u.uid', array('pz_id'=>$pz_id),  array('t.*','u.mobile'));
        return $rows;
    }
    /**
     * 支付给投资人利息
     * @param type $pz_id
     */
    public static function payInserest($pz_id){
        $pz_id = intval($pz_id);
        $pz_row = \Model\P2p\Peizi::getRowById($pz_id);
        if(intval($pz_row['p2pstatus'])!=6){
            return array(0,'策略记录状态错误');
        }
        if(time()<$pz_row['next_pay_interest_time']){
            return array(0,'支付利息时间未到');
        }
        $tz_rows = self::getRowsByPz_id($pz_id);
        //支付利息
        foreach ($tz_rows as $tz_row){
            if($tz_row['earned_interest']<$tz_row['plan_interest']){
                //更新投资记录的赚取利息
                $updata['earned_interest'] = $tz_row['earned_interest']+$tz_row['interest_one'];
                $res = \Common\Query::update('user_peizi_touzi', $updata, array('tz_id'=>$tz_row['tz_id']));
                if(!$res){
                    return array(0,'更新赚取利息失败');
                }
                //赚取利息流水
                $res = \Model\User\Fund::interestEarn($tz_row['uid'], $tz_row['interest_one'], $pz_id);
                if($res[0] == 0){
                    return array(0,'赚取利息流水插入失败');
                }
            }
        }
        //更新下次支付利息时间
        $nexttime = strtotime('+1 month',$pz_row['next_pay_interest_time']);
        if($nexttime<$pz_row['end_time']){
            $updata = array();
            $updata['next_pay_interest_time'] = $nexttime;
            $res = \Common\Query::update('user_peizi', $updata, array('pz_id'=>$pz_id));
            if(!$res){
                return array(0,'更新支付利息时间失败');
            }
        }
        return array(1,'支付利息成功');
    }
    /**
     * 支付给投资人盈利分成
     * @param type $pz_id
     */
    public static function payFencheng($pz_id){
        $pz_id = intval($pz_id);
        $pz_row = \Model\P2p\Peizi::getRowById($pz_id);
        
        //支付盈利分成
        if($pz_row['pz_type']==5 ){
            $tz_rows = self::getRowsByPz_id($pz_id);
            foreach ($tz_rows as $tz_row){
                //更新投资记录的盈利分成
                $fencheng_money = 0;
                if($pz_row['profit_loss_money']>0){ 
                    $fencheng_money = intval($tz_row['tz_money']/$pz_row['pz_money']*$pz_row['profit_loss_money']*$pz_row['fencheng_rate']/100);
                }
                if($fencheng_money>0){
                    $updata['fencheng_money'] = $fencheng_money;
                    $res = \Common\Query::update('user_peizi_touzi', $updata, array('tz_id'=>$tz_row['tz_id']));
                    if(!$res){
                        return array(0,'更新盈利分成失败');
                    }
                }
                //盈利分成流水
                $res = \Model\User\Fund::winFenchengIn($tz_row['uid'], $fencheng_money, $tz_row['tz_id']);
                if($res[0] == 0){
                    return array(0,'盈利分成流水插入失败');
                }
            }
        }
        return array(1,'盈利分成成功');
    }
    /**
     * 退回投资人投资资金
     */
    public static function backPeiziMoney($pz_id){
        $tz_rows = self::getRowsByPz_id($pz_id);
        foreach ($tz_rows as $tz_row) {
            $res = \Model\User\Fund::creditor_in($tz_row['uid'], $tz_row['tz_money'], $tz_row['tz_id']);
            if($res[0]==0){
                return array(0,'退回资金失败');
            }
        }
        return array(1,'退回资金成功');
    }

    /**
     * 获得统计用户投资数据
     * @param int $uid
     * @param int $type tz_money
     * @return int
     */
    public static function getInfoByUid($uid, $type='tz_money', $ys=0){
    	$where = 't.uid='.$uid;
    	if($ys==1){
    		$where .= '	AND p.p2pstatus=7';
    	}
    	if($ys==2){
    		$where .= '	AND p.p2pstatus=6';
    	}
    	$table = $ys ? 'user_peizi_touzi as t left join user_peizi as p on t.pz_id=p.pz_id' : 'user_peizi_touzi as t';
    	$sql = 'SELECT IFNULL(sum('.$type.'),0) as total FROM '.$table.' WHERE '.$where;
    	$res = \Common\Query::sqlselone($sql);
    	return $res ? $res['total'] : 0;
    }
    
	/**
     * 通过策略id获取策略记录
     * @param type $tz_id
     * @return type
     */
    public static function getListById($pz_id){
        return \Common\Query::sqlsel('SELECT t.*,p.pz_times,p.pz_times_unit FROM user_peizi_touzi as t left join user_peizi as p on t.pz_id=p.pz_id WHERE t.pz_id='.$pz_id);
    }
    
    /**
     * 根据编号获得投资数据
     * @param int $uid
     * @param int $pz_id
     * @return int
     */
    public static function getTouziInfoById($uid,$tz_id){
     return \Common\Query::sqlselone('SELECT t.*, p.pz_money,p.year_rate,p.fencheng_rate,p.uid,p.pz_times,p.pz_times_unit,p.p2pstatus,p.start_time,p.end_time FROM user_peizi_touzi as t left join user_peizi as p on t.pz_id=p.pz_id WHERE t.tz_id='.$tz_id.' AND t.uid='.$uid);
    }
    /**
     * 得到正在投标中的投资资金
     * @return type
     */
    public static function getUnpassTouzi(){
        $sql = 'select sum(tz_money) tz_money from user_peizi_touzi tz left join user_peizi pz on tz.pz_id=pz.pz_id where pz.p2pstatus=2';
        $row = \Common\Query::sqlselone($sql);
        return $row?$row['tz_money']:0;
    }
    
	/**
     * 得到投资用户数
     * @return type
     */
    public static function get_touzi_users(){
        return \Common\Query::sqlselone('select count(DISTINCT uid) tz_user,sum(tz_money) tz_money,sum(earned_interest) earned_interest from user_peizi_touzi');
    }
    
    /**
     * 获取投资用户统计
     * @return int
     */
    public static function get_touzi_users_by_type($type=0){
    	$where = $type=1 ? 'WHERE fencheng_money=0' :'';
    	$res = \Common\Query::sqlselone('select count(DISTINCT uid) total from user_peizi_touzi '.$where);
    	return $res ? $res['total']:0;
    }
  
}
