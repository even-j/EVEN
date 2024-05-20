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

class user extends \apps\UserControl {

    //账户中心
    public function account() {
        $this->setTitle('用户中心'.'-'.SITE_TITLE);

        $uid = $this->uid;
        $user = $this->user;
        $user ['user_name'] = substr_replace($user ['mobile'], '****', 3, 4);
        $user ['card_info'] = substr_replace($user ['id_card'], '****', 10, 4);
        $bank_card = \Model\User\BankCard::getByUid($uid);
        if ($bank_card) {
            $bank_info = \Model\Sys\AccountBank::getBankInfo($bank_card ['bank_name']);
            $bank_card ['card_type_pic'] = $bank_info ['litpic'];
            $bank_card ['last_card_no'] = substr($bank_card ['card_no'], - 4);
        }
        $user ['bank_card'] = $bank_card;
        $user ['bank_card_count'] = \Model\User\BankCard::getBankCardCountByByUid($uid);
        $this->assign('userinfo', $user);
        $this->template('account.php');
    }

    //资金记录
    public function fund() {
        $this->setTitle('资金记录—' . SITE_TITLE);

        $fundtype = isset($_GET ['fundtype']) ? intval($_GET ['fundtype']) : 0;
        $timetype = isset($_GET ['timetype']) ? intval($_GET ['timetype']) : 5;
        $curpage = isset($_GET ['page']) ? intval($_GET ['page']) : 1;
        $pagesize = 10;
        $where = ' WHERE r.uid=' . $this->uid;
        $time = time();
        if ($timetype == 1) { //三天内
            $time_tmp = $time - 3 * 24 * 60 * 60;
            $where .= ' and rtime>=' . $time_tmp;
        } else if ($timetype == 2) { //一周内
            $time_tmp = $time - 7 * 24 * 60 * 60;
            $where .= ' and rtime>=' . $time_tmp;
        } else if ($timetype == 3) { //一月内
            $time_tmp = $time - 30 * 24 * 60 * 60;
            $where .= ' and rtime>=' . $time_tmp;
        } else if ($timetype == 4) { //三月内
            $time_tmp = $time - 90 * 24 * 60 * 60;
            $where .= ' and rtime>=' . $time_tmp;
        } else if ($timetype == 5) { //一年内
            $time_tmp = $time - 365 * 24 * 60 * 60;
            $where .= ' and rtime>=' . $time_tmp;
        }
        if ($fundtype > 0) {
            $where .= ' and type=' . $fundtype;
        }

        $order = ' ORDER BY fund_id desc';
        $res = \Common\Pager::getList('user_fund_record r left join user_peizi pz on r.rec_id=pz.pz_id', $where, array('r.*', 'pz.pz_type'), $order, $curpage, $pagesize, 1);

        $this->assign('fundtype', $fundtype);
        $this->assign('timetype', $timetype);
        $this->assign('user', $this->user);
        $this->assign('rows', $res ['data']);
        $this->assign('pager', $res ['pager']);
        $this->template('fund.php');
    }

    //充值
    public function recharge() {
        $this->setTitle('用户充值—' . SITE_TITLE);
        $money = isset($_GET ['money']) ? floatval($_GET ['money']) : '';
        $pay_list = \Model\Pay\PaySet::getList();
        $this->assign('pay_list', $pay_list);
        $account_list = \Model\Pay\PaySet::getAccountList($this->uid);
        $this->assign('account_list', $account_list);
        
        $this->assign('uid', $this->uid);
        $this->assign('money', $money);
        $this->template('recharge.php');
    }

    //充值
    public function dorecharge() {
        include SITEROOT . 'Plugin' . DIRECTORY_SEPARATOR . 'YeePay' . DIRECTORY_SEPARATOR . 'yeepayCommon.php';
        $this->setTitle('用户充值—' . SITE_TITLE);
        $money = isset($_POST ['p3_Amt']) ? floatval($_POST ['p3_Amt']) : '';

        #	商家设置用户购买商品的支付信息.
        ##易宝支付平台统一使用GBK/GB2312编码方式,参数如用到中文，请注意转码
        # 业务类型
        # 支付请求，固定值"Buy"
        $var ['p0_Cmd'] = $p0_Cmd;

        #	商户编号p1_MerId,以及密钥merchantKey 需要从易宝支付平台获得
        $var ['p1_MerId'] = $p1_MerId;

        #	商户订单号,选填.
        ##若不为""，提交的订单号必须在自身账户交易中唯一;为""时，易宝支付会自动生成随机的商户订单号.
        $var ['p2_Order'] = "";

        #	支付金额,必填.
        ##单位:元，精确到分.
        $var ['p3_Amt'] = $money;

        #	交易币种,固定值"CNY".
        $var ['p4_Cur'] = "CNY";

        #	商品名称
        ##用于支付时显示在易宝支付网关左侧的订单产品信息.
        $var ['p5_Pid'] = mb_convert_encoding(SITE_NAME, 'utf-8', 'gbk') ;

        #	商品种类
        $var ['p6_Pcat'] = 'roducttype';

        #	商品描述
        $var ['p7_Pdesc'] = 'productdesc';

        #	商户接收支付成功数据的地址,支付成功后易宝支付会向该地址发送两次成功通知.
        $var ['p8_Url'] = DOMAIN . '/index.php?app=web&mod=user&ac=rechargeCallback';
        #	送货地址
        # 为"1": 需要用户将送货地址留在易宝支付系统;为"0": 不需要，默认为 "0".
        $var ['p9_SAF'] = "0";

        #	商户扩展信息
        ##商户可以任意填写1K 的字符串,支付成功时将原样返回.	
        $data ['money'] = $money;
        $data ['uid'] = $this->uid;
        $var ['pa_MP'] = 'userId or other'; //json_encode($data);
        #	支付通道编码
        ##默认为""，到易宝支付网关.若不需显示易宝支付的页面，直接跳转到各银行、神州行支付、骏网一卡通等支付页面，该字段可依照附录:银行列表设置参数值.			
        $var ['pd_FrpId'] = ''; //isset ( $_POST ['pd_FrpId'] ) ? floatval ( $_POST ['pd_FrpId'] ) : '';
        #	应答机制
        ##默认为"1": 需要应答机制;
        $var ['pr_NeedResponse'] = "1";

        #调用签名函数生成签名串
        $var ['hmac'] = getReqHmacString($var ['p0_Cmd'], $var ['p2_Order'], $var ['p3_Amt'], $var ['p4_Cur'], $var ['p5_Pid'], $var ['p6_Pcat'], $var ['p7_Pdesc'], $var ['p8_Url'], $var ['p9_SAF'], $var ['pa_MP'], $var ['pd_FrpId'], $var ['pr_NeedResponse']);
        $this->assign('reqURL_onLine', $reqURL_onLine);
        $this->assign('var', $var);
        $this->template('dorecharge.php');
    }

    public function rechargeCallback() {
        
    }

