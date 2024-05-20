<!--include file "common.php"-->
<link rel="stylesheet" href="/public/web/css/modify.css">
<link rel="stylesheet" href="/public/web/css/validate_base.css">
<link rel="stylesheet" href="/public/web/css/operate_status.css">
<link rel="stylesheet" href="/public/web/css/realName.css">
<style>
<!--
.operate-block .addedByMilkLee a.submit{
	color:white;
	text-decoration:none;
}
-->
</style>
</head>
<body>
 <!--include file "user_header.php"-->
 <section class="center1000 operate-wrap clearfix">
            <header class="header2">
                <div class="title">身份信息</div>
            </header>
            <div class="operate-block">
                <dl class="clearfix">
                    <dt class="tick">身份信息保存成功，绑定银行卡后就可以进行资金操作了</dt>
                    <dd class="clearfix addedByMilkLee">
                       	<a href="<?php echo \App::URL('web/user/bank');?>" class="submit">绑定银行卡</a> 
                       	<a href="<?php echo \App::URL('web/user/account');?>" style="padding-left:27px;"> 返回账号设置</a> 
                    </dd>
                </dl>
            </div>
 </section>

<!--include file "footer.php"-->
</body>
</html>