<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of index
 *
 * @author Administrator
 */

namespace apps\web;

class rechargeBack extends \apps\ViewsControl {

    //易宝
    public function callback_yeepay(){
        include SITEROOT.'Plugin'.DIRECTORY_SEPARATOR.'YeePay'.DIRECTORY_SEPARATOR.'yeepayCommon.php';
        #	只有支付成功时易宝支付才会通知商户.
        ##支付成功回调有两次，都会通知到在线支付请求参数中的p8_Url上：浏览器重定向;服务器点对点通讯.

        #	解析返回参数.
        $return = getCallBackValue($r0_Cmd,$r1_Code,$r2_TrxId,$r3_Amt,$r4_Cur,$r5_Pid,$r6_Order,$r7_Uid,$r8_MP,$r9_BType,$hmac);

        #	判断返回签名是否正确（True/False）
        $bRet = CheckHmac($r0_Cmd,$r1_Code,$r2_TrxId,$r3_Amt,$r4_Cur,$r5_Pid,$r6_Order,$r7_Uid,$r8_MP,$r9_BType,$hmac);
        #	以上代码和变量不需要修改.

        #	校验码正确.
        if($bRet){
                if($r1_Code=="1"){
                #	需要比较返回的金额与商家数据库中订单的金额是否相等，只有相等的情况下才认为是交易成功.
                #	并且需要对返回的处理进行事务控制，进行记录的排它性处理，在接收到支付结果通知后，判断是否进行过业务逻辑处理，不要重复进行业务逻辑处理，防止对同一条交易重复发货的情况发生.      	  	

                        if($r9_BType=="1"){
                            \Common\Query::commitstart();
                            $res = \Model\User\Fund::recharge( $r6_Order);
                            if($res[0]==0){
                                \Common\Query::rollback();
                            }
                            else{
                                \Common\Query::commit();
                            }
                            //var_dump($res);
                            //$this->fontRedirect($res[1], '', 100000);
                            $this->sysRedirect(\App::URL('web/recharge/result_yeepay'));
                        }elseif($r9_BType=="2"){
                            #如果需要应答机制则必须回写流,以success开头,大小写不敏感.
                            \Common\Query::commitstart();
                            $res = \Model\User\Fund::recharge( $r6_Order);
                            if($res[0]==0){
                                \Common\Query::rollback();
                            }
                            else{
                                \Common\Query::commit();
                                echo "success";   	
                            }

                        }
                }

        }else{
                echo "交易信息被篡改";
        }
    }
    //多得宝
    public function paycallback1() {
        include SITEROOT . 'Plugin' . DIRECTORY_SEPARATOR . 'ddbill' . DIRECTORY_SEPARATOR . 'merchant.php';

        $merchant_code = $_POST["merchant_code"];

        $interface_version = $_POST["interface_version"];

        $sign_type = $_POST["sign_type"];

        $dinpaySign = base64_decode($_POST["sign"]);

        $notify_type = $_POST["notify_type"];

        $notify_id = $_POST["notify_id"];

        $order_no = $_POST["order_no"];

        $order_time = $_POST["order_time"];

        $order_amount = $_POST["order_amount"];

        $trade_status = $_POST["trade_status"];

        $trade_time = $_POST["trade_time"];

        $trade_no = $_POST["trade_no"];

        $bank_seq_no = $_POST["bank_seq_no"];

        $extra_return_param = $_POST["extra_return_param"];



        /////////////////////////////   参数组装  /////////////////////////////////
        /**
          除了sign_type dinpaySign参数，其他非空参数都要参与组装，组装顺序是按照a~z的顺序，下划线"_"优先于字母
         */
        $signStr = "";

        if ($bank_seq_no != "") {
            $signStr = $signStr . "bank_seq_no=" . $bank_seq_no . "&";
        }

        if ($extra_return_param != "") {
            $signStr = $signStr . "extra_return_param=" . $extra_return_param . "&";
        }

        $signStr = $signStr . "interface_version=" . $interface_version . "&";

        $signStr = $signStr . "merchant_code=" . $merchant_code . "&";

        $signStr = $signStr . "notify_id=" . $notify_id . "&";

        $signStr = $signStr . "notify_type=" . $notify_type . "&";

        $signStr = $signStr . "order_amount=" . $order_amount . "&";

        $signStr = $signStr . "order_no=" . $order_no . "&";

        $signStr = $signStr . "order_time=" . $order_time . "&";

        $signStr = $signStr . "trade_no=" . $trade_no . "&";

        $signStr = $signStr . "trade_status=" . $trade_status . "&";

        $signStr = $signStr . "trade_time=" . $trade_time;

        //echo $signStr;
        /////////////////////////////   RSA-S验证  /////////////////////////////////


        $ddbill_public_key = openssl_get_publickey($ddbill_public_key);

        $flag = openssl_verify($signStr, $dinpaySign, $ddbill_public_key, OPENSSL_ALGO_MD5);

        $result = "";

        if ($flag == true) {
            $recharge_id = $order_no;
            //\App::logs('a.txt', $recharge_id);
            \Common\Query::commitstart();
            $res = \Model\User\Fund::recharge($recharge_id);
            if ($res[0] == 1) {
                \Common\Query::commit();
                $result = "deposit successful";
            } else {
                \Common\Query::rollback();
                $result = "deposit failed";
            }
        } else {

            $result = "deposit failed";
        }
    }
    
