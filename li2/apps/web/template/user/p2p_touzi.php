<!--include file "common.php"-->
<!--include file "header.php"-->
<!--include file "nav.php"-->

<link rel="stylesheet" type="text/css" href="/public/web/css/myInvest.css"/>
<link rel="stylesheet" href="/public/web/css/myAccount_new.css ">
<link rel="stylesheet" href="/public/web/css/acount_2015.css">
<link rel="stylesheet" href="/public/web/css/fund.css">
<link rel="stylesheet" href="/public/web/css/cool.css">
<link rel="stylesheet" href="/public/web/css/p2p.css">
<link rel="stylesheet" href="/public/web/css/left_menu.css">
<link rel="stylesheet" href="/public/web/css/tip-yellowsimple.css" />
<script type="text/javascript" src="/public/web/js/tab.js"></script>
<script type="text/javascript" src="/public/web/js/utils.js"></script>
<script type="text/javascript" src="/public/web/js/jquery.poshytip.js"></script>

<div class="content" style="border-top: 1px solid #D8D8D8;">
	<div class="center1000">

<div class="acount-sub-nav clearfix"></div>
<div class="fullBox container act-box">
<!--include file "user_left_menu.php"-->
<div class="right rCon clearfix">
<!--我的投资开始-->
<div class="data_frame">
<div class="total_found">
<h3>累计投资</h3><span class="info_tips"><img class="pop_tip" title="累计投资=已收本金+待收本金。" src="/public/web/images/icon_qa.png"></span>
<div class="clear data-margin"><div class="f30 cd22"><?php echo number_format(floatval($user_touzi['total_bj'])/100,2);?><span class="f18 c888">元</span></div></div>
<div class="data-sub clear">
<ul>
<li><h4>已收本金</h4><?php echo number_format(floatval($user_touzi['total_ysbj'])/100,2);?><font class="c888 f14">元</font></li>
<li><h4>待收本金</h4><?php echo number_format(floatval($user_touzi['total_dsbj'])/100,2);?><font class="c888 f14">元</font></li>
</ul>
</div>
</div>
<div class="total_get">
<h3>累计收益</h3><span class="info_tips"><img class="pop_tip" title="总收益=已收利息+待收利息。" src="/public/web/images/icon_qa.png"></span>
<div class="clear data-margin"><div class="f30 cd22"><?php echo number_format(floatval($user_touzi['total_sy'])/100,2);?><span class="f18 c888">元</span></div></div>
<div class="data-sub clear">
<ul>
<li><h4>已收利息</h4><?php echo number_format(floatval($user_touzi['total_yslx'])/100,2);?><font class="c888 f14">元</font></li>
<li><h4>待收利息</h4><?php echo number_format(floatval($user_touzi['total_dslx'])/100,2);?><font class="c888 f14">元</font></li>
</ul>
</div>
</div>
<div class="total_money">
<h3>可用余额</h3><span class="money_detail f12"><a href="<?php echo \App::URL('web/user/fund');?>" class="link-gray">查看明细</a></span>
<div class="clear data-margin"><div class="f30 cd22"><?php echo number_format(floatval($user['balance'])/100,2);?><span class="f18 c888">元</span></div></div>
<div class="data-sub clear">
<ul>
        <li id="btnRed"><a href="<?php echo \App::URL('web/user/recharge');?>">充值</a></li>
        <li id="btnGray"><a href="<?php echo \App::URL('web/user/withdrawl');?>">提现</a></li>
        <div class="clear"></div>
      </ul>
