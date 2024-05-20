<?php

namespace apps\admin;
class business extends \apps\AdminControl {
    
    //提现
    public function withdrawl() {
        $this->setNavtitle ( '提现' );
        $uid = $this->adminid;
	$pz_id = isset($_GET['pz_id'])?intval($_GET['pz_id']):0;
        $pz_row = \Common\Query::selone('user_peizi', array('pz_id'=>  intval($pz_id)));
        $this->assign('pz_row',$pz_row);
        $this->template ( 'withdrawl.php' );
    }
	
    //提现3
    public function doWithdrawl() {
        $pz_id = $_POST['pz_id'];
        $money = $_POST['money'];
        if(empty($pz_id)){
            $this->fontRedirect('参数错误', 'back');
            exit();
        }
        $pz_row = \Common\Query::selone('user_peizi', array('pz_id'=>  intval($pz_id)));
        if($money!= ($pz_row['bond_init']/100)){
            //$this->fontRedirect('金额错误', 'back');
            exit();
        }
        $tx_row = \Common\Query::selone('bus_withdraw_record', array('pz_id'=>$pz_id));
        if($tx_row){
            $this->fontRedirect('已经提交', 'back');
            exit();
        }
        $shop_id = \Model\Admin\BusShop::getShopIdByAdminid($this->adminid);
        \Common\Query::commitstart();
        $res = \Model\Business\Withdraw::add($this->adminid, $money*100, $shop_id, $pz_id);
        if(!$res){
            \Common\Query::rollback();
            $this->fontRedirect('提交失败', 'back');
            exit();
        }
        $res = \Common\Query::update('user_peizi', array('bus_status'=>2), array('pz_id'=>$pz_id));
        if(!$res){
            \Common\Query::rollback();
            $this->fontRedirect('状态修改错误', 'back');
            exit();
        }
        \Common\Query::commit();
        $this->fontRedirect('提交成功', '/index.php?app=admin&mod=business&ac=withdrawl&pz_id='.$pz_id);
    }
	
}

?>