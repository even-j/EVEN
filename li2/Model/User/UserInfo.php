<?php
/**
 * Description of UserInfo
 *
 * @author Administrator
 */

namespace Model\User;

use Common\Cache;
use Common\Query;

class UserInfo {

    //put your code here
    /**
     * 获取用户信息
     * @param type $funiu_no
     * @return type
     */
    public static function getinfo($uid) {
        if (!$uid) {
            return false;
        }
        $key = 'uinfo_' . $uid;
        $uinfo = Cache::get($key);
        if ($uinfo) {
            return $uinfo;
        }
        $uinfo = Query::selone('user_info', array('uid' => $uid));
        if ($uinfo) {
            Cache::save($key, $uinfo);
        }
        return $uinfo;
    }
    /**
     * 删除用户的缓存
     * @param type $uid
     */
    public static function removeCache($uid) {
        $key = 'uinfo_' . $uid;
        \Common\Cache::rm($key);
    }

    public static function getByIdcrad($id_card){
        $where['id_card'] = \App::t($id_card);
        $where['status'] = 1;
        $res = \Common\Query::selone('user_info', $where);
        return $res;
    }
    
    public static function getByRandid($randid){
        $where['randid'] = \App::t($randid);
        $res = \Common\Query::selone('user_info', $where);
        return $res;
    }
    
    public static function getByMobile($mobile){
        $where['mobile'] = \App::t($mobile);
        $where['status'] = 1;
        $res = \Common\Query::selone('user_info', $where);
        return $res;
    }
    
    public static function isVip($uid){
        $user = \Model\User\UserInfo::getinfo($uid);
        if($user['level'] == 1 && time()>= strtotime($user['vip_start_time']) && time()<=strtotime($user['vip_end_time'])){
            return true;
        }
        return false;
    }

