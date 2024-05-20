<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of wechat
 *
 * @author Administrator
 */

namespace Model\Wechat;

class Action {

//put your code here
    /**
     * 获取access_token
     * @return type
     */
    static $_instance;

    public static function getInstance() {
        if (!(self::$_instance instanceof self)) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }

    private function __construct() {
        
    }

    public function getaccess_token() {
        $access_tokenstr = \Common\Cache::get('wechat_token');
        $gettime = time();
        if ($access_tokenstr) {
            return $access_tokenstr;
        }
        $wechat = \apps\Config::getInstance()->wechat;
        $sAppId = $wechat['AppId'];
        $APPSECRET = $wechat['AppSecret'];
        $url = 'https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=' . $sAppId . '&secret=' . $APPSECRET;
        $r = \core\net\Curl::curlget($url);
        $arr = json_decode($r, true);
        $expirestime = isset($arr['expires_in']) ? intval($arr['expires_in']) : 7000;
        $access_token = serialize(array('access_token' => $arr['access_token'], 'expirestime' => $expirestime, 'gettime' => $gettime));
        if (isset($arr['access_token'])) {
            \Common\Cache::save('wechat_token', $arr['access_token'], $expirestime);
        }
        return $arr['access_token'];
    }

    /**
     * 得到jsapi_ticket
     * @return type
     */
    public function get_jsapi_ticket() {
        $jsapi_ticked = \Common\Cache::get('wechat_jsapi_ticket');
        if ($jsapi_ticked) {
            return $jsapi_ticked;
        }
        $access_token = $this->getaccess_token();
        $url = 'https://api.weixin.qq.com/cgi-bin/ticket/getticket?access_token=' . $access_token . '&type=jsapi';
        $r = \core\net\Curl::curlget($url);
        $arr = json_decode($r, true);
        $expirestime = isset($arr['expires_in']) ? intval($arr['expires_in']) : 7000;
        if (isset($arr['ticket'])) {
            \Common\Cache::save('wechat_jsapi_ticket', $arr['ticket'], $expirestime);
        }
        return $arr['ticket'];
    }

    public function get_jsapi_signature($url) {
        $wechat = \apps\Config::getInstance()->wechat;
        $data['appid'] = $wechat['AppId'];
        $data['ticket'] = $this->get_jsapi_ticket();
        $data['noncestr'] = 'wxFUniu890poUI123';
        $data['timestamp'] = time();
        $data['url'] = $url;
        $str = 'jsapi_ticket=' . $data['ticket'] . '&noncestr=' . $data['noncestr'] . '&timestamp=' . $data['timestamp'] . '&url=' . $url;
        $data['signature'] = sha1($str);
        return $data;
    }

    /**
     * 解析微信发送数据
     * @param type $postStr
     * @return type
     */
    public function loadmsg($postStr) {
        $postObj = simplexml_load_string($postStr, 'SimpleXMLElement', LIBXML_NOCDATA);//解析数据
        $data=json_decode(json_encode($postObj), 1);
        $arr['fromUsername'] = isset($data['FromUserName'])?trim($data['FromUserName']):'';//发送消息方ID
        $arr['toUsername'] = isset($data['ToUserName'])?trim($data['ToUserName']):'';//接收消息方ID
        $arr['form_MsgType'] = isset($data['MsgType'])?trim($data['MsgType']):'';//消息类型
        $arr['form_Key'] = isset($data['EventKey'])?$data['EventKey']:array();//菜单key
        $arr['form_Event'] = isset($data['Event'])?trim($data['Event']):'';
        $arr['Content'] = isset($data['Content'])?trim($data['Content']):'';
        $arr['MsgId'] = isset($data['MsgId'])?trim($data['MsgId']):'';
        return $arr;
    }

