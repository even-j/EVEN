<?php

/*
 * 全能付
 */

/**
 * Description of index
 *
 * @author Administrator
 */

namespace apps\pay;

class gwmwii_zfb extends \core\Controller {

    //put your code here
    public function bank() {
        parent::view();
        $this->template ( 'bank.php' );
        //$this->template('bank.php');
    }

    public function saoma(){
        
        
        
        $money = isset($_GET ['money']) ? floatval($_GET ['money']) : 0;
        $uid = isset($_GET ['uid']) ? intval($_GET ['uid']) : 0;
        if(empty($uid)){
            $this->fontRedirect('用户未登录，请先登录', \App::URL('web/member/login'), 3);
            exit;
        }
        //添加记录
        $recharge_id = \Model\User\Recharge::add($uid, $money * 100, '利赢支付宝'.$pay_type);
        if(!$recharge_id){
            exit('错误');
        }
        
        $payset = \Model\Pay\PaySet::getSet('gwmwii_zfb');
        $version = '1.0';
        $customerid=$payset['sid'];
        $sdorderno=$recharge_id;
        $total_fee=number_format($money,2,'.','');
        $paytype='alipay';
        $bankcode='';
        $notifyurl=$payset['domain'].'/paycallback_gwmwii.php';
        $returnurl=$payset['domain'].'/index.php?app=pay&mod=pub&ac=result_ewm';
        $remark='';
        $get_code=0;
        $userkey = $payset['skey'];

        $sign_str = 'version='.$version.'&customerid='.$customerid.'&total_fee='.$total_fee.'&sdorderno='.$sdorderno.'&notifyurl='.$notifyurl.'&returnurl='.$returnurl.'&'.$userkey;
        $sign=md5($sign_str);

        $var['version'] = $version;
        $var['customerid'] = $customerid;
        $var['sdorderno'] = $sdorderno;
        $var['total_fee'] = $total_fee;
        $var['paytype'] = $paytype;
        $var['notifyurl'] = $notifyurl;
        $var['returnurl'] = $returnurl;
        $var['remark'] = $remark;
        $var['bankcode'] = $bankcode;
        $var['sign'] = $sign;
        $var['get_code'] = $get_code;

        $this->assign('var',$var);
        $this->template('saoma.php');
        /* }else{
          echo "请选择收款方式";
          } */
    }
    public function notify(){
        $payset = \Model\Pay\PaySet::getSet('gwmwii_zfb');
        $userkey = $payset['skey'];
        $status=$_POST['status'];
        $customerid=$_POST['customerid'];
        $sdorderno=$_POST['sdorderno'];
        $total_fee=$_POST['total_fee'];
        $paytype=$_POST['paytype'];
        $sdpayno=$_POST['sdpayno'];
        $remark=$_POST['remark'];
        $sign=$_POST['sign'];

        $mysign=md5('customerid='.$customerid.'&status='.$status.'&sdpayno='.$sdpayno.'&sdorderno='.$sdorderno.'&total_fee='.$total_fee.'&paytype='.$paytype.'&'.$userkey);

        if($sign==$mysign){
            if($status=='1'){
                $recharge_id = $sdorderno;
                \Common\Query::commitstart();
                $res = \Model\User\Fund::recharge($recharge_id);
                if ($res[0] == 1) {
                    \Common\Query::commit();
                    echo 'success';
                } else {
                    \Common\Query::rollback();
                    echo 'fail';
                }
            } else {
                echo 'fail';
            }
        } else {
            echo 'signerr';
        }
    } 
    
    function ewmpost($url_ewm, $data) {
        $ch = curl_init($url_ewm);
        $header = array('apikey: safepay',);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        $responseTextt = curl_exec($ch);
        return $responseTextt;
    }

    /** 获取当前时间戳，精确到毫秒 */
    function microtime_float() {
        list($usec, $sec) = explode(" ", microtime());
        return ((float) $usec + (float) $sec);
    }

    /** 格式化时间戳，精确到毫秒，x代表毫秒 */
    function microtime_format($tag, $time) {
        list($usec, $sec) = explode(".", $time);
        $date = date($tag, $usec);
        return str_replace('x', $sec, $date);
    }

    function getMillisecond() {
        list($s1, $s2) = explode(' ', microtime());
        return (float) sprintf('%.0f', (floatval($s1) + floatval($s2)) * 1000);
    }

     function verifyString($data) {
        ksort($data);
        unset($data['sign']);
        $arr = array();
        foreach ($data AS $k => $v) {
            if ($k != 'sign') {
                $arr[] = $k . "=" . $v;
            }
        }

        return implode("&", $arr);
    }

}