    /**
     * 用户注册
     * @param type $data
     */
    public static function reg($mobile,$pwd,$intid='') {
        //判断手机号重复
        $row = \Common\Query::selone('user_info', array('mobile'=>$mobile));
        if($row){
            return array(0,'该手机号已存在!');
        }
        $ip = \App::getonlineip();

        if ($ip==''){

				return array(0,'注册IP不存在');
       }



        $regist_set = \apps\Config::getInstance()->regist;
        if(isset($regist_set['status']) && $regist_set['status'] == 1){
            $row = \Common\Query::selone('user_info', array('reg_ip'=>$ip),array(),array(array('reg_time','desc')));
            if($row && time()-$row['reg_time'] < intval($regist_set['hours'])*3600){
                return array(0,'相同IP'.intval($regist_set['hours']).'小时内不能重复注册');
            }
        }
        //注册
        $regarr = array();
        $rand = rand(100000, 999999);
        $regarr['rand'] = $rand;
        $regarr['mobile'] = $mobile;
        $regarr['pwd'] = self::renderPassword($rand, $pwd);
        $regarr['reg_time'] = time();
        $regarr['reg_ip'] = $ip;
        $regarr['randid'] = $mobile;//\App::rand_str(32,1);
        $regarr['group_id']=1;
        if(empty($intid)&&isset($_SESSION) && isset($_SESSION['intid']) && !empty($_SESSION['intid']))
        {
            $intid=$_SESSION['intid'];
        }
        if(!empty($intid)){
            $int_user = self::getByRandid($intid);
            if($int_user){
                $regarr['introducer_id'] = $int_user['uid'];
            }
        }
        
        
        $regarr['reg_domain'] = $_SERVER['HTTP_HOST'];
        
        $uid = \Common\Query::insert('user_info', $regarr);
        //赠送管理费
        $params_manage_send = \Model\Admin\Params::get( 'manage_send' );
        if(floatval($params_manage_send['regist'])>0){
            Fund::regist($uid, floatval($params_manage_send['regist'])*100);
        }
        self::login($mobile,$pwd);
        return array(1,$uid);
    }
    /**
     * 用户登录
     * @param type $mobile
     * @param type $pwd
     */
    public static function login($mobile,$pwd) {
        //判断用户密码
        $row = \Common\Query::selone('user_info', array('mobile'=>$mobile));
        if(!$row || $row['status'] == 3){
            return array(0,'用户不存在');
        }
        if(!$row || $row['status'] == 2){
            return array(0,'用户被冻结');
        }
        $rand = $row['rand'];
        if(self::renderPassword($rand, $pwd) != $row['pwd']){
            return array(0,'密码错误');
        }
        //登录
        $uid = $row['uid'];
        $cookie_pwd = md5(rand(1000, 99999999));
        $login_ip = \App::getonlineip(0);
        $key = 'user_session_' . $uid;
        $value = array('uid' => $uid, 'pwd' => $cookie_pwd, 'login_ip' => $login_ip, 'intime' => time());
        Cache::save($key, $value);
        //Query::insert('user_session', array('user_id'=>$user_id,'pwd'=>$pwd,'login_ip'=>$login_ip,'intime'=>time()), true);
        if(!isset($_SESSION)){
            session_start();
        }
        $_SESSION['uid'] = $uid;
        $_SESSION['pwd'] = $cookie_pwd;
        //\core\net\NCookie::set('uid', $uid);
        //\core\net\NCookie::set('pwd', $cookie_pwd);
        //更新用户信息
        $time = time();
        $sql = "update user_info set last_login_time=".$time.",login_times=login_times+1,last_login_ip='".$login_ip."' where uid=".$uid;
        \Common\Query::sqlquery($sql);
        self::removeCache($uid);
        //登录记录
        $logindata['uid'] = $uid;
        $logindata['login_time'] = time();
        $logindata['login_ip'] = $login_ip;
        \Common\Query::insert('user_login_logs', $logindata);
        
        return array(1,$uid);
    }
    /**
     * 用户退出
     * @param type $uid
     * @return boolean
     */
    public static function logout($uid) {
        if(!isset($_SESSION)){
            session_start();
        }
        $uid = isset($_SESSION['uid'])?$_SESSION['uid']:0;
        //$uid = \core\net\NCookie::get('uid');
        $key = 'user_session_' . $uid;
        Cache::rm($key);
        unset($_SESSION['uid']);
        unset($_SESSION['pwd']);
        //\core\net\NCookie::set('uid', 0, -12222);
        //\core\net\NCookie::set('pwd', 0, -12222);
        return true;
    }
    /**
     * 检测用户是否登录
     * @return type
     */
    public static function checkuser() {
        if(!isset($_SESSION)){
            session_start();
        }
        $uid = isset($_SESSION['uid'])?$_SESSION['uid']:0;
        $pwd = isset($_SESSION['pwd'])?$_SESSION['pwd']:0;
        //$uid = \core\net\NCookie::get('uid');
        //$pwd = \core\net\NCookie::get('pwd');
        //echo 'uid:'.$uid.'<br>';
        //echo 'pwd:'.$pwd.'<br>';
        $key = 'user_session_' . $uid;
        $arr = Cache::get($key);
        //$arr=  Query::selone('user_session', array('uid'=>$uid,'pwd'=>$pwd));
        if (!is_array($arr) || empty($arr)) {
            return array();
        }
        //echo 'uid2:'.$arr['uid'].'<br>';
        //echo 'pwd2:'.$arr['pwd'].'<br>';
        if($arr['uid'] != $uid || $arr['pwd'] != $pwd){
            return array();
        }
        return self::getinfo($uid);
    }
    /**
     * 加密密码
     * @param type $rand
     * @param type $pwd
     * @return type
     */
    public static function renderPassword($rand, $pwd) {
        return md5($rand . $pwd);
    }
    /**
     * 判断手机用户是否存在
     * @param type $mobile
     * @return boolean
     */
    public static function checkUserIsExist($mobile){
        $row = \Common\Query::selone('user_info', array('mobile'=>$mobile));
        if($row){
            return true;
        }
        return false;
    }
    /**
     * 判断身份证是否存在
     * @param type $id_card
     * @return boolean
     */
    public static function checkIdcardIsExist($id_card){
        $row = \Common\Query::selone('user_info', array('id_card'=>$id_card));
        if($row){
            return true;
        }
        return false;
    }

    /**
     * 检测用户密码是否正确
     * @param type $mobile
     * @param type $pwd
     * @return boolean
     */
    public static function checkUserPwd($mobile,$pwd){
        $row = \Common\Query::selone('user_info', array('mobile'=>$mobile));
        $rand = $row['rand'];
        if(self::renderPassword($rand, $pwd) == $row['pwd']){
            return true;
        }
        return false;
    }