    //智通宝
    public function paycallback_ztbao() {
        include SITEROOT . 'Plugin' . DIRECTORY_SEPARATOR . 'ztbao' . DIRECTORY_SEPARATOR . 'merchant.php';

        $merchant_code = $_POST["merchant_code"];

        $interface_version = $_POST["interface_version"];

        $sign_type = $_POST["sign_type"];

        $dinpaySign = base64_decode($_POST["sign"]);

        $notify_type = $_POST["notify_type"];

        $notify_id = $_POST["notify_id"];

        $order_no = $_POST["order_no"];

        $order_time = $_POST["order_time"];

        $order_amount = $_POST["order_amount"];

        $trade_status = $_POST["trade_status"];

        $trade_time = $_POST["trade_time"];

        $trade_no = $_POST["trade_no"];

        $bank_seq_no = $_POST["bank_seq_no"];

        $extra_return_param = $_POST["extra_return_param"];



        /////////////////////////////   参数组装  /////////////////////////////////
        /**
          除了sign_type dinpaySign参数，其他非空参数都要参与组装，组装顺序是按照a~z的顺序，下划线"_"优先于字母
         */
        $signStr = "";

        if ($bank_seq_no != "") {
            $signStr = $signStr . "bank_seq_no=" . $bank_seq_no . "&";
        }

        if ($extra_return_param != "") {
            $signStr = $signStr . "extra_return_param=" . $extra_return_param . "&";
        }

        $signStr = $signStr . "interface_version=" . $interface_version . "&";

        $signStr = $signStr . "merchant_code=" . $merchant_code . "&";

        $signStr = $signStr . "notify_id=" . $notify_id . "&";

        $signStr = $signStr . "notify_type=" . $notify_type . "&";

        $signStr = $signStr . "order_amount=" . $order_amount . "&";

        $signStr = $signStr . "order_no=" . $order_no . "&";

        $signStr = $signStr . "order_time=" . $order_time . "&";

        $signStr = $signStr . "trade_no=" . $trade_no . "&";

        $signStr = $signStr . "trade_status=" . $trade_status . "&";

        $signStr = $signStr . "trade_time=" . $trade_time;

        //echo $signStr;
        /////////////////////////////   RSA-S验证  /////////////////////////////////


        $dinpay_public_key = openssl_get_publickey($dinpay_public_key);

        $flag = openssl_verify($signStr, $dinpaySign, $dinpay_public_key, OPENSSL_ALGO_MD5);

        $result = "";

        if ($flag == true) {
            $recharge_id = $order_no;
            //\App::logs('a.txt', $recharge_id);
            \Common\Query::commitstart();
            $res = \Model\User\Fund::recharge($recharge_id);
            if ($res[0] == 1) {
                \Common\Query::commit();
                $result = "SUCCESS";
            } else {
                \Common\Query::rollback();
                $result = "Verification Error";
            }
        } else {
            $result = "Verification Error";
        }
        echo $result;
    }

