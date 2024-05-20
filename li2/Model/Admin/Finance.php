<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Model\Admin;

/**
 * Description of Ad
 *
 * @author Administrator
 */
class Finance {
	/**
	 * 根据id获取账户信息
	 * @param string $id
	 * @return array
	 */
	public static function getAccountById($id) {
		return \Common\Query::selone('finance_account',array ('id' => $id));
	} 
	/**
	 * 删除账户
	 * @param array $arr
	 * @return array
	 */
	public static function delAccount($arr) {
		$id = \Common\Query::delete('finance_account',array ('id' =>$arr['id']));
		return array ('code' => $id, 'msg' => '删除成功' );
	}
        
        /**
	 * 修改账户
	 * @param array $arr
	 * @return array
	 */
	public static function editAccount($arr) {
                $inarr = array (
                        'name' => $arr ['name'],
                        'type' => $arr ['type'],
                        'channel'=>$arr['channel'],
                        'holder'=>$arr['holder'],
                        'account'=>$arr['account'],
                        'address'=>$arr['address'],
                        'caption'=>$arr['caption'],
                        'sortno'=>$arr['sortno'],
                        'status'=>$arr['status'],
                        'remark'=>$arr['remark'],
                        'path'=>$arr['path'],
                        'group_id'=>$arr['group_id']
                );
		$id = \Common\Query::update ( 'finance_account', $inarr, array ('id' => $arr ['id'] ) );
		return array ('code' => $id, 'msg' => '修改成功' );
	}
	
	/**
	 * 添加账户
	 * @param array $arr
	 * @return array
	 */
	public static function addAccount($arr) {
		$inarr = array (
			'name' => $arr ['name'],
			'type' => $arr ['type'],
			'channel'=>$arr['channel'],
			'holder'=>$arr['holder'],
			'account'=>$arr['account'],
			'address'=>$arr['address'],
			'caption'=>$arr['caption'],
			'sortno'=>$arr['sortno'],
			'status'=>$arr['status'],
			'remark'=>$arr['remark'],
			'path'=>$arr['path'],
                        'group_id'=>$arr['group_id']
		);
		$id = \Common\Query::insert ( 'finance_account', $inarr );
		return array ('code' => $id, 'msg' => '添加成功' );
	}
        
        /**
	 * 根据id获取支付设置信息
	 * @param string $id
	 * @return array
	 */
	public static function getPaysetById($id) {
		return \Common\Query::selone('pay_set',array ('id' => $id));
	} 
	/**
	 * 删除支付设置
	 * @param array $arr
	 * @return array
	 */
	public static function delPayset($arr) {
		$id = \Common\Query::delete('pay_set',array ('id' =>$arr['id']));
		return array ('code' => $id, 'msg' => '删除成功' );
	}
        
        /**
	 * 修改支付设置
	 * @param array $arr
	 * @return array
	 */
	public static function editPayset($arr) {
                $inarr = array (
			'code' => $arr ['code'],
                        'controller' => $arr ['controller'],
			'can_iframe' => $arr ['can_iframe'],
			'manner'=>$arr['manner'],
			'pay_type'=>$arr['pay_type'],
			'name'=>$arr['name'],
			'domain'=>$arr['domain'],
			'sid'=>$arr['sid'],
			'skey'=>$arr['skey'],
			'status'=>$arr['status'],
			'client_type'=>$arr['client_type'],
                        'terminal_id'=>$arr['terminal_id'],
                        'server_pub_key'=>$arr['server_pub_key'],
                        'mem_pri_key'=>$arr['mem_pri_key'],
                        'memo'=>$arr['memo'],
		);
		$id = \Common\Query::update ( 'pay_set', $inarr, array ('id' => $arr ['id'] ) );
		return array ('code' => $id, 'msg' => '修改成功' );
	}
	