    //提现
    public function withdrawl() {
        $this->setTitle('申请提现—' . SITE_TITLE);
        $uid = $this->uid;
        $user = $this->user;
        $user ['balance'] = $user ['balance'] > 0 ? $user ['balance'] / 100 : 0;
        $user ['aviable_money'] = number_format($user ['balance'], 2);
        /* $bank_card = \Model\User\BankCard::getByUid ( $uid );

          if ($bank_card) {
          $bank_info = \Model\Sys\AccountBank::getBankInfo ( $bank_card ['bank_name'] );
          $bank_card ['card_type_pic'] = $bank_info ['litpic'];
          $bank_card ['last_card_no'] = substr ( $bank_card ['card_no'], - 4 );
          } */

        $user ['to_pay_cost'] = \Model\Peizi\Peizi::getToPayCost($uid) + \Model\Peizi\Peizi::getToPayCost($uid, 6); // 股票策略 + P2P策略 所需服务费
        //$user ['bank_card'] = $bank_card;
        $res = \Model\User\BankCard::getBankCardListByUid($uid);
        $bankList = array();
        foreach ($res as $bank_card) {
            $bank_info = \Model\Sys\AccountBank::getBankInfo($bank_card ['bank_name']);
            $bank_card ['card_type_pic'] = $bank_info ['litpic'];
            $bank_card ['last_card_no'] = substr($bank_card ['card_no'], - 4);
            $bankList[] = $bank_card;
        }

        $this->assign('bankList', $bankList);
        $this->assign('userinfo', $user);
        $this->template('withdrawl.php');
    }

    //提现 2
    public function withdrawlMoneyFirst() {
        $this->setTitle('确认提现信息—' . SITE_TITLE);
        if ($_POST) {
            $true_name = isset($_POST ['trueName']) ? \App::t($_POST ['trueName']) : '';
            $card_id = isset($_POST ['cardId']) ? intval($_POST ['cardId']) : 0;
            if (!$card_id) {
                $this->fontRedirect('请选择要提现的银行卡', \App::URL('web/user/withdrawl'));
            }
            $bank_card = \Model\User\BankCard::getByUid($this->uid, $card_id);
            $bank_info = \Model\Sys\AccountBank::getBankInfo($bank_card ['bank_name']);
            $bankCardPic = $bank_info ['litpic'];
            $bankCardTail = substr($bank_card ['card_no'], - 4);

            $withdrawalMoney = isset($_POST ['withdrawalMoney']) ? floatval($_POST ['withdrawalMoney']) : 0;


            $data = array('true_name' => $true_name, 'bankCardPic' => $bankCardPic, 'bankCardTail' => $bankCardTail, 'withdrawalMoney' => $withdrawalMoney, 'qk_time' => \Model\User\UserInfo::get_qk_time(time()), 'card_id' => $card_id);

            $this->assign('data', $data);
            $this->template('withdrawl2.php');
        } else {
            $this->fontRedirect('提现金额未填写', \App::URL('web/user/withdrawl'));
        }
    }

    //提现3
    public function withdrawalsMoney() {
        $uid = $this->uid;
        if ($_POST && $uid > 0) {
            $url = \App::URL('web/user/withdrawl');
            $card_id = isset($_POST ['bank']) ? intval($_POST ['bank']) : 0;
            $withdrawalMoney = isset($_POST ['money']) ? floatval($_POST ['money']) * 100 : 0;
            if ($card_id > 0 && $withdrawalMoney > 0) {
                \Common\Query::commitstart();
                //添加提现记录
                $res = \Model\User\Withdraw::add($uid, $withdrawalMoney, $card_id);
                if (empty($res)) {
                    \Common\Query::rollback();
                    exit(json_encode(array('code'=>0,'msg'=>'添加提现记录错误')));
                    //$this->fontRedirect('添加提现记录错误', $url);
                    //exit();
                }
                //冻结资金
                $res = \Model\User\Fund::withdrawFrozen($uid, $withdrawalMoney);
                if ($res [0] == 0) {
                    \Common\Query::rollback();
                    exit(json_encode(array('code'=>0,'msg'=>$res [1])));
                    //$this->fontRedirect($res [1], $url);
                    //exit();
                }
                \Common\Query::commit();
                exit(json_encode(array('code'=>1,'msg'=>'')));
                //$this->sysRedirect(\App::URL('web/user/txok'));
            } else {
                exit(json_encode(array('code'=>0,'msg'=>'提现卡号不存在')));
                //$this->fontRedirect('提现卡号不存在', $url);
            }
        } else {
            exit(json_encode(array('code'=>0,'msg'=>'提现金额未填写')));
            //$this->fontRedirect('提现金额未填写', $url);
        }
    }

    //提现完成
    public function txok() {
        $this->setTitle('提现申请提交成功—' . SITE_TITLE);
        $message = array();
        $message ['title'] = '提现申请';
        $message ['info'] = '提现申请已提交，请等待银行处理';
        $message ['first_link'] = '<a href="' . \App::URL('web/user/fund') . '" class="submit">资金管理</a>';
        $message ['second_link'] = '<a href="' . \App::URL('web/user/account') . '" style="padding-left:27px;"> 返回账号设置</a> ';
        $message ['process'] = '<ul class="process"><li><b>1</b>填写提现金额</li><li><b>2</b>确认提现信息</li><li class="current"><b>3</b>提现申请已提交-等待银行处理</li></ul>';
        $this->assign('message', $message);
        $this->template('success.php');
    }
    
    //提现完成
    public function success() {
        $this->setTitle('提现申请提交成功—' . SITE_TITLE);
        $message = array();
        $message ['title'] = '提现申请';
        $message ['info'] = '提现申请已提交，请等待银行处理';
        $message ['first_link'] = '<a href="' . \App::URL('web/user/fund') . '" class="submit">资金管理</a>';
        $message ['second_link'] = '<a href="' . \App::URL('web/user/account') . '" style="padding-left:27px;"> 返回账号设置</a> ';
        $message ['process'] = '<ul class="process"><li><b>1</b>填写提现金额</li><li><b>2</b>确认提现信息</li><li class="current"><b>3</b>提现申请已提交-等待银行处理</li></ul>';
        $this->assign('message', $message);
        $this->template('success.php');
    }

    //验证充值金额
    public function verifynumber() {
        $res = array('status' => 2, 'msg' => '');
        if ($_POST) {
            $number = isset($_POST ['number']) ? floatval($_POST ['number']) : 0;
            if (!is_numeric($number)) {
                $res ['msg'] = '请输入有效数字！';
            } else if ($number > 0 && $number < 0.01) {
                $res ['msg'] = '每次充值不能少于0.01元！';
            } else {
                $res ['status'] = 1;
                $res ['msg'] = '验证通过' . ($number);
            }
        }
        exit(json_encode($res));
    }

    //银行卡信息绑定
    public function bank() {
        $uid = $this->uid;
        $user = $this->user;
        if (!$user ['id_card'] && !$user ['true_name']) {
            $this->fontRedirect('您的身份信息未绑定!', \App::URL('web/user/sfz'));
        }
        $bankinfo = array();
        $card_id = isset($_GET ['card_id']) ? intval($_GET ['card_id']) : 0;
        if ($card_id > 0) {
            $bankinfo = \Model\User\BankCard::getByUid($uid, $card_id);
        }
        /* if ($bankinfo && $bankinfo ['is_audit'] == 1) {
          $this->fontRedirect ( '您的银行卡已绑定过!', \App::URL ( 'web/user/account' ) );
          } */
        $this->setTitle('银行卡绑定');
        $bankList = \Model\User\BankCard::getBankCardListByUid($this->uid);
        $province = \Model\Sys\Area::getProvinces();
        $bank_arr = array(
            '招商银行'=>'cmb',
             '中国银行'=>'boc',
             '中国工商银行'=>'icbc',
             '中国建设银行'=>'ccb',
             '中国农业银行'=>'abc',
             '中国邮政储蓄银行'=>'psbc',
             '交通银行'=>'bcs',
             '上海浦东发展银行'=>'spdb',
             '中国民生银行'=>'cmbc',
             '兴业银行'=>'cib',
             '平安银行'=>'pa',
             '北京银行'=>'bob',
             '上海银行'=>'bos',
             '华夏银行'=>'hx-2',
             '光大银行'=>'ceb',
            '广发银行'=>'cgb',
            '中信银行'=>'ecitic',
            '农村信用社'=>'xys',
        );
        $this->assign('user', $user);
        $this->assign('bankinfo', $bankinfo);
        $this->assign('bankList', $bankList);
        $this->assign('province', $province);
        $this->assign('bank_arr', $bank_arr);
        $this->template('bank_set.php');
    }

