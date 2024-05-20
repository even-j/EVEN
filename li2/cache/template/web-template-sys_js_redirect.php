<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <title><?php if (isset($title)) echo $title ?></title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?php if($ISHTTPS==true) {?>
<meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests" /> 
<?php }?>
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
<meta name="description" content="<?php if (isset($description)) echo $description ?>" />
<meta name="keywords" content="<?php if (isset($keywords)) echo $keywords ?>" />
<!--<link href="/public/web/css/common.css" rel="stylesheet" type="text/css" media="screen,projection" />
<link href="/public/web/css/main.css" rel="stylesheet" type="text/css">
-->
<script src="/public/web/js/jquery.js" type="text/javascript"></script>
<script src="/public/web/layer/3.0.3/layer.js" type="text/javascript"></script>
<script src="/public/web/js/common_home.js?v=3" type="text/javascript"></script>
<script src="/public/web/js/main.js" type="text/javascript"></script>

<script type="text/javascript" src="/public/web/js/add/com.js"></script>
<link href="/public/web/css/add/common.css?v=3" rel="stylesheet" type="text/css" />
<link href="/public/web/css/main.css" rel="stylesheet" type="text/css" />

    </head>
<body>
<style>
.message{color:green;font-size: 20px;font-weight: 800;line-height:40px;text-align: center;padding:0 10px;}
</style>
    <div style="margin-top:5px;margin-bottom: 30px;clear: both">&nbsp;</div>
<div class="message"><?php echo $this->msg ?></div>
<div class="txt-c clear" style="margin-top: 30px;text-align: center;clear: both"><?php echo $this->time?>秒后自动跳转，<a style="color:blue;text-decoration: underline" href="javascript:jump();" >马上跳转</a></div>

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