	/**
	 * 添加支付设置
	 * @param array $arr
	 * @return array
	 */
	public static function addPayset($arr) {
		$inarr = array (
			'code' => $arr ['code'],
                        'controller' => $arr ['controller'],
			'can_iframe' => $arr ['can_iframe'],
			'manner'=>$arr['manner'],
			'pay_type'=>$arr['pay_type'],
			'name'=>$arr['name'],
			'domain'=>$arr['domain'],
			'sid'=>$arr['sid'],
			'skey'=>$arr['skey'],
			'status'=>$arr['status'],
			'client_type'=>$arr['client_type'],
                        'terminal_id'=>$arr['terminal_id'],
                        'server_pub_key'=>$arr['server_pub_key'],
                        'mem_pri_key'=>$arr['mem_pri_key'],
                        'memo'=>$arr['memo'],
		);
		$id = \Common\Query::insert ( 'pay_set', $inarr );
		return array ('code' => $id, 'msg' => '添加成功' );
	}
        
        public static function getSetInfo(){
        $info=array(
            'uline'=>array('name'=>'优畅支付','pay_type'=>array('pay.weixin.native'=>'微信','pay.alipay.native'=>'支付宝'),'domain'=>'notnull','sid'=>'notnull','skey'=>'notnull','terminal_id'=>'null','server_pub_key'=>'null','mem_pri_key'=>'null','can_iframe'=>'1','memo'=>''),
            'gwmwii_wx'=>array('name'=>'利赢微信支付','pay_type'=>array('pay.weixin.native'=>'微信'),'domain'=>'notnull','sid'=>'notnull','skey'=>'notnull','terminal_id'=>'null','server_pub_key'=>'null','mem_pri_key'=>'null','can_iframe'=>'1','memo'=>''),
            'gwmwii_zfb'=>array('name'=>'利赢支付宝支付','pay_type'=>array('pay.alipay.native'=>'支付宝'),'domain'=>'notnull','sid'=>'notnull','skey'=>'notnull','terminal_id'=>'null','server_pub_key'=>'null','mem_pri_key'=>'null','can_iframe'=>'1','memo'=>''),
            'jinm_zfb'=>array('name'=>'金米支付宝支付','pay_type'=>array('pay.weixin.native'=>'微信','pay.alipay.native'=>'支付宝'),'domain'=>'notnull','sid'=>'notnull','skey'=>'notnull','terminal_id'=>'null','server_pub_key'=>'null','mem_pri_key'=>'null','can_iframe'=>'0','memo'=>''),
            'pay365'=>array('name'=>'365支付','pay_type'=>array('pay.weixin.native'=>'微信','pay.alipay.native'=>'支付宝'),'domain'=>'notnull','sid'=>'notnull','skey'=>'notnull','terminal_id'=>'null','server_pub_key'=>'null','mem_pri_key'=>'null','can_iframe'=>'0','memo'=>'终端ID填写机构号'),
            'swiftpass'=>array('name'=>'威富通','pay_type'=>array('pay.weixin.native'=>'微信','pay.alipay.native'=>'支付宝'),'domain'=>'notnull','sid'=>'notnull','skey'=>'notnull','terminal_id'=>'null','server_pub_key'=>'null','mem_pri_key'=>'null','can_iframe'=>'0','memo'=>''),
            'qnf'=>array('name'=>'全能付','pay_type'=>array('pay.weixin.native'=>'微信','pay.alipay.native'=>'支付宝'),'domain'=>'notnull','sid'=>'notnull','skey'=>'notnull','terminal_id'=>'null','server_pub_key'=>'null','mem_pri_key'=>'null','can_iframe'=>'0','memo'=>''),
            'bobi'=>array('name'=>'波币钱包','pay_type'=>array('pay.weixin.native'=>'微信','pay.alipay.native'=>'支付宝'),'domain'=>'notnull','sid'=>'notnull','skey'=>'notnull','terminal_id'=>'null','server_pub_key'=>'null','mem_pri_key'=>'null','can_iframe'=>'0','memo'=>''),

            );
        return $info;
    }
    
        public static function getFinanceAccountType() {
            $type = array(0 => '银行', 1 => '微信', 2 => '京东', 3 => '支付宝', 4 => 'QQ钱包', 5 => '财付通', 6 => '百度钱包');
            return $type;
        }
        
        //判断分组是否存在，true:存在，false:不存在
    public static function isGroupExist($group_id)
    {
        $rows = \Common\Query::sqlsel('SELECT *  from finance_account where status=1');
        if($rows)
        {
            foreach ($rows as $row)
            {
                $arr_group= explode(',',$row['group_id']);
                if(in_array($group_id, $arr_group))
                {
                    return true;
                }
            }
        }
        return false;
    }
}