    //银行卡信息绑定
    public function bankinfoveried() {
        if ($_POST) {
            $uid = $this->uid;
            $bank_name = isset($_POST ['bank']) ? \App::t($_POST ['bank']) : '';
            $province_id = isset($_POST ['province']) ? intval($_POST ['province']) : 0;
            $card_id = isset($_POST ['card_id']) ? intval($_POST ['card_id']) : 0;
            $city_id = isset($_POST ['city']) ? intval($_POST ['city']) : 0;
            $card_no = isset($_POST ['number']) ?trim($_POST ['number']):'';// preg_replace('/[\s]/', '', \App::t($_POST ['number'])) : '';
            $province_name = isset($_POST ['province_name']) ? \App::t($_POST ['province_name']) : '';
            $city_name = isset($_POST ['city_name']) ? \App::t($_POST ['city_name']) : '';
            $bank_count = \Model\User\BankCard::getBankCardCountByByUid($uid);
            $otherbank = isset($_POST ['otherbank']) ? \App::t($_POST ['otherbank']) : '';

            $type = isset($_POST ['type']) ? intval($_POST ['type']) : 1;
            if($type ==2){
                $bank_name = '虚拟币地址';
                $card_no = isset($_POST ['address']) ?trim($_POST ['address']):'';
            }

//ECHO $card_no;DIE;
            if(empty($otherbank)  && $bank_name=="其他")
            {
                exit(json_encode(array('code'=>0,'msg'=>'银行名称不能为空!')));
            }
            if(!empty($otherbank) && $bank_name=="其他")
            {
                $bank_name=trim($otherbank);
            }
           
           
            if ($bank_count >=1) {
                //exit(json_encode(array('code'=>0,'msg'=>'最多只能添加1张银行卡!')));
                //$this->fontRedirect('最多只能添加5张银行卡!', \App::URL('web/user/sfz'));
            }
            if (\Model\User\BankCard::checkBandCardIsExist($card_no)) {
                exit(json_encode(array('code'=>0,'msg'=>'该卡号已存在，不能重复添加!'.$card_no)));
                //$this->fontRedirect('该卡号已存在，不能重复添加!', \App::URL('web/user/bank'));
            } else {
                $res = 0;
                if ($card_id > 0) {
                    $updarr = array();
                    $updarr ['bank_name'] = $bank_name;
                    $updarr ['province_id'] = $province_id;
                    $updarr ['city_id'] = $city_id;
                    $updarr ['card_no'] = $card_no;
                    $updarr ['province_name'] = $province_name;
                    $updarr ['city_name'] = $city_name;
                    $res = \Model\User\BankCard::edit($updarr, $card_id);
                } else {
                    $res = \Model\User\BankCard::add($uid, $province_id, $province_name, $city_id, $city_name, $card_no, $bank_name,$type);
                }
                if ($res > 0) {
                    exit(json_encode(array('code'=>1,'msg'=>'')));
                    //$this->sysRedirect(\App::URL('web/user/bankok'));
                    \Model\User\UserInfo::removeCache($uid);
                } else {
                    exit(json_encode(array('code'=>0,'msg'=>'银行卡信息添加失败!')));
                    //$this->fontRedirect('银行卡信息添加失败!', \App::URL('web/user/bank'));
                }
            }
        }
    }

    //银行卡号是否已绑定
    public function cardIsExist() {
        if (isset($_GET ['card_no'])) {
            $card_no = isset($_GET ['card_no']) ? \App::t($_GET ['card_no']) : '';
            $res = \Model\User\BankCard::checkBandCardIsExist($card_no);
            exit(json_encode($res));
        }
    }

    //银行卡添加完成
    public function bankok() {
        $this->setTitle('银行卡信息保存成功—' . SITE_TITLE);
        $this->template('bank_set_ok.php');
    }

    public function banklist() {
        $this->setTitle('我的银行卡—' . SITE_TITLE);
        $res = \Model\User\BankCard::getBankCardListByUid($this->uid);
        $bankList = array();
        foreach ($res as $bank_card) {
            $bank_info = \Model\Sys\AccountBank::getBankInfo($bank_card ['bank_name']);
            $bank_card ['card_type_pic'] = $bank_info ['litpic'];
            $bank_card ['last_card_no'] = substr($bank_card ['card_no'], - 4);
            $bankList[] = $bank_card;
        }

        $this->assign('bankList', $bankList);
        $this->template('banklist.php');
    }

    //银行卡设为未默认
    public function setbank() {
        $res = array('code' => 0, 'msg' => '银行卡默认设置操作失败');
        if ($_POST) {
            $card_id = $_POST ['card_id'] ? intval($_POST ['card_id']) : 0;
            if ($card_id > 0) {
                $r = \Model\User\BankCard::setBankCardDefault($this->uid, $card_id);
                if ($r > 0) {
                    $res['code'] = 1;
                    $res['msg'] = '银行卡默认设置操作成功';
                }
            }
        }
        exit(json_encode($res));
    }

    //获得城市
    public function ajaxregion() {
        if ($_GET) {
            $provinceId = $_GET ['provinceId'] ? intval($_GET ['provinceId']) : 0;
            $citys = \Model\Sys\Area::getCitys($provinceId);
            exit(json_encode($citys));
        }
    }

    //身份证
    public function sfz() {
        $this->setTitle('身份证设置—' . SITE_TITLE);
        $user = \Model\User\UserInfo::getinfo($this->uid);
        $this->assign('user', $user);
        $this->template('sfz_set.php');
    }

    //身份证认证
    public function doindentity() {
        $uid = $this->uid;
        $realName = isset($_POST ['realName']) ? \App::t($_POST ['realName']) : '';
        $id_crad = isset($_POST ['identityCard']) ? \App::t($_POST ['identityCard']) : '';
        $user = \Model\User\UserInfo::getByIdcrad($id_crad);
        if($user){
            exit(json_encode(array('code'=>0,'msg'=>'身份证号已存在!')));
            //$this->fontRedirect('身份证号已存在!', \App::URL('web/user/sfz'));
        }
        $showapi_set = \apps\Config::getInstance()->showapi;
        if(isset($showapi_set['status']) && $showapi_set['status'] == 1){
            $r = \Model\Api\Showapi::sfz($id_crad, $realName);
            if($r['ret']!=0){
                exit(json_encode(array('code'=>0,'msg'=>$r['msg'])));
            }
        }
        $res = \Model\User\UserInfo::bindInfo($uid, $realName, $id_crad);
        if ($res > 0) {
            \Model\User\UserInfo::removeCache($uid);
            exit(json_encode(array('code'=>1,'msg'=>'')));
            //$this->sysRedirect(\App::URL('web/user/sfzok'));
        } else {
            exit(json_encode(array('code'=>0,'msg'=>'身份信息认证失败!')));
            //$this->fontRedirect('身份信息认证失败!', \App::URL('web/user/sfz'));
        }
    }

