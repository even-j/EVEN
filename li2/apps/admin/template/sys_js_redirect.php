<!--include file "admin_include.php"-->
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
