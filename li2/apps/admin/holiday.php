<?php

namespace apps\admin;
class holiday extends \apps\AdminControl {
    
     //put your code here
    public function view() {
    	$this->setTitle('节假日管理');
    	$page = isset ( $_GET ['page'] ) ? intval ( $_GET ['page'] ) : 1;
    	$where = ' WHERE 1=1' ; 
   		$condition = array ('begindate' => '', 'enddate' => '' );
		$begindate = isset ( $_GET ['begindate'] ) ? $_GET ['begindate'] : $condition ['begindate'];
		$enddate = isset ( $_GET ['enddate'] ) ? $_GET ['enddate'] : $condition ['enddate'];
		if ($begindate && $enddate) {
			$condition ['begindate'] = $begindate;
			$condition ['enddate'] = $enddate;
			$where .= " AND hdate>='" . ($begindate) . "' AND hdate<='" . ($enddate) . "'";
		}
		$selarr = array ('id','hdate' );
		$order = ' ORDER BY hdate DESC';
		$res = \Common\Pager::getList ( 'admin_holiday', $where, $selarr, $order, $page, 20);

		$this->assign('pager', $res ['pager']);
    	$this->assign('dataList', $res ['data']);
    	$this->assign('condition', $condition);
    	$this->template ( 'index.php' );
    }
    
    //删除
    public function del(){
    	$id = isset($_GET['id']) ? $_GET['id'] : 0;
		$res =  \Model\Admin\Holiday::delHoliday(array('id'=>$id));
		$this->sysRedirect('/index.php?app=admin&mod=holiday&ac=view');
    }
    
 	//编辑数据
    public function ajaxHdate(){
    	$res = array('code'=>0);
    	if($_POST){
	    	$id = isset ( $_POST ['id'] ) ? intval($_POST['id']) : 0;
	    	$hdate = isset ( $_POST ['hdate'] ) ? $_POST['hdate'] : '';
	    	if ($id>0 && $hdate){
	    		$r = \Model\Admin\Holiday::editHoliday(array('id'=>$id,'hdate'=>$hdate));
	    		if ($r>0){
	    			$res['hdate'] = $hdate;
	    			$res['code'] = 1;
	    		}
	    	}
    	}
    	exit(json_encode($res));
    }
    
    //新增数据
    public function doEdit(){
		if ($_POST ['submit']) {
			$hdate = $_POST['hdate'];
			$res = 0;
			if($hdate){
				$arr =  array('hdate'=>$hdate);
				$res = \Model\Admin\Holiday::addHoliday($arr);
			}
			$msg = $res>0 ? '添加成功' : '添加失败';
    		$this->fontRedirect($msg,'/index.php?app=admin&mod=holiday&ac=view');
		}
	}
	
	
}

?>