    //身份证认证完成
    public function sfzok() {
        $this->setTitle('身份证设置完成—' . SITE_TITLE);
        $message = array();
        $message ['title'] = '身份信息';
        $message ['info'] = '身份信息保存成功，绑定银行卡后就可以进行资金操作了';
        $message ['first_link'] = '<a href="' . \App::URL('web/user/bank') . '" class="submit">绑定银行卡</a>';
        $message ['second_link'] = '<a href="' . \App::URL('web/user/account') . '" style="padding-left:27px;"> 返回账号设置</a> ';
        $this->assign('message', $message);
        $this->template('success.php');
    }

    //验证身份证是否存在
    public function checkId() {
        if (isset($_GET)) {
            $idcardno = isset($_GET ['idcardno']) ? \App::t($_GET ['idcardno']) : '';
            $ret = \Model\User\UserInfo::checkIdcardIsExist($idcardno);
            $res = $ret ? '1' : '0';
            exit($res);
        }
    }

    //修改密码
    public function login_password() {
        $this->setTitle('修改密码—' . SITE_TITLE);
        $this->template('login_password.php');
    }
    
    public function modifyLoginPwd(){
        $user = \Model\User\UserInfo::getinfo($this->uid);
        $mobile = $user['mobile'];
        $oldPwd = isset($_POST['oldPwd']) ? $_POST['oldPwd'] : '';
        $newPwd = isset($_POST['newPwd']) ? $_POST['newPwd'] : '';
        $res = \Model\User\UserInfo::checkUserPwd($mobile, $oldPwd);
        if(!$res){
            exit(json_encode(array('code'=>0,'msg'=>'密码错误')));
        }
        $res = \Model\User\UserInfo::pwdReset($mobile, $newPwd);
        if($res[0] == 0){
            exit(json_encode(array('code'=>0,'msg'=>$res[1])));
        }
        exit(json_encode(array('code'=>1,'msg'=>$res[1])));
    }

    //密码修改成功
    public function passwordok() {
        $this->setTitle('修改密码完成—' . SITE_TITLE);
        $message = array();
        $message ['title'] = '修改登录密码';
        $message ['info'] = '恭喜您，密码修改成功！';
        $message ['first_link'] = '<a href="' . \App::URL('web/member/login') . '" class="submit">立即登录</a>';
        $message ['second_link'] = '<a href="' . \App::URL('web/member/account') . '" style="padding-left:27px;"> 返回账号设置</a> ';
        $this->assign('message', $message);
        $this->template('success.php');
    }

    //密码验证
    public function modPwdValidate() {
        if (isset($_GET)) {
            $mobile = isset($_GET ['mobile']) ? \App::t($_GET ['mobile']) : '';
            $password = isset($_GET ['password']) ? $_GET ['password'] : '';
            $ret = \Model\User\UserInfo::checkUserPwd($mobile, $password);
            if (!$ret) {
                echo '旧密码输入错误!';
            }
        }
    }

    //检测用户是否登录
    public function checkLogin() {
        $user = $this->user;
        if ($user) {
            echo 1;
        }
        echo 0;
    }

    //按日策略    
    public function peizi() {
        $this->setTitle('策略记录—' . SITE_TITLE);
        $status = isset($_GET ['status']) ? intval($_GET ['status']) : 0;
        $pz_type = isset($_GET ['pz_type']) ? intval($_GET ['pz_type']) : 1;
        $curpage = isset($_GET ['page']) ? intval($_GET ['page']) : 1;
        $num = isset($_GET ['num']) ? strtoupper($_GET ['num'])  : '';//方案号
        $sp_user = isset($_GET ['sp_user']) ? $_GET ['sp_user'] : '';//操盘账号
        $pagesize = 3;
        $where = 'pz_type=' . $pz_type . ' and uid=' . $this->uid;
        if(!empty($status)){
            $where .= ' and status='.intval($status);
        }
        if(!empty($num)){
            $where .= ' and pz_id='.intval(substr($num,8));
        }
        if(!empty($sp_user)){
            $where .= " and sp_user='".$sp_user."'";
        }
        $order = 'pz_time desc';
        $rows = \Model\Sys\Common::getTableRrcordList('user_peizi', '*', $where, $order, $curpage, $pagesize);
        $rowcount = \Model\Sys\Common::getTableRecordCount('user_peizi', $where);
        $var ['overcount'] = \Model\Sys\Common::getTableRecordCount('user_peizi', 'pz_type=' . $pz_type . ' and uid=' . $this->uid . ' and status=4');
        $row = \Common\Query::sqlselone('select sum(profit_loss_money) profit_loss_money from user_peizi where pz_type=' . $pz_type . ' and uid=' . $this->uid);
        $var ['profit_loss_money'] = $row ? $row ['profit_loss_money'] : 0;
        $pager = \Common\Pager::getPageList($curpage, $rowcount, $pagesize);
        $this->assign('rows', $rows);
        $this->assign('pager', $pager);
        $this->assign('user', $this->user);
        $this->assign('var', $var);
        $this->template('peizi.php');
    }

    //实盘详情
    public function peizi_detail() {
        $this->setTitle('按日策略—' . SITE_TITLE);
        $pz_id = isset($_GET ['pz_id']) ? intval($_GET ['pz_id']) : 0;
        $pz_row = \Common\Query::selone('user_peizi', array('pz_id' => $pz_id, 'uid' => $this->uid));
        //结束状态跳到结束展示页面
        if ($pz_row ['status'] == 0) {
            exit();
        }
        $curpage = isset($_GET ['page']) ? intval($_GET ['page']) : 1;

        $pagesize = 10;
        $where = "uid=" . $this->uid . " and table_name='user_peizi' and rec_id=" . $pz_id;
        $order = 'rtime desc';
        $fund_rows = \Model\Sys\Common::getTableRrcordList('user_fund_record', '*', $where, $order, $curpage, $pagesize);
        $rowcount = \Model\Sys\Common::getTableRecordCount('user_fund_record', $where);
        $pager = \Common\Pager::getPageList($curpage, $rowcount, $pagesize);
        $params = \Model\Admin\Params::get('peizi');

        //$this->assign('var',  $var);
        $this->assign('params', $params);
        $this->assign('pz_row', $pz_row);
        $this->assign('fund_rows', $fund_rows);
        $this->assign('pager', $pager);
        $this->assign('user', $this->user);
        $this->template('peizi_detail.php');
    }

