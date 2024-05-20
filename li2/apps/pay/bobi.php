<?php


/**
 * Description of index
 *
 * @author Administrator
 */

namespace apps\pay;

class bobi extends \core\Controller {


    public function saoma() {
        $money = isset($_GET ['money']) ? floatval($_GET ['money']) : 0;
        $uid = isset($_GET ['uid']) ? intval($_GET ['uid']) : 0;
        if (empty($uid)) {
            $this->fontRedirect('用户未登录，请先登录', \App::URL('web/member/login'), 3);
            exit;
        }
        if ($money < 10 ) {
            //exit('最小交易金额为10元');
        }

        //添加记录
        $order_id = 'Z' . date('YmdHis').$uid . rand(100,999);
        $recharge_id = \Model\User\Recharge::add($uid, $money*100, '波币钱包',$order_id );
        if (!$recharge_id) {
            exit('错误');
        }
        $payset = \Model\Pay\PaySet::getSet('bobi');
        $skey = $payset['skey']; //秘钥
        $bg_url = $payset['domain'] . '/paycallback_bobi.php'; //交易结束时候的通知地址（后台）

        $var['currency_id'] = 1;
        $var['money'] = $money;
        $var['callback_url'] = $bg_url;
        $var['cp_order_id'] = $order_id;
        $var['show_name'] = $order_id;
        $var['mch_id'] = $payset['sid'];
        $var['time'] = time();
        ksort($var);
        $str='';
        foreach ( $var as $k=> $v){
            $str .= $k.'='.$v.'&';
        }
        $sign_str = $str.'pri_key=' . $skey;
        $sign = strtolower(md5($sign_str));
        $var['sign'] = $sign;
        $url ='https://gateway.bbpayapp.com/bobi_api/pay_independent';

        $options = array(
            'http' => array(
                'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
                'method'  => 'POST',
                'content' => http_build_query($var)
            )
        );
        \App::logs(date('Y-m-d').'bb.txt', $var);
        $context  = stream_context_create($options);
        $result = file_get_contents($url, false, $context);
        \App::logs(date('Y-m-d').'bb.txt', $result);
        $data= json_decode($result, true);

        // $data =$this->post($url, $var);

        if($data['code']==0 && $data['pay_url']){
            header("Location: ".$data['pay_url']);
            die;
        }else{
            die('支付失败');
        }
    }

    public function notify() {
        \App::logs(date('Y-m-d').'bb.txt', $_REQUEST);
        \App::logs(date('Y-m-d').'bb.txt', json_encode($_REQUEST));
        $payset = \Model\Pay\PaySet::getSet('bobi');
        $key = $payset['skey']; //秘钥
        $data = array(
                'cp_order_id' => $_POST['cp_order_id'] ,
                'mch_id' => $_POST['mch_id'] ,
                'sign' => $_POST['sign'] ,
                'msg' => $_POST['msg'],
                'status' => $_POST['status'],
                'money' => $_POST['money'] ,
            );

            // 商户号校验
            if ($data['mch_id'] != $payset['sid']) {
                die('商户号不匹配');
            }

            // 支付签名用支付密钥  提现签用提现密钥
            $sign = $this->make_sign($data, $key);
            // 验证签名
            if ($sign != $data['sign']) {
                //die('验签失败');
            }

            if ($data['status'] == '1') {
                $recharge_id = $data['cp_order_id'];
                $sql = "select money,recharge_id from user_recharge_record where order_id= '". $recharge_id."'";
                $recharge_row = \Common\Query::sqlselone($sql);
                if($recharge_row && intval($recharge_row['money']/100)== $data['money'])
                {
                    $recharge_id =$recharge_row['recharge_id'];
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

    }

    function make_sign( $data,  $key)
    {
        ksort($data);
        $sign_str = '';
        foreach ($data as $pk => $pv) {
            if ($pk == 'sign') {
                continue;
            }
            $sign_str .= "{$pk}={$pv}&";
        }
        $sign_str .= "pri_key={$key}";

        return md5($sign_str);
    }

    public static function post($url, $data)
    {
        $headers = array(
            'Content-Type: application/x-www-form-urlencoded',
        );
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
        curl_setopt($ch, CURLOPT_TIMEOUT, 20);
        $output = curl_exec($ch);
        curl_close($ch);
        print_r($data);
        print_r($output);

        return json_decode($output, true);
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

    public function auto_create111() {

        $skey = 'ebec010935cbbb58b4360ac49abb0dc0'; //秘钥
        $bg_url = '/paycallback_bobi.php'; //交易结束时候的通知地址（后台）

        $var['currency_id'] = 1;
        $var['money'] = 20;
        $var['callback_url'] = $bg_url;
        $var['cp_order_id'] = time();
        $var['show_name'] = time();
        $var['mch_id'] = 10994;
        $var['time'] = time();
        ksort($var);
        $str='';
        foreach ( $var as $k=> $v){
            $str .= $k.'='.$v.'&';
        }
        $sign_str = $str.'pri_key=' . $skey;
        $sign = strtolower(md5($sign_str));
        $var['sign'] = $sign;
        $url ='https://gateway.bbpayapp.com/bobi_api/pay_independent';

        $data =$this->post1($url, $var);;
        print_r($data)  . "\n\n";exit;
    }

    public static function post1($url, $data)
    {
        $headers = array(
            'Content-Type: application/x-www-form-urlencoded',
        );
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
        curl_setopt($ch, CURLOPT_TIMEOUT, 20);
        curl_setopt($ch, CURLOPT_HEADER, 1);
        print_r($data);
        $output = curl_exec($ch);
        curl_close($ch);
        echo $url;
        print_r($output);

        return json_decode($output, true);
    }


}
