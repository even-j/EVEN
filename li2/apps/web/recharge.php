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

class recharge extends \apps\ViewsControl {

    //充值
    public function dorecharge() {
        include SITEROOT . 'Plugin' . DIRECTORY_SEPARATOR . 'ddbill' . DIRECTORY_SEPARATOR . 'merchant.php';
        $money = isset($_POST ['p3_Amt']) ? floatval($_POST ['p3_Amt']) : '';
        $uid = isset($_POST ['uid']) ? intval($_POST ['uid']) : '';

        if(empty($uid)){
            $this->fontRedirect('用户未登录，请先登录', \App::URL('web/member/login'), 3);
            exit;
        }
        //添加记录
        $res = \Model\User\Recharge::add($uid, $money * 100, '多的宝');
        if ($res) {
            /*             *
             * 功能：多的宝网银支付接口
             * 版本：3.0
             * 日期：2017-04-19
             * 说明：
             * 以下代码只是为了方便商户测试而提供的样例代码，商户可以根据自己网站的需要，按照技术文档编写,
             * 并非一定要使用该代码。该代码仅供学习和研究接口使用，仅为提供一个参考。
             * */

            ///////////////////////////  初始化接口参数  //////////////////////////////
            /**
              接口参数请参考多的宝网银支付文档，除了sign参数，其他参数都要在这里初始化
             */
            $var['merchant_code'] = "1000500416"; //商户号，1111110166是测试商户号，线上发布时要更换商家自己的商户号！

            $var['service_type'] = "direct_pay";

            $var['interface_version'] = "V3.0";

            $var['sign_type'] = "RSA-S";

            $var['input_charset'] = "UTF-8";

            $var['notify_url'] =  'http://pay.autoamrb.com.cn/paycallback1.php';;
            ;

            $var['order_no'] = $res;

            $var['order_time'] = date('Y-m-d H:i:s');

            $var['order_amount'] = $money;

            $var['product_name'] = "百姓";

            //以下参数为可选参数，如有需要，可参考文档设定参数值

            $var['return_url'] = DOMAIN . \App::URL('web/user/fund');

            $var['pay_type'] = "";

            $var['redo_flag'] = "";

            $var['product_code'] = "";

            $var['product_desc'] = "";

            $var['product_num'] = "";

            $var['show_url'] = "";

            $var['client_ip'] = "";

            $var['bank_code'] = "";

            $var['extend_param'] = "";

            $var['extra_return_param'] = "";




            /////////////////////////////   参数组装  /////////////////////////////////
            /**
              除了sign_type参数，其他非空参数都要参与组装，组装顺序是按照a~z的顺序，下划线"_"优先于字母
             */
            $var['signStr'] = "";

            if ($var['bank_code'] != "") {
                $var['signStr'] = $var['signStr'] . "bank_code=" . $var['bank_code'] . "&";
            }
            if ($var['client_ip'] != "") {
                $var['signStr'] = $var['signStr'] . "client_ip=" . $var['client_ip'] . "&";
            }
            if ($var['extend_param'] != "") {
                $var['signStr'] = $var['signStr'] . "extend_param=" . $var['extend_param'] . "&";
            }
            if ($var['extra_return_param'] != "") {
                $var['signStr'] = $var['signStr'] . "extra_return_param=" . $var['extra_return_param'] . "&";
            }

            $var['signStr'] = $var['signStr'] . "input_charset=" . $var['input_charset'] . "&";
            $var['signStr'] = $var['signStr'] . "interface_version=" . $var['interface_version'] . "&";
            $var['signStr'] = $var['signStr'] . "merchant_code=" . $var['merchant_code'] . "&";
            $var['signStr'] = $var['signStr'] . "notify_url=" . $var['notify_url'] . "&";
            $var['signStr'] = $var['signStr'] . "order_amount=" . $var['order_amount'] . "&";
            $var['signStr'] = $var['signStr'] . "order_no=" . $var['order_no'] . "&";
            $var['signStr'] = $var['signStr'] . "order_time=" . $var['order_time'] . "&";

            if ($var['pay_type'] != "") {
                $var['signStr'] = $var['signStr'] . "pay_type=" . $var['pay_type'] . "&";
            }

            if ($var['product_code'] != "") {
                $var['signStr'] = $var['signStr'] . "product_code=" . $var['product_code'] . "&";
            }
            if ($var['product_desc'] != "") {
                $var['signStr'] = $var['signStr'] . "product_desc=" . $var['product_desc'] . "&";
            }

            $var['signStr'] = $var['signStr'] . "product_name=" . $var['product_name'] . "&";

            if ($var['product_num'] != "") {
                $var['signStr'] = $var['signStr'] . "product_num=" . $var['product_num'] . "&";
            }
            if ($var['redo_flag'] != "") {
                $var['signStr'] = $var['signStr'] . "redo_flag=" . $var['redo_flag'] . "&";
            }
            if ($var['return_url'] != "") {
                $var['signStr'] = $var['signStr'] . "return_url=" . $var['return_url'] . "&";
            }

            $var['signStr'] = $var['signStr'] . "service_type=" . $var['service_type'];

            if ($var['show_url'] != "") {

                $var['signStr'] = $var['signStr'] . "&show_url=" . $var['show_url'];
            }

            //echo $var['signStr."<br>";  
            /////////////////////////////   获取sign值（RSA-S加密）  /////////////////////////////////

            $var['merchant_private_key'] = openssl_get_privatekey($merchant_private_key);

            openssl_sign($var['signStr'], $var['sign_info'], $var['merchant_private_key'], OPENSSL_ALGO_MD5);

            $var['sign'] = base64_encode($var['sign_info']);

            // echo $sign;
        }

        $this->assign('var', $var);
        $this->template('dorecharge.php');
    }
    
