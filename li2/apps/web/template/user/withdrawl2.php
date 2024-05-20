<!--include file "common.php"-->
<!--include file "header.php"-->
<!--include file "nav.php"-->
<link rel="stylesheet" type="text/css" href="/public/web/css/myInvest.css">
<link rel="stylesheet" type="text/css" href="/public/web/css/fund.css">

<div class="content" style="border-top: 1px solid #D8D8D8;">
    <div class="center1000">

<div class="seeYouAgain">
	<a href="/"><?php echo SITE_NAME;?>首页</a>&nbsp;&gt;&nbsp;<a
		href="<?php echo \App::URL('web/user/account');?>">我的账户</a>&nbsp;&gt;&nbsp;<a
		href="<?php echo \App::URL('web/user/fund');?>">资金管理</a>&nbsp;&gt;&nbsp;<a
		href="<?php echo \App::URL('web/user/withdrawl');?>">提现</a>
</div>


<div class="cut-line"></div>
<section class="center1000 apply-wrap clearfix">
    <header class="header2">
        <ul class="process">
            <li><b>1</b>填写提现金额</li>
            <li class="current"><b>2</b>确认提现信息</li>
            <li><b>3</b>提现申请已提交-等待银行处理</li>
        </ul>
        <div class="title">申请提现</div>
    </header>
    <div class="bulb-tip">
        <em class="bulb"></em>
        请您仔细核对您的账户信息，如信息有误，将导致提现失败，资金将退回您的账户。
    </div>
    <div class="fund-cont clearfix">
    <form id="frmwithdraw" action="<?php echo \App::URL('web/user/withdrawalsMoney');?>" method="post">
    	<input type="hidden" name="withdrawalMoney" value="<?php echo number_format($data['withdrawalMoney'],2);?>" />
    	<input type="hidden" name="serviceFee" value="0" />
    	<input type="hidden" name="realMoney" value="<?php echo $data['withdrawalMoney']?>" />
    	<input type="hidden" name="card_id" value="<?php echo $data['card_id'];?>" />
        <ul class="ui-fund-item clearfix">
            <li>
                <label>真实姓名</label>
                <strong class="bold"><?php echo $data['true_name']?></strong>
            </li>
            <li>
                <label>提现银行卡</label>
                <div class="bank-select">
                    <div class="sel-bank">
                        <img src="<?php echo $data['bankCardPic']?>">
                        <strong><em>尾号：</em><?php echo $data['bankCardTail']?></strong>
                    </div>
                </div>
            </li>
            <li>
                <label>到账时间</label>
                <span>工作时间及时到账，非工作时间次日9点前</span>
            </li>
            <li>
                <label>提现金额</label>
                <span class="pri"><em><?php echo number_format($data['withdrawalMoney'],2)?></em>元</span>
            </li>
           
            <li class="cut-block padding-top10">
                <a class="button"  id="btnSubmit" style="cursor:pointer;">确认，下一步</a>
                <div class="clear"></div>
            </li>
        </ul>
        
        </form>
    </div>
</div>

</div>
</section>
<script>
var checkSubmitFlg = 0;
$(function(){
  $("#btnSubmit").click(function(){
	if(checkSubmitFlg == 1){
		return;
	}
	checkSubmitFlg = 1;
  	$("#frmwithdraw").submit();
  });
});
</script>


<!--include file "footer.php"-->
</body>
</html>