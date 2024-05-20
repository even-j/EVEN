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

class pay365 extends \core\Controller {

    public function saoma(){
        include SITEROOT . 'Plugin' . DIRECTORY_SEPARATOR . 'pay365' . DIRECTORY_SEPARATOR . 'config.php';
        
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
        $Fs = 'wx';
        $MerchantNo = $config['MerchantNo'];
        $JigouNo = $config['JigouNo'];
        $OrderNo = $recharge_id;
        $Amount = $money;//单位元
        $BankName = 1000;
        $NotifyUrl = $config['NotifyUrl'];
        $ReturnUrl = $config['ReturnUrl'];
        $Ip = '101.52.145.33';
        $Sign = md5($Fs.$JigouNo.$OrderNo.$Amount.$NotifyUrl.$key);
        //获取结果JSON数据
        $error_msg = '';
        $data['Fs'] = $Fs;
        $data['MerchantNo'] = $MerchantNo;
        $data['OrderNo'] = $OrderNo;
        $data['Amount'] = $Amount;
        $data['BankName'] = $BankName;
        $data['NotifyUrl'] = $NotifyUrl;
        $data['ReturnUrl'] = $ReturnUrl;
        $data['Sign'] = $Sign;
        $responseText = $this->curl_post('http://103.80.27.113:3651/pay1.0/', $data);
        echo $responseText . "\n\n";exit;
        //解析JSON数据
        $txt = json_decode($responseText);
        if($txt->Status != 100){
            $error_msg = $txt->CodeMsg;
        }
        $pay_tyep = array('wx'=>'微信','zfb'=>'支付宝','wx_h5'=>'微信','zfb_h5'=>'支付宝','b2c'=>'网银');
        $qrcode = $txt->CodeUrl;
        $this->assign('money',$money);
        $this->assign('error_msg',$error_msg);
        $this->assign('qrcode',$qrcode);
        $this->assign('pay_type',$pay_tyep[$Fs]);
        $this->template('qrcode.php');
        /* }else{
          echo "请选择收款方式";
          } */
    }
    public function notify(){
        include SITEROOT . 'Plugin' . DIRECTORY_SEPARATOR . 'pay365' . DIRECTORY_SEPARATOR . 'config.php';
        $MerchantNo =$_REQUEST['MerchantNo'];
        $OrderNo =$_REQUEST['OrderNo'];
        $Amount =$_REQUEST['Amount'];
        $Status = $_REQUEST['Status'];
        $sign = $_REQUEST['Sign'];
        $key = $config['key'];
        $JigouNo = $config['JigouNo'];
        $sign_string= $JigouNo.$OrderNo.$Amount.$Status.$key;
        if(md5($sign_string) == $sign){
            if($Status == 100){
                $recharge_id = $OrderNo;
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
        else{
            echo 'error';
            exit;
        }
    } 
    
    function curl_post($url_ewm, $data) {
        $ch = curl_init($url_ewm);
//        $header = array('apikey: safepay',);
//        curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        $responseTextt = curl_exec($ch);
        return $responseTextt;
    }



}
