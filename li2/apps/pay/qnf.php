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

class qnf extends \core\Controller {

    //put your code here
    public function bank() {
        parent::view();
        $this->template ( 'bank.php' );
        //$this->template('bank.php');
    }

    public function saoma(){
        include SITEROOT . 'Plugin' . DIRECTORY_SEPARATOR . 'qnf' . DIRECTORY_SEPARATOR . 'config.php';
        
        $pay_type = isset($_GET ['pay_type']) ? \App::t($_GET ['pay_type']) : '';
        $money = isset($_GET ['money']) ? floatval($_GET ['money']) : 0;
        $uid = isset($_GET ['uid']) ? intval($_GET ['uid']) : 0;
        if(empty($uid)){
            $this->fontRedirect('用户未登录，请先登录', \App::URL('web/member/login'), 3);
            exit;
        }
        //添加记录
        $recharge_id = \Model\User\Recharge::add($uid, $money * 100, '全能付'.$pay_type);
        if(!$recharge_id){
            exit('错误');
        }
        $datastring=array(
	    'pay_fs'=>$pay_type,//$pay_fs,//'weixin',//'weixin',//(alipay; qq)
            'pay_MerchantNo'=>$config['jigouhao'],//'7EC887686D677A19',
            'MerchantNo'=>$config['MerchantNo'],//'10000000',
            'pay_orderNo'=> $recharge_id,
            'pay_Amount'=>$money,
            'pay_ProductName'=>'',
            'pay_NotifyUrl'=>$config['domain'].'/paycallback_qnf.php',
            'pay_ewm'=>'No',
            'url_ewm'=>'http://api.qnf99.cn:5051/pay1.0/',
            'key'=>$config['key'],//'DB432A05DD58C09D934C8007B831CB17',
            'tranType'=>"2",
	);
        switch ($datastring['pay_fs']) {
            //代付查询
            case 'cx':
                $str = $datastring['pay_fs'] . "" . $datastring['pay_MerchantNo'] . "" . $datastring['pay_orderNo'] . "" . $datastring['key'];
                $sign = md5($str);
                $data = array(
                    ' pay_fs' => $datastring['pay_fs'],
                    'pay_MerchantNo' => $datastring['MerchantNo'],
                    'pay_orderNo' => $datastring['pay_orderNo'],
                    'sign' => $sign
                );
                break;
            //代付
            case 'df':
                $dfdata = array(
                    'acctName' => '张三',
                    'acctNo' => '622619238107397',
                    'bankName' => '民生银行',
                    'retUrl' => 'http://d.qnf99.cn:5052/cssj/merchantdf/',
                    'bankCode' => 'CMBC'
                );
                $str = $datastring['pay_fs'] . "" . $datastring['pay_MerchantNo'] . "" . $datastring['pay_orderNo'] . "" . $datastring['pay_Amount'] . "" . $dfdata['acctNo'] . "" . $datastring['key'];
                $sign = md5($str);
                $data = array(
                    'pay_fs' => $datastring['pay_fs'],
                    'pay_MerchantNo' => $datastring['MerchantNo'],
                    'pay_orderNo' => $datastring['pay_orderNo'],
                    'pay_Amount' => $datastring['pay_Amount'],
                    'pay_acctName' => $dfdata['acctName'],
                    'pay_acctNo' => $dfdata['acctNo'],
                    'pay_bankName' => $dfdata['bankName'],
                    'pay_bankCode' => $dfdata['bankCode'],
                    'pay_retUrl' => $dfdata['retUrl'],
                    'sign' => $sign
                );
                break;
            //订单查询
            case 'ordercx':
                $str = $datastring['pay_fs'] . "" . $datastring['pay_MerchantNo'] . "" . $datastring['pay_orderNo'] . "" . $datastring['key'];
                $sign = md5($str);
                $data = array(
                    ' pay_fs' => $datastring['pay_fs'],
                    'pay_MerchantNo' => $datastring['MerchantNo'],
                    'pay_orderNo' => $datastring['pay_orderNo'],
                    'sign' => $sign
                );
                break;
            //微信、支付宝、qq支付请求
            default:
                $str = $datastring['pay_fs'] . "" . $datastring['pay_MerchantNo'] . "" . $datastring['pay_orderNo'] . "" . $datastring['pay_Amount'] . "" . $datastring['pay_NotifyUrl'] . "" . $datastring['pay_ewm'] . "" . $datastring['key'];
                $sign = md5($str);
                $data = array(
                    'pay_fs' => $datastring['pay_fs'],
                    'pay_MerchantNo' => $datastring['MerchantNo'],
                    'pay_orderNo' => $datastring['pay_orderNo'],
                    'pay_Amount' => $datastring['pay_Amount'],
                    'pay_ProductName' => $datastring['pay_ProductName'],
                    'pay_NotifyUrl' => $datastring['pay_NotifyUrl'],
                    'pay_ewm' => $datastring['pay_ewm'],
                    'pay_bankName' => "1000", /////////////////////////////////////////////////(支付银行代码)网银支付必填（不参与签名）
                    'pay_returnUrl' => '', /////////////////////////////////////////(是/否必填； 否)
                    'tranType' => $datastring['tranType'],
                    'sign' => $sign
                );
                break;
        }
        //获取结果JSON数据
        $error_msg = '';
        $responseText = $this->ewmpost($datastring['url_ewm'], $data);
        //echo $responseText . "\n\n";exit;
        //解析JSON数据
        $txt = json_decode($responseText);
        if($txt->pay_Status != 100){
            $error_msg = $txt->pay_CodeMsg;
        }
        $qrcode = $txt->pay_Code;
        $this->assign('money',$money);
        $this->assign('error_msg',$error_msg);
        $this->assign('qrcode',$qrcode);
        $this->assign('pay_type',$pay_type);
        $this->template('qrcode.php');
        /* }else{
          echo "请选择收款方式";
          } */
    }
    public function notify(){
        include SITEROOT . 'Plugin' . DIRECTORY_SEPARATOR . 'qnf' . DIRECTORY_SEPARATOR . 'config.php';
        $merchantNo =$_REQUEST['pay_MerchantNo'];
        $pay_orderNo =$_REQUEST['pay_OrderNo'];
        $pay_Amount =$_REQUEST['pay_Amount'];
        $sign = $_REQUEST['sign'];
        $key =$config['key'];
        $sign_string= $merchantNo. $pay_orderNo. $pay_Amount .$key;
        if(md5($sign_string) == $sign){
            $recharge_id = $pay_orderNo;
            //\App::logs('a.txt', $recharge_id);
            \Common\Query::commitstart();
            $res = \Model\User\Fund::recharge($recharge_id);
            if ($res[0] == 1) {
                \Common\Query::commit();
                echo 'success';
                exit;
            } else {
                \Common\Query::rollback();
                echo 'error';
                exit;
            }
        }
        else{
            echo 'error';
            exit;
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