    //历史实盘信息
    public function peizi_detail_his() {
        $this->setTitle('按日策略—' . SITE_TITLE);
        $pz_id = isset($_GET ['pz_id']) ? intval($_GET ['pz_id']) : 0;
        $pz_row = \Common\Query::selone('user_peizi', array('pz_id' => $pz_id, 'uid' => $this->uid));
        //未审核
        if ($pz_row ['status'] == 0) {
            exit();
        }
        //操盘状态跳到操盘展示页面
        if ($pz_row ['status'] == 2 || $pz_row ['status'] == 3) {
            $this->peizi_detail();
            exit();
        }
        $curpage = isset($_GET ['page']) ? intval($_GET ['page']) : 1;

        //服务费
        $sql = 'select sum(money) money from user_fund_record where uid=' . $this->uid . ' and rec_id=' . $pz_id . ' and type=10';
        $fund_row = \Common\Query::sqlselone($sql);
        $var ['manage_cost_money'] = $fund_row ? $fund_row ['money'] : 0;
        //交易天数
        $sql = 'select count(money) cou from user_fund_record where uid=' . $this->uid . ' and rec_id=' . $pz_id . ' and type=10';
        $fund_row = \Common\Query::sqlselone($sql);
        $var ['sp_days'] = $fund_row ? $fund_row ['cou'] : 0;
        //流水记录
        $pagesize = 10;
        $where = 'uid=' . $this->uid . ' and rec_id=' . $pz_id;
        $order = 'rtime desc';
        $fund_rows = \Model\Sys\Common::getTableRrcordList('user_fund_record', '*', $where, $order, $curpage, $pagesize);
        $rowcount = \Model\Sys\Common::getTableRecordCount('user_fund_record', $where);
        $pager = \Common\Pager::getPageList($curpage, $rowcount, $pagesize);
        $params = \Model\Admin\Params::get('peizi_free');

        $this->assign('params', $params);
        $this->assign('var', $var);
        $this->assign('pz_row', $pz_row);
        $this->assign('fund_rows', $fund_rows);
        $this->assign('pager', $pager);
        $this->assign('user', $this->user);
        $this->template('peizi_detail_his.php');
    }

    //我的策略
    public function p2p_peizi() {
        $this->setTitle('我的策略—' . SITE_TITLE);
        $uid = $this->uid;

        $datetype = isset($_GET ['datetype']) ? intval($_GET ['datetype']) : 1;
        $page = isset($_GET ['page']) ? intval($_GET ['page']) : 1;
        $status = isset($_GET ['status']) ? $_GET ['status'] : '';
        $where = ' WHERE p.uid=' . $uid . ' AND (p.pz_type=3 or p.pz_type=5)';
        if ($status != '' && $status >= 0) {
            if ($status == 6) {
                $where .= ' AND (p.p2pstatus=' . $status . ' AND p.status!=4)';
            } elseif ($status == 7) {
                $where .= ' AND (p.p2pstatus=' . $status . ' OR (p.p2pstatus=6 and p.status=4))';
            } else {
                $where .= ' AND p.p2pstatus=' . $status;
            }
        }

        $selarr = array('p.*');
        $order = ' ORDER BY p.pz_time DESC';
        $res = \Common\Pager::getList('user_peizi AS p', $where, $selarr, $order, $page, 10);
        $dataList = array();
        $status = array('0' => '未交保证金', '1' => '等待审核', '2' => '募资中', '3' => '已取消', '4' => '募资成功', '5' => '申请结束操盘，等待清算中', '6' => '操盘中', '7' => '已平仓结束');

        foreach ($res ['data'] as $row) {
            $row ['limit_day'] = $row ['end_time'] > time() && $row ['p2pstatus'] == 6 ? '<font class="cd22">(剩余' . \App::daysSpan($row ['end_time'], time()) . '天)</font>' : '';
            $color = $row ['p2pstatus'] <= 5 ? 'red' : 'blue';
            $row ['p_status'] = isset($row ['p2pstatus']) ? $status [$row ['p2pstatus']] : '<span class="' . $color . '">未支付</span>';

            if ($row ['p2pstatus'] == 4 && $row ['status'] == 1) { //满标未划拔
                $row ['p_status'] = '等待操盘帐号分配';
            }
            if (!$row['sp_user'] && $row ['p2pstatus'] == 6) {
                $row['p_status'] = '即将分配操盘帐号';
            }
            if ($row ['status'] == 3) {
                $row ['p_status'] = '申请结束操盘，等待清算中';
            }
            if ($row ['p2pstatus'] >= 6 && $row ['status'] == 4) { //可能存在终止操盘，但不结束策略
                $cpyk = intval($row ['profit_loss_money'] / 100);
                $cpyk = $cpyk > 0 ? '<span class="red">' . $cpyk . '</span>' : '<span class="green">' . $cpyk . '</span>';
                $row ['p_status'] = '已平仓结束<br/>操盘盈亏：' . $cpyk;
            }
            $dataList [] = $row;
        }

        $user = $this->user;

        $user ['total_pz'] = \Model\P2p\Peizi::getInfoByUid($uid, 'pz_money'); //策略总金额
        $this->assign('pager', $res ['pager']);
        $this->assign('dataList', $dataList);

        $this->assign('user_peizi', $user);
        $this->template('p2p_peizi.php');
    }

    //我的投资
    public function p2p_touzi() {
        $this->setTitle('我的投资—' . SITE_TITLE);
        $uid = $this->uid;
        $user = $this->user;
        $total_bj = \Model\P2p\Touzi::getInfoByUid($uid, 'tz_money'); //累计投资
        $total_ysbj = \Model\P2p\Touzi::getInfoByUid($uid, 'tz_money', 1); //已收本金
        $total_dsbj = $total_bj - $total_ysbj; //待收本金


        $total_yslx = \Model\P2p\Touzi::getInfoByUid($uid, 'earned_interest'); //已收利息
        $total_dslx = \Model\P2p\Touzi::getInfoByUid($uid, 'plan_interest', 2); //待收利息
        $total_sy = $total_yslx + $total_dslx; //累计收益


        $user ['total_bj'] = $total_bj;
        $user ['total_ysbj'] = $total_ysbj;
        $user ['total_dsbj'] = $total_dsbj;
        $user ['total_yslx'] = $total_yslx;
        $user ['total_dslx'] = $total_dslx;
        $user ['total_sy'] = $total_sy;

        $datetype = isset($_GET ['datetype']) ? intval($_GET ['datetype']) : 1;
        $page = isset($_GET ['page']) ? intval($_GET ['page']) : 1;
        $status = isset($_GET ['status']) ? intval($_GET ['status']) : '';
        $where = ' WHERE t.uid=' . $uid;
        if ($status) {
            $where .= $status == 1 ? ' AND (p.p2pstatus!=7 AND p.p2pstatus!=3)' : ' AND (p.p2pstatus=3 OR p.p2pstatus=7)';
        }
        $time = time();
        if ($datetype == 2) { //三天内
            $time_tmp = $time - 3 * 24 * 60 * 60;
            $where .= ' AND t.tz_time>=' . $time_tmp;
        } else if ($datetype == 3) { //一周内
            $time_tmp = $time - 7 * 24 * 60 * 60;
            $where .= ' AND t.tz_time>=' . $time_tmp;
        } else if ($datetype == 4) { //一月内
            $time_tmp = $time - 30 * 24 * 60 * 60;
            $where .= ' AND t.tz_time>=' . $time_tmp;
        } else if ($datetype == 5) { //三月内
            $time_tmp = $time - 90 * 24 * 60 * 60;
            $where .= ' AND t.tz_time>=' . $time_tmp;
        } else if ($datetype == 6) { //一年内
            $time_tmp = $time - 365 * 24 * 60 * 60;
            $where .= ' AND t.tz_time>=' . $time_tmp;
        }

        $selarr = array('t.tz_id', 't.pz_id', 'p.pz_money', 'p.year_rate', 'p.year_rate', 'p.fencheng_rate', 't.plan_interest', 't.tz_money', 't.earned_interest', 't.tz_time', 'p.end_time', 'p.p2pstatus');
        $order = ' ORDER BY t.tz_time DESC';
        $res = \Common\Pager::getList('user_peizi_touzi as t left join user_peizi as p on t.pz_id=p.pz_id', $where, $selarr, $order, $page, 10);
        $dataList = array();
        $status = array('0' => '未交保证金', '1' => '等待审核', '2' => '募资中', '3' => '过期废标', '4' => '满标', '5' => '申请结束操盘，等待清算中', '6' => '操盘中', '7' => '已平仓结束');
        foreach ($res ['data'] as $row) {
            $row ['p_status'] = isset($row ['p2pstatus']) ? $status [$row ['p2pstatus']] : '过期废标';
            $dataList [] = $row;
        }

        $this->assign('datetype', $datetype);
        $this->assign('pager', $res ['pager']);
        $this->assign('dataList', $dataList);

        $this->assign('user_touzi', $user);
        $this->template('p2p_touzi.php');
    }

