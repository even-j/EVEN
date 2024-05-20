<?php

namespace apps\admin;
class trade extends \apps\AdminControl {
    
     //put your code here
    public function view() {
    	$this->setTitle('交易账户管理');
    	$page = isset ( $_GET ['page'] ) ? intval ( $_GET ['page'] ) : 1;
    	$where = ' WHERE 1=1' ; 
		$condition = array('status'=>'','account'=>'','type'=>'');
                $type = isset($_GET['type']) ? $_GET['type'] : $condition['type'];
		$status = isset($_GET['status']) ? $_GET['status'] : $condition['status'];
		$account = isset($_GET['account']) ? $_GET['account'] : $condition['account'];
                if ($type!=''){
			$condition['type'] = $type;
			$where .= ' AND type='.$type;
		}
		if ($status!=''){
			$condition['status'] = $status;
			$where .= ' AND status='.$status;
		}
                if ($account){
			$condition['account'] = $account;
			$where .= " AND account='".$account."'";
		}
		$selarr = array ('parent_account','account','pwd', 'status', 'addtime','type' );
		$order = ' ORDER BY account ASC,addtime DESC';
		$res = \Common\Pager::getList ( 'trade_account', $where, $selarr, $order, $page, 20);
		$status = array ( '0' => '未使用', '1' => '已使用');

		$dataList = array();
		foreach ($res ['data'] as $data){
			$data['o_status'] = $data['status'] ? '<span class="green">'.$status[$data['status']].'</span>' : '<span class="red">'.$status[$data['status']].'</span>'; 
			$dataList[] = $data;
		}
		
		$this->assign('pager', $res ['pager']);
		$this->assign('status', $status);
    	$this->assign('dataList', $dataList);
    	$this->assign('condition', $condition);
    	$this->template ( 'index.php' );
    }
    
    //删除
    public function del(){
    	$account = isset($_GET['account']) ? $_GET['account'] : '';
    	$url = '/index.php?app=admin&mod=trade&ac=view';
    	if($account){
			$res =  \Model\Admin\TradeAccount::delTradeAcount($account);
			$this->sysRedirect($url);
    	}else{
			$this->fontRedirect('删除失败', $url);
		}
    }
    
     //编辑和添加
    public function add(){
    	$this->edit();
    }
    
    
    //编辑和添加
    public function edit(){
    	$account = isset($_GET['account']) ? $_GET['account'] : '';
    	$nav_title = $account ? '编辑交易账户' : '添加交易账户';
    	$ad_type = array();
    	$status = array ( '0' => '未使用', '1' => '已使用');
    	$data = \Model\Admin\TradeAccount::getTradeAcount($account);
    	
    	$this->assign('nav_title', $nav_title);
    	$this->assign('data', $data);
    	$this->assign('status', $status);
    	$this->template ( 'edit.php' );
    }
    
    //保存数据
    public function doEdit(){
		if ($_POST ['submit']) {
			$parent_account = $_POST['parent_account'];
			$account = $_POST['account'];
			$pwd = $_POST['pwd'];
			$status = $_POST['status'];
			$addtime = $_POST['addtime'];
                        $type = $_POST['type'];
                        echo $type;
			$arr = array('account'=>$account,'pwd'=>$pwd,'status'=>$status,'parent_account'=>$parent_account,'type'=>$type);
			$url = '/index.php?app=admin&mod=trade&ac=view';
			if($account && $pwd){
				if ($addtime){//修改
					$res =  \Model\Admin\TradeAccount::editTradeAcount($arr);
				}else{
					$arr['addtime'] = time();
					$res =  \Model\Admin\TradeAccount::addTradeAcount($arr);
				}
				$this->sysRedirect($url);
			}else{
				$this->fontRedirect('参数提交错误', $url);
			}
			//echo $_POST ['account'];
		}
	}
	
	//检查账户是否存在
	public function ajaxCheckAccount(){
		$res = array('status'=>0);
		if($_POST){
			$account = $_POST['account'];
			if(\Model\Admin\TradeAccount::getTradeAcount($account)){
				$res['status'] = 1;
			}
		}
    	exit(json_encode($res));
	}
	
	//交易账户导入
	public function tradeAccountUp(){
            $ext = substr(strrchr($_FILES['ufile']['name'], '.'), 1); 
            if($ext!='csv'){
                $this->fontRedirect('文件错误，只能上传csv文件', '/index.php?app=admin&mod=trade&ac=view',2);
                exit();
            }
            $fpath = SITEROOT.'data'.DIRECTORY_SEPARATOR.'upload'.DIRECTORY_SEPARATOR.uniqid().'.'.$ext; 
            $do = copy($_FILES['ufile']['tmp_name'],$fpath); 
            if ($do){ 
                echo ""; 
            }else{ 
                echo "上传文件失败<br>"; 
                exit();
            }
            $first_row = true;
            $handle=fopen($fpath,"r"); 
            \Common\Query::commitstart();
            $index = -1;
            echo '<p>&nbsp;</p>';
            while($data=fgetcsv($handle,10000,",")){ 
            	$index++;
                if($first_row){
                    $first_row = false;
                    continue;
                }
                //$data = eval('return '.iconv('gbk','utf-8',var_export($data,true)).';');
                //var_dump($data);
                $type = $data[0];
                //$type = $type== '普通账号'?1:2;
                $parent_account = $data[1];
                $account = $data[2];
                $pwd = $data[3];
                $row = \Model\Admin\TradeAccount::getTradeAcount($account);
                if($row){
                    echo '<p style="color:red;">第'.$index.'个账号：'.$account.'已存在，数据未导入；<br></p>';
                    continue;
                }else{
					$arr = array('account'=>$account,'pwd'=>$pwd,'status'=>'0','parent_account'=>$parent_account,'type'=>$type);
					$url = '/index.php?app=admin&mod=trade&ac=view';
					if($account && $pwd){
						$arr['addtime'] = time();
						$res =  \Model\Admin\TradeAccount::addTradeAcount($arr);
						if(empty($res)){
	                        echo '<p style="color:red;">第'.$index.'个账号导入失败；<br></p>';
	                        \Common\Query::rollback();
	                        //exit();
	                    }else{
	                    	 \Common\Query::commit();
	                    	 echo '<p style="color:green;">第'.$index.'个账号导入成功。<br></p>';
	                    }
					}
            }
        }
          fclose($handle); 
          unlink($fpath);
          echo '<p align="center"><br/><a href="/index.php?app=admin&mod=trade&ac=view">返回</a></p>';
	}

}	

?>