    /**
     * 重设密码
     * @param type $mobile
     * @param type $pwd
     */
    public static function pwdReset($mobile,$pwd){
        if(self::checkUserIsExist($mobile)){
            $updarr['rand'] = rand(100000,999999);
            $updarr['pwd'] = self::renderPassword($updarr['rand'], $pwd);
            $res = \Common\Query::update('user_info', $updarr, array('mobile'=>$mobile));
            if($res){
                return array(1,'设置成功');
            }
            return array(0,'设置失败');
        }
        return array(0,'用户不存在');
    }
    /**
     * 判断用户是否绑定身份信息
     * @param type $uid
     * @return boolean
     */
    public static function checkBindInfo($uid){
        $row = \Model\User\UserInfo::getinfo($uid);
        if(empty($row)){
            return false;
        }
        if(empty($row['true_name']) || empty($row['id_card']) ){
            return false;
        }
        return true;
    }

    /**
     * 绑定身份信息
     * @param type $uid
     * @param type $true_name
     * @param type $id_card
     * @return type
     */
    public static function bindInfo($uid,$true_name,$id_card,$mobile){
       /* if(self::checkIdcardIsExist(\App::t($id_card))){
            return 0;
        }*/
        $user_row = self::getinfo($uid);
//        if($user_row['id_card']){
//            return false;
//        }
        if(!empty($mobile)){
            $updarr['mobile'] = \App::t($mobile);
        }
        $updarr['true_name'] = \App::t($true_name);
        $updarr['id_card'] = \App::t($id_card);
        $res = \Common\Query::update('user_info', $updarr, array('uid'=>$uid));
        if($res){
            //赠送管理费
            $row_count = \Common\Query::sqlselone("select count(fund_id) total from user_fund_record where uid=".$uid." and type=105");
            if(intval($row_count['total']) <=0){
                $params_send = \Model\Admin\Params::get('manage_send');
                Fund::send_sfz($uid, floatval($params_send['sfz'])*100);
            }
        }
        \Model\User\UserInfo::removeCache($uid);
        return $res;
    }
    public static function add($mobile,$password,$true_name='',$id_card=''){
        //注册
        $regarr = array();
        $rand = rand(100000, 999999);
        $regarr['rand'] = $rand;
        $regarr['mobile'] = $mobile;
        $regarr['pwd'] = self::renderPassword($rand, $password);
        $regarr['reg_time'] = time();
        $regarr['reg_ip'] = \App::getonlineip();
        $regarr['randid'] = $mobile;//\App::rand_str(32,1);
        $regarr['reg_domain'] = $_SERVER['HTTP_HOST'];
        $uid = \Common\Query::insert('user_info', $regarr);
        //赠送管理费
        $params_manage_send = \Model\Admin\Params::get( 'manage_send' );
        if(floatval($params_manage_send['regist'])>0){
            Fund::regist($uid, floatval($params_manage_send['regist'])*100);
        }
        return $uid;
    }
    /**
     * 删除用户
     * @param type $uid
     * @return type
     */
    public static function del($uid){
        $updarr['status'] = 3;
        $res = \Common\Query::update('user_info', $updarr, array('uid'=>$uid));
        \Model\User\UserInfo::removeCache($uid);
        return $res;
    }
    /**
     * 冻结用户
     * @param type $uid
     * @return type
     */
    public static function frozen($uid){
        $updarr['status'] = 2;
        $res = \Common\Query::update('user_info', $updarr, array('uid'=>$uid));
        \Model\User\UserInfo::removeCache($uid);
        return $res;
    }
    
    /**
     * 解冻用户
     * @param type $uid
     * @return type
     */
    public static function unfrozen($uid){
        $updarr['status'] = 1;
        $res = \Common\Query::update('user_info', $updarr, array('uid'=>$uid));
        \Model\User\UserInfo::removeCache($uid);
        return $res;
    }

        /**
     * 修改用戶信息
     * @param array $updarr
     * @return type
     */
    public static function modifyUserInfo($updarr){
        $res = \Common\Query::update('user_info', $updarr, array('uid'=>$updarr['uid']));
        \Model\User\UserInfo::removeCache($updarr['uid']);
        return $res;
    }
    
