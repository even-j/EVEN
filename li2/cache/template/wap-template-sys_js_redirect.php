<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0"/>
<meta name="format-detection" content="telephone=no" />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta charset="utf-8">
<title><?php if (isset($title)) echo $title ?></title>
<meta name="keywords" content="<?php if (isset($keywords)) echo $keywords ?>">
<meta name="description" content="<?php if (isset($description)) echo $description ?>">
<link rel="stylesheet" href="/public/wap/css/wap_style.css">
<link rel="stylesheet" href="/public/wap/css/wap_new.css">
<script src="/public/wap/js/jquery.js" type="text/javascript"></script>
<script src="/public/wap/js/layer_mobile/layer.js" type="text/javascript"></script>
<script src="/public/wap/js/common.js" type="text/javascript"></script>

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
