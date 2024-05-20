<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
namespace Model\Trade;

use Common\Cache;
use Common\Query;

class Account {
    /**
     * 随机取一个交易帐号，并设置为使用状态
     * @return type
     */
    public static function getRandOne($pz_type){
        $where ='status=0';
        if($pz_type==4){//免费体验
            $where .= ' and type=2';
        }
        else{
            $where .= ' and type=1';
        }
        $sql = 'select * from trade_account where '.$where.' order by rand() limit 0,1';
        $row = \Common\Query::sqlselone($sql);
        if($row){
            $sql = "update trade_account set status=1 where account='".$row['account']."'";
            $res = \Common\Query::sqlquery($sql);
            if($res){
                return $row;
            }
            return array();
        }
        return array();
    }
    /**
     * 账号设置成可使用状态
     * @param type $account
     * @return type
     */
    public static function setCanuseState($account){
        $updarr['status'] = 0;
        $res = \Common\Query::update('trade_account', $updarr, array('account'=>$account));
        return $res;
    }
    /**
     * 获得帐号类型
     * @param type $type
     * @return string
     */
    public static function getAccountType($type){
        $name = '';
        switch ($type){
            case 1:
                $name= '普通账号';
                break;
            case 2:
                $name= '免费体验账号';
                break;
        }
        return $name;
    }
}
