<!--include file "admin_include.php"-->
<div class="topbar-wrap white">
        <div class="topbar-inner clearfix">
            <div class="topbar-logo-wrap clearfix">
                <h1 class="topbar-logo"><a href="/index.php?app=admin&mod=index&ac=view" target="_self" class="navbar-brand"><?php echo SITE_NAME;?>后台管理</a></h1>
                <ul class="navbar-list clearfix">
                    <li><a class="on" href="/index.php?app=admin&mod=index&ac=view" target="_top">首页</a></li>
                    <li><a href="<?php echo DOMAIN;?>" target="_blank">网站首页</a></li>
                </ul>
            </div>
            <div class="top-info-wrap">
                <ul class="top-info-list clearfix">
                	<li><?php echo '<b class="orange">'.$admin_user['real_name'].'</b>，欢迎您登陆【'.SITE_NAME.'】后台管理中心！';?></li>
                    <li><a href="/index.php?app=admin&mod=admin&ac=password" target="mainFrame">修改密码</a></li>
                    <li><a href="/index.php?app=admin&mod=login&ac=logout" target="_top">退出</a></li>
                </ul>
            </div>
        </div>
</div>

</body>
</html>