    public function dorecharge_ztbao() {
        include SITEROOT . 'Plugin' . DIRECTORY_SEPARATOR . 'ztbao' . DIRECTORY_SEPARATOR . 'merchant.php';
        $money = isset($_POST ['p3_Amt']) ? floatval($_POST ['p3_Amt']) : '';
        $uid = isset($_POST ['uid']) ? intval($_POST ['uid']) : '';

        if(empty($uid)){
            $this->fontRedirect('用户未登录，请先登录', \App::URL('web/member/login'), 3);
            exit;
        }
        //添加记录
        $res = \Model\User\Recharge::add($uid, $money * 100, '智通宝');
        if ($res) {
            $var['merchant_code'] = "100158888387"; //商户号，1111110166是测试商户号，线上发布时要更换商家自己的商户号！

            $var['service_type'] = "direct_pay";

            $var['interface_version'] = "V3.0";

            $var['sign_type'] = "RSA-S";

            $var['input_charset'] = "UTF-8";

            $var['notify_url'] =  'http://pay.qhqyl.top/paycallback_ztbao.php';;
            ;

            $var['order_no'] = $res;

            $var['order_time'] = date('Y-m-d H:i:s');

            $var['order_amount'] = $money;

            $var['product_name'] = "零柒";

            //以下参数为可选参数，如有需要，可参考文档设定参数值

            $var['return_url'] = DOMAIN . \App::URL('web/user/fund');

            $var['pay_type'] = "";

            $var['redo_flag'] = "";

            $var['product_code'] = "";

            $var['product_desc'] = "";

            $var['product_num'] = "";

            $var['show_url'] = "";

            $var['client_ip'] = "";

            $var['bank_code'] = "";

            $var['extend_param'] = "";

            $var['extra_return_param'] = "";




            /////////////////////////////   参数组装  /////////////////////////////////
            /**
              除了sign_type参数，其他非空参数都要参与组装，组装顺序是按照a~z的顺序，下划线"_"优先于字母
             */
            $var['signStr'] = "";

            if ($var['bank_code'] != "") {
                $var['signStr'] = $var['signStr'] . "bank_code=" . $var['bank_code'] . "&";
            }
            if ($var['client_ip'] != "") {
                $var['signStr'] = $var['signStr'] . "client_ip=" . $var['client_ip'] . "&";
            }
            if ($var['extend_param'] != "") {
                $var['signStr'] = $var['signStr'] . "extend_param=" . $var['extend_param'] . "&";
            }
            if ($var['extra_return_param'] != "") {
                $var['signStr'] = $var['signStr'] . "extra_return_param=" . $var['extra_return_param'] . "&";
            }

            $var['signStr'] = $var['signStr'] . "input_charset=" . $var['input_charset'] . "&";
            $var['signStr'] = $var['signStr'] . "interface_version=" . $var['interface_version'] . "&";
            $var['signStr'] = $var['signStr'] . "merchant_code=" . $var['merchant_code'] . "&";
            $var['signStr'] = $var['signStr'] . "notify_url=" . $var['notify_url'] . "&";
            $var['signStr'] = $var['signStr'] . "order_amount=" . $var['order_amount'] . "&";
            $var['signStr'] = $var['signStr'] . "order_no=" . $var['order_no'] . "&";
            $var['signStr'] = $var['signStr'] . "order_time=" . $var['order_time'] . "&";

            if ($var['pay_type'] != "") {
                $var['signStr'] = $var['signStr'] . "pay_type=" . $var['pay_type'] . "&";
            }

            if ($var['product_code'] != "") {
                $var['signStr'] = $var['signStr'] . "product_code=" . $var['product_code'] . "&";
            }
            if ($var['product_desc'] != "") {
                $var['signStr'] = $var['signStr'] . "product_desc=" . $var['product_desc'] . "&";
            }

            $var['signStr'] = $var['signStr'] . "product_name=" . $var['product_name'] . "&";

            if ($var['product_num'] != "") {
                $var['signStr'] = $var['signStr'] . "product_num=" . $var['product_num'] . "&";
            }
            if ($var['redo_flag'] != "") {
                $var['signStr'] = $var['signStr'] . "redo_flag=" . $var['redo_flag'] . "&";
            }
            if ($var['return_url'] != "") {
                $var['signStr'] = $var['signStr'] . "return_url=" . $var['return_url'] . "&";
            }

            $var['signStr'] = $var['signStr'] . "service_type=" . $var['service_type'];

            if ($var['show_url'] != "") {

                $var['signStr'] = $var['signStr'] . "&show_url=" . $var['show_url'];
            }

            //echo $var['signStr."<br>";  
            /////////////////////////////   获取sign值（RSA-S加密）  /////////////////////////////////

            $var['merchant_private_key'] = openssl_get_privatekey($merchant_private_key);

            openssl_sign($var['signStr'], $var['sign_info'], $var['merchant_private_key'], OPENSSL_ALGO_MD5);

            $var['sign'] = base64_encode($var['sign_info']);

            // echo $sign;
        }

        $this->assign('var', $var);
        $this->template('dorecharge_ztbao.php');
    }

