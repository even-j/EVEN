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
class peizi extends \apps\ViewsControl {
    //put your code here
    public function day() {
    	$title = '按天配资-'.SITE_TITLE;
        $this->setTitle($title);
        $params = \Model\Admin\Params::get('peizi');
        $params = \Model\Admin\Params::vip($this->uid, $params);
        $this->assign('params',$params);
        $this->template ( 'day.php' );
    }
	
    public function free() {
    	$title = '免费体验-'.SITE_TITLE;
        $this->setTitle($title);
        $count = \Model\Peizi\Peizi::getPeiziFreeCountCurDay();
        $params = \Model\Admin\Params::get('peizi_free');
        $var['isChaogeshu'] = 0;
        if($count>=$params['per_day_count']){
            $var['isChaogeshu'] = 1;
        }
        $this->assign('var',$var);
        $this->assign('params',$params);
        $this->template ( 'free.php' );
    }
    public function month() {
        $title = '按月策略-'.SITE_TITLE;
        $this->setTitle($title);
        $params = \Model\Admin\Params::get('peizi_month');
        $params = \Model\Admin\Params::vip($this->uid, $params);
        $this->assign('params',$params);
        $this->template ( 'month.php' );
    }
    
    public function qihuo() {
        $data = \Model\Admin\ArticleType::getArticleTypeByUrl(\App::get('currentactions'));
    	$title = isset($data) && $data['title'] ? $data['title'] : $data['name'];
    	$keywords = isset($data) && $data['tags'] ? $data['tags'] : $data['name'].','.SITE_NAME;
    	$description = isset($data) && $data['description'] ? $data['description'] : ''.SITE_NAME.$data['name'];
    	
        $this->setTitle($title.'—'.SITE_NAME);
        $this->setKeywords($keywords);
        $this->setDescription($description);
        
        $params = \Model\Admin\Params::get('peizi_qihuo');
        $this->assign('params',$params);
        $this->template ( 'qihuo.php' );
    }
    
    public function p2p() {
        $this->setTitle('策略炒股_'.SITE_NAME);
        $row_max = \Common\Query::selone('user_peizi', array('pz_type'=>3,'p2pstatus'=>2), array('max(year_rate) year_rate_max'));
        $row_avg = \Common\Query::selone('user_peizi', array('pz_type'=>3), array('avg(year_rate) year_rate_avg'));
        $year_rate_max = ($row_max && !empty($row_max['year_rate_max'])) ? $row_max['year_rate_max'] : round($row_avg['year_rate_avg'], 2);
        
        $helpList = \Model\Admin\Article::getArticleList(7);
        $params = \Model\Admin\Params::get('p2p');
        $this->assign('year_rate_max',$year_rate_max);
        $this->assign('params',$params);
        $this->assign('helpList',$helpList);
        $this->template ( 'p2p.php' );
    }
    
    public function p2p_fc() {
        $data = \Model\Admin\ArticleType::getArticleTypeByUrl(\App::get('currentactions'));
    	$title = isset($data) && $data['title'] ? $data['title'] : $data['name'];
    	$keywords = isset($data) && $data['tags'] ? $data['tags'] : $data['name'].','.SITE_NAME;
    	$description = isset($data) && $data['description'] ? $data['description'] : ''.SITE_NAME.$data['name'];
    	
        $this->setTitle($title.'—'.SITE_NAME);
        $this->setKeywords($keywords);
        $this->setDescription($description);
        
        $helpList = \Model\Admin\Article::getArticleList(7);
        $params = \Model\Admin\Params::get('p2p');
        $this->assign('params',$params);
        $this->assign('helpList',$helpList);
        $this->template ( 'p2p_fc.php' );
    }
    
