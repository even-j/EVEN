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

class swiftpass extends \core\Controller {

    public function saoma(){
        require(SITEROOT . 'Plugin/swiftpass/Utils.class.php');
        require(SITEROOT . 'Plugin/swiftpass/config/config.php');
        require(SITEROOT . 'Plugin/swiftpass/class/RequestHandler.class.php');
        require(SITEROOT . 'Plugin/swiftpass/class/ClientResponseHandler.class.php');
        require(SITEROOT . 'Plugin/swiftpass/class/PayHttpClient.class.php');
        
        $money = isset($_GET ['money']) ? floatval($_GET ['money']) : 0;
        $uid = isset($_GET ['uid']) ? intval($_GET ['uid']) : 0;
        if(empty($uid)){
            $this->fontRedirect('用户未登录，请先登录', \App::URL('web/member/login'), 3);
            exit;
        }
        $code = isset($_GET ['code']) ? \App::t($_GET ['code']) : '';
        $payset = \Model\Pay\PaySet::getSet($code);
        $pay_type = $payset['pay_type']=="pay.weixin.native"?'微信':'支付宝';
        //添加记录
        $recharge_id = \Model\User\Recharge::add($uid, $money * 100, '威富通'.$pay_type);
        if(!$recharge_id){
            exit('错误');
        }
        $error_msg='';

        $reqHandler = new \RequestHandler();
        $cfg = new \Config();
        $reqHandler->setParameter('service', $payset['pay_type']); //接口类型pay.weixin.native/pay.alipay.native
        $reqHandler->setParameter('mch_id', $payset['sid']); //必填项，商户号，由平台分配�
        $reqHandler->setParameter('version', '2.0');
        $reqHandler->setParameter('sign_type', 'MD5');
        $reqHandler->setParameter('mch_create_ip', \App::getonlineip());
        $reqHandler->setParameter('body', '支付');
        $reqHandler->setParameter('total_fee', $money * 100);
        $reqHandler->setParameter('out_trade_no', $recharge_id);
        //$reqHandler->setParameter('op_device_id','东风一号');
        $reqHandler->setParameter('limit_pay', 'no_credit');
        $reqHandler->setParameter('attach', $code);//编号加到附加信息
        //this->reqHandler->setParameter('goods_tag','1fds');
        //$reqHandler->setParameter('groupno','8111100093');
        //通知地址，必填项，接收平台通知的URL，需给绝对路径，255字符内格式如:http://wap.tenpay.com/tenpay.asp
        //$notify_url = 'http://'.$_SERVER['HTTP_HOST'];
        //$reqHandler->setParameter('notify_url',$notify_url.'/payInterface/request.php?method=callback');
        $reqHandler->setParameter('notify_url', $payset['domain'].'/paycallback_swiftpass.php');
        $reqHandler->setParameter('nonce_str', mt_rand(time(), time() + rand())); //随机字符串，必填项，不长于 32 位
        $reqHandler->setKey($payset['skey']);
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
                    //$res = array('code_img_url' => $resHandler->getParameter('code_img_url'),
                    //    'code_url' => $resHandler->getParameter('code_url'),
                    //    'code_status' => $resHandler->getParameter('code_status'));
                    $qrcode = $resHandler->getParameter('code_url');
                } else {
                    $error_msg = 'Error Code:' . $resHandler->getParameter('err_code') . ' Error Message:' . $resHandler->getParameter('err_msg');
                }
            }
            //$res = array('status'=>500,'msg'=>'Error Code:'.$resHandler->getParameter('status').' Error Message:'.$resHandler->getParameter('message'));
        } else {
            $error_msg = 'Response Code:' . $pay->getResponseCode() . ' Error Info:' . $pay->getErrInfo();
        }
        //var_dump($res);
        $this->assign('money',$money);
        $this->assign('error_msg',$error_msg);
        $this->assign('qrcode',$qrcode);
        $this->assign('pay_type',$pay_type);
        
        $this->assign("res", $res);
        $this->assign("money", $money);
        $this->assign('recharge_id', $recharge_id);
        $this->template('qrcode.php');
    }
    public function notify(){
        require(SITEROOT . 'Plugin/swiftpass/Utils.class.php');
        require(SITEROOT . 'Plugin/swiftpass/config/config.php');
        require(SITEROOT . 'Plugin/swiftpass/class/RequestHandler.class.php');
        require(SITEROOT . 'Plugin/swiftpass/class/ClientResponseHandler.class.php');
        require(SITEROOT . 'Plugin/swiftpass/class/PayHttpClient.class.php');
        $xml = file_get_contents('php://input');
        $resHandler = new \ClientResponseHandler();
        $resHandler->setContent($xml);
        
        $code = $resHandler->getParameter('attach');//附加信息
        $payset = \Model\Pay\PaySet::getSet($code);
        $cfg = new \Config();
        //file_put_contents('1.txt',$xml);//检测是否执行callback方法，如果执行，会生成1.txt文件，且文件中的内容就是通知参数
        

        //\App::logs('a.txt', $resHandler->getAllParameters());
        $resHandler->setKey($payset['skey']);
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
    
    

}