    public function dorecharge_yeepay() {
		header("Content-type:text/html;charset=gb2312");
            include SITEROOT.'Plugin'.DIRECTORY_SEPARATOR.'YeePay'.DIRECTORY_SEPARATOR.'yeepayCommon.php';
            $this->setTitle ( '用户充值—'.iconv('UTF-8', 'gb2312', SITE_NAME) );
            $money = isset ( $_POST ['p3_Amt'] ) ? floatval ( $_POST ['p3_Amt'] ) : '';
            $uid = isset ( $_POST ['uid'] ) ? intval ( $_POST ['uid'] ) : '';

			//添加记录
			$res = \Model\User\Recharge::add($uid,$money*100,'易宝');
			if($res){

				#	商家设置用户购买商品的支付信息.
				##易宝支付平台统一使用GBK/GB2312编码方式,参数如用到中文，请注意转码

				# 业务类型
				# 支付请求，固定值"Buy"
				$var['p0_Cmd'] = $p0_Cmd;
				
				#	商户编号p1_MerId,以及密钥merchantKey 需要从易宝支付平台获得
				$var['p1_MerId'] = $p1_MerId;
				
				#	商户订单号,选填.
				##若不为""，提交的订单号必须在自身账户交易中唯一;为""时，易宝支付会自动生成随机的商户订单号.
				$var['p2_Order'] = $res;

				#	支付金额,必填.
				##单位:元，精确到分.
				$var['p3_Amt'] = $money;

				#	交易币种,固定值"CNY".
				$var['p4_Cur'] = "CNY";

				#	商品名称
				##用于支付时显示在易宝支付网关左侧的订单产品信息.
				$var['p5_Pid'] = ''.iconv('UTF-8', 'gb2312', SITE_NAME);
				//$var['p5_Pid'] = mb_convert_encoding(iconv('UTF-8', 'gb2312', SITE_NAME),"UTF-8","GB2312");

				#	商品种类
				$var['p6_Pcat'] = iconv('UTF-8', 'gb2312', '充值');

				#	商品描述
				$var['p7_Pdesc'] = iconv('UTF-8', 'gb2312', SITE_NAME).$var['p6_Pcat'];

				#	商户接收支付成功数据的地址,支付成功后易宝支付会向该地址发送两次成功通知.
				$var['p8_Url'] = 'http://pay3.tonl44.top/index.php?app=web&mod=rechargeBack&ac=callback_yeepay';	
				#	送货地址
				# 为"1": 需要用户将送货地址留在易宝支付系统;为"0": 不需要，默认为 "0".
				$var['p9_SAF'] = "0";

				#	商户扩展信息
				##商户可以任意填写1K 的字符串,支付成功时将原样返回.	
				$data['money'] = $money;
				$data['uid'] = $uid;
				$var['pa_MP'] = '';//json_encode($data);

				#	支付通道编码
				##默认为""，到易宝支付网关.若不需显示易宝支付的页面，直接跳转到各银行、神州行支付、骏网一卡通等支付页面，该字段可依照附录:银行列表设置参数值.			
				$var['pd_FrpId'] = '';//isset ( $_POST ['pd_FrpId'] ) ? $_POST ['pd_FrpId'] : '';

				#	应答机制
				##默认为"1": 需要应答机制;
				$var['pr_NeedResponse'] = "1";

				#调用签名函数生成签名串
				$var['hmac'] = getReqHmacString($var['p0_Cmd'],$var['p2_Order'],$var['p3_Amt'],$var['p4_Cur'],$var['p5_Pid'],$var['p6_Pcat'],$var['p7_Pdesc'],$var['p8_Url'],$var['p9_SAF'],$var['pa_MP'],$var['pd_FrpId'],$var['pr_NeedResponse']);
			}
            $this->assign ( 'reqURL_onLine', $reqURL_onLine );
            $this->assign ( 'var', $var );
            $this->template ( 'dorecharge_yeepay.php' );
	}
    public function dorecharge_xinqidian() {
        $pay_xinqidian = \apps\Config::getInstance()->pay_xinqidian;
        $this->setTitle('用户充值');
        $money = isset($_POST ['p3_Amt']) ? floatval($_POST ['p3_Amt']) : '';
        $bank = isset($_POST ['pd_FrpId']) ? $_POST ['pd_FrpId'] : '';
        $uid = isset($_POST ['uid']) ? intval($_POST ['uid']) : '';
        //添加记录
        $recharge_id = \Model\User\Recharge::add($uid, $money * 100, '新起点');


        $P_UserId = $pay_xinqidian['uid'];
        $SalfStr = $pay_xinqidian['key'];
        $P_CardId = ''; //卡号：
        $P_CardPass = ''; //卡密：
        $P_FaceValue = $money; //支付金额
        $P_ChannelId = 1; //充值类别：1银行，2-支付宝充值，3-财付通充值
        $P_Subject = '华亿策略'; //产品名称
        $P_Price = $money; //产品价格
        $P_Quantity = 1; //购买数量：
        $P_Description = $bank; //产品描述：
        $P_Notic = $recharge_id; //自定义信息：
        $P_Result_url = "http://www.dzpeizi.com/paycallback1.php"; //回调地址
        $P_Notify_url = "http://www.dzpeizi.com/payback1.php";
        ; //跳转地址

        $P_OrderId = $recharge_id;
        $preEncodeStr = $P_UserId . "|" . $P_OrderId . "|" . $P_CardId . "|" . $P_CardPass . "|" . $P_FaceValue . "|" . $P_ChannelId . "|" . $SalfStr;

        $P_PostKey = md5($preEncodeStr);

        $params = "P_UserId=" . $P_UserId;
        $params .= "&P_OrderId=" . $P_OrderId;
        $params .= "&P_CardId=" . $P_CardId;
        $params .= "&P_CardPass=" . $P_CardPass;
        $params .= "&P_FaceValue=" . $P_FaceValue;
        $params .= "&P_ChannelId=" . $P_ChannelId;
        $params .= "&P_Subject=" . $P_Subject;
        $params .= "&P_Price=" . $P_Price;
        $params .= "&P_Quantity=" . $P_Quantity;
        $params .= "&P_Description=" . $P_Description;
        $params .= "&P_Notic=" . $P_Notic;
        $params .= "&P_Result_url=" . $P_Result_url;
        $params .= "&P_Notify_url=" . $P_Notify_url;
        $params .= "&P_PostKey=" . $P_PostKey;

        //在这里对订单进行入库保存
        //下面这句是提交到API
        $gateWary = 'http://www.xqd100000.com/pay/bank/up.aspx';
        header("location:$gateWary?$params");
    }
    public function recharge_weixin() {
        $this->setTitle('充值');
        $var['money'] = isset($_POST ['p3_Amt']) ? floatval($_POST ['p3_Amt']) : '';
        $var['uid'] = isset($_POST ['uid']) ? intval($_POST ['uid']) : '';
        $this->assign("var",$var);
        $this->template("recharge_weixin.php");
    }
    public function dorecharge_weixin() {
        $this->setTitle('用户充值');
        $money = isset($_REQUEST ['p3_Amt']) ? floatval($_REQUEST ['p3_Amt']) : '';
        $uid = isset($_REQUEST ['uid']) ? intval($_REQUEST ['uid']) : '';
        if(empty($uid)){
            $this->fontRedirect('用户未登录，请先登录', \App::URL('web/member/login'), 3);
            exit;
        }
        //添加记录
        $recharge_id = \Model\User\Recharge::add($uid, $money * 100, '微信');
        if(empty($recharge_id)){
            echo '充值错误';
            exit;
        }
        include (SITEROOT . 'Plugin/ddbill/phpqrcode.php');
        /*         *
         * 功能：多的宝微信 支付宝通用扫码支付接口
         * 版本：3.0
         * 日期：2017-04-19
         * 说明：
         * 以下代码只是为了方便商户测试而提供的样例代码，商户可以根据自己网站的需要，按照技术文档编写,
         * 并非一定要使用该代码。该代码仅供学习和研究接口使用，仅为提供一个参考。
         * */


///////////////////////////  初始化接口参数  //////////////////////////////
        /**
          接口参数请参考多的宝微信支付文档，除了sign参数，其他参数都要在这里初始化
         */
        include_once(SITEROOT . 'Plugin/ddbill/merchant.php');

        $merchant_code = "1000500416"; //商户号，1111110166是测试商户号，调试时要更换商家自己的商户号 1000500416

        $service_type = "weixin_scan"; //微信：weixin_scan 支付宝：alipay_scan

        $notify_url =  'http://pay.autoamrb.com.cn/paycallbackwx.php';

        $interface_version = "V3.1";

        $client_ip = '127.0.0.1';

        $sign_type = "RSA-S";

        $order_no = $recharge_id;

        $order_time = date('Y-m-d H:i:s');

        $order_amount = $money;

        $product_name = 'peizi';

        $product_code = "";

        $product_num = "";

        $product_desc = "";

        $extra_return_param = "";

        $extend_param = "";

/////////////////////////////   参数组装  /////////////////////////////////
        /**
          除了sign_type dinpaySign参数，其他非空参数都要参与组装，组装顺序是按照a~z的顺序，下划线"_"优先于字母
         */
        $signStr = "";

        $signStr = $signStr . "client_ip=" . $client_ip . "&";

        if ($extend_param != "") {
            $signStr = $signStr . "extend_param=" . $extend_param . "&";
        }

        if ($extra_return_param != "") {
            $signStr = $signStr . "extra_return_param=" . $extra_return_param . "&";
        }

        $signStr = $signStr . "interface_version=" . $interface_version . "&";

        $signStr = $signStr . "merchant_code=" . $merchant_code . "&";

        $signStr = $signStr . "notify_url=" . $notify_url . "&";

        $signStr = $signStr . "order_amount=" . $order_amount . "&";

        $signStr = $signStr . "order_no=" . $order_no . "&";

        $signStr = $signStr . "order_time=" . $order_time . "&";

        if ($product_code != "") {
            $signStr = $signStr . "product_code=" . $product_code . "&";
        }

        if ($product_desc != "") {
            $signStr = $signStr . "product_desc=" . $product_desc . "&";
        }

        $signStr = $signStr . "product_name=" . $product_name . "&";

        if ($product_num != "") {
            $signStr = $signStr . "product_num=" . $product_num . "&";
        }

        $signStr = $signStr . "service_type=" . $service_type;

/////////////////////////////   RSA-S签名  /////////////////////////////////
/////////////////////////////////初始化商户私钥//////////////////////////////////////


        $merchant_private_key = openssl_get_privatekey($merchant_private_key);

        openssl_sign($signStr, $sign_info, $merchant_private_key, OPENSSL_ALGO_MD5);

        $sign = base64_encode($sign_info);

/////////////////////////  提交参数到多的宝扫码支付网关  ////////////////////////

        /**
          curl方法提交支付参数到智付微信网关https://api.ddbill.com/gateway/api/weixin，并且获取返回值
         */
        $postdata = array('extend_param' => $extend_param,
            'extra_return_param' => $extra_return_param,
            'product_code' => $product_code,
            'product_desc' => $product_desc,
            'product_num' => $product_num,
            'merchant_code' => $merchant_code,
            'service_type' => $service_type,
            'notify_url' => $notify_url,
            'interface_version' => $interface_version,
            'sign_type' => $sign_type,
            'order_no' => $order_no,
            'client_ip' => $client_ip,
            'sign' => $sign,
            'order_time' => $order_time,
            'order_amount' => $order_amount,
            'product_name' => $product_name);


        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://api.ddbill.com/gateway/api/scanpay");
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HEADER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($postdata));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $response = curl_exec($ch);
        curl_close($ch);    
        