    //我的投资
    public function p2p_touzi_detail() {
        $this->setTitle('投资详情—' . SITE_TITLE);

        $tz_id = isset($_GET ['tz_id']) ? intval($_GET ['tz_id']) : 0;
        $uid = $this->uid;
        $data = \Model\P2p\Touzi::getTouziInfoById($uid, $tz_id);
        if (!$data) {
            $this->fontRedirect('该投资单号不存在', \App::URL('web/user/p2p_touzi'));
        }
        $this->assign('data', $data);
        $this->template('touzi_detail.php');
    }

    //推广
    public function tuiguang() {
        $this->setTitle('推广记录—' . SITE_TITLE);

        $curpage = isset($_GET ['page']) ? intval($_GET ['page']) : 1;
        $pagesize = 15;
        $where = ' WHERE introducer_id=' . $this->uid;
        $time = time();

        $order = ' ORDER BY uid desc';
        $res = \Common\Pager::getList('user_info', $where, array(), $order, $curpage, $pagesize, 1);
        $site_base = \Model\Admin\Params::get ( 'site_base' );
        $this->assign('site_base', $site_base);
        $this->assign('user', $this->user);
        $this->assign('rows', $res ['data']);
        $this->assign('pager', $res ['pager']);
        $this->template('tuiguang.php');
    }
    //推广用户
    public function tuiguang_user() {
        $this->setTitle('推广记录—' . SITE_TITLE);
        $search_param['begindate'] = isset($_GET ['begindate']) ? $_GET ['begindate'] : '';
        $search_param['enddate'] = isset($_GET ['enddate']) ? $_GET ['enddate'] : '';

        $curpage = isset($_GET ['page']) ? intval($_GET ['page']) : 1;
        $pagesize = 15;
        $where = ' WHERE introducer_id=' . $this->uid;
        if(!empty($search_param['begindate']))
        {
            $where.=' and reg_time>='.strtotime($search_param['begindate']);
        }
        if(!empty($search_param['enddate']))
        {
            $where.=' and reg_time<='.strtotime($search_param['enddate'].'23:59:59');
        }
        
        $time = time();
        $order = ' ORDER BY uid desc';
        $res = \Common\Pager::getList('user_info', $where, array(), $order, $curpage, $pagesize, 1);
        $site_base = \Model\Admin\Params::get ( 'site_base' );
        $this->assign('search_param',$search_param);
        $this->assign('site_base', $site_base);
        $this->assign('user', $this->user);
        $this->assign('rows', $res ['data']);
        $this->assign('pager', $res ['pager']);
        $this->template('tuiguang_user.php');
    }
    //充值记录
    public function tuiguang_recharge() {
        $this->setTitle('充值记录—' . SITE_TITLE);
        $search_param['begindate'] = isset($_GET ['begindate']) ? $_GET ['begindate'] : '';
        $search_param['enddate'] = isset($_GET ['enddate']) ? $_GET ['enddate'] : '';
        $users = \Common\Query::select('user_info', array('introducer_id'=>$this->uid), array('uid'));
        $uids = array();
        if($users){
            foreach ($users as $user) {
                $uids[] = $user['uid'];
            }
        }
        else{
            $uids = array(0);
        }
        $curpage = isset($_GET ['page']) ? intval($_GET ['page']) : 1;
        $pagesize = 15;
        $where = ' WHERE r.status=1 and r.uid in ('. implode(',', $uids).')';
        if(!empty($search_param['begindate']))
        {
            $where.=' and rtime>='.strtotime($search_param['begindate']);
        }
        if(!empty($search_param['enddate']))
        {
            $where.=' and rtime<='.strtotime($search_param['enddate'].'23:59:59');
        }
        $time = time();

        $order = ' ORDER BY r.rtime desc';
        $res = \Common\Pager::getList('v_recharge_record r left join user_info u on r.uid=u.uid', $where, array("r.rtime","r.money","u.mobile","u.true_name"), $order, $curpage, $pagesize, 1);
        $total = \Common\Pager::getList('v_recharge_record r left join user_info u on r.uid=u.uid', $where, array("''","sum(r.money) money","'合计' as mobile","''"), $order, $curpage, $pagesize, 1);
        $this->assign('search_param',$search_param);
        $this->assign('user', $this->user);
        $this->assign('rows', $res ['data']);
        $this->assign('total',$total['data']);
        $this->assign('pager', $res ['pager']);
        $this->template('tuiguang_recharge.php');
    }
    
    //提现记录
    public function tuiguang_withdraw() {
        $this->setTitle('提现记录—' . SITE_TITLE);
        $search_param['begindate'] = isset($_GET ['begindate']) ? $_GET ['begindate'] : '';
        $search_param['enddate'] = isset($_GET ['enddate']) ? $_GET ['enddate'] : '';
        $search_param['status']= isset($_GET ['status']) ? $_GET ['status'] : '';
        $users = \Common\Query::select('user_info', array('introducer_id'=>$this->uid), array('uid'));
        $uids = array();
        if($users){
            foreach ($users as $user) {
                $uids[] = $user['uid'];
            }
        }
        else{
            $uids = array(0);
        }
        $curpage = isset($_GET ['page']) ? intval($_GET ['page']) : 1;
        $pagesize = 15;
        $where = ' WHERE r.status=1 and r.uid in ('. implode(',', $uids).')';
        
        if(!empty($search_param['begindate']))
        {
            $where.=' and r.rtime>='.strtotime($search_param['begindate']);
        }
        if(!empty($search_param['enddate']))
        {
            $where.=' and r.rtime<='.strtotime($search_param['enddate'].'23:59:59');
        }
        $time = time();
        $withdrawstatus=array(0=>'未完成',1=>'已审核',2=>'已完成');
        $order = ' ORDER BY r.rtime desc';
        $res = \Common\Pager::getList('user_withdraw_record r left join user_info u on r.uid=u.uid', $where, array("u.true_name","r.rtime","r.money",'u.mobile'), $order, $curpage, $pagesize, 1);
        $total = \Common\Pager::getList('user_withdraw_record r left join user_info u on r.uid=u.uid', $where, array("'合计' as true_name",  "''","sum(r.money) money","''"), $order, $curpage, $pagesize, 1);
        $this->assign('search_param',$search_param);
        $this->assign('user', $this->user);
        $this->assign('withdrawstatus',$withdrawstatus);
        $this->assign('rows', $res ['data']);
        $this->assign('total',$total['data']);
        $this->assign('pager', $res ['pager']);
        $this->template('tuiguang_withdraw.php');
    }
    
