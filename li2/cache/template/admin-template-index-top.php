<!DOCTYPE HTML>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php if(isset($title)) echo $title.'_'?><?php echo SITE_NAME;?>—后台管理</title>
<link rel="stylesheet" type="text/css" href="/public/admin/css/common.css?v=201812202"/>
<link rel="stylesheet" type="text/css" href="/public/admin/css/main.css?v=5"/>
<script type="text/javascript" src="/public/admin/js/jquery-1.7.1.min.js"></script>
<script type="text/javascript" src="/public/admin/js/common.js?v=201812202"></script>
<script type="text/javascript" src="/public/admin/js/libs/modernizr.min.js"></script>
<script type="text/javascript" src="/public/admin/js/layer/layer.js"></script>

</head>

<body>
<?php $admin_user = \Model\Admin\User::getAdminInfo(array('admin_id'=>\Model\Admin\User::checks())); ?>
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