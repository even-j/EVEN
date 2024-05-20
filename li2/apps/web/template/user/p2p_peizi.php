<!--include file "common.php"-->
<!--include file "header.php"-->
<!--include file "nav.php"-->
<link rel="stylesheet" type="text/css" href="/public/web/css/serviceCenter.css"/>
<link rel="stylesheet" href="/public/web/css/acount_2015.css">
<link rel="stylesheet" href="/public/web/css/fund.css">
<link rel="stylesheet" href="/public/web/css/cool.css">
<script type="text/javascript" src="/public/web/js/jquery-1.8.3.min.js"></script>
<link rel="stylesheet" href="/public/web/css/daywin_2015.css">

<div class="content" style="border-top: 1px solid #D8D8D8;">
  <div class="center1000">
    <div class="acount-sub-nav clearfix"> </div>
    <div class="fullBox container act-box">
      <!--include file "user_left_menu.php"-->
      
      <!--我的配资开始-->
      <div class="right rCon clearfix"> 
        <!--我的投资开始-->
        <div class="subtitle fl" style="width:769px;"> <b class="anyWhere fl" style="top:8px;"></b>我的策略</div>
        <div class="data_frame" id="mylend">
          <div class="total_lend">
            <h3>当前策略金额</h3>
            <div class="clear data-margin2">
              <div class="f30 cd22"><?php echo number_format(floatval($user_peizi['total_pz'])/100/10000,0);?><span class="f18 c888">万元</span></div>
            </div>
          </div>
          <div class="total_money">
            <h3>可用余额</h3>
            <span class="money_detail f12"><a href="<?php echo \App::URL('web/user/fund');?>" class="link-gray">查看明细</a></span>
            <div class="clear data-margin2">
              <div class="f30 cd22"><?php echo number_format(floatval($user['balance'])/100,2)?><span class="f18 c888">元</span></div>
            </div>
            <div class="data-sub">
              <ul>
                <li id="btnRed"><a href="<?php echo \App::URL('web/user/recharge');?>">充值</a></li>
                <li id="btnBlue"><a href="<?php echo \App::URL('web/user/withdrawl');?>">提现</a></li>
                <li id="btnTxt" style="width:180px;"><!--<a href="javascript:void(0);" id="alert_tqyl_ok" style="width:60px;">提取盈利</a>--></li>
                <div class="clear"></div>
              </ul>
            </div>
          </div>
        </div>
        <!--列表开始-->
        <div class="clear"></div>
        <!--//列表开始-->
        <div class="list-tab-frame">
          <ul class="new-qa-hd">
            <li id="all-tab" <?php echo isset($_GET['status']) ? '' : ' class="current"' ;?> ><a href="<?php echo \App::URL('web/user/p2p_peizi');?>">全部</a></li>
            <li id="wait-tab" <?php echo isset($_GET['status']) && $_GET['status']==2 ? 'class="current"' : '' ;?>><a href="<?php echo \App::URL('web/user/p2p_peizi',array('status'=>2));?>">募资中</a></li>
            <li id="trading-tab" <?php echo isset($_GET['status']) && $_GET['status']==6 ? 'class="current"' : '' ;?>><a href="<?php echo \App::URL('web/user/p2p_peizi',array('status'=>6));?>">操盘中</a></li>
            <!-- <li  id="expire-tab" ><a>即将到期</a></li> -->
            <li id="over-tab" <?php echo isset($_GET['status']) && $_GET['status']==7 ? 'class="current"' : '' ;?>><a href="<?php echo \App::URL('web/user/p2p_peizi',array('status'=>7));?>">已结束</a></li>
          </ul>
        </div>
        
        <!--列表开始-->
          <div class="list-box all-tab fl">
          <?php if($dataList){?>
           			<?php foreach ($dataList as $data){?>
           			<div class="mylend_item">
           			<div class="item_title"> <a href="<?php echo \App::URL('web/peiziu/p2p4',array('pz_id'=>$data['pz_id']));?>" target="_blank" class="link-blue"><?php echo date('Ymd',$data['pz_time']).$data['pz_id'];?>[股票]</a> 
           			<?php if($data['p2pstatus']==6){?><span class="fr">结束时间：<?php echo date('Y-m-d',$data['end_time']);?> <?php echo $data['limit_day'];?> </span> <span class="fr">开始时间：<?php echo date('Y-m-d',$data['start_time']);?></span><?php }else{?><span class="fr">申请时间：<?php echo date('Y-m-d H:i:s',$data['pz_time']);?> </span><?php }?></div>
		            <div class="item_sub">
		              <ul>
		                <li>策略金额<p class="f18"><?php echo number_format(floatval($data['pz_money'])/100/10000,0);?>万</p>
		                </li>
		                <li>保证金<p class="f18"><?php echo number_format(floatval($data['bond_total'])/100,2);?>元</p>
		                </li>
		                <li>借款期限<p><?php echo $data['pz_times'];?><?php echo \Model\P2p\Peizi::getTimeUnitName($data['pz_times_unit']);?> </p>
		                </li>
		                <li>每期利息<p><?php echo number_format(floatval($data['interest'])/100,2);?>元</p></li>
                                <!--<li class="c444 mylend_state">--><li><?php if($data['p2pstatus']==2){echo  \Model\Sys\Common::countdown($data['limit_end_time']);}?>
                                    <p><?php echo $data['p_status'];?>
                                    <?php if($data['p2pstatus']==2){?>
                                    <span class="info_tips"><img id="pop_tip_warn" src="/public/web/images/icon_qa.png" style="cursor:pointer"></span>
                                    <?php }?>
                                    </p>
                                </li>
		                <li><a d="opmenu" class="ui-btn state1 link-blue" href="<?php echo \App::URL('web/peiziu/p2p4',array('pz_id'=>$data['pz_id']));?>" target="_blank">查看详情</a> </li>
		              </ul>
		            </div>
            		</div>
           			<?php }?>
           <?php }else{?>
          		<div class="mylend_item" style="text-align: center;">没有符合条件的策略记录</div>
          <?php }?>
          </div>
         <!--结束-->
         <div class="list-page" style="text-align:center"><?php echo $pager?></div>
        
        <!--end--> 
        <!--列表结束--> 
        <!--我的投资结束--> 
      </div>
      <!--我的配资结束--> 
    </div>
  </div>
</div>
<script type="text/javascript">
	$(document).ready(function() {
		$("#financercenter").attr("class", "selected");
		$(".s_amount").each(function(){
			var amount = $.trim($(this).text());
			$(this).text(Number(amount).format());
		});
	});
     function tipsEnter(obj, title) {
		layer.tips(title, obj, { style: ['background-color:#FFFFDB; color:#000;border:1px solid #D1C183; margin-top:-20px;line-height:25px'], guide: 1, maxWidth:250, time:1000});
	};
	function tipsLeave() {
		layer.closeTips();
	};
        $('.info_tips img').on('mouseenter', function(){  
            tipsEnter(this, '三天倒计时终止时未满标（流标）则募资失败，取消募集，退回保证金、管理费、利息，需要重新发起募资策略。');
        });
        $('.info_tips img').on('mouseleave', function(){  
           tipsLeave();
        })
</script>
<script src="/public/web/js/layer.min.js"></script>
<!--include file "footer.php"-->
</body></html>