        //echo $response;
        //$res=simplexml_load_string($response);
        if(empty($response)){
            $res = array('status'=>500,'msg'=>'请求失败');
        }
        else{
            $xml = simplexml_load_string($response);
            $qrcode = $xml->response->qrcode;//这里返回的依然是个SimpleXMLElement对象
            $qrcode = (string)$qrcode;
            $result_code = $xml->response->result_code;
            $result_code = (string)$result_code;
            $result_desc = $xml->response->result_desc;
            $result_desc = (string)$result_desc;
            if($result_code == 0){
                $res = array('status'=>0,'msg'=>'请求成功','code_url'=>$qrcode);
            }
            else{
                $res = array('status'=>500,'msg'=>$result_desc);
            }
        }


        
//        $login = (string) $xml->login;//在做数据比较时，注意要先强制转换
//        print_r($login);



        /////////////////////////////   获取qrcode，并生成二维码  /////////////////////
        /**
          解析智付返回参数，获取qrcode的值，并且根据这个值生成二维码
         */
        //$resp_code=$res->response->resp_code;
        //	if($resp_code=="SUCCESS"){
        //	$qrcode=$res->response->qrcode;
        //	echo $qrcode;





        /** if(file_exists('qrcode.png')){

          unlink('qrcode.png');
          }
          $pic="qrcode.png";

          $errorCorrectionLevel = 'L';

          $matrixPointSize = 10;

          QRcode::png ( $qrcode, $pic, $errorCorrectionLevel, $matrixPointSize, 2 );

          echo "扫描微信二维支付："."<br>"."<img src=$pic>"; * */
        //	}
        //var_dump($res);
        $this->assign("res", $res);
        $this->assign("money", $money);
        $this->assign('recharge_id', $recharge_id);
        $this->template('dorecharge_weixin.php');
    }

    public function dorecharge_weixin2() {
        require(SITEROOT . 'Plugin/mbupay_wx/Utils.class.php');
        require(SITEROOT . 'Plugin/mbupay_wx/config/config.php');
        require(SITEROOT . 'Plugin/mbupay_wx/class/RequestHandler.class.php');
        require(SITEROOT . 'Plugin/mbupay_wx/class/ClientResponseHandler.class.php');
        require(SITEROOT . 'Plugin/mbupay_wx/class/PayHttpClient.class.php');
        $this->setTitle('用户充值');
        $money = isset($_POST ['p3_Amt']) ? floatval($_POST ['p3_Amt']) : '';
        $uid = isset($_POST ['uid']) ? intval($_POST ['uid']) : '';
        //添加记录
        $recharge_id = \Model\User\Recharge::add($uid, $money * 100, '微信');

        $reqHandler = new \RequestHandler();
        $cfg = new \Config();
        $reqHandler->setParameter('method', 'mbupay.wxpay.native'); //接口类型
        $reqHandler->setParameter('appid', $cfg->C('appid')); //必填项，商户号，由平台分配�
        $reqHandler->setParameter('mch_id', $cfg->C('mchId')); //必填项，商户号，由平台分配�
        $reqHandler->setParameter('version', $cfg->C('version'));
        //$reqHandler->setParameter('op_shop_id','1314');
        $reqHandler->setParameter('body', '百姓支付');
        $reqHandler->setParameter('total_fee', $money * 100);
        $reqHandler->setParameter('out_trade_no', $recharge_id);
        //$reqHandler->setParameter('op_device_id','东风一号');
        $reqHandler->setParameter('limit_pay', 'no_credit');
        //this->reqHandler->setParameter('goods_tag','1fds');
        //$reqHandler->setParameter('groupno','8111100093');
        //通知地址，必填项，接收平台通知的URL，需给绝对路径，255字符内格式如:http://wap.tenpay.com/tenpay.asp
        //$notify_url = 'http://'.$_SERVER['HTTP_HOST'];
        //$reqHandler->setParameter('notify_url',$notify_url.'/payInterface/request.php?method=callback');
        $reqHandler->setParameter('notify_url', $cfg->C('notify_url'));
        $reqHandler->setParameter('nonce_str', mt_rand(time(), time() + rand())); //随机字符串，必填项，不长于 32 位
        $reqHandler->setKey($cfg->C('key'));
        $reqHandler->createSign(); //创建签名
        $data = \Utils::toXml($reqHandler->getAllParameters());
        //var_dump($reqHandler->getAllParameters());

        $pay = new \PayHttpClient();
        $resHandler = new \ClientResponseHandler();
        $pay->setReqContent($reqHandler->getGateURL(), $data);
        if ($pay->call()) {
            $resHandler->setContent($pay->getResContent());
            $resHandler->setKey($reqHandler->getKey());
            //var_dump($resHandler->getAllParameters());
            if ($resHandler->isTenpaySign()) {
                //当返回状态与业务结果都为0时才返回支付二维码，其它结果请查看接口文档
                if ($resHandler->getParameter('status') == 0 && $resHandler->getParameter('result_code') == 0) {
                    $res = array('code_img_url' => $resHandler->getParameter('code_img_url'),
                        'code_url' => $resHandler->getParameter('code_url'),
                        'code_status' => $resHandler->getParameter('code_status'));
                } else {
                    $res = array('status' => 500, 'msg' => 'Error Code:' . $resHandler->getParameter('err_code') . ' Error Message:' . $resHandler->getParameter('err_msg'));
                }
            }
            //$res = array('status'=>500,'msg'=>'Error Code:'.$resHandler->getParameter('status').' Error Message:'.$resHandler->getParameter('message'));
        } else {
            $res = array('status' => 500, 'msg' => 'Response Code:' . $pay->getResponseCode() . ' Error Info:' . $pay->getErrInfo());
        }
        //var_dump($res);
        $this->assign("res", $res);
        $this->assign("money", $money);
        $this->assign('recharge_id', $recharge_id);
        $this->template('dorecharge_weixin2.php');
    }

    public function qrcode() {
        require_once SITEROOT . 'Plugin/phpqrcode/phpqrcode.php';
        $text = $_GET['text'];
        \QRcode::png($text, false, QR_ECLEVEL_L, 10);
    }

    public function recharge_alipay() {
        $this->setTitle('充值');
        $var['money'] = isset($_POST ['p3_Amt']) ? floatval($_POST ['p3_Amt']) : '';
        $var['uid'] = isset($_POST ['uid']) ? intval($_POST ['uid']) : '';
        $this->assign("var",$var);
        $this->template("recharge_alipay.php");
    }
    public function dorecharge_alipay() {
        $this->setTitle('用户充值');
        $money = isset($_REQUEST ['p3_Amt']) ? floatval($_REQUEST ['p3_Amt']) : '';
        $uid = isset($_REQUEST ['uid']) ? intval($_REQUEST ['uid']) : '';
        if(empty($uid)){
            $this->fontRedirect('用户未登录，请先登录', \App::URL('web/member/login'), 3);
            exit;
        }
        //添加记录
        $recharge_id = \Model\User\Recharge::add($uid, $money * 100, '支付宝');
        if(empty($recharge_id)){
            echo '充值错误';
            exit;
        }
        include (SITEROOT . 'Plugin/ddbill/phpqrcode.php');
        /*         *
         * 功能：多的宝微信 支付宝通用扫码支付接口
         * 版本：3.0
         * 日期：2017-04-19
         * 说明：
         * 以下代码只是为了方便商户测试而提供的样例代码，商户可以根据自己网站的需要，按照技术文档编写,
         * 并非一定要使用该代码。该代码仅供学习和研究接口使用，仅为提供一个参考。
         * */


///////////////////////////  初始化接口参数  //////////////////////////////
        /**
          接口参数请参考多的宝微信支付文档，除了sign参数，其他参数都要在这里初始化
         */
        include_once(SITEROOT . 'Plugin/ddbill/merchant.php');

        $merchant_code = "1000500416"; //商户号，1111110166是测试商户号，调试时要更换商家自己的商户号 1000500416

        $service_type = "alipay_scan"; //微信：weixin_scan 支付宝：alipay_scan

        $notify_url =  'http://pay.autoamrb.com.cn/paycallbackzfb.php';

        $interface_version = "V3.1";

        $client_ip = '127.0.0.1';

        $sign_type = "RSA-S";

        $order_no = $recharge_id;

        $order_time = date('Y-m-d H:i:s');

        $order_amount = $money;

        $product_name = 'peizi';

        $product_code = "";

        $product_num = "";

        $product_desc = "";

        $extra_return_param = "";

        $extend_param = "";

/////////////////////////////   参数组装  /////////////////////////////////
        /**
          除了sign_type dinpaySign参数，其他非空参数都要参与组装，组装顺序是按照a~z的顺序，下划线"_"优先于字母
         */
        $signStr = "";

        $signStr = $signStr . "client_ip=" . $client_ip . "&";

        if ($extend_param != "") {
            $signStr = $signStr . "extend_param=" . $extend_param . "&";
        }

        if ($extra_return_param != "") {
            $signStr = $signStr . "extra_return_param=" . $extra_return_param . "&";
        }

        $signStr = $signStr . "interface_version=" . $interface_version . "&";

        $signStr = $signStr . "merchant_code=" . $merchant_code . "&";

        $signStr = $signStr . "notify_url=" . $notify_url . "&";

        $signStr = $signStr . "order_amount=" . $order_amount . "&";

        $signStr = $signStr . "order_no=" . $order_no . "&";

        $signStr = $signStr . "order_time=" . $order_time . "&";

        if ($product_code != "") {
            $signStr = $signStr . "product_code=" . $product_code . "&";
        }

        if ($product_desc != "") {
            $signStr = $signStr . "product_desc=" . $product_desc . "&";
        }

        $signStr = $signStr . "product_name=" . $product_name . "&";

        if ($product_num != "") {
            $signStr = $signStr . "product_num=" . $product_num . "&";
        }

        $signStr = $signStr . "service_type=" . $service_type;

/////////////////////////////   RSA-S签名  /////////////////////////////////
/////////////////////////////////初始化商户私钥//////////////////////////////////////


        $merchant_private_key = openssl_get_privatekey($merchant_private_key);

        openssl_sign($signStr, $sign_info, $merchant_private_key, OPENSSL_ALGO_MD5);

        $sign = base64_encode($sign_info);

/////////////////////////  提交参数到多的宝扫码支付网关  ////////////////////////

        /**
          curl方法提交支付参数到智付微信网关https://api.ddbill.com/gateway/api/weixin，并且获取返回值
         */
        $postdata = array('extend_param' => $extend_param,
            'extra_return_param' => $extra_return_param,
            'product_code' => $product_code,
            'product_desc' => $product_desc,
            'product_num' => $product_num,
            'merchant_code' => $merchant_code,
            'service_type' => $service_type,
            'notify_url' => $notify_url,
            'interface_version' => $interface_version,
            'sign_type' => $sign_type,
            'order_no' => $order_no,
            'client_ip' => $client_ip,
            'sign' => $sign,
            'order_time' => $order_time,
            'order_amount' => $order_amount,
            'product_name' => $product_name);


        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://api.ddbill.com/gateway/api/scanpay");
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HEADER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($postdata));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $response = curl_exec($ch);
        curl_close($ch);    
        
        //echo $response;
        //$res=simplexml_load_string($response);
        if(empty($response)){
            $res = array('status'=>500,'msg'=>'请求失败');
        }
        else{
            $xml = simplexml_load_string($response);
            $qrcode = $xml->response->qrcode;//这里返回的依然是个SimpleXMLElement对象
            $qrcode = (string)$qrcode;
            $result_code = $xml->response->result_code;
            $result_code = (string)$result_code;
            $result_desc = $xml->response->result_desc;
            $result_desc = (string)$result_desc;
            if($result_code == 0){
                $res = array('status'=>0,'msg'=>'请求成功','code_url'=>$qrcode);
            }
            else{
                $res = array('status'=>500,'msg'=>$result_desc);
            }
        }


        
