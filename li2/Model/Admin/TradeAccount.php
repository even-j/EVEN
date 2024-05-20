<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Model\Admin;

/**
 * Description of TradeAccount
 *
 * @author Administrator
 */
class TradeAccount {
	
	/**
	 * 添加交易账户
	 * @param array $arr
	 * @return array
	 */
	public static function addTradeAcount($arr) {
		$inarr = array ('parent_account'=>$arr ['parent_account'],'account' => $arr ['account'],'pwd' => $arr ['pwd'],'addtime'=>$arr['addtime'],'type'=>$arr['type']);
		\Common\Query::sqlquery("set names gbk");
        return \Common\Query::insert ( 'trade_account', $inarr );
	}
	
	/**
	 * 修改交易账户
	 * @param array $arr
	 * @return array
	 */
	public static function editTradeAcount($arr) {
		return \Common\Query::update ( 'trade_account', array ('parent_account'=>$arr ['parent_account'],'pwd' => $arr ['pwd'],'status'=>$arr['status'],'type'=>$arr['type']), array ('account' => $arr ['account'] ) );
	}
	
	/**
	 * 获取交易账户信息
	 * @param string $account
	 * @return array
	 */
	public static function getTradeAcount($account) {
		return \Common\Query::selone('trade_account',array ('account' => $account));
	}
	/**
	 * 删除交易账户
	 * @param array $arr
	 * @return array
	 */
	public static function delTradeAcount($account) {
		return \Common\Query::delete('trade_account',array ('account' =>$account));
	}
        /**
         * 得到未使用的帐户数
         * @return type
         */
        public static function getCanuseAccountCount(){
            $sql = 'select count(account) total from trade_account where status=0 and type=1';
            $row = \Common\Query::sqlselone($sql);
            return $row?$row['total']:0;
        }
        
        /**
         * 得到未使用的免费体验帐户数
         * @return type
         */
        public static function getCanuseAccountCount_free(){
            $sql = 'select count(account) total from trade_account where status=0 and type=2';
            $row = \Common\Query::sqlselone($sql);
            return $row?$row['total']:0;
        }
}
