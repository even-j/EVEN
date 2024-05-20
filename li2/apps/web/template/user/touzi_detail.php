<!--include file "common.php"-->
<!--include file "header.php"-->
<!--include file "nav.php"-->
<link rel="stylesheet" href="/public/web/css/serviceCenter.css">
<link rel="stylesheet" href="/public/web/css/daywin_2015.css">
<link rel="stylesheet" href="/public/web/css/p2p.css">
<link rel="stylesheet" href="/public/web/css/base.css">
<link rel="stylesheet" href="/public/web/css/myInvest.css">
<link rel="stylesheet" href="/public/web/css/acount_2015.css">
<link rel="stylesheet" href="/public/web/css/fund.css" />

<style type="text/css">
/*投资详情*/
.steps{height:46px;border-bottom:2px solid #e6e6e6;position:relative;}
.steps ol{width:1000px;margin:0 auto;}
.steps ol li{display:inline;float:left;width: 203px;padding-left: 130px;height:46px;line-height:46px;font-size:16px;font-weight:bold;color:#999;font-family:"\5FAE\8F6F\96C5\9ED1","\534E\6587\7EC6\9ED1","\9ED1\4F53",arial;}
.steps ol li i{display:inline-block;zoom:1;*display:inline;margin-right:5px;width:24px;height:24px;text-align:center;font-style:normal;line-height:24px;font-size:14px;font-weight:bold;color:#FFF;background:url(https://img658.b0.upaiyun.com/v2/658/www/images/ico-circle2.png) no-repeat 0 0;}
.steps ol li.active{color:#ff3b3b;border-bottom:2px solid #ff3b3b;}
.steps ol li.active i{background-image:url(https://img658.b0.upaiyun.com/v2/658/www/images/ico-circle1.png);}
.box-yellow{ background-color:#fffcda; border:1px solid #ffeaaa; padding:25px 40px; margin:30px 0 10px 0px; float:left; width:918px}
.box-yellow h2{ font-size:16px; font-weight:bold; line-height:25px}
.box-yellow p{ font-size:14px; line-height:120%; padding:10px 0 30px 0}
.btnRed a {background: #ff3b3b;
transition: 0.3s background ease;
height: 49px;
line-height: 49px;
width: 180px;
color: #fff;
text-align: center;
float: left;
display: block;
border-radius:3px;
font-size:18px;
}
.btnRed a:hover{background: #ec2400;
text-decoration: none;
color: #fff;}
.found-detail{
	margin:15px 0 15px 0;
	float:left;
}
.found-detail h3{ font-size:18px;height: 50px;line-height: 50px;}
#mytd td{padding:15px 8px; border:1px solid #e2e2e2; font-size:14px}
#mytd td .p-l{}
#mytd .td_r{ background-color:#f6f6f6; text-align:right}
#mytd .td_t{ background-color:#f6f6f6; text-align:center}
/*投资详情*/
</style>

<div style=" border-top:1px solid #ccc; clear:both; height:1px; width:100%"></div>	

<section class="content">
	  <div class="center1000">
	<!--投资详情开始-->
			<div class="seeYouAgain">
				<a href="/"><?php echo SITE_NAME;?>首页</a>&nbsp;&gt;&nbsp;
				<a href="<?php echo \App::URL('web/user/account');?>">我的账户</a>&nbsp;&gt;&nbsp;
				<a href="<?php echo \App::URL('web/user/p2p_touzi');?>">我的投资</a>&nbsp;&gt;&nbsp;
				投资详情
			</div>
            <!--投资进度-->
            <div class="steps steps-3" style="width:1000px">
	<ol>
	    <li <?php if($data['p2pstatus']>=1 && $data['p2pstatus']<=3){ echo 'class="active"';}?>><i>1</i><span>投资</span></li>
		<li <?php if($data['p2pstatus']>=4 && $data['p2pstatus']<=6){ echo 'class="active"';}?>><i>2</i><span>回款</span></li>
	    <li <?php if($data['p2pstatus']==7){ echo 'class="active"';}?>><i>3</i><span>结束</span></li>
	</ol>
	</div>
    <!--投资状态-->
    <div class="box-yellow clear">
    	 <?php if($data['p2pstatus']>=0 && $data['p2pstatus']<=3){?>
    	  <?php if($data['p2pstatus']==0){?>
    	   <h2>当前状态： 等待审核</h2>
    	  <?php }elseif($data['p2pstatus']==3){?>
    	  <h2>当前状态：已取消</h2>
    	  <?php }else{?>
    	  <h2>当前状态：募资中</h2>
    	  <p>等待标满，获得您的收益。</p>
    	  <?php }?>
         <?php }elseif($data['p2pstatus']>=4 && $data['p2pstatus']<=6){?>
    	 <h2>当前状态：<?php echo ($data['p2pstatus']==4 || $data['p2pstatus']==5) ? '满标中' : '回款中';?></h2>
		 <p>已收利息：<font class="cd22"><?php echo number_format(floatval($data['earned_interest'])/100,2);?></font>元&nbsp;&nbsp;&nbsp;&nbsp;待收利息：<font class="cd22"><?php echo number_format(floatval($data['plan_interest']-$data['earned_interest'])/100,2);?></font>元 </p>
    	 <?php }elseif($data['p2pstatus']==7){?>
  	 	 <h2>当前状态：已平仓结束</h2>
  	 	 <p>投资已完美结束，您的本金与收益已计入您的账户中。</p>
  	 	 <?php }?>  		
  	 	
  		  <div class="btnRed"><a href="<?php echo \App::URL('web/user/fund');?>">查看资金</a></div>
  		  
    
		</div>
        <div class="clear found-detail"><h3>投资信息</h3>
        <table width="1005" border="0" align="left" cellpadding="0" cellspacing="1" style="background:#e2e2e2;" id="mytd">
  <tbody>
    <tr>
      <td width="150" bgcolor="#f6f6f6" class="td_r">项目编号</td>
      <td width="350" align="left" bgcolor="#FFFFFF"><?php echo date('Ymd',$data['tz_time']).$data['pz_id'];?>，<a href="<?php echo \App::URL('web/peizi/earn2',array('pz_id'=>$data['pz_id']));?>" class="link-blue" target="_blank">点击查看项目详情</a></td>
      <td width="150" bgcolor="#f6f6f6" class="td_r">投资时间</td>
      <td width="350" align="left" bgcolor="#FFFFFF">
   		  <!-- 开始时间 --><?php echo date('Y-m-d H:i:s',$data['tz_time']);?>
      </td>
      </tr>
    <tr>
      <td width="150" bgcolor="#f6f6f6" class="td_r">借款金额</td>
      <td align="left" bgcolor="#FFFFFF"><?php echo number_format(floatval($data['pz_money'])/100,0);?>元</td>
      <td width="150" bgcolor="#f6f6f6" class="td_r">投资本金</td>
      <td align="left" bgcolor="#FFFFFF"><?php echo number_format(floatval($data['tz_money'])/100,0);?>元</td>
      </tr>
       <tr>
      <td width="150" bgcolor="#f6f6f6" class="td_r">年息收益</td>
      <td align="left" bgcolor="#FFFFFF"><?php echo $data['year_rate'];?>%<br/>
      	<span class="cd22"></span>
      </td>
      <td width="150" bgcolor="#f6f6f6" class="td_r">投资收益</td>
      <td align="left" bgcolor="#FFFFFF"><p><!-- 收益 --><?php echo number_format(floatval($data['plan_interest'])/100,2);?>元</p></td>
      </tr>

				<tr>
					<td width="150" bgcolor="#f6f6f6" class="td_r">盈利分成</td>
					<td align="left" bgcolor="#FFFFFF"><?php echo $data['fencheng_rate']>0 ? $data['fencheng_rate'].'(%)' :'无';?></td>
					<td width="150" bgcolor="#f6f6f6" class="td_r">盈利收益</td>
					<td align="left" bgcolor="#FFFFFF"><?php echo $data['fencheng_rate']>0 ? number_format(floatval($data['fencheng_money'])/100,2) :'无';?></td>
				</tr>
			<tr>
				<td width="150" bgcolor="#f6f6f6" class="td_r">借款时间</td>
				<td align="left" bgcolor="#FFFFFF">
					<?php echo date('Y-m-d',$data['start_time']);?> 至<?php echo date('Y-m-d',$data['end_time']);?> <font class="cd22">   (<?php echo $data['pz_times']. \Model\P2p\Peizi::getTimeUnitName($data['pz_times_unit']);?>)   </font>
				</td>
				<td width="150" bgcolor="#f6f6f6" class="td_r">到期时间</td>
				<td align="left" bgcolor="#FFFFFF"><!-- 结束时间 --><?php echo date('Y-m-d',$data['end_time']+24*3600);?></td>
			</tr>
			<tr>
				<td width="150" bgcolor="#f6f6f6" class="td_r">借款用途</td>
				<td align="left" bgcolor="#FFFFFF"> 短期股票融资 </td>
				<td width="150" bgcolor="#f6f6f6" class="td_r">回款方式</td>
				<!-- 1为按天，2为按周，3为按月 -->
				<td align="left" bgcolor="#FFFFFF">按<?php echo \Model\P2p\Peizi::getTimeUnitName($data['pz_times_unit']);?>收息，到期还本</td> 

			</tr>
			<tr>
				<td width="150" bgcolor="#f6f6f6" class="td_r">项目合同</td>
				<td width="350" align="left" bgcolor="#FFFFFF" colspan="3">
 <a href="<?php echo \App::URL('web/peizi/p2p_protocol',array('pz_id'=>$data['pz_id']));?>" class="link-blue" target="_blank">合同下载</a> </td>
			</tr>
		</tbody>
</table>
</div>
        <div class="clear"></div>
        <?php if($data['p2pstatus']==7){?>
        <div class="clear found-detail" style="margin-bottom:60px"><h3>还款信息</h3>
        <table width="1005" border="0" align="left" cellpadding="0" cellspacing="1" style="background:#e2e2e2;" id="mytd">
  <tbody>
    <tr>
      <td width="250" class="td_t">日期</td>
      <td width="250" class="td_t">应收利息</td>
      <td width="250" class="td_t">应收本金</td>
      <td width="250" class="td_t">状态</td>
      </tr>
			<!-- 0初始状态  1融资失败(流标)结束 2待收款项 3已收到利息 4已收到利息及本金  5已收到本金(平仓)结束 6平仓结束-->
			<!-- 转让人仅显示收到本金的收益记录-->
		      <tr>
		         <td align="center" bgcolor="#FFFFFF">
		    		<?php echo date('Y-m-d',$data['end_time']+24*3600);?>
		         </td>
			      <td align="center" bgcolor="#FFFFFF">
						<?php echo number_format(floatval($data['plan_interest'])/100,2);?>元
				  </td>
			      <td align="center" bgcolor="#FFFFFF">
						<?php echo number_format(floatval($data['tz_money'])/100,0);?>元
				  </td>
			      <td align="center" bgcolor="#FFFFFF">
			      		<?php echo '已收到本金及利息';?>
			      </td>
		      </tr>
  </tbody>
</table>
        </div>
        <div class="clear"></div>
        <!--投资详情结束-->
        <?php }?>
</div>

	</section>	

<!-- content -->
	
<!--include file "footer.php"-->
</body>
</html>