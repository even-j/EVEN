<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
namespace Model\P2p;

use Common\Cache;
use Common\Query;

class Peizi {
    /**
     * 返回值单位都为：分
     * @param type $uid
     * @param type $pz_money 万元
     * @param type $pz_ratio
     * @param type $pz_times_unit
     * @param type $pz_times
     * @param type $year_rate 
     * 
     */
    public static function calc($uid,$pz_money,$pz_ratio,$pz_times_unit,$pz_times,$year_rate){
        $params = \Model\Admin\Params::get('p2p');
        $var['bond'] = $pz_money*10000/$pz_ratio*100;
        if($pz_times_unit==3){//月
            $var['interest'] = round($pz_money*10000 * $year_rate/100/12, 2)*100 ;
            $var['service_money'] = round($pz_money*10000*$params['service_cost_rate'.$pz_ratio]/100,2)*100;
        }
        else{//天
            $var['interest'] = round($pz_money*10000 * $year_rate/100/12/30*$pz_times,2)*100;
            $var['service_money'] = round($pz_money*10000*$params['service_cost_rate'.$pz_ratio]/100/30*$pz_times,2)*100;
        }  
        $var['manage_money'] = $params['manage_cost_money']/100*100;
        $var['alarm_money'] = $pz_money*10000*100+$var['bond']*$params['alarm_rate'.$pz_ratio]/100;
        $var['stop_money'] = $pz_money*10000*100+$var['bond']*$params['stop_rate'.$pz_ratio]/100;
        return $var;
    }

