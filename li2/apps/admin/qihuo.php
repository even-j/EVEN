<?php

namespace apps\admin;
class qihuo extends \apps\AdminControl {
	//实盘资金划拨
	public function fund(){
            $this->setTitle('实盘资金划拨');
            $pagesize = 20;
            $condition['order_id'] = isset ( $_GET ['order_id'] ) ? $_GET ['order_id'] : '';
            $condition['status'] = isset ( $_GET ['status'] ) ? $_GET ['status'] : '1';
            $condition['begindate'] = isset ( $_GET ['begindate'] ) ? $_GET ['begindate'] : '';
            $condition['enddate'] = isset ( $_GET ['enddate'] ) ? $_GET ['enddate'] : '';
            $curpage = isset ( $_GET ['page'] ) ? intval ( $_GET ['page'] ) : 1;
            $where = ' WHERE (pz.pz_type=7)';
            if(!empty($condition['order_id'])){
                $pz_id = substr($condition['order_id'], 8);
                $where .= ' and pz.pz_id='.intval($pz_id);
            }
            if($condition['status']==''){
                $where .= ' and (pz.status>0)';
            }
            else if($condition['status']=='1'){
                $where .= ' and pz.status=1';
            }
            else{
                $where .= ' and pz.status>1';
            }
            if ($condition['begindate'] && $condition['enddate']) {
                $where .= " AND (FROM_UNIXTIME(pz.pz_time,'%Y-%m-%d')>='" . ($condition['begindate']) . "' AND FROM_UNIXTIME(pz.pz_time,'%Y-%m-%d')<='" . ($condition['enddate']) . "')";
            }
            $selarr = array ('pz.*' ,'u.true_name');
            $order = ' ORDER BY pz.pz_time DESC';
            $res = \Common\Pager::getList ( 'user_peizi pz left join user_info u on pz.uid=u.uid', $where, $selarr, $order, $curpage, $pagesize, 1 );

            $this->assign ( 'list', $res['data']);
            $this->assign ( 'pager', $res ['pager'] );
            $this->assign ( 'condition', $condition);
	    $this->template ( 'fund.php' );		
	}
        public function fundedit(){
            $this->setTitle('实盘资金划拨');
            $this->setNavtitle('实盘资金划拨');
            $pz_id = isset($_GET['pz_id'])?intval($_GET['pz_id']):0;
            $pz_row = \Common\Query::selone('user_peizi', array('pz_id'=>  intval($pz_id)));
            $this->assign('pz_row',$pz_row);
            $this->template ( 'fundedit.php' );
        }
        public function doFundEdit(){
            $pz_id = isset($_POST['pz_id'])?intval($_POST['pz_id']):0;
            $sp_user = isset($_POST['sp_user'])?\App::t($_POST['sp_user']):'';
            $sp_pwd = isset($_POST['sp_pwd'])?\App::t($_POST['sp_pwd']):'';
            $status = isset($_POST['status'])?intval($_POST['status']):0;
            $peizi_row = \Model\Peizi\Peizi::getById($pz_id);
            $url = '/index.php?app=admin&mod=qihuo&ac=fundedit&pz_id='.$pz_id;
            if(empty($pz_id)){
                $this->fontRedirect('参数错误', 'back',2);
                exit();
            }
            if($peizi_row['status']==$status){
                $this->fontRedirect('状态值未变化', 'back',2);
                exit();
            }
            if(empty($sp_user)){
                $this->fontRedirect('证券账户不能为空', $url,2);
                exit();
            }
            if(empty($sp_pwd)){
                $this->fontRedirect('证券密码不能为空', $url,2);
                exit();
            }
            \Common\Query::commitstart();
            //状态修改
            $udpin['sp_user'] = $sp_user;
            $udpin['sp_pwd'] = $sp_pwd;
            $udpin['huabo_time'] = time();
            $udpin['trade_balance'] = $peizi_row['trade_money_total'];
            $udpin['update_time'] = time();
            if(!empty($status)){
                $udpin['status'] = $status;
            }
            $res = \Common\Query::update('user_peizi', $udpin, array('pz_id'=>$pz_id,'status'=>1));
            if(!$res){
                \Common\Query::rollback();
                $this->fontRedirect('状态修改失败', $url,2);
                exit();
            }
            //支付管理费
            $res = \Model\Peizi\Peizi::payManageCost($peizi_row);
            if($res[0] == 0){
                \Common\Query::rollback();
                $this->fontRedirect($res[1], $url,2);
                exit();
            }
            //资金委托进股市
            if($peizi_row['pz_type'] == 3 || $peizi_row['pz_type'] == 5){//p2p
                $res = \Model\User\Fund::tradeIn($peizi_row['uid'],$peizi_row['trade_money_total'],$peizi_row['pz_id']);
                if($res[0] == 0){
                    \Common\Query::rollback();
                    $this->fontRedirect($res[1], $url,2);
                    exit();
                }
            }
            \Common\Query::commit();
            //短信通知
            $user = \Model\User\UserInfo::getinfo($peizi_row['uid']);
            \Model\Api\Sms::smsSend($user['mobile'], '您的配资(实盘单号：'.date('Ymd',$peizi_row['pz_time']).$peizi_row['pz_id'].')资金已到帐，请下载客户端进行交易！');
            $this->fontRedirect('提交成功', $url,2);
            exit();
        }

             
	//补亏划拨
	public function loss(){
            $this->setTitle('补亏划拨');
            $pagesize = 20;
            $condition['order_id'] = isset ( $_GET ['order_id'] ) ? $_GET ['order_id'] : '';
            $condition['status'] = isset ( $_GET ['status'] ) ? $_GET ['status'] : '0';
            $condition['begindate'] = isset ( $_GET ['begindate'] ) ? $_GET ['begindate'] : '';
            $condition['enddate'] = isset ( $_GET ['enddate'] ) ? $_GET ['enddate'] : '';
            $curpage = isset ( $_GET ['page'] ) ? intval ( $_GET ['page'] ) : 1;
            $where = ' WHERE pz_type=7';
            if(!empty($condition['order_id'])){
                $pz_id = substr($condition['order_id'], 8);
                $where .= ' and loss.pz_id='.intval($pz_id);
            }
            if($condition['status']!=''){
                $where .= ' and loss.status='.  intval($condition['status']);
            }
            if ($condition['begindate'] && $condition['enddate']) {
                $where .= " AND (FROM_UNIXTIME(loss.add_time,'%Y-%m-%d')>='" . ($condition['begindate']) . "' AND FROM_UNIXTIME(loss.add_time,'%Y-%m-%d')<='" . ($condition['enddate']) . "')";
            }
            $selarr = array ('pz.*','loss.add_time','loss.add_loss','loss.status lossstatus','loss.fill_id','u.true_name' );
            $order = ' ORDER BY loss.add_time DESC';
            $res = \Common\Pager::getList ( 'user_peizi_fillloss loss left join user_peizi pz on loss.pz_id=pz.pz_id left join user_info u on pz.uid=u.uid', $where, $selarr, $order, $curpage, $pagesize, 1 );

            $this->assign ( 'list', $res['data']);
            $this->assign ( 'pager', $res ['pager'] );
            $this->assign ( 'condition', $condition);
	    $this->template ( 'loss.php' );
	}
	public function lossedit(){
            $this->setTitle('补亏划拨');
            $this->setNavtitle('补亏划拨');
            $fill_id = isset($_GET['fill_id'])?intval($_GET['fill_id']):0;
            $fill_row = \Common\Query::selone('user_peizi_fillloss', array('fill_id'=>  intval($fill_id)));
            $pz_row = \Common\Query::selone('user_peizi', array('pz_id'=>  intval($fill_row['pz_id'])));
            $this->assign('fill_row',$fill_row);
            $this->assign('pz_row',$pz_row);
            $this->template ( 'lossedit.php' );
        }
        public function doLossEdit(){
            $fill_id = isset($_POST['fill_id'])?intval($_POST['fill_id']):0;
            $status = isset($_POST['status'])?intval($_POST['status']):0;
            $fill_row = \Common\Query::selone('user_peizi_fillloss', array('fill_id'=>$fill_id));
            $url = '/index.php?app=admin&mod=qihuo&ac=lossedit&fill_id='.$fill_id;
            if(empty($fill_id)){
                $this->fontRedirect('参数错误', 'back',2);
                exit();
            }
            if($fill_row['status']==$status){
                $this->fontRedirect('状态值未变化', 'back',2);
                exit();
            }
            $udpin = array();
            if(!empty($status)){
                $udpin['status'] = $status;
            }
            $udpin['huabo_time'] = time();
            $res = \Common\Query::update('user_peizi_fillloss', $udpin, array('fill_id'=>$fill_id,'status'=>0));
            if($res){
                //短信通知
                $user = \Model\User\UserInfo::getinfo($fill_row['uid']);
                \Model\Api\Sms::smsSend($user['mobile'], '尊敬的'.SITE_NAME.'客户：您的补亏资金已到帐，请注意查收！');
                $this->fontRedirect('提交成功', $url,2);
                exit();
            }
            else{
                $this->fontRedirect('提交失败', $url,2);
                exit();
            }
        }

