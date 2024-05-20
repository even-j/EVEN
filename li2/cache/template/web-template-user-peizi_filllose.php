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

        <link href="/public/web/css/dialog.css" rel="stylesheet" type="text/css"/>
        <script type="text/javascript">
            $(function(){
                $('.submit').click(function(){
                    var money = $("#total").val();
                    var pz_id = $("#pz_id").val();
                    var balance = <?php echo floatval($user['balance'])/100 ?>;
                    if(money == ''){
                        layer.alert('金额不能为空',{icon:2});
                        //top.dialog2('金额不能为空','error');
                        return;
                    }
                    if(isNaN(money)){
                        layer.alert('金额应为数字',{icon:2});
                        //top.dialog2('金额应为数字','error');
                        return;
                    }
                    if(balance<money){
                        layer.alert('余额不足',{icon:2});
                        //top.dialog2('余额不足','error');
                        return;
                    }
                    $(this).attr("disabled","true");
                    $.post("<?php echo \App::URL('web/user/do_peizi_filllose')?>", {money:money,pz_id:pz_id},function(res){
                        if(res.code==0){
                            //top.dlg.destroy();
                            //top.dialog2(res.msg,'error');
                            layer.alert(res.msg,{icon:2});
                        }else{
                            layer.alert(res.msg,{icon:1},function(index){
                                closeWin();
                            });
                            //dlg.destroy();
                            //top.dialog2(res.msg,'success');
                            
                            //$('#message').attr('class','err');
                            //$('#message').html('错误：'+res.info);
                        }                
                    },'json');
                    $(this).attr("disabled","false");
                });
            });
            function closeWin(){
                var index = parent.layer.getFrameIndex(window.name);
                parent.layer.close(index);
            }
        </script>
    </head>
    <body>
        <form action="">
            <!--<div class="tip" id="message">盈利超过10%可提取10%以上部分，同时锁定10%以下部分，每周可提1次</div>-->
            <div class="tip" id="message">
                <em>账户余额：</em>
                <font class="cd22 f16 mymoney"><?php echo number_format(floatval($user['balance'])/100,2) ?></font>元  
                <a href="<?php echo \App::URL('web/user/recharge');?>" target="_blank" class="link-blue f16" style="padding-left:10px">马上充值</a>
            </div>
            <table>
                <tr>
                    <th>补亏金额：</th>
                    <td><input class="text" type="text" id="total" name="total"> 元</td>
                </tr>
            </table>
            <div class="actions">
                <input type="hidden" id="pz_id" name="pz_id" value="<?php echo $pz_id;?>">
                <input class="submit" type="button" value="确认">
                <input class="cancel" type="button" value="取消" onclick="closeWin()">
                <!--<input class="cancel" type="button" value="取消" onclick="dlg.destroy()">-->
            </div>
        </form>
    </body>
</html>