    /**
     * 发送客服文本信息
     * @param type $OPENID
     * @param type $content
     * @return type
     */
    public function sendmsg($OPENID, $content) {
        $ACCESS_TOKEN = $this->getaccess_token();
        $url = 'https://api.weixin.qq.com/cgi-bin/message/custom/send?access_token=' . $ACCESS_TOKEN;
        $content = str_replace('"', '\"', $content);
        $post_data = '{
                "touser":"' . $OPENID . '",
                "msgtype":"text",
                "text":
                {
                     "content":"' . $content . '"
                }
            }';
        return \core\net\Curl::curlpost($url, $post_data);
    }

    /**
     * 发送客服图文信息
     * @param type $OPENID
     * @param type $dataarr
     * @return type
     */
    public function sendimgmsg($OPENID, $dataarr) {
        $ACCESS_TOKEN = $this->getaccess_token();
        $url = 'https://api.weixin.qq.com/cgi-bin/message/custom/send?access_token=' . $ACCESS_TOKEN;
        $data = '';
        $s = '';
        foreach ($dataarr as $value) {
            $data.=$s . '{
                     "title":"' . $value['title'] . '",
                     "description":"' . $value['desc'] . '",
                     "url":"' . $value['url'] . '",
                     "picurl":"' . $value['pic'] . '"
                 }';
            $s = ',';
        }
        $post_data = '{
            "touser":"' . $OPENID . '",
            "msgtype":"news",
            "news":{
                "articles": [' . $data . ']
            }
        }';
        $ds = \core\net\Curl::curlpost($url, $post_data);
        return $ds;
    }

    /**
     * 发送模板消息
     * @param type $OPENID
     * @param type $template_id
     * @param string $url
     * @param type $data
     */
    public function sendTempt($OPENID, $template_id, $detailurl, $data) {
        $ACCESS_TOKEN = $this->getaccess_token();
        $url = 'https://api.weixin.qq.com/cgi-bin/message/template/send?access_token=' . $ACCESS_TOKEN;
        $dataarr = array('touser' => $OPENID, 'template_id' => $template_id, 'url' => $detailurl);
        foreach ($data as $key => $v) {
            $encode = mb_detect_encoding($v, array("ASCII", "UTF-8", "GB2312", "GBK", "BIG5"));
            if ($encode != "UTF-8") {
                $v = iconv($encode, "UTF-8//IGNORE", $v);
            }
            $dataarr['data'][$key] = array('value' => $v, 'color' => "#173177");
        }
        $post_data = json_encode($dataarr, JSON_UNESCAPED_UNICODE);
        return \core\net\Curl::curlpost($url, $post_data);
    }
    /**
     * 回复消息
     * @param type $to
     * @param type $from
     * @param type $data
     * @return boolean
     */
    public function response($to, $from, $data) {
        header("Content-type:text/xml");
        if (is_array($data)) {
            echo $this->showlist($to, $from, $data);
            return false;
        }
        echo $this->showtext($to, $from, $data);
    }

    /**
     * 回复微信消息
     * @param type $toUsername
     * @param type $FromUserName
     * @param type $contents
     */
    private function showtext($to, $from, $contents) {
        return "<xml>
                    <ToUserName><![CDATA[" . $to . "]]></ToUserName>
                    <FromUserName><![CDATA[" . $from . "]]></FromUserName>
                    <CreateTime>" . time() . "</CreateTime>
                    <MsgType><![CDATA[text]]></MsgType>
                    <Content><![CDATA[" . $contents . "]]></Content>
                    </xml>";
    }
    /**
     * 回复消息列表
     * @param type $to
     * @param type $from
     * @param type $data
     * @return string
     */
    private function showlist($to, $from, $data) {
        $num = count($data);
        //\App::logs('wechat', $num);
        $str = "<xml>
            <ToUserName><![CDATA[" . $to . "]]></ToUserName>
            <FromUserName><![CDATA[" . $from . "]]></FromUserName>
            <CreateTime><![CDATA[" . time() . "]]></CreateTime>
            <MsgType><![CDATA[news]]></MsgType>
            <ArticleCount>{$num}</ArticleCount>
            <Articles>
         ";
        foreach ($data as $value) {
            $str.= "<item>
                    <Title><![CDATA[{$value['title']}]]></Title> 
                    <Description><![CDATA[{$value['desc']}]]></Description>
                    <PicUrl><![CDATA[{$value['pic']}]]></PicUrl>
                    <Url><![CDATA[" . $value['url'] . "]]></Url>
                </item>";
        }
        $str.= "</Articles>
            <FuncFlag>0</FuncFlag>
        </xml>";
        return $str;
    }

    /**
     * 用户订阅
     * @param type $openid
     */
    public function subscribe($openid) {
        $uid = \Model\User\UserInfo::getuid($openid, 'wechat');
        if (!$uid) {
            $regarr['third_type'] = 'wechat';
            $regarr['openid'] = $openid;
            $regarr['secret'] = '';
            $uid = \Model\User\UserInfo::reg($regarr);

            //\Model\User\UserHongbao::addHongbaoFromBase($uid,'register');
        }
        \Common\Query::update('user_info', array('is_atten_weixin' => 1), array('user_id' => $uid));
        \Model\User\UserInfo::removeCache($uid);
    }

    /**
     * 用户取消关注
     * @param type $openid
     */
    public function unsubscribe($openid) {
        $uid = \Model\User\UserInfo::getuid($openid, 'wechat');
        \Common\Query::update('user_info', array('is_atten_weixin' => 0), array('user_id' => $uid));
        \Model\User\UserInfo::removeCache($uid);
    }

}