    /**
     * 
     * @param type $uid
     * @param type $pz_money 万元
     * @param type $pz_ratio
     * @param type $pz_times_unit
     * @param type $pz_times
     * @param type $year_rate
     * 
     */
    public static function add($uid,$pz_type,$pz_money,$pz_ratio,$pz_times_unit,$pz_times,$year_rate,$fencheng){
        $params = \Model\Admin\Params::get('p2p');
        if($pz_money>$params['peizi_max']){
            return array(0,'超出最高策略限额');
        }
        $feiyong = self::calc($uid, $pz_money, $pz_ratio, $pz_times_unit, $pz_times, $year_rate);
        
        $indata['pz_type'] = $pz_type;//3:p2p,5:分成
        $indata['uid'] = $uid;
        $indata['pz_time'] = time();
        $indata['pz_money'] = $pz_money*10000*100;
        $indata['trade_money_total'] = $indata['pz_money']+$feiyong['bond'];
        $indata['pz_ratio'] = $pz_ratio;
        $indata['pz_times_unit'] = $pz_times_unit;
        $indata['pz_times'] = $pz_times;
        $indata['has_touzi_money'] = 0;
        $indata['pz_days'] = $pz_times;
        if($pz_times_unit == 3){//月
            $indata['pz_days'] = $pz_times*30;
        }
        $indata['year_rate'] = $year_rate;
        $indata['fencheng_rate'] = $fencheng;
        $indata['bond_init'] = $feiyong['bond'];
        $indata['bond_total'] = $feiyong['bond'];
        $indata['service_rate'] = $params['service_cost_rate'.$pz_ratio];
        $indata['interest'] = $feiyong['interest'];
        $indata['service_money'] = $feiyong['service_money'];
        $indata['manage_money'] = $feiyong['manage_money'];
        $indata['limit_days'] = $params['limit_days'];
        $indata['p2pstatus'] = 1;
        $indata['alarm_money'] = $feiyong['alarm_money'];
        $indata['stop_money'] = $feiyong['stop_money'];
        $indata['next_pay_interest_time'] = 0;
        $indata['next_get_interest_time'] = 0;
        $res = \Common\Query::insert('user_peizi', $indata);
        if($res){
            $indata['pz_id'] = $res;
            return array(1,$indata);
        }
        return array(0,'插入数据失败');
    }
    /**
     * 收取策略人管理费利息
     * @param type $pz_id
     */
    public static function getInserest($pz_id){
        $pz_row = \Model\P2p\Peizi::getRowById($pz_id);
        //支付利息
        $res = \Model\User\Fund::interestPay($pz_row['uid'], $pz_row['interest'], $pz_row['pz_id'],'user_peizi');
        if($res[0]==0){
            return array(0,$res[1]);
        }
        //支付管理费
        $res = \Model\User\Fund::managecostPay($pz_row['uid'], $pz_row['service_money']+$pz_row['manage_money'], $pz_row['pz_id'],'user_peizi');
        if($res[0]==0){
            return array(0,$res[1]);
        }
        //实际支付管理费、利息
        $sql ='update user_peizi set manage_cost_act=manage_cost_act+' . ($pz_row['service_money']+$pz_row['manage_money']+$pz_row['interest']) .' where pz_id='.$pz_row['pz_id'];
        $res = \Common\Query::sqlquery($sql);
        if(!$res){
            return array(0,'更新实际支付管理费、利息失败');
        }
        //更新下次收取利息时间
        $nexttime = strtotime('+1 month',$pz_row['next_get_interest_time']);
        if($nexttime<$pz_row['end_time']){
            $updata = array();
            $updata['next_get_interest_time'] = $nexttime;
            $res = \Common\Query::update('user_peizi', $updata, array('pz_id'=>$pz_id));
            if(!$res){
                return array(0,'更新下次收取利息时间失败');
            }
        }
        return array(1,'收取成功');
    }
    /**
     * 收取策略人盈利分成
     * @param type $pz_id
     */
    public static function payFencheng($pz_id){
        $pz_id = intval($pz_id);
        $pz_row = \Model\P2p\Peizi::getRowById($pz_id);
        
        //支付盈利分成
        if($pz_row['pz_type']==5){
            $fencheng_money = 0;
            if($pz_row['profit_loss_money']>0){
                $fencheng_money = intval($pz_row['profit_loss_money']*$pz_row['fencheng_rate']/100) ;
            }
            //盈利分成流水
            $res = \Model\User\Fund::winFenchengOut($pz_row['uid'], $fencheng_money, $pz_id);
            if($res[0] == 0){
                return array(0,$res[1]);
            }
        }
        return array(1,'盈利分成成功');
    }
    /**
     * 通过id获取策略记录
     * @param type $pz_id
     * @return type
     */
    public static function getRowById($pz_id,$uid = 0){
        $where['pz_id'] =$pz_id;
        if($uid>0){
            $where['uid'] = $uid;
        }
        $row = \Common\Query::selone('user_peizi', $where);
        return $row;
    }
  
    /**
     * 获得已投资的金额
     * @param type $pz_id
     * @return type
     */
    public static function getTouziMoney($pz_id){
        $row = \Common\Query::selone('user_peizi_touzi', array('pz_id'=>$pz_id),array('sum(tz_money) tz_money'));
        return $row?$row['tz_money']:0;
    }
    /**
     * 获得已投资的用户数
     * @param type $pz_id
     * @return type
     */
    public static function getTouziUsers($pz_id){
        $row = \Common\Query::selone('user_peizi_touzi', array('pz_id'=>$pz_id),array('count(uid) total'));
        return $row?$row['total']:0;
    }
      /**
     * 获得已投资的记录条烽
     * @param type $pz_id
     * @return type
     */
    public static function getTouziRecordCount($pz_id){
        $row = \Common\Query::selone('user_peizi_touzi', array('pz_id'=>$pz_id),array('count(tz_id) total'));
        return $row?$row['total']:0;
    }
    
    public static function getTimeUnitName($type){
        $name = '';
        switch ($type){
            case 1:
                $name = '天';
                break;
            case 2:
                $name = '周';
                break;
            case 3:
                $name = '月';
                break;
        }
        return $name;
    }
    