    //多得宝微信
    public function paycallbackwx() {
        include_once(SITEROOT . 'Plugin/ddbill/merchant.php');

        $merchant_code = $_POST["merchant_code"];

        $interface_version = $_POST["interface_version"];

        $sign_type = $_POST["sign_type"];

        $dinpaySign = base64_decode($_POST["sign"]);

        $notify_type = $_POST["notify_type"];

        $notify_id = $_POST["notify_id"];

        $order_no = $_POST["order_no"];

        $order_time = $_POST["order_time"];

        $order_amount = $_POST["order_amount"];

        $trade_status = $_POST["trade_status"];

        $trade_time = $_POST["trade_time"];

        $trade_no = $_POST["trade_no"];

        $bank_seq_no = $_POST["bank_seq_no"];

        $extra_return_param = $_POST["extra_return_param"];


        /////////////////////////////   参数组装  /////////////////////////////////
        /** 	
          除了sign_type dinpaySign参数，其他非空参数都要参与组装，组装顺序是按照a~z的顺序，下划线"_"优先于字母
         */
        $signStr = "";

        if ($bank_seq_no != "") {
            $signStr = $signStr . "bank_seq_no=" . $bank_seq_no . "&";
        }

        if ($extra_return_param != "") {
            $signStr = $signStr . "extra_return_param=" . $extra_return_param . "&";
        }

        $signStr = $signStr . "interface_version=" . $interface_version . "&";

        $signStr = $signStr . "merchant_code=" . $merchant_code . "&";

        $signStr = $signStr . "notify_id=" . $notify_id . "&";

        $signStr = $signStr . "notify_type=" . $notify_type . "&";

        $signStr = $signStr . "order_amount=" . $order_amount . "&";

        $signStr = $signStr . "order_no=" . $order_no . "&";

        $signStr = $signStr . "order_time=" . $order_time . "&";

        $signStr = $signStr . "trade_no=" . $trade_no . "&";

        $signStr = $signStr . "trade_status=" . $trade_status . "&";

        $signStr = $signStr . "trade_time=" . $trade_time;

        //echo $signStr;
        /////////////////////////////   RSA-S验证  /////////////////////////////////


        $ddbill_public_key = openssl_get_publickey($ddbill_public_key);

        $flag = openssl_verify($signStr, $dinpaySign, $ddbill_public_key, OPENSSL_ALGO_MD5);

        ///////////////////////////   响应“SUCCESS” /////////////////////////////

        if ($flag) {
            $recharge_id = $order_no;
            //\App::logs('a.txt', $recharge_id);
            \Common\Query::commitstart();
            $res = \Model\User\Fund::recharge($recharge_id);
            if ($res[0] == 1) {
                \Common\Query::commit();
                echo"SUCCESS";
            } else {
                \Common\Query::rollback();
                echo"Verification Error";
            }
        } else {
            echo"Verification Error";
        }
    }

    //中信微信
    public function paycallbackwx2() {
        require(SITEROOT . 'Plugin/mbupay_wx/Utils.class.php');
        require(SITEROOT . 'Plugin/mbupay_wx/config/config.php');
        require(SITEROOT . 'Plugin/mbupay_wx/class/RequestHandler.class.php');
        require(SITEROOT . 'Plugin/mbupay_wx/class/ClientResponseHandler.class.php');
        require(SITEROOT . 'Plugin/mbupay_wx/class/PayHttpClient.class.php');
        $xml = file_get_contents('php://input');
        $resHandler = new \ClientResponseHandler();
        $cfg = new \Config();

        //file_put_contents('1.txt',$xml);//检测是否执行callback方法，如果执行，会生成1.txt文件，且文件中的内容就是通知参数
        $resHandler->setContent($xml);

        //\App::logs('a.txt', $resHandler->getAllParameters());
        $resHandler->setKey($cfg->C('key'));
        if ($resHandler->isTenpaySign()) {

            if ($resHandler->getParameter('status') == 0 && $resHandler->getParameter('result_code') == 0) {
                //校验单号和金额是否一致，更改订单状态等业务处理
                $recharge_id = $resHandler->getParameter('out_trade_no');
                //\App::logs('a.txt', $recharge_id);
                \Common\Query::commitstart();
                $res = \Model\User\Fund::recharge($recharge_id);
                if ($res[0] == 1) {
                    \Common\Query::commit();
                    echo 'success';
                } else {
                    \Common\Query::rollback();
                    echo 'failure1';
                }
                //\Utils::dataRecodes('接口回调收到通知参数',$resHandler->getAllParameters());
                //file_put_contents('2.txt',1);//如果生成2.txt,说明前一步的输出success是有执行
                exit();
            } else {
                echo 'failure1';
                exit();
            }
        } else {
            echo 'failure2';
        }
    }

