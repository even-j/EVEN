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
<div class="message"><?php echo $this->msg ?></div>

<div class="tc" style="margin-top: 30px"><?php echo $this->time?>秒后自动跳转，<a style="color:blue;text-decoration: underline" href="javascript:jump();" >马上跳转</a></div>

<script>
    var time = <?php echo $this->time?>;
    time = time || 1 ;
    time = time * 1000;
    setTimeout(function(){
       jump();
    },time);
    function jump(){
        var url = "<?php echo $this->uri?>";
        if(url!=null && url == 'back'){
            window.history.go(-1);
        }
        else if(url!=null && url!=''){
            window.location.href = url;
        }
    }
</script>
</body>
</html>