 	/**
     * 获得统计用户策略数据
     * @param int $uid
     * @param int $type tz_money
     * @return int
     */
    public static function getInfoByUid($uid, $type='tz_money'){
    	$res = \Common\Query::sqlselone('SELECT IFNULL(sum('.$type.'),0) as total FROM user_peizi WHERE pz_type=3 and uid='.$uid.' AND (p2pstatus>0 AND p2pstatus!=3 AND p2pstatus!=7 AND status!=4)');
    	return $res ? $res['total'] : 0;
    }
    
    /**
     * 根据编号获得用户策略信息
     * @param int $id
     * @return array
     */
    public static function getPeiziById($uid,$pz_id){
      return \Common\Query::sqlselone('SELECT p.*,t.fencheng_money FROM user_peizi as p left join user_peizi_touzi as t on t.pz_id=p.pz_id WHERE p.pz_id='.$pz_id.' AND p.uid='.$uid);
    }
    /**
     * 获得p2p策略申请待审核条数
     * @return type
     */
    public static function getApplyWaitCount(){
        $sql = 'select count(pz_id) total from user_peizi where (pz_type=3 or pz_type=5)  and p2pstatus=1';
        $row = \Common\Query::sqlselone($sql);
        return $row?$row['total']:0;
    }
    /**
     * 获得p2p策略满标待审核条数
     * @return type
     */
    public static function getFullWaitCount(){
        $sql = 'select count(pz_id) total from user_peizi where (pz_type=3 or pz_type=5) and p2pstatus=4';
        $row = \Common\Query::sqlselone($sql);
        return $row?$row['total']:0;
    }
    /**
     * 获得p2p策略废标待处理条数
     * @return type
     */
    public static function getThrowsWaitCount(){
        $sql = 'select count(pz_id) total from user_peizi where (pz_type=3 or pz_type=5) and p2pstatus=2 and limit_end_time<'.time();
        $row = \Common\Query::sqlselone($sql);
        return $row?$row['total']:0;
    }
    /**
     * 获得p2p策略完标待处理条数
     * @return type
     */
    public static function getEndWaitCount($pz_type = 3){
        $sql = 'select count(pz_id) total from user_peizi where (pz_type='.$pz_type.') and p2pstatus=6 and end_time<'.time();
        $row = \Common\Query::sqlselone($sql);
        return $row?$row['total']:0;
    }
    
    /**
     * 获得p2p策略待交利息不足条数
     * @return type
     */
    public static function getNoMeneyCount(){
        $time = time();
        //$today = mktime(0, 0, 0, date('m',$time), date('d',$time), date('Y',$time));
        //9点后，开盘时间内不再提醒
        if(date('H',$time)<=9 || date('H',$time)>=15){
            $sql = 'select count(pz.pz_id) total from user_peizi pz left join user_info u on pz.uid=u.uid where pz.p2pstatus=6 and (pz.pz_type=3 or pz.pz_type=5) and pz.pz_times_unit=3 and pz.pz_times>1 and pz.next_get_interest_time<'.time().' and (pz.interest+pz.service_money+pz.manage_money)>u.balance';
            $row = \Common\Query::sqlselone($sql);
            return $row?$row['total']:0;
        }
        return 0;
    }
    /**
     * 得到未返还的投资金额
     * @return type
     */
    public static function getUnbackTouzi($uid=0){
        $sql = 'select sum(creditor) creditor,sum(debt) debt from user_info ';
        if($uid>0){
        	$sql.= ' WHERE uid='.$uid;
        }
        $row = \Common\Query::sqlselone($sql);
        return $row?($row['creditor']-$row['debt']):0;
    }
    /**
     * 得到系统的亏损
     * @return type
     */
    public static function getLossSys(){
        $sql = 'select sum(fill_loss_money) fill_loss_money,sum(back_money) back_money,sum(profit_loss_money) profit_loss_money from user_peizi where status=4';
        $row = \Common\Query::sqlselone($sql);
        return $row?($row['back_money']-($row['profit_loss_money']+$row['fill_loss_money'])):0;
    }

}
