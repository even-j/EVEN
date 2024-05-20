<?php

/*
 * 金米支付宝支付
 */

/**
 * Description of index
 *
 * @author Administrator
 */

namespace apps\pay;

class jinm_zfb extends \core\Controller {

    //put your code here
    public function bank() {
        parent::view();
        $this->template('bank.php');
        //$this->template('bank.php');
    }

    public function saoma() {
        $money = isset($_GET ['money']) ? floatval($_GET ['money']) : 0;
        $uid = isset($_GET ['uid']) ? intval($_GET ['uid']) : 0;
        if (empty($uid)) {
            $this->fontRedirect('用户未登录，请先登录', \App::URL('web/member/login'), 3);
            exit;
        }
        if ($money < 10 ) {
            exit('最小交易金额为10元');
        }
        //添加记录
        $recharge_id = \Model\User\Recharge::add($uid, $money * 100, '金米支付宝支付' . $pay_type);
        if (!$recharge_id) {
            exit('错误');
        }

        $payset = \Model\Pay\PaySet::getSet('jinm_zfb');
        $skey = $payset['skey']; //秘钥
        $merchant_no = $payset['sid']; //商户号
        $merchant_req_no = $recharge_id;//请求订单编号
        $order_amt = $money * 100; //交易金额;单位：分
        $bg_url = $payset['domain'] . '/paycallback_jinm.php'; //交易结束时候的通知地址（后台）
        $return_url = $payset['domain'] . '/index.php?app=pay&mod=pub&ac=result_ewm'; //交易结束时候的通知地址（前台页面）
        $biz_code = '1'; //支付宝wap支付业务代码为“1”定值
        $payer_ip = \App::getonlineip();
        $subject='2';
        $sign_str = 'bg_url=' . $bg_url . '&biz_code=' . $biz_code . '&merchant_no=' . $merchant_no . '&merchant_req_no=' . $merchant_req_no . '&order_amt=' . $order_amt . '&payer_ip=' . $payer_ip .'&return_url='.$return_url.'&subject='.$subject. '&' . $skey;
        $sign = strtoupper(md5($sign_str));

        $var['merchant_no'] = $merchant_no;
        $var['merchant_req_no'] = $merchant_req_no;
        $var['order_amt'] = $order_amt;
        $var['bg_url'] = $bg_url;
        $var['return_url'] = $return_url;
        $var['biz_code'] = $biz_code;
        $var['payer_ip'] = $payer_ip;
        $var['sign'] = $sign;
        $var['subject']=$subject;
        $this->assign('var', $var);
        
        $this->template('saoma.php');
    }

    public function notify() {
        \App::logs('b.txt', $_REQUEST);
        $payset = \Model\Pay\PaySet::getSet('jinm_zfb');
        $skey = $payset['skey']; //秘钥
        $rsp_code = $_POST['rsp_code']; //状态码
        $rsp_msg = $_POST['rsp_msg']; //状态描述
        $merchant_req_no = $_POST['merchant_req_no']; //商户请求订单编号
        $merchant_rate = $_POST['merchant_rate']; //费率
        $order_amt = $_POST['order_amt']; //订单交易金额
        $biz_code = $_POST['biz_code']; //业务代码
        $state = $_POST['state']; //交易状态
        $sign = $_POST['sign']; //签名
        $mysign = strtoupper(md5('biz_code=' . $biz_code . '&merchant_rate=' . $merchant_rate . '&merchant_req_no=' . $merchant_req_no . '&order_amt=' . $order_amt .'&rsp_code=' . $rsp_code . '&rsp_msg=' . $rsp_msg . '&state=' . $state . '&' . $skey));

        if ($sign == $mysign) {
            if ($state == '0') {
                $recharge_id = $merchant_req_no;
                $sql = 'select money from user_recharge_record where recharge_id='. intval($recharge_id);
                $recharge_row = \Common\Query::sqlselone($sql);
                if($recharge_row && intval($recharge_row['money'])== intval(order_amt)) 
                {
                    \Common\Query::commitstart();
                    $res = \Model\User\Fund::recharge($recharge_id);
                    if ($res[0] == 1) {
                        \Common\Query::commit();
                        echo 'SUCCESS';
                    } else {
                        \Common\Query::rollback();
                        echo 'fail';
                    }
                }
                else {
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