	/**
     * 获取用户总登陆次数
     * @return int
     */
    public static function get_total_logins(){
    	$res = \Common\Query::sqlsel('SELECT COUNT(DISTINCT uid) AS total FROM user_login_logs ');
    	return $res ? $res[0]['total'] : 0;
    }
    
	/**
     * 获取用户总登陆次数
     * @return int
     */
    public static function get_total_user_by_type($type=1){
    	$where = $type==1 ? 'user_recharge_record WHERE status=1' : 'user_withdraw_record WHERE status=2';
    	$res = \Common\Query::sqlsel('SELECT COUNT(DISTINCT uid) AS total FROM '.$where);
    	return $res ? $res[0]['total'] : 0;
    }
    
	/**
     * 获取用户总充值金额
     * @return int
     */
    public static function get_total_money_by_type($type=1){
    	$where = $type==1 ? 'user_recharge_record WHERE status=1' : 'user_withdraw_record WHERE status=2';
    	$res = \Common\Query::sqlsel('SELECT SUM(money) AS total FROM '.$where);
    	return $res ? $res[0]['total'] : 0;
    }
    
	/**
     * 获取总用户数
     * @return int
     */
    public static function get_total_users(){
    	$res = \Common\Query::sqlsel('SELECT COUNT(uid) AS total FROM user_info');
    	return $res ? $res[0]['total'] : 0;
    }
    
	/**
     * 根据条件总用户数
     * @return int
     */
    public static function get_total_users_by_day($day = 1,$where='reg_time',$isday=1){
    	$op = $isday && $day==1 ? '=' : '<=';
    	$by = $isday ? 'DAY' : 'MONTH';
    	$res = \Common\Query::sqlsel('SELECT COUNT(uid) AS total FROM user_info WHERE DATE_SUB(CURDATE(), INTERVAL '.$day.' '.$by.') '.$op.' FROM_UNIXTIME('.$where.',"%Y-%m-%d")');
    	return $res ? $res[0]['total'] : 0;
    }
    
	/**
     * 统计用户资产信息
     * @param type $type
     * @return type
     */
    public static function getTotalByType($type='balance'){
    	$res = \Common\Query::selone('user_info',array() ,array('IFNULL(sum('.$type.'),0) AS total'));
    	return $res ? $res['total'] : array();
    }
    
     /**
     * 返回取款的到账时间 
     * @param int $curr_time
     * @return string
     */
	public static function get_qk_time($curr_time){ 
		$qk_time = date('H:i',$curr_time);
		$str = '次日01：00';
		if($qk_time>='08:00' && $qk_time<'10:00'){
			$str = '14：00';
		}else if($qk_time>='10:00' && $qk_time<'12:00'){
			$str = '16：00';
		}else if($qk_time>='12:00' && $qk_time<'15:30'){
			$str = '19：30';
		}
		return $str;
	}
	
    /**
     * 正在策略中的条数
     * @param type $status
     * @return type
     */
    public static function get_peizi_count($uid){
        $row = \Common\Query::sqlselone('select count(pz_id) total from user_peizi WHERE uid='. intval($uid).' and status in(2,3)');
        return $row ? $row ['total'] : 0;
    }
    
    //判断分组是否存在，true:存在，false:不存在
    public static  function isGroupExist($group_id)
    {
        $group_id=intval($group_id);
    	$res = \Common\Query::sqlsel('SELECT count(uid) num from user_info where group_id='.$group_id );
        if(intval($res[0]['num'])==0)
        {
             return false;
        }
        return true;
    }
    //批量更新分组ID
    public static  function UpdateGroupId($ids,$group_id)
    {
        if(empty($ids) || empty($group_id))
        {
            return array('ret'=>1,'msg'=>'获取参数错误');
        }
        
        $id_arr=explode(',',$ids);
        $data['group_id'] = $group_id;
       
        $res = \Common\Query::update('user_info', $data, array('uid'=>array('in',$id_arr)));

        if($res)
        {
            $result = array('ret'=>0,'msg'=>'批量更新分组成功');
        }
        else
        {
            $result = array('ret'=>1,'msg'=>'批量更新分组失败');
        }
        return $result;
    }
}