    //借款协议
    public function p2p_protocol() {
        $this->setTitle('借款协议—'.SITE_NAME);
        $pz_id = isset ( $_GET ['pz_id'] ) ? intval ( $_GET ['pz_id'] ) : 0;
        $peizi = \Model\Peizi\Peizi::getById($pz_id);
        $touziList = \Model\P2p\Touzi::getListById($pz_id);
        if($peizi){
        	$user = \Model\User\UserInfo::getinfo($peizi['uid']);
        	$user ['card_info'] = substr_replace ( $user ['id_card'], '****', 10, 4 );
        	$user ['mobile_info'] = substr_replace ( $user ['mobile'], '****', 3, 4 );
        	$peizi['user'] = $user;
        	$p2p = \Model\P2p\Peizi::getPeiziById($peizi['uid'], $pz_id);
        	$peizi['p2p'] = $p2p;
        }
        
        $this->assign('peizi',$peizi);
        $this->assign('touziList',$touziList);
        
        $this->template ( 'p2p_protocol.php' );
    }
    
    public function earn1() {
        $this->setTitle('投资理财_高息投资理财_'.SITE_NAME);
        $orderfield = isset($_GET['orderfield']) ?$_GET['orderfield']:'pz_time';
        $ordertype = isset($_GET['ordertype']) ?$_GET['ordertype']:'desc';
        $p2pstatus = isset($_GET['p2pstatus']) ?$_GET['p2pstatus']:'0';//0为全部，1为可投
        $dh = isset($_GET['dh']) ?$_GET['dh']:'';
        
        $curpage = isset($_GET['page']) ?$_GET['page']:1;
        $pagesize = 8;
        $table = 'user_peizi p2p left join user_info u on p2p.uid=u.uid';
        $where = ' WHERE p2p.p2pstatus>1 ';
        if($dh!=''){
            $s_id = substr($dh, 8);
            $where .= ' and pz_id='.intval($s_id);
        }
        if($p2pstatus>0){
            $where .= ' and p2p.p2pstatus=2';
        }
		$order = ' ORDER BY '.$orderfield.' '.$ordertype;
        $res= \Common\Pager::getList($table, $where, array('p2p.*','u.true_name','u.id_card'), $order, $curpage, $pagesize);
        $p2p_rows = $res['data'];
        $pager = $res['pager'];
        $var['orderfield'] = $orderfield;
        $var['ordertype'] = $ordertype;
        $var['dh'] = $dh;
        $var['p2pstatus'] = $p2pstatus;
        //策略动态
        $where = " WHERE FROM_UNIXTIME(`tz_time`,'%Y-%m-%d')=current_date()"; 
		$selarr = array ('`uid`','`tz_time`','`tz_money`');
		$order = ' ORDER BY `tz_time` DESC';
		$res = \Common\Pager::getList ( 'user_peizi_touzi', $where, $selarr, $order, 1, 10);
		$touziList = array();
    	foreach ($res ['data'] as $data){
    		$data['user'] = \Model\User\UserInfo::getinfo($data['uid']);
			$touziList[] = $data;
		}
			
        //新手指引
        $helpList = \Model\Admin\Article::getArticleList(7);
        $this->assign('helpList',$helpList);
        $this->assign('touziList',$touziList);
        $this->assign('var',$var);
        $this->assign('p2p_rows',$p2p_rows);
        $this->assign('pager',$pager);
        $this->template ( 'earn1.php' );
    }
    public function earn2() {
        $pz_id = isset($_GET['pz_id'])?intval($_GET['pz_id']):0;
        $row = \Model\P2p\Peizi::getRowById($pz_id);
        $pz_user = \Model\User\UserInfo::getinfo($row['uid']);
        
        $title = \App::msubstr($pz_user['true_name'], 0, 1).\App::getSexy($pz_user['id_card']).'借款'.$row['pz_money']/10000/100 .'万元|市值'.($row['pz_money']+$row['bond_total'])/10000/100 .'万元股票做质押'; 
        $this->setTitle($title.'—'.SITE_NAME);
        
        $tz_rows = \Model\P2p\Touzi::getRowsByPz_id($pz_id);
        
        $var['touzi_money'] = \Model\P2p\Peizi::getTouziMoney($pz_id);
        $var['touzi_users'] = \Model\P2p\Peizi::getTouziUsers($pz_id);
        $var['touzi_per'] = round($var['touzi_money']/$row['pz_money']*100,2);
        
        $feiyong = \Model\P2p\Peizi::calc($this->uid, $row['pz_money']/10000/100, $row['pz_ratio'], $row['pz_times_unit'], $row['pz_times'], $row['year_rate']);
        $feiyong_1 = \Model\P2p\Peizi::calc($this->uid, 1, $row['pz_ratio'], $row['pz_times_unit'], $row['pz_times'], $row['year_rate']);
        
        $this->assign('feiyong',$feiyong);
        $this->assign('feiyong_1',$feiyong_1);
        $this->assign('var',$var);
        $this->assign('row',$row);
        $this->assign('tz_rows',$tz_rows);
        $this->assign('pz_user',$pz_user);
        $this->assign('user',  $this->user);
        $this->template ( 'earn2.php' );
    }
    
