<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Model\User;

use Common\Cache;
use Common\Query;

class Sign {
    public static function getByUid($uid){
        $sign_row = \Common\Query::selone('user_sign', array('uid'=> intval($uid)));
        return $sign_row;
    }

    public static function sign($uid){
        $params_sign = \Model\Admin\Params::get( 'manage_send' );
        $set_cycle = intval($params_sign['sign_cycle']);
        \Common\Query::commitstart();
        $sql = "select * from user_sign where uid=".intval($uid)." for update";
        $times = 0;
        $sign_row = \Common\Query::sqlselone($sql);
        if($sign_row){
            if(date('Y-m-d',strtotime($sign_row['qd_time'])) == date('Y-m-d')){
                //当天
                \Common\Query::rollback();
                return array('ret'=>1,'msg'=>'您今天已签到了');
            }
            elseif(date('Y-m-d',strtotime($sign_row['qd_time'])) == date('Y-m-d',time()-24*3600)){
                //昨天 次数原来+1
                $times  = intval($sign_row['times'])+1;
                if($times> $set_cycle){
                    //超出循环周期，认为是最后一天
                    $times = $set_cycle;
                }
            }
            else{
                //其它，重新累计
                $times = 1;
            }
        }
        else{
            //还没签过，开始累计
            $times = 1;
        }
        $money_set = $params_sign['sign'];
        $money_set_arr = explode(',', $money_set);
        if(count($money_set_arr)< $set_cycle){
            \Common\Query::rollback();
            return array('ret'=>1,'msg'=>'签到设置错误');
        }
        $money = floatval($money_set_arr[$times-1])*100;
        //添加赠送管理费
        $res = Fund::sign($uid, $money,'签到');
        if($res[0] == 0){
            \Common\Query::rollback();
            return array('ret'=>1,'msg'=>$res[1]);
        }
        //更新签到时间
        $data['uid'] = intval($uid);
        $data['times'] = $times;
        $data['qd_time'] = date('Y-m-d H:i:s');
        $res = \Common\Query::insert("user_sign", $data, true);
        if(!$res){
            \Common\Query::rollback();
            return array('ret'=>1,'msg'=>'签到错误');
        }
        \Common\Query::commit();
        return array('ret'=>0,'msg'=>'签到成功','money'=>$money/100,'times'=>$times);
    }
}