        //盈利提取
	public function win(){
            $this->setTitle('结束配资');
            $pagesize = 20;
            $condition['order_id'] = isset ( $_GET ['order_id'] ) ? $_GET ['order_id'] : '';
            $condition['status'] = isset ( $_GET ['status'] ) ? $_GET ['status'] : '';
            $condition['begindate'] = isset ( $_GET ['begindate'] ) ? $_GET ['begindate'] : '';
            $condition['enddate'] = isset ( $_GET ['enddate'] ) ? $_GET ['enddate'] : '';
            $curpage = isset ( $_GET ['page'] ) ? intval ( $_GET ['page'] ) : 1;
            $where = ' WHERE (pz.pz_type=7)';
            if(!empty($condition['order_id'])){
                $pz_id = substr($condition['order_id'], 8);
                $where .= ' and pz.pz_id='.intval($pz_id);
            }
            if($condition['status']==''){
                $where .= ' and (pz.status>1)';
            }
            else{
                $where .= ' and pz.status='.  intval($condition['status']);
            }
            if ($condition['begindate'] && $condition['enddate']) {
                $where .= " AND (FROM_UNIXTIME(pz.pz_time,'%Y-%m-%d')>='" . ($condition['begindate']) . "' AND FROM_UNIXTIME(pz.pz_time,'%Y-%m-%d')<='" . ($condition['enddate']) . "')";
            }
            $selarr = array ('pz.*' ,'u.true_name');
            $order = ' ORDER BY pz.pz_time DESC';
            $res = \Common\Pager::getList ( 'user_peizi pz left join user_info u on pz.uid=u.uid', $where, $selarr, $order, $curpage, $pagesize, 1 );

            $this->assign ( 'list', $res['data']);
            $this->assign ( 'pager', $res ['pager'] );
            $this->assign ( 'condition', $condition);
	    $this->template ( 'win.php' );	
	}
        public function winedit(){
            $this->setTitle('结束配资');
            $this->setNavtitle('结束配资');
            $pz_id = isset($_GET['pz_id'])?intval($_GET['pz_id']):0;
            $pz_row = \Common\Query::selone('user_peizi', array('pz_id'=>  intval($pz_id)));
            $this->assign('pz_row',$pz_row);
            $this->template ( 'winedit.php' );
        }
        public function doWinEdit(){
            $pz_id = isset($_POST['pz_id'])?intval($_POST['pz_id']):0;
            $pz_row = \Model\Peizi\Peizi::getById($pz_id);
            $trade_balance = isset($_POST['trade_balance'])?  floatval($_POST['trade_balance'])*100:0;
            /*if($trade_balance>$pz_row['trade_balance']*1.2 || $trade_balance<$pz_row['trade_balance']*0.8){
                $this->fontRedirect('资产值异常', 'back');
                exit();
            }*/
            $status = isset($_POST['status'])?intval($_POST['status']):0;
            $url = '/index.php?app=admin&mod=qihuo&ac=winedit&pz_id='.$pz_id;
            if(empty($pz_id)){
                $this->fontRedirect('参数错误', 'back');
                exit();
            }
            if(empty($trade_balance)){
                $this->fontRedirect('参数错误', $url);
                exit();
            }
            if($pz_row['status']==$status){
                $this->fontRedirect('状态值未变化', 'back',2);
                exit();
            }
            //判断是否还有补亏未划拔
            $bk_row = \Common\Query::selone('user_peizi_fillloss', array('pz_id'=>$pz_id,'status'=>0), array('count(fill_id) as total'));
            if($bk_row && $bk_row['total']>0){
                $this->fontRedirect('还有补亏记录未划拔', $url);
                exit();
            }
            //判断是否还有追加配资未划拔
            $add_row = \Common\Query::selone('user_peizi_add', array('pz_id'=>$pz_id,'status'=>0), array('count(add_id) as total'));
            if($add_row && $add_row['total']>0){
                $this->fontRedirect('还有追加配资记录未划拔', $url);
                exit();
            }
            //状态修改
            $udpin['trade_balance'] = $trade_balance;
            $udpin['update_time'] = time();
            if(!empty($status)){
                $udpin['status'] = $status;
            }
            \Common\Query::commitstart();
            
            $res = \Common\Query::update('user_peizi', $udpin, array('pz_id'=>$pz_id,'status'=>$pz_row['status']));
            if(!$res){
                \Common\Query::rollback();
                $this->fontRedirect('状态修改错误', $url,2);
                exit();
            }
            //资金委托出股市 非p2p不用
            /*$res = \Model\User\Fund::tradeOut($pz_row['uid'],$pz_row['trade_balance'],$pz_row['pz_id']);
            if($res[0] == 0){
                \Common\Query::rollback();
                $this->fontRedirect($res[1], $url,2);
                exit();
            }*/
            //结束操盘计算
            $res = \Model\Peizi\Peizi::end($pz_id);
            if($res[0] == 0){
                \Common\Query::rollback();
                $this->fontRedirect($res[1], $url,2);
                exit();
            }
            \Common\Query::commit();
            //短信通知
            $user = \Model\User\UserInfo::getinfo($pz_row['uid']);
            \Model\Api\Sms::smsSend($user['mobile'], '您的配资(实盘单号：'.date('Ymd',$pz_row['pz_time']).$pz_row['pz_id'].')清算结束！');
            $this->fontRedirect('提交成功', $url,2);
        }
}

?>