<dl>
    <dt class="t4"><a>操盘管理</a></dt>
    <a href="<?php echo \App::URL("web/user/peizi",array('pz_type'=>4));?>"><dd <?php if($_GET['ac']=='peizi' && $_GET['pz_type']==4){echo ' class="current"';}?>>免费体验</dd></a>
    <a href="<?php echo \App::URL("web/user/peizi",array('pz_type'=>1));?>"><dd <?php if($_GET['ac']=='peizi' && $_GET['pz_type']==1){echo ' class="current"';}?>>按天策略</dd></a>
    <a href="<?php echo \App::URL("web/user/peizi",array('pz_type'=>2));?>"><dd <?php if($_GET['ac']=='peizi' && $_GET['pz_type']==2){echo ' class="current"';}?>>按月策略</dd></a>
    <dt class="t4"><a>资金管理</a></dt>
    <a href="<?php echo \App::URL("web/user/recharge");?>"><dd <?php if($_GET['ac']=='recharge'){echo ' class="current"';}?>>账户充值</dd></a>
    <a href="<?php echo \App::URL("web/user/withdrawl");?>"><dd <?php if($_GET['ac']=='withdrawl'){echo ' class="current"';}?>>我要提款</dd></a>
    <a href="<?php echo \App::URL("web/user/fund");?>"><dd <?php if($_GET['ac']=='fund'){echo ' class="current"';}?>>资金流水</dd></a>
    <dt class="t4"><a>账户管理</a></dt>
    <a href="<?php echo \App::URL("web/user/account");?>"><dd <?php if($_GET['ac']=='account'){echo ' class="current"';}?>>我的账户</dd></a>
    <a href="<?php echo \App::URL("web/user/bank");?>"><dd <?php if($_GET['ac']=='bank'){echo ' class="current"';}?>>银行卡管理</dd></a>
    <a href="<?php echo \App::URL("web/user/sfz");?>"><dd <?php if($_GET['ac']=='sfz'){echo ' class="current"';}?>>实名认证</dd></a>
    <a href="<?php echo \App::URL("web/user/login_password");?>"><dd <?php if($_GET['ac']=='login_password'){echo ' class="current"';}?>>登陆密码</dd></a>
    <a href="<?php echo \App::URL("web/user/tuiguang");?>"><dd <?php if($_GET['ac']=='tuiguang'){echo ' class="current"';}?>>推广链接</dd></a>
</dl>