</div>
</div>
</div>
<div class="clear f12 m-all-20 fl txt-r w790"><a href="<?php echo \App::URL('web/article/view',array('pid'=>26));?>" class="link-888" target="_blank">资金由易宝懒猫全程托管</a></div> 
<!--列表开始-->
<div class="clear"></div>
	 <!--//列表开始-->
	<div class="tab-div">
        <div id="tabbar-div">
         <p>
		 	<a href="<?php echo \App::URL('web/user/p2p_touzi')?>"><span <?php echo isset($_GET['status']) ? 'class="tab-back"' : ' class="tab-front"' ;?> id="all-tab">全部投资</span></a>
		    <a href="<?php echo \App::URL('web/user/p2p_touzi',array('status'=>1));?>"><span <?php echo isset($_GET['status']) && $_GET['status']==1 ? 'class="tab-front"' : ' class="tab-back"' ;?> id="wait-tab">待回款</span> </a>
            <a href="<?php echo \App::URL('web/user/p2p_touzi',array('status'=>2));?>"><span <?php echo isset($_GET['status']) && $_GET['status']==2 ? 'class="tab-front"' : ' class="tab-back"' ;?> id="over-tab">已回款</span></a>
         </p>
       </div>
       <div class="lazy-btn" style="display:none"><a href="/autoBidConfig">懒人投资</a></div>
       
  </div>
  <div class="time-filer f12 clear fl " style="position:relative">
				<div class="fl">投资时间：<select class="sel" name="datetype" id="datetype" onchange="changePage()">
				<option value="1" <?php if($datetype==1){echo 'selected="selected"';}?>>全部</option>
				  <option value="2" <?php if($datetype==2){echo 'selected="selected"';}?>>三天以内</option>
					<option value="3" <?php if($datetype==3){echo 'selected="selected"';}?>>一周以内</option>
					<option value="4" <?php if($datetype==4){echo 'selected="selected"';}?>>一个月以内</option>
					<option value="5" <?php if($datetype==5){echo 'selected="selected"';}?>>三个月以内</option>
					<option value="6" <?php if($datetype==6){echo 'selected="selected"';}?>>一年以内</option>
				</select></div>
                <!--<div class="fl lazy-filter"><input type="checkbox" name="isAutoBid" id="isAutoBid" onclick="changePage()">懒人投资</div>-->
        
        </div>
         <div class="list-box fl">
         <img id="waitgif" src="/public/web/images/data_loading.gif" style="display:none;">
        
		 	 <!--全部-->
			   <table width="790" cellpadding="3" cellspacing="0" id="all-table">
             <tbody><tr>
               <th width="15%"><h5>借款金额(元)</h5></th>
               <th width="8%"><h5>年息收益</h5></th>
               <th width="9%"><h5>盈利分成</h5></th>
               <th width="11%"><h5>投资本金(元)</h5></th>
               <th width="10%"><h5>利息收益(元)</h5></th>
               <th width="10%"><h5>投资时间</h5></th>
               <th width="16%"><h5>到期时间</h5></th>
               <th width="10%"><h5>状态</h5></th>
               <th width="11%"><h5>操作</h5></th>
             </tr>
           </tbody></table>
           <?php if($dataList){?>
           		 <table width="790" cellpadding="3" cellspacing="0" id="all-table">
           			<?php foreach ($dataList as $data){?>
           			<tr>
		               <td><?php echo number_format(floatval($data['pz_money'])/100,2);?><td>
		               <td><?php echo $data['year_rate'];?>(%)<td>
		                <td><?php echo $data['fencheng_rate'];?>(%)<td>
		               <td><?php echo number_format(floatval($data['tz_money'])/100,2);?><td>
		               <td><?php echo number_format(floatval($data['earned_interest'])/100,2);?><td>
		               <td><?php echo date('Y-m-d',$data['tz_time']);?><td>
		               <td><?php echo date('Y-m-d',$data['end_time']);?><td>
		               <td><?php echo $data['p_status'];?><td>
		               <td><a class="ui-btn state2 link-blue" target="_blank" href="<?php echo \App::URL('web/user/p2p_touzi_detail',array('tz_id'=>$data['tz_id']));?>" d="opmenu">查看详情</a><td>
		             </tr>
           			<?php }?>
           		</table>
           <?php }else{?>
          	<div style="text-align:center">  没有符合条件的投资记录</div>
          <?php }?>
         <!--结束-->
         <div class="list-page" style="text-align:center"><?php echo $pager?></div>
</div>
<!--列表结束-->
<!--我的投资结束-->
</div></div>
</div>
</div>

<!--提示-->
<script>
	$(function(){
		$("#investercenter").attr("class", "selected");
	});
	
	$(function(){
		$('img.pop_tip').poshytip({
			className: 'tip-yellowsimple',
			showTimeout: 1,
			alignTo: 'target',
			alignX: 'center',
			offsetY: 5,
			allowTipHover: false,
			fade: false,
			slide: false
		});
	});
</script>
<script type="text/javascript">
	function changePage() {
	
		var datetype = document.getElementById("datetype").value;
		/*var checkbox = document.getElementById("isAutoBid");*/
		var isAutoBid ="";
		/*if(checkbox.checked)
			isAutoBid = "1";*/
		var status = "<?php echo isset($_GET['status']) ? intval($_GET['status']) : '';?>";
		var page = "<?php echo isset($_GET['page']) ?  intval($_GET['page']) : '';?>";
		var url = "<?php echo \App::URL('web/user/p2p_touzi')?>";
		if(url.indexOf("?")>0){
			url = url + "&datetype="+datetype;
		}else{
			url = url + "?datetype="+datetype;
		}
		if(status!=''){
			 url = url+"&status="+status;
		}
		if(isAutoBid=="1"){
			 url = url+"&isAutoBid="+isAutoBid;
		}
		if(page!=''){
			 url = url+"&page="+page;
		}
		window.self.location = url;
		
	}
</script>
<style>
.norton, .save-360, .faith {
	display: inline-block;
	overflow: hidden;
	background:none;
}
</style>
<div class="clear"></div>
<!--include file "footer.php"-->
</body>
</html>