    public function earn4() {
        $title = \App::msubstr($pz_user['true_name'], 0, 1).\App::getSexy($pz_user['id_card']).'借款'.$row['pz_money']/10000/100 .'万元|市值'.($row['pz_money']+$row['bond_total'])/10000/100 .'万元股票做质押'; 
    	$this->setTitle($title.'—'.SITE_NAME);
        $this->template ( 'earn4.php' );
    }
    
    public function earn4_1() {
        $title = \App::msubstr($pz_user['true_name'], 0, 1).\App::getSexy($pz_user['id_card']).'借款'.$row['pz_money']/10000/100 .'万元|市值'.($row['pz_money']+$row['bond_total'])/10000/100 .'万元股票做质押'; 
        $this->setTitle($title.'—'.SITE_NAME);
        $this->template ( 'earn4_1.php' );
    }
    

    public function paycallback1(){
        $pay_xinqidian = \apps\Config::getInstance()->pay_xinqidian;
        $SalfStr = $pay_xinqidian['key'];
        $UserId=$_REQUEST["P_UserId"];
        $OrderId = $_REQUEST["P_OrderId"];
        $CardId = $_REQUEST["P_CardId"];
        $CardPass = $_REQUEST["P_CardPass"];
        $FaceValue = $_REQUEST["P_FaceValue"];
        $ChannelId = $_REQUEST["P_ChannelId"];

        $subject = $_REQUEST["P_Subject"];
        $description = $_REQUEST["P_Description"];
        $price = $_REQUEST["P_Price"];
        $quantity = $_REQUEST["P_Quantity"];
        $notic = $_REQUEST["P_Notic"];
        $ErrCode = $_REQUEST["P_ErrCode"];
        $PostKey = $_REQUEST["P_PostKey"];
        $payMoney = $_REQUEST["P_PayMoney"];

        $preEncodeStr = $UserId . "|" . $OrderId . "|" . $CardId . "|" . $CardPass . "|" . $FaceValue . "|" . $ChannelId . "|" . $SalfStr;
        $encodeStr = md5($preEncodeStr);

        echo "errCode=0";
        if ($PostKey == $encodeStr) {
            if ($ErrCode == "0") { //支付成功
                //设置为成功订单,主意订单的重复处理
                \Common\Query::commitstart();
                $res = \Model\User\Fund::recharge($OrderId);
                if($res[0] == 1){
                    \Common\Query::commit();
                }
                else{
                    \Common\Query::rollback();
                }
            } else {
                //支付失败
                echo "-err";
            }
        } else {
            echo "-数据被传改";
        }
    }
    public function payback1(){
        $msg = '支付成功';
        $this->assign("msg",$msg);
        $this->template ( 'payback1.php' );
    }
	
}