    //多得宝支付宝
    public function paycallbackzfb() {
        include_once(SITEROOT . 'Plugin/ddbill/merchant.php');

        $merchant_code = $_POST["merchant_code"];

        $interface_version = $_POST["interface_version"];

        $sign_type = $_POST["sign_type"];

        $dinpaySign = base64_decode($_POST["sign"]);

        $notify_type = $_POST["notify_type"];

        $notify_id = $_POST["notify_id"];

        $order_no = $_POST["order_no"];

        $order_time = $_POST["order_time"];

        $order_amount = $_POST["order_amount"];

        $trade_status = $_POST["trade_status"];

        $trade_time = $_POST["trade_time"];

        $trade_no = $_POST["trade_no"];

        $bank_seq_no = $_POST["bank_seq_no"];

        $extra_return_param = $_POST["extra_return_param"];


        /////////////////////////////   参数组装  /////////////////////////////////
        /** 	
          除了sign_type dinpaySign参数，其他非空参数都要参与组装，组装顺序是按照a~z的顺序，下划线"_"优先于字母
         */
        $signStr = "";

        if ($bank_seq_no != "") {
            $signStr = $signStr . "bank_seq_no=" . $bank_seq_no . "&";
        }

        if ($extra_return_param != "") {
            $signStr = $signStr . "extra_return_param=" . $extra_return_param . "&";
        }

        $signStr = $signStr . "interface_version=" . $interface_version . "&";

        $signStr = $signStr . "merchant_code=" . $merchant_code . "&";

        $signStr = $signStr . "notify_id=" . $notify_id . "&";

        $signStr = $signStr . "notify_type=" . $notify_type . "&";

        $signStr = $signStr . "order_amount=" . $order_amount . "&";

        $signStr = $signStr . "order_no=" . $order_no . "&";

        $signStr = $signStr . "order_time=" . $order_time . "&";

        $signStr = $signStr . "trade_no=" . $trade_no . "&";

        $signStr = $signStr . "trade_status=" . $trade_status . "&";

        $signStr = $signStr . "trade_time=" . $trade_time;

        //echo $signStr;
        /////////////////////////////   RSA-S验证  /////////////////////////////////


        $ddbill_public_key = openssl_get_publickey($ddbill_public_key);

        $flag = openssl_verify($signStr, $dinpaySign, $ddbill_public_key, OPENSSL_ALGO_MD5);

        ///////////////////////////   响应“SUCCESS” /////////////////////////////

        if ($flag) {
            $recharge_id = $order_no;
            //\App::logs('a.txt', $recharge_id);
            \Common\Query::commitstart();
            $res = \Model\User\Fund::recharge($recharge_id);
            if ($res[0] == 1) {
                \Common\Query::commit();
                echo"SUCCESS";
            } else {
                \Common\Query::rollback();
                echo"Verification Error";
            }
        } else {
            echo"Verification Error";
        }
    }
    //中信支付宝
    public function paycallbackzfb2() {
        require(SITEROOT . 'Plugin/mbupay_zfb/Utils.class.php');
        require(SITEROOT . 'Plugin/mbupay_zfb/config/config.php');
        require(SITEROOT . 'Plugin/mbupay_zfb/class/RequestHandler.class.php');
        require(SITEROOT . 'Plugin/mbupay_zfb/class/ClientResponseHandler.class.php');
        require(SITEROOT . 'Plugin/mbupay_zfb/class/PayHttpClient.class.php');
        $xml = file_get_contents('php://input');
        $resHandler = new \ClientResponseHandler();
        $cfg = new \Config();

        //file_put_contents('1.txt',$xml);//检测是否执行callback方法，如果执行，会生成1.txt文件，且文件中的内容就是通知参数
        $resHandler->setContent($xml);

        //\App::logs('a.txt', $resHandler->getAllParameters());
        $resHandler->setKey($cfg->C('key'));
        if ($resHandler->isTenpaySign()) {

            if ($resHandler->getParameter('status') == 0 && $resHandler->getParameter('result_code') == 0) {
                //校验单号和金额是否一致，更改订单状态等业务处理
                $recharge_id = $resHandler->getParameter('out_trade_no');
                //\App::logs('a.txt', $recharge_id);
                \Common\Query::commitstart();
                $res = \Model\User\Fund::recharge($recharge_id);
                if ($res[0] == 1) {
                    \Common\Query::commit();
                    echo 'success';
                } else {
                    \Common\Query::rollback();
                    echo 'failure1';
                }
                //\Utils::dataRecodes('接口回调收到通知参数',$resHandler->getAllParameters());
                //file_put_contents('2.txt',1);//如果生成2.txt,说明前一步的输出success是有执行
                exit();
            } else {
                echo 'failure1';
                exit();
            }
        } else {
            echo 'failure2';
        }
    }

    public function success() {
        $this->setTitle('支付结果—' . SITE_NAME);

        $this->template('success.php');
    }

}
