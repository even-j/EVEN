<?php

/*
 * 优畅
 */

/**
 * Description of index
 *
 * @author Administrator
 */

namespace apps\pay;

class uline extends \core\Controller {

    public function saoma(){
        $pay_set = \Model\Pay\PaySet::getSet('uline');
        $pay_type = $pay_set['pay_type'];
        $money = isset($_GET ['money']) ? floatval($_GET ['money']) : 0;
        $name = isset($_GET ['name']) ? \App::t($_GET ['name']) : '';
        $uid = isset($_GET ['uid']) ? intval($_GET ['uid']) : 0;
        if(empty($uid)){
            $this->fontRedirect('用户未登录，请先登录', \App::URL('web/member/login'), 3);
            exit;
        }
        //添加记录
        $recharge_id = \Model\User\Recharge::add($uid, $money * 100, '优畅支付');
        if(!$recharge_id){
            exit('错误');
        }
        
        $error_msg='';
        $qrcode = '';
        
        $data['mch_id'] = $pay_set['sid'];
        $data['device_info'] = 'WEB';
        $data['nonce_str'] = mt_rand(time(), time() + rand());
        $data['body'] = '支付';
        $data['out_trade_no'] = $recharge_id;
        $data['total_fee'] = $money * 100;
        $data['spbill_create_ip'] = '127.0.0.1';//\App::getonlineip();
        $data['notify_url'] = $pay_set['domain'].'/paycallback_uline.php';
        $data['trade_type'] = 'NATIVE';
        $data['payment_code'] = $pay_type;//'WX_OFFLINE_NATIVE/ALI_OFFLINE_NATIVE';
        $sign = $this->createSign($data, $pay_set['skey']);
        $data['sign'] = $sign;
        echo $this->arryToXml($data);
        $res = $this->curl_post('http://mapi.bosc.uline.cc', $this->arryToXml($data));
        var_dump($res);
        $res = $this->xmlToArray($res);
        if($res['return_code'] == 'SUCCESS'){
            if($res['result_code'] = 'SUCCESS'){
                $qrcode = $res['code_url'];
            }
            else{
                $error_msg = $res['err_msg'];
            }
        }
        else{
            $error_msg = $res['return_msg'];
        }
        
        
        $this->assign('money',$money);
        $this->assign('error_msg',$error_msg);
        $this->assign('qrcode',$qrcode);
        $this->assign('pay_type',$pay_type=="WX_OFFLINE_NATIVE"?'微信':'支付宝');
        $this->assign('recharge_id', $recharge_id);
        $this->template('qrcode.php');
    }
    public function notify(){
        $pay_set = \Model\Pay\PaySet::getSet('uline');
        $xml = file_get_contents('php://input');
        $data = $this->xmlToArray($xml);
        
        if($data['return_code'] == 'SUCCESS'){
            if($data['result_code'] == 'SUCCESS'){
                $sign = $this->createSign($data, $pay_set['skey']);
                if($sign == $data['sign']){
                    $recharge_id = $data['out_trade_no'];
                    \Common\Query::commitstart();
                    $res = \Model\User\Fund::recharge($recharge_id);
                    if ($res[0] == 1) {
                        \Common\Query::commit();
                        $notice_res = array('return_code'=>'SUCCESS','return_msg'=>'');
                        echo $this->arryToXml($notice_res);
                        exit;
                    } else {
                        \Common\Query::rollback();
                        $notice_res = array('return_code'=>'FAIL','return_msg'=>'处理错误');
                        echo $this->arryToXml($notice_res);
                        exit;
                    }
                }
                else{
                    $notice_res = array('return_code'=>'FAIL','return_msg'=>'签名错误');
                    echo $this->arryToXml($notice_res);
                    exit;
                }
                
            }
            else{
                $notice_res = array('return_code'=>'FAIL','return_msg'=>$data['err_code_des']);
                echo $this->arryToXml($notice_res);
                exit;
            }
            
        }
        else{
            $notice_res = array('return_code'=>'FAIL','return_msg'=>$data['return_msg']);
            echo $this->arryToXml($notice_res);
            exit;
        }
    } 
    
    function createSign($params,$key) {
        $signPars = "";
        ksort($params);
        foreach($params as $k => $v) {
            if("" != $v && "sign" != $k) {
                $signPars .= $k . "=" . $v . "&";
            }
        }
        $signPars .= "key=" . $key;
        $sign = strtoupper(md5($signPars));
        return $sign;
    }
    
    /**
     * 将数据转为XML
     */
    public function arryToXml($params){
        $xml = '<xml>';
        forEach($params as $k=>$v){
            //$xml.='<'.$k.'><![CDATA['.$v.']]></'.$k.'>';
            $xml.='<'.$k.'>'.$v.'</'.$k.'>';
        }
        $xml.='</xml>';
        return $xml;
    }
    
    function curl_post($url,$xml) {
        //启动一个CURL会话
        $ch = curl_init();

        // 设置curl允许执行的最长秒数
        curl_setopt($ch, CURLOPT_TIMEOUT, 20);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        // 获取的信息以文件流的形式返回，而不是直接输出。
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        //发送一个常规的POST请求。
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_URL, $url);
        //要传送的所有数据
        curl_setopt($ch, CURLOPT_POSTFIELDS, $xml);

        // 执行操作
        $res = curl_exec($ch);
        curl_close($ch);
        return $res;
    }
    
    function xmlToArray($content) {
        $data = array();
        $xml = simplexml_load_string($content);

        if ($xml && $xml->children()) {
            foreach ($xml->children() as $node) {
                //有子节点
                if ($node->children()) {
                    $k = $node->getName();
                    $nodeXml = $node->asXML();
                    $v = substr($nodeXml, strlen($k) + 2, strlen($nodeXml) - 2 * strlen($k) - 5);
                } else {
                    $k = $node->getName();
                    $v = (string) $node;
                }
//                if ($encode != "" && $encode != "UTF-8") {
//                    $k = iconv("UTF-8", $encode, $k);
//                    $v = iconv("UTF-8", $encode, $v);
//                }
                $data[$k] = $v;
            }
        }
        return $data;
    }

}