//        $login = (string) $xml->login;//在做数据比较时，注意要先强制转换
//        print_r($login);



        /////////////////////////////   获取qrcode，并生成二维码  /////////////////////
        /**
          解析智付返回参数，获取qrcode的值，并且根据这个值生成二维码
         */
        //$resp_code=$res->response->resp_code;
        //	if($resp_code=="SUCCESS"){
        //	$qrcode=$res->response->qrcode;
        //	echo $qrcode;





        /** if(file_exists('qrcode.png')){

          unlink('qrcode.png');
          }
          $pic="qrcode.png";

          $errorCorrectionLevel = 'L';

          $matrixPointSize = 10;

          QRcode::png ( $qrcode, $pic, $errorCorrectionLevel, $matrixPointSize, 2 );

          echo "扫描微信二维支付："."<br>"."<img src=$pic>"; * */
        //	}
        //var_dump($res);
        $this->assign("res", $res);
        $this->assign("money", $money);
        $this->assign('recharge_id', $recharge_id);
        $this->template('dorecharge_alipay.php');
    }

    public function dorecharge_alipay2() {
        require(SITEROOT . 'Plugin/mbupay_zfb/Utils.class.php');
        require(SITEROOT . 'Plugin/mbupay_zfb/config/config.php');
        require(SITEROOT . 'Plugin/mbupay_zfb/class/RequestHandler.class.php');
        require(SITEROOT . 'Plugin/mbupay_zfb/class/ClientResponseHandler.class.php');
        require(SITEROOT . 'Plugin/mbupay_zfb/class/PayHttpClient.class.php');
        $this->setTitle('用户充值');
        $money = isset($_POST ['p3_Amt']) ? floatval($_POST ['p3_Amt']) : '';
        $uid = isset($_POST ['uid']) ? intval($_POST ['uid']) : '';
        //添加记录
        $recharge_id = \Model\User\Recharge::add($uid, $money * 100, '支付宝');

        $reqHandler = new \RequestHandler();
        $cfg = new \Config();
        $reqHandler->setParameter('method', 'mbupay.alipay.native'); //接口类型
        $reqHandler->setParameter('appid', $cfg->C('appid')); //必填项，商户号，由平台分配�
        $reqHandler->setParameter('mch_id', $cfg->C('mchId')); //必填项，商户号，由平台分配�
        $reqHandler->setParameter('version', $cfg->C('version'));
        //$reqHandler->setParameter('op_shop_id','1314');
        $reqHandler->setParameter('body', '百姓支付');
        $reqHandler->setParameter('total_fee', $money * 100);
        $reqHandler->setParameter('out_trade_no', $recharge_id);
        //$reqHandler->setParameter('op_device_id','东风一号');
        $reqHandler->setParameter('limit_pay', 'no_credit');
        //this->reqHandler->setParameter('goods_tag','1fds');
        //$reqHandler->setParameter('groupno','8111100093');
        //通知地址，必填项，接收平台通知的URL，需给绝对路径，255字符内格式如:http://wap.tenpay.com/tenpay.asp
        //$notify_url = 'http://'.$_SERVER['HTTP_HOST'];
        //$reqHandler->setParameter('notify_url',$notify_url.'/payInterface/request.php?method=callback');
        $reqHandler->setParameter('notify_url', $cfg->C('notify_url'));
        $reqHandler->setParameter('nonce_str', mt_rand(time(), time() + rand())); //随机字符串，必填项，不长于 32 位
        $reqHandler->setKey($cfg->C('key'));
        $reqHandler->createSign(); //创建签名
        $data = \Utils::toXml($reqHandler->getAllParameters());
        //var_dump($reqHandler->getAllParameters());

        $pay = new \PayHttpClient();
        $resHandler = new \ClientResponseHandler();
        $pay->setReqContent($reqHandler->getGateURL(), $data);
        if ($pay->call()) {
            $resHandler->setContent($pay->getResContent());
            $resHandler->setKey($reqHandler->getKey());
            //var_dump($resHandler->getAllParameters());
            if ($resHandler->isTenpaySign()) {
                //当返回状态与业务结果都为0时才返回支付二维码，其它结果请查看接口文档
                if ($resHandler->getParameter('status') == 0 && $resHandler->getParameter('result_code') == 0) {
                    $res = array('code_img_url' => $resHandler->getParameter('code_img_url'),
                        'code_url' => $resHandler->getParameter('code_url'),
                        'code_status' => $resHandler->getParameter('code_status'));
                } else {
                    $res = array('status' => 500, 'msg' => 'Error Code:' . $resHandler->getParameter('err_code') . ' Error Message:' . $resHandler->getParameter('err_msg'));
                }
            }
            //$res = array('status'=>500,'msg'=>'Error Code:'.$resHandler->getParameter('status').' Error Message:'.$resHandler->getParameter('message'));
        } else {
            $res = array('status' => 500, 'msg' => 'Response Code:' . $pay->getResponseCode() . ' Error Info:' . $pay->getErrInfo());
        }
        //var_dump($res);
        $this->assign("res", $res);
        $this->assign("money", $money);
        $this->assign('recharge_id', $recharge_id);
        $this->template('dorecharge_alipay2.php');
    }

    public function is_recharge_success() {
        $recharge_id = isset($_POST ['recharge_id']) ? intval($_POST ['recharge_id']) : '';
        $row = \Common\Query::selone("user_recharge_record", array("recharge_id" => $recharge_id));
        if ($row && $row['status'] == 1) {
            echo json_encode(array('code' => 1));
        } else {
            echo json_encode(array('code' => 0));
        }
    }

    //用户银行卡实名认证
    public function doShiming() {
        header("Content-type:text/html;charset=gb2312");
        include SITEROOT . 'Plugin' . DIRECTORY_SEPARATOR . 'YeePay' . DIRECTORY_SEPARATOR . 'yeepayCommon.php';
        if ($_POST) {
            $rz_user = $this->user;
            $p0_Cmd = 'FastRealNameAuth';
            $name = iconv('UTF-8', 'GB2312', $rz_user['true_name']);
            $idCardNumber = $rz_user['id_card'];
            $bankCardNumber = isset($_POST['card_no']) ? preg_replace('/[\s]/', '', \App::t($_POST ['card_no'])) : '';
            $bankName = isset($_POST['bank_name']) ? iconv('UTF-8', 'GB2312', $_POST['bank_name']) : '';
            $bankCode = isset($_POST['bank_code']) ? $_POST['bank_code'] : '';
            $province = isset($_POST['province_name']) ? iconv('UTF-8', 'GB2312', $_POST['province_name']) : '';
            $city = isset($_POST['city_name']) ? iconv('UTF-8', 'GB2312', $_POST['city_name']) : '';
            $pattern = '1';
            $res_desc = '';
            $busId = '';

            #调用签名函数生成签名串
            $hmac = getShimingHmacString($p0_Cmd, $p1_MerId, $name, $idCardNumber, $bankCode, $bankCardNumber, $bankName, $province, $city, $pattern, $res_desc, $busId);
            $post_data['p0_Cmd'] = $p0_Cmd;
            $post_data['customerId'] = $p1_MerId;
            $post_data['name'] = $name;
            $post_data['idCardNumber'] = $idCardNumber;
            $post_data['bankCode'] = $bankCode;
            $post_data['bankCardNumber'] = $bankCardNumber;
            $post_data['bankName'] = $bankName;
            $post_data['province'] = $province;
            $post_data['city'] = $city;
            $post_data['pattern'] = $pattern;
            $post_data['res_desc'] = $res_desc;
            $post_data['busId'] = $busId;
            $post_data['hmac'] = $hmac;
            $url_param = '';
            foreach ($post_data as $key => $val) {
                $url_param .= ($key == 'hmac' ? $key . '=' . $val : $key . '=' . $val . '&');
            }
            //exit(json_encode($post_data));
            //echo $url_param;
            $return = file_get_contents($shimingURL_onLine . '?' . $url_param);
            $arr = array_filter(explode('=', $return));
            $res = \App::t(str_replace('pattern', '', $arr[5]));
            if ($res != 'SUCCESS') {
                logstr($return);
            }
            exit($res);
        }
    }

    public function dorecharge_offline() {
        $money = isset($_POST['p3_Amt']) ? floatval($_POST['p3_Amt']) * 100 : 0;
        $uid = $this->uid;//isset($_POST ['uid']) ? intval($_POST ['uid']) : '';
        $channel = isset($_POST ['channel']) ? $_POST ['channel'] : '';
        $name = isset($_POST ['name']) ? $_POST ['name'] : '';
        if(empty($money)){
            if(\App::isMobile()){
                exit(json_encode(array('code'=>0,'msg'=>'转账金额不能为空')));
            }
            else{
                $this->sysRedirect(\App::URL('web/recharge/result', array('msg' => '转账金额不能为空')));
            }
        }
        if(empty($name)){
            if(\App::isMobile()){
                exit(json_encode(array('code'=>0,'msg'=>'付款账号不能为空')));
            }
            else{
                $this->sysRedirect(\App::URL('web/recharge/result', array('msg' => '付款账号不能为空')));
            }
        }
        \Common\Query::commitstart();
        $recharge_id = \Model\User\RechargeOffline::add($uid, $money,$name,$channel);
        if (!$recharge_id) {
            \Common\Query::rollback();
            if(\App::isMobile()){
                exit(json_encode(array('code'=>0,'msg'=>'提交失败！')));
            }
            else{
                $this->sysRedirect(\App::URL('web/recharge/result', array('msg' => '充值申请提交失败')));
            }
        }
        \Common\Query::commit();
        if(\App::isMobile()){
            exit(json_encode(array('code'=>1,'msg'=>'提交成功，后台正在处理，请稍候！')));
        }
        else{
            $this->sysRedirect(\App::URL('web/recharge/result', array('msg' => '充值申请提交成功，请等待客服人员处理。')));
        }
    }

    public function result() {
        $this->template('result.php');
    }

    public function result_yeepay() {
        $this->template('result_yeepay.php');
    }

}
