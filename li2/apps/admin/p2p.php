<?php

namespace apps\admin;
class p2p extends \apps\AdminControl {
	//配资审核
	public function apply(){
            $this->setTitle('配资审核');
            $pagesize = 20;
            $condition['order_id'] = isset ( $_GET ['order_id'] ) ? $_GET ['order_id'] : '';
            $condition['status'] = isset ( $_GET ['status'] ) ? $_GET ['status'] : '1';
            $condition['begindate'] = isset ( $_GET ['begindate'] ) ? $_GET ['begindate'] : '';
            $condition['enddate'] = isset ( $_GET ['enddate'] ) ? $_GET ['enddate'] : '';
            $curpage = isset ( $_GET ['page'] ) ? intval ( $_GET ['page'] ) : 1;
            $where = ' WHERE pz.pz_type=3 or pz.pz_type=5';
            if(!empty($condition['order_id'])){
                $pz_id = substr($condition['order_id'], 8);
                $where .= ' and pz.pz_id='.intval($pz_id);
            }
            if($condition['status']==''){
                $where .= ' and (pz.p2pstatus>0)';
            }
            else if($condition['status']=='1'){
                $where .= ' and pz.p2pstatus=1';
            }
            else{
                $where .= ' and pz.p2pstatus>1';
            }
            if ($condition['begindate'] && $condition['enddate']) {
                $where .= " AND (FROM_UNIXTIME(pz.pz_time,'%Y-%m-%d')>='" . ($condition['begindate']) . "' AND FROM_UNIXTIME(pz.pz_time,'%Y-%m-%d')<='" . ($condition['enddate']) . "')";
            }
            $selarr = array ('pz.*,u.true_name' );
            $order = ' ORDER BY pz.pz_time DESC';
            $res = \Common\Pager::getList ( 'user_peizi pz left join user_info u on pz.uid=u.uid', $where, $selarr, $order, $curpage, $pagesize, 1 );

            $this->assign ( 'list', $res['data']);
            $this->assign ( 'pager', $res ['pager'] );
            $this->assign ( 'condition', $condition);
	    $this->template ( 'apply.php' );		
	}
        public function applyedit(){
            $this->setTitle('配资审核');
            $this->setNavtitle('配资审核');
            $pz_id = isset($_GET['pz_id'])?intval($_GET['pz_id']):0;
            $pz_row = \Common\Query::selone('user_peizi', array('pz_id'=>  intval($pz_id)));
            $this->assign('pz_row',$pz_row);
            $this->template ( 'applyedit.php' );
        }
        public function doApplyEdit(){
            $pz_id = isset($_POST['pz_id'])?intval($_POST['pz_id']):0;
            $p2pstatus = isset($_POST['p2pstatus'])?intval($_POST['p2pstatus']):0;
            $peizi_row = \Model\Peizi\Peizi::getById($pz_id);
            $url = '/index.php?app=admin&mod=p2p&ac=applyedit&pz_id='.$pz_id;
            if(empty($pz_id)){
                $this->fontRedirect('参数错误', 'back',2);
                exit();
            }
            if($peizi_row['p2pstatus']==$p2pstatus){
                $this->fontRedirect('状态值未变化', 'back',2);
                exit();
            }
            \Common\Query::commitstart();
            //状态修改
            $udpin['limit_start_time'] = time();
            $udpin['limit_end_time'] = $peizi_row['limit_days']*24*60*60+$udpin['limit_start_time'];
            $udpin['start_time'] = $udpin['limit_end_time'];
            if($peizi_row['pz_times_unit']==1){
                $udpin['end_time'] = strtotime('+'.$peizi_row['pz_times'].' day', $udpin['limit_end_time']) ;
            }
            else  if($peizi_row['pz_times_unit']==3){
                $udpin['end_time'] = strtotime('+'.$peizi_row['pz_times'].' month', $udpin['limit_end_time']) ;
            }
            if(!empty($p2pstatus)){
                $udpin['p2pstatus'] = $p2pstatus;
            }
            $res = \Common\Query::update('user_peizi', $udpin, array('pz_id'=>$pz_id,'p2pstatus'=>1));
            if(!$res){
                \Common\Query::rollback();
                $this->fontRedirect('状态修改失败', $url,2);
                exit();
            }
            
            \Common\Query::commit();
            //短信通知
            $user = \Model\User\UserInfo::getinfo($peizi_row['uid']);
            \Model\Api\Sms::smsSend($user['mobile'], '您的配资(配资单号：'.date('Ymd',$peizi_row['pz_time']).$peizi_row['pz_id'].')已审核通过，现已处于募资状态中！');
            $this->fontRedirect('提交成功', $url,2);
            exit();
        }
        //满标审核
	public function full(){
            $this->setTitle('满标审核');
            $pagesize = 20;
            $condition['order_id'] = isset ( $_GET ['order_id'] ) ? $_GET ['order_id'] : '';
            $condition['status'] = isset ( $_GET ['status'] ) ? $_GET ['status'] : '4';
            $condition['begindate'] = isset ( $_GET ['begindate'] ) ? $_GET ['begindate'] : '';
            $condition['enddate'] = isset ( $_GET ['enddate'] ) ? $_GET ['enddate'] : '';
            $curpage = isset ( $_GET ['page'] ) ? intval ( $_GET ['page'] ) : 1;
            $where = ' WHERE pz.pz_type=3 or pz.pz_type=5';
            if(!empty($condition['order_id'])){
                $pz_id = substr($condition['order_id'], 8);
                $where .= ' and pz.pz_id='.intval($pz_id);
            }
            if($condition['status']==''){
                $where .= ' and (pz.p2pstatus>3)';
            }
            else if($condition['status']=='4'){
                $where .= ' and pz.p2pstatus=4';
            }
            else{
                $where .= ' and pz.p2pstatus>4';
            }
            if ($condition['begindate'] && $condition['enddate']) {
                $where .= " AND (FROM_UNIXTIME(pz.pz_time,'%Y-%m-%d')>='" . ($condition['begindate']) . "' AND FROM_UNIXTIME(pz.pz_time,'%Y-%m-%d')<='" . ($condition['enddate']) . "')";
            }
            $selarr = array ('pz.*','u.true_name' );
            $order = ' ORDER BY pz.pz_time DESC';
            $res = \Common\Pager::getList ( 'user_peizi pz left join user_info u on pz.uid=u.uid', $where, $selarr, $order, $curpage, $pagesize, 1 );

            $this->assign ( 'list', $res['data']);
            $this->assign ( 'pager', $res ['pager'] );
            $this->assign ( 'condition', $condition);
	    $this->template ( 'full.php' );		
	}
        public function fulledit(){
            $this->setTitle('满标审核');
            $this->setNavtitle('满标审核');
            $pz_id = isset($_GET['pz_id'])?intval($_GET['pz_id']):0;
            $pz_row = \Common\Query::selone('user_peizi', array('pz_id'=>  intval($pz_id)));
            $this->assign('pz_row',$pz_row);
            $this->template ( 'fulledit.php' );
        }
        public function doFullEdit(){
            $pz_id = isset($_POST['pz_id'])?intval($_POST['pz_id']):0;
            $p2pstatus = isset($_POST['p2pstatus'])?intval($_POST['p2pstatus']):0;
            $peizi_row = \Model\Peizi\Peizi::getById($pz_id);
            $url = '/index.php?app=admin&mod=p2p&ac=fulledit&pz_id='.$pz_id;
            if(empty($pz_id)){
                $this->fontRedirect('参数错误', 'back',2);
                exit();
            }
            if($peizi_row['p2pstatus']==$p2pstatus){
                $this->fontRedirect('状态值未变化', 'back',2);
                exit();
            }
            \Common\Query::commitstart();
            //状态修改，实际配资开始结束时间修改
            $udpin['start_time'] = time();
            if($peizi_row['pz_times_unit']==1){
                $udpin['end_time'] = strtotime('+'.$peizi_row['pz_times'].' day',$udpin['start_time']) ;
            }
            else{
                $udpin['end_time'] = strtotime('+'.$peizi_row['pz_times'].' month',$udpin['start_time']) ;
            }
            $udpin['end_time_act'] = $udpin['end_time'];
            if(!empty($p2pstatus)){
                $udpin['p2pstatus'] = $p2pstatus;
            }
            $res = \Common\Query::update('user_peizi', $udpin, array('pz_id'=>$pz_id,'p2pstatus'=>$peizi_row['p2pstatus']));
            if(!$res){
                \Common\Query::rollback();
                $this->fontRedirect('状态修改失败', $url,2);
                exit();
            }
            //操盘状态修改
            $res = \Common\Query::update('user_peizi', array('status'=>1), array('pz_id'=>$pz_id,'status'=>0));
            if(!$res){
                \Common\Query::rollback();
                $this->fontRedirect('操盘状态修改失败', $url,2);
                exit();
            }
            //按月配资，并且大于1个月，下次利息管理费收取时间更新，时间为开始时间加1个月
            if($peizi_row['pz_times_unit']==3 && $peizi_row['pz_times']>1){
                $updata = array();
                $updata['next_get_interest_time'] = strtotime('+1 month', $udpin['start_time']);
                $res = \Common\Query::update('user_peizi', $updata, array('pz_id'=>$peizi_row['pz_id']));
                if(!$res){
                    \Common\Query::rollback();
                    $this->fontRedirect('修改下次利息管理费收取时间失败', $url,2);
                    exit();
                }
            }
            //下次支付利息给投资人时间更新 ，
            if($peizi_row['pz_times_unit']==3 && $peizi_row['pz_times']>1){
                $updata = array();
                //时间为配资开始时间往后一个月的前一天
                $updata['next_pay_interest_time'] = strtotime('-1 day', strtotime('+1 month', $udpin['start_time'])) ;
                $res = \Common\Query::update('user_peizi', $updata, array('pz_id'=>$peizi_row['pz_id']));
                if(!$res){
                    \Common\Query::rollback();
                    $this->fontRedirect('修改下次支付利息给投资人时间失败', $url,2);
                    exit();
                }
            }
            else{
                $updata = array();
                //时间为配资结束时间前1天
                $updata['next_pay_interest_time'] =  strtotime('-1 day', $udpin['end_time']) ;
                $res = \Common\Query::update('user_peizi', $updata, array('pz_id'=>$peizi_row['pz_id']));
                if(!$res){
                    \Common\Query::rollback();
                    $this->fontRedirect('修改下次支付利息给投资人时间失败', $url,2);
                    exit();
                }
            }
            //借入配资本金
            $res = \Model\User\Fund::peiziBorrow($peizi_row['uid'], $peizi_row['pz_money'], $peizi_row['pz_id']);
            if($res[0]==0){
                \Common\Query::rollback();
                $this->fontRedirect($res[1], $url,3);
                exit();
            }
            //冻结配资本金
            $res = \Model\User\Fund::peiziFrozen($peizi_row['uid'], $peizi_row['pz_money'], $peizi_row['pz_id']);
            if($res[0]==0){
                \Common\Query::rollback();
                $this->fontRedirect($res[1], $url,3);
                exit();
            }
            
            \Common\Query::commit();
            //短信通知
            //配资人
            $user = \Model\User\UserInfo::getinfo($peizi_row['uid']);
            \Model\Api\Sms::smsSend($user['mobile'], '您的配资(配资单号：'.date('Ymd',$peizi_row['pz_time']).$peizi_row['pz_id'].')已满标，系统正在为您划拔操盘资金、分配操盘账号，完成后会有短信通知，请留意短信通知！');
            //投资人
            $tz_users = \Common\Query::sqlsel('select distinct tz.uid,u.mobile from user_peizi_touzi tz left join user_info u on tz.uid=u.uid where tz.pz_id='.$pz_id);
            foreach ($tz_users as $tz_user) {
                \Model\Api\Sms::smsSend($tz_user['mobile'], '您投资的项目(项目编号：'.date('Ymd',$peizi_row['pz_time']).$peizi_row['pz_id'].')已满标，标的到期后将给您分派利息！');
            }
            $this->fontRedirect('提交成功,请继续完成操盘账号分配，资金划拔', $url,20);
            exit();
        }
        //废标处理
	public function throws(){
            $this->setTitle('废标处理');
            $pagesize = 20;
            $condition['order_id'] = isset ( $_GET ['order_id'] ) ? $_GET ['order_id'] : '';
            $condition['status'] = isset ( $_GET ['status'] ) ? $_GET ['status'] : '2';
            $condition['begindate'] = isset ( $_GET ['begindate'] ) ? $_GET ['begindate'] : '';
            $condition['enddate'] = isset ( $_GET ['enddate'] ) ? $_GET ['enddate'] : '';
            $curpage = isset ( $_GET ['page'] ) ? intval ( $_GET ['page'] ) : 1;
            $where = ' WHERE (pz.pz_type=3 or pz.pz_type=5)';
            if(!empty($condition['order_id'])){
                $pz_id = substr($condition['order_id'], 8);
                $where .= ' and pz.pz_id='.intval($pz_id);
            }
            if($condition['status']==''){
                $where .= ' and (pz.p2pstatus=3 or pz.p2pstatus=2)';
            }
            else if($condition['status']=='3'){
                $where .= ' and pz.p2pstatus=3';
            }
            else{
                $where .= ' and pz.p2pstatus=2';
            }
            if ($condition['begindate'] && $condition['enddate']) {
                $where .= " AND (FROM_UNIXTIME(pz.pz_time,'%Y-%m-%d')>='" . ($condition['begindate']) . "' AND FROM_UNIXTIME(pz.pz_time,'%Y-%m-%d')<='" . ($condition['enddate']) . "')";
            }
            $selarr = array ('pz.*' ,'u.true_name');
            $order = ' ORDER BY pz_time DESC';
            $res = \Common\Pager::getList ( 'user_peizi pz left join user_info u on pz.uid=u.uid', $where, $selarr, $order, $curpage, $pagesize, 1 );

            $this->assign ( 'list', $res['data']);
            $this->assign ( 'pager', $res ['pager'] );
            $this->assign ( 'condition', $condition);
	    $this->template ( 'throws.php' );		
	}
        public function throwsedit(){
            $this->setTitle('废标处理');
            $this->setNavtitle('废标处理');
            $pz_id = isset($_GET['pz_id'])?intval($_GET['pz_id']):0;
            $pz_row = \Common\Query::selone('user_peizi', array('pz_id'=>  intval($pz_id)));
            $this->assign('pz_row',$pz_row);
            $this->template ( 'throwsedit.php' );
        }
        public function doThrowsEdit(){
            $pz_id = isset($_POST['pz_id'])?intval($_POST['pz_id']):0;
            $p2pstatus = isset($_POST['p2pstatus'])?intval($_POST['p2pstatus']):0;
            $peizi_row = \Model\Peizi\Peizi::getById($pz_id);
            $url = '/index.php?app=admin&mod=p2p&ac=throwsedit&pz_id='.$pz_id;
            if(empty($pz_id)){
                $this->fontRedirect('参数错误', 'back',2);
                exit();
            }
            if($peizi_row['p2pstatus']==$p2pstatus){
                $this->fontRedirect('状态值未变化', 'back',2);
                exit();
            }
            \Common\Query::commitstart();
            //状态修改
            if(!empty($p2pstatus)){
                $udpin['p2pstatus'] = $p2pstatus;
            }
            $res = \Common\Query::update('user_peizi', $udpin, array('pz_id'=>$pz_id,'p2pstatus'=>2));
            if(!$res){
                \Common\Query::rollback();
                $this->fontRedirect('状态修改失败', $url,2);
                exit();
            }
            //解冻保证金
            $res = \Model\User\Fund::bondBack($peizi_row['uid'], $peizi_row['bond_total'], $pz_id);
            if($res[0]==0){
                \Common\Query::rollback();
                $this->fontRedirect($res[1], $url,2);
                exit();
            }
            //退回利息
            $res = \Model\User\Fund::interestBack($peizi_row['uid'], $peizi_row['interest'], $pz_id);
            if($res[0]==0){
                \Common\Query::rollback();
                $this->fontRedirect($res[1], $url,2);
                exit();
            }
            //退回管理费
            $res = \Model\User\Fund::managecostBack($peizi_row['uid'], $peizi_row['service_money']+$peizi_row['manage_money'], $pz_id);
            if($res[0]==0){
                \Common\Query::rollback();
                $this->fontRedirect($res[1], $url,2);
                exit();
            }
            //退回投资人的投资金
            $res = \Model\P2p\Touzi::backPeiziMoney($pz_id);
            if($res[0]==0){
                \Common\Query::rollback();
                $this->fontRedirect($res[1], $url,2);
                exit();
            }
            \Common\Query::commit();
            //短信通知
            //配资人
            $user = \Model\User\UserInfo::getinfo($peizi_row['uid']);
            \Model\Api\Sms::smsSend($user['mobile'], '您的配资(配资单号：'.date('Ymd',$peizi_row['pz_time']).$peizi_row['pz_id'].')由于超出募资期限，已被中止募资。您支付的保证金、利息、管理费已退回！');
            //投资人
            $tz_users = \Common\Query::sqlsel('select distinct tz.uid,u.mobile from user_peizi_touzi tz left join user_info u on tz.uid=u.uid where tz.pz_id='.$pz_id);
            foreach ($tz_users as $tz_user) {
                \Model\Api\Sms::smsSend($tz_user['mobile'], '您投资的项目(项目编号：'.date('Ymd',$peizi_row['pz_time']).$peizi_row['pz_id'].')由于超出募资期限，已被中止募资。您的投资资金已退还到您的帐户！');
            }
            $this->fontRedirect('提交成功', $url,3);
            exit();
        }
        //实盘资金划拨
	public function fund(){
            $this->setTitle('实盘资金划拨');
            $pagesize = 20;
            $condition['order_id'] = isset ( $_GET ['order_id'] ) ? $_GET ['order_id'] : '';
            $condition['status'] = isset ( $_GET ['status'] ) ? $_GET ['status'] : '1';
            $condition['begindate'] = isset ( $_GET ['begindate'] ) ? $_GET ['begindate'] : '';
            $condition['enddate'] = isset ( $_GET ['enddate'] ) ? $_GET ['enddate'] : '';
            $curpage = isset ( $_GET ['page'] ) ? intval ( $_GET ['page'] ) : 1;
            $where = ' WHERE (pz.pz_type=3 || pz.pz_type=5)';
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
            $url = '/index.php?app=admin&mod=peizi&ac=fundedit&pz_id='.$pz_id;
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
        //结束操盘
	public function endcp(){
            $this->setTitle('结束操盘');
            $pagesize = 20;
            $condition['order_id'] = isset ( $_GET ['order_id'] ) ? $_GET ['order_id'] : '';
            $condition['status'] = isset ( $_GET ['status'] ) ? $_GET ['status'] : '';
            $condition['begindate'] = isset ( $_GET ['begindate'] ) ? $_GET ['begindate'] : '';
            $condition['enddate'] = isset ( $_GET ['enddate'] ) ? $_GET ['enddate'] : '';
            $curpage = isset ( $_GET ['page'] ) ? intval ( $_GET ['page'] ) : 1;
            $where = ' WHERE (pz.pz_type=3 or pz.pz_type=5) ';
            if(!empty($condition['order_id'])){
                $pz_id = substr($condition['order_id'], 8);
                $where .= ' and pz.pz_id='.intval($pz_id);
            }
            if($condition['status']==''){
                $where .= ' and (pz.status>=2)';
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
	    $this->template ( 'endcp.php' );	
	}
        public function endcpedit(){
            $this->setTitle('结束操盘');
            $this->setNavtitle('结束操盘');
            $pz_id = isset($_GET['pz_id'])?intval($_GET['pz_id']):0;
            $pz_row = \Common\Query::selone('user_peizi', array('pz_id'=>  intval($pz_id)));
            $this->assign('pz_row',$pz_row);
            $this->template ( 'endcpedit.php' );
        }
        public function doEndcpEdit(){
            $pz_id = isset($_POST['pz_id'])?intval($_POST['pz_id']):0;
            $pz_row = \Model\Peizi\Peizi::getById($pz_id);
            $trade_balance = isset($_POST['trade_balance'])?  floatval($_POST['trade_balance'])*100:0;
            /*if($trade_balance>$pz_row['trade_balance']*1.2 || $trade_balance<$pz_row['trade_balance']*0.8){
                $this->fontRedirect('资产值异常', 'back');
                exit();
            }*/
            $status = isset($_POST['status'])?intval($_POST['status']):0;
            $url = '/index.php?app=admin&mod=p2p&ac=endcpedit&pz_id='.$pz_id;
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
            //资金委托出股市
            $res = \Model\User\Fund::tradeOut($pz_row['uid'],$pz_row['trade_balance'],$pz_row['pz_id']);
            if($res[0] == 0){
                \Common\Query::rollback();
                $this->fontRedirect($res[1], $url,2);
                exit();
            }
            //结束操盘计算
            $res = \Model\Peizi\Peizi::end($pz_id);
            if($res[0] == 0){
                \Common\Query::rollback();
                $this->fontRedirect($res[1], $url,2);
                exit();
            }
            /***********配资人 开始*************/
            //解冻配资本金
            $res = \Model\User\Fund::peiziUnfrozen($pz_row['uid'],$pz_row['pz_money'],$pz_row['pz_id']);
            if($res[0] == 0){
                \Common\Query::rollback();
                $this->fontRedirect($res[1], $url,2);
                exit();
            }
            //退还配资本金
            $res = \Model\User\Fund::peiziBack($pz_row['uid'],$pz_row['pz_money'],$pz_row['pz_id']);
            if($res[0] == 0){
                \Common\Query::rollback();
                $this->fontRedirect($res[1], $url,2);
                exit();
            }
            //配资人分成支出
            $res = \Model\P2p\Peizi::payFencheng($pz_id);
            if($res[0]==0){
                \Common\Query::rollback();
                $this->fontRedirect($res[1], $url,5);
                exit();
            }
            /***********配资人 结束*************/
            \Common\Query::commit();
            //短信通知
            $user = \Model\User\UserInfo::getinfo($pz_row['uid']);
            \Model\Api\Sms::smsSend($user['mobile'], '您的配资(实盘单号：'.date('Ymd',$pz_row['pz_time']).$pz_row['pz_id'].')清算结束！');
            $this->fontRedirect('提交成功', $url,2);
        }
        //完标处理
	public function end(){
            $this->setTitle('完标处理');
            $pagesize = 20;
            $condition['order_id'] = isset ( $_GET ['order_id'] ) ? $_GET ['order_id'] : '';
            $condition['status'] = isset ( $_GET ['status'] ) ? $_GET ['status'] : '';
            $condition['begindate'] = isset ( $_GET ['begindate'] ) ? $_GET ['begindate'] : '';
            $condition['enddate'] = isset ( $_GET ['enddate'] ) ? $_GET ['enddate'] : '';
            $curpage = isset ( $_GET ['page'] ) ? intval ( $_GET ['page'] ) : 1;
            $where = ' WHERE pz.pz_type=3 or pz.pz_type=5';
            if(!empty($condition['order_id'])){
                $pz_id = substr($condition['order_id'], 8);
                $where .= ' and pz.pz_id='.intval($pz_id);
            }
            if($condition['status']==''){
                $where .= ' and (pz.p2pstatus=5 or pz.p2pstatus=6 or pz.p2pstatus=7)';
            }
            else if($condition['status']=='7'){
                $where .= ' and pz.p2pstatus=7';
            }
            else{
                $where .= ' and pz.p2pstatus=6';
            }
            if ($condition['begindate'] && $condition['enddate']) {
                $where .= " AND (FROM_UNIXTIME(pz.pz_time,'%Y-%m-%d')>='" . ($condition['begindate']) . "' AND FROM_UNIXTIME(pz.pz_time,'%Y-%m-%d')<='" . ($condition['enddate']) . "')";
            }
            $selarr = array ('pz.*','u.true_name' );
            $order = ' ORDER BY pz.pz_time DESC';
            $res = \Common\Pager::getList ( 'user_peizi pz left join user_info u on pz.uid=u.uid', $where, $selarr, $order, $curpage, $pagesize, 1 );

            $this->assign ( 'list', $res['data']);
            $this->assign ( 'pager', $res ['pager'] );
            $this->assign ( 'condition', $condition);
	    $this->template ( 'end.php' );		
	}
        public function endedit(){
            $this->setTitle('完标处理');
            $this->setNavtitle('完标处理');
            $pz_id = isset($_GET['pz_id'])?intval($_GET['pz_id']):0;
            $pz_row = \Common\Query::selone('user_peizi', array('pz_id'=>  intval($pz_id)));
            $this->assign('pz_row',$pz_row);
            $this->template ( 'endedit.php' );
        }
        public function doEndEdit(){
            $pz_id = isset($_POST['pz_id'])?intval($_POST['pz_id']):0;
            $p2pstatus = isset($_POST['p2pstatus'])?intval($_POST['p2pstatus']):0;
            $peizi_row = \Model\Peizi\Peizi::getById($pz_id);
            $url = '/index.php?app=admin&mod=p2p&ac=endedit&pz_id='.$pz_id;
            if(empty($pz_id)){
                $this->fontRedirect('参数错误', 'back',2);
                exit();
            }
            if($peizi_row['p2pstatus']==$p2pstatus){
                $this->fontRedirect('状态值未变化', 'back',2);
                exit();
            }
            //判断是否操盘结束
            if($peizi_row['status']!=4){
                $this->fontRedirect('操盘未结束，请先结束操盘！<a href="/index.php?app=admin&mod=p2p&ac=endcpedit&pz_id='.$pz_id.'">结束操盘</a>', $url,30);
                exit();
            }
            \Common\Query::commitstart();
            
            /***********投资人 开始*************/
            //支付利息给投资人
            $res = \Model\P2p\Touzi::payInserest($pz_id);
            if($res[0]==0){
                \Common\Query::rollback();
                $this->fontRedirect($res[1], $url,5);
                exit();
            }
            //支付分成给投资人
            $res = \Model\P2p\Touzi::payFencheng($pz_id);
            if($res[0]==0){
                \Common\Query::rollback();
                $this->fontRedirect($res[1], $url,5);
                exit();
            }
            //退回投资资金给投资人
            $res = \Model\P2p\Touzi::backPeiziMoney($pz_id);
            if($res[0]==0){
                \Common\Query::rollback();
                $this->fontRedirect($res[1], $url,2);
                exit();
            }
            /***********投资人 开始*************/
            //状态修改
            if(!empty($p2pstatus)){
                $udpin['p2pstatus'] = $p2pstatus;
                $res = \Common\Query::update('user_peizi', $udpin, array('pz_id'=>$pz_id,'p2pstatus'=>6));
                if(!$res){
                    \Common\Query::rollback();
                    $this->fontRedirect('状态修改失败', $url,2);
                    exit();
                }
            }
            \Common\Query::commit();
            //短信通知
            $user = \Model\User\UserInfo::getinfo($peizi_row['uid']);
            \Model\Api\Sms::smsSend($user['mobile'], '您的配资(配资单号：'.date('Ymd',$peizi_row['pz_time']).$peizi_row['pz_id'].')已结束！');
            //投资人
            $tz_users = \Common\Query::sqlsel('select distinct tz.uid,u.mobile from user_peizi_touzi tz left join user_info u on tz.uid=u.uid where tz.pz_id='.$pz_id);
            foreach ($tz_users as $tz_user) {
                \Model\Api\Sms::smsSend($tz_user['mobile'], '您投资的项目(项目编号：'.date('Ymd',$peizi_row['pz_time']).$peizi_row['pz_id'].')已结束。您的投资资金和赚取的利息已返还到您的帐户！');
            }
            $this->fontRedirect('提交成功', $url,3);
            exit();
        }
        //管理费不足
	public function mcost(){
            $this->setTitle('管理费不足');
            $pagesize = 20;
            $condition['order_id'] = isset ( $_GET ['order_id'] ) ? $_GET ['order_id'] : '';
            $curpage = isset ( $_GET ['page'] ) ? intval ( $_GET ['page'] ) : 1;
            $where = ' WHERE pz.manage_cost>u.balance';
            $table = '(SELECT sum(interest+service_money+manage_money)  manage_cost,uid from user_peizi WHERE p2pstatus=6 and pz_type=3 and pz_times_unit=3 and pz_times>1 and next_get_interest_time<'.time().' GROUP BY uid) pz LEFT JOIN user_info u on pz.uid=u.uid';
            $selarr = array ('pz.manage_cost','u.true_name','u.mobile','u.balance','u.uid' );
            $order = '';
            $res = \Common\Pager::getList ( $table, $where, $selarr, $order, $curpage, $pagesize, 1 );

            $this->assign ( 'list', $res['data']);
            $this->assign ( 'pager', $res ['pager'] );
            $this->assign ( 'condition', $condition);
	    $this->template ( 'mcost.php' );		
	}
}

?>