    //策略记录
    public function tuiguang_peizi() {
        $this->setTitle('策略记录—' . SITE_TITLE);
        $search_param['begindate'] = isset($_GET ['begindate']) ? $_GET ['begindate'] : '';
        $search_param['enddate'] = isset($_GET ['enddate']) ? $_GET ['enddate'] : '';
        $search_param['status'] = isset($_GET ['status']) ? $_GET ['status'] : '';
        $users = \Common\Query::select('user_info', array('introducer_id'=>$this->uid), array('uid'));
        $uids = array();
        if($users){
            foreach ($users as $user) {
                $uids[] = $user['uid'];
            }
        }
        else{
            $uids = array(0);
        }
        $curpage = isset($_GET ['page']) ? intval($_GET ['page']) : 1;
        $pagesize = 15;
        $where = ' WHERE pz.pz_type in(1,2) and pz.uid in ('. implode(',', $uids).')';
        if(!empty($search_param['begindate']))
        {
            $where.=' and pz.pz_time>='.strtotime($search_param['begindate']);
        }
        if(!empty($search_param['enddate']))
        {
            $where.=' and pz.pz_time<='.strtotime($search_param['enddate'].'23:59:59');
        }
        if(!empty($search_param['status']))
        {
            if(intval($search_param['status'])==4)
            {
                $where.=' and pz.status=4';
            }
            else
            {
                $where.=' and pz.status in(0,1,2,3)';
            }
        }
        $time = time();
        $order = ' ORDER BY pz.pz_id desc';
        $res = \Common\Pager::getList('user_peizi pz left join user_info u on pz.uid=u.uid', $where, array("pz.pz_id","pz.pz_type","pz.pz_times","pz.pz_time","pz.bond_total","pz.pz_ratio","pz.manage_cost_day","pz.status","pz.profit_loss_money","u.mobile","u.true_name"), $order, $curpage, $pagesize, 1);
        $total = \Common\Pager::getList('user_peizi pz left join user_info u on pz.uid=u.uid', $where, array("'合计' as pz_id","''","''","''","sum(pz.bond_total*pz.pz_ratio) as  bond_total","''","''","''","sum(pz.manage_cost_day) as manage_cost_day","sum(pz.profit_loss_money) as profit_loss_money","''","''"), $order, $curpage, $pagesize, 1);
        
        $peizistatus=array(0=>'创建',1=>'已支付',2=>'操盘中',3=>'用户提出结算',4=>'结束');
        $this->assign('peizistatus',$peizistatus);
        $this->assign('search_param',$search_param);
        $this->assign('user', $this->user);
        $this->assign('rows', $res ['data']);
        $this->assign('total',$total['data']);
        $this->assign('pager', $res ['pager']);
        $this->template('tuiguang_peizi.php');
    }
    
    
    //佣金记录
    public function tuiguang_fund() {
        $this->setTitle('管理费—' . SITE_TITLE);

        $curpage = isset($_GET ['page']) ? intval($_GET ['page']) : 1;
        $pagesize = 15;
        $where = ' WHERE f.type=200 and f.uid=' . $this->uid;
        $time = time();

        $order = ' ORDER BY f.fund_id desc';
        $res = \Common\Pager::getList('user_fund_record f left join user_peizi pz on f.rec_id=pz.pz_id', $where, array("f.rtime","f.money","pz.pz_id","pz.manage_cost_day"), $order, $curpage, $pagesize, 1);

        $this->assign('user', $this->user);
        $this->assign('rows', $res ['data']);
        $this->assign('pager', $res ['pager']);
        $this->template('tuiguang_fund.php');
    }
    public function peizi_add() {
        $pz_id = intval($_GET['pz_id']);
        $pz_row = \Model\Peizi\Peizi::getById($pz_id, $this->uid);
        if($pz_row['pz_type'] == 1){
            $params = \Model\Admin\Params::get('peizi');
            $sheng_days = \Model\Peizi\Peizi::calcAddDaysDay($pz_row['end_time']);
        }
        else if($pz_row['pz_type'] == 2){
            $params = \Model\Admin\Params::get('peizi_month');
            $sheng_days = \Model\Peizi\Peizi::calcAddDaysMonth($pz_row['end_time']);
        }
        $this->assign('sheng_days',$sheng_days);
        $this->assign('params',$params);
        
        $this->assign("pz_id", $pz_id);
        $this->assign("pz_row", $pz_row);
        $this->assign('user', $this->user);
        $this->template('peizi_add.php');
    }
    public function peizi_filllose() {
        $this->assign("pz_id", intval($_GET['pz_id']));
        $this->assign('user', $this->user);
        $this->template('peizi_filllose.php');
    }
    public function peizi_getprofit() {
        $this->assign("pz_id", intval($_GET['pz_id']));
        $this->assign('user', $this->user);
        $this->template('peizi_getprofit.php');
    }
    public function peizi_end() {
        $this->assign("pz_id", intval($_GET['pz_id']));
        $this->assign('user', $this->user);
        $this->template('peizi_end.php');
    }
    //补亏
    public function do_peizi_filllose() {
        $money = isset($_POST ['money']) ? floatval($_POST ['money']) * 100 : 0;
        $pz_id = isset($_POST ['pz_id']) ? floatval($_POST ['pz_id']) : 0;
        $pz_row = \Model\Peizi\Peizi::getById($pz_id, $this->uid);
        if(empty($pz_row)){
            $result ['code'] = 0;
            $result ['msg'] = '参数错误';
            exit(json_encode($result));
        }
        $result = array();

        if ($pz_row ['pz_type'] == 4) { //免费试玩
            $result ['code'] = 0;
            $result ['msg'] = '禁止操作';
            exit(json_encode($result));
        }
        if ($pz_row ['status'] != 2){ //非操盘
            $result ['code'] = 0;
            $result ['msg'] = '非操盘中，禁止操作';
            exit(json_encode($result));
        }
        if ($money <= 0 || $pz_id == 0) {
            $result ['code'] = 0;
            $result ['msg'] = '参数错误';
            exit(json_encode($result));
        }
        \Common\Query::commitstart();
        $res = \Model\Peizi\FillLoss::add($pz_id, $money);
        if (empty($res)) {
            \Common\Query::rollback();
            $result ['code'] = 0;
            $result ['msg'] = '补亏提交失败';
            exit(json_encode($result));
        }
        $res = \Model\User\Fund::fillLoss($this->uid, $money, $pz_id);
        if (empty($res [0])) {
            \Common\Query::rollback();
            $result ['code'] = 0;
            $result ['msg'] = $res [1];
            exit(json_encode($result));
        }
        \Common\Query::commit();
        $result ['code'] = 1;
        $result ['msg'] = '补亏提交成功，请等待处理！';
        exit(json_encode($result));
    }

    //策略追加
    public function do_peizi_add() {
        $bond = isset($_POST ['money']) ? floatval($_POST ['money']) * 100 : 0;//保证金
        $pz_id = isset($_POST ['pz_id']) ? floatval($_POST ['pz_id']) : 0;
        $pz_row = \Model\Peizi\Peizi::getById($pz_id, $this->uid);
        if(empty($pz_row)){
            $result ['code'] = 0;
            $result ['msg'] = '参数错误';
            exit(json_encode($result));
        }
        $result = array();
        if ($pz_row ['pz_type'] == 3 || $pz_row ['pz_type'] == 4) { //p2p,免费试玩
            $result ['code'] = 0;
            $result ['msg'] = '禁止操作';
            exit(json_encode($result));
        }
        if ($pz_row ['status'] != 2){ //非操盘
            $result ['code'] = 0;
            $result ['msg'] = '非操盘中，禁止操作';
            exit(json_encode($result));
        }
        if ($bond <= 0 || $pz_id == 0) {
            $result ['code'] = 0;
            $result ['msg'] = '参数错误';
            exit(json_encode($result));
        }
        $calc = array();
        if($pz_row['pz_type'] == 1){
            //按天
            $calc = \Model\Peizi\Peizi::calc_month($this->uid,$pz_row['pz_type'], intval($bond) / 100, $pz_row ['pz_ratio']);
        }
        elseif($pz_row['pz_type'] == 2){
            //按月
            $calc = \Model\Peizi\Peizi::calc_month($this->uid,$pz_row['pz_type'], intval($bond) / 100, $pz_row ['pz_ratio']);
        }
        if ($calc [0] == 0) {
            $result ['code'] = 0;
            $result ['msg'] = $calc [1];
            exit(json_encode($result));
        }
        $feiyong = $calc [1];
        $manage_cost_money = $feiyong ['manage_cost_day'];
        //计算实际剩余天数的费用，按天的计算另外还要写
        if($pz_row['pz_type'] == 1){
            $manage_cost_money = \Model\Peizi\Peizi::calcAddManagerCostDay($pz_row,$manage_cost_money);
        }
        elseif($pz_row['pz_type'] == 2){
            $manage_cost_money = \Model\Peizi\Peizi::calcAddManagerCostMonth($pz_row,$manage_cost_money);
        }
        $money = $feiyong ['caopan_money'];
        if ($this->user ['balance'] < $bond) {
            \Common\Query::rollback();
            $result ['code'] = 0;
            $result ['msg'] = '余额不足';
            exit(json_encode($result));
        }
        if ((floatval($this->user ['balance']) + floatval($this->user ['send'])) < ($manage_cost_money + $bond)) {
            \Common\Query::rollback();
            $result ['code'] = 0;
            $result ['msg'] = '余额不足';
            exit(json_encode($result));
        }
        \Common\Query::commitstart();
        //追加保证金
        $res = \Model\User\Fund::bond($this->uid, $bond, $pz_id);
        if ($res [0] == 0) {
            \Common\Query::rollback();
            $result ['code'] = 0;
            $result ['msg'] = $res [1];
            exit(json_encode($result));
        }
        //添加记录
        $alarm_money = $pz_row ['alarm_money'] + $feiyong ['alarm_money'];
        $stop_money = $pz_row ['stop_money'] + $feiyong ['stop_money'];
        $res = \Model\Peizi\Add::add($pz_id, $money, $bond, $alarm_money, $stop_money);
        if (empty($res)) {
            \Common\Query::rollback();
            $result ['code'] = 0;
            $result ['msg'] = '追加失败';
            exit(json_encode($result));
        }
        /* $res = \Model\Peizi\Peizi::doAdd($this->uid,$pz_id, $money);
          if(empty($res[0])){
          \Common\Query::rollback();
          $result['status'] = 0;
          $result['msg'] = $res[1];
          exit(json_encode($result));
          } */
        \Common\Query::commit();
        $result ['code'] = 1;
        $result ['msg'] = '追加成功，请等待处理！';
        exit(json_encode($result));
    }

    //用户申请终止策略
    public function do_peizi_end() {
        $pz_id = isset($_POST ['pz_id']) ? floatval($_POST ['pz_id']) : 0;
        $pz_row = \Model\Peizi\Peizi::getById($pz_id, $this->uid);
        if(empty($pz_row)){
            $result ['code'] = 0;
            $result ['msg'] = '参数错误';
            exit(json_encode($result));
        }
        if ($pz_row ['status'] != 2){ //非操盘
            $result ['code'] = 0;
            $result ['msg'] = '非操盘中，禁止操作';
            exit(json_encode($result));
        }
        if ($pz_id == 0) {
            $result ['code'] = 0;
            $result ['msg'] = '参数错误';
            exit(json_encode($result));
        }
        //有追加实盘数据
        $row = \Common\Query::selone('user_peizi_add', array('pz_id' => $pz_id, 'status' => 0));
        if ($row) {
            $result ['code'] = 0;
            $result ['msg'] = '有追加实盘金记录未审核';
            exit(json_encode($result));
        }
        //有补亏数据
        $row = \Common\Query::selone('user_peizi_fillloss', array('pz_id' => $pz_id, 'status' => 0));
        if ($row) {
            $result ['code'] = 0;
            $result ['msg'] = '有补亏记录未审核';
            exit(json_encode($result));
        }
        $res = \Model\Peizi\Peizi::userEnd($this->uid, $pz_id);
        if ($res) {
            $result ['code'] = 1;
            $result ['msg'] = '申请成功';
            exit(json_encode($result));
        }
        $result ['code'] = 0;
        $result ['msg'] = '申请失败';
        exit(json_encode($result));
    }
    public function do_peizi_getprofit() {
        $money = isset($_POST ['money']) ? floatval($_POST ['money']) * 100 : 0;
        $pz_id = isset($_POST ['pz_id']) ? floatval($_POST ['pz_id']) : 0;
        $pz_row = \Model\Peizi\Peizi::getById($pz_id, $this->uid);
        if(empty($pz_row)){
            $result ['code'] = 0;
            $result ['msg'] = '参数错误';
            exit(json_encode($result));
        }
        $result = array();

        if ($pz_row ['pz_type'] == 4) { //免费试玩
            $result ['code'] = 0;
            $result ['msg'] = '禁止操作';
            exit(json_encode($result));
        }
        if ($pz_row ['status'] != 2){ //非操盘
            $result ['code'] = 0;
            $result ['msg'] = '非操盘中，禁止操作';
            exit(json_encode($result));
        }
        if ($money <= 0 || $pz_id == 0) {
            $result ['code'] = 0;
            $result ['msg'] = '参数错误';
            exit(json_encode($result));
        }
        \Common\Query::commitstart();
        $res = \Model\Peizi\GetProfit::add($this->uid,$pz_id, $money);
        if (empty($res)) {
            \Common\Query::rollback();
            $result ['code'] = 0;
            $result ['msg'] = '盈利提取申请失败';
            exit(json_encode($result));
        }
        \Common\Query::commit();
        $result ['code'] = 1;
        $result ['msg'] = '盈利提取申请成功';
        exit(json_encode($result));
    }
    public function peizi_spaccount() {
        $pz_id = intval($_GET['pz_id']);
        $pz_row = \Model\Peizi\Peizi::getById($pz_id, $this->uid);
        $this->assign("pz_row", $pz_row);
        $this->template('peizi_spaccount.php');
    }
    public function sign(){
        $res = \Model\User\Sign::sign($this->uid);
        exit(json_encode($res));
    }
}
