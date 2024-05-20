<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <!--include file "common.php"-->
        <link href="/public/web/css/dialog.css" rel="stylesheet" type="text/css"/>
        <script type="text/javascript">
            $(function(){
                $('.submit').click(function(){
                    var pz_id = $("#pz_id").val();
                    $(this).attr("disabled","true");
                    $.post("<?php echo \App::URL('web/user/do_peizi_end')?>", {pz_id:pz_id},function(res){
                        if(res.code==1){
                            layer.alert('提交成功，请等待处理！',{icon:1},function(index){
                                closeWin();
                            });
                            //top.dlg.destroy();
                            //top.dialog2('提交成功，请等待处理！','success');
                        }else{
                            layer.alert(res.msg,{icon:2});
                            //top.dialog2(res.msg,'error');
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
            <div class="tip" id="message">温馨提示：请确保账户内已经全部清仓完毕，否则我们将有权把您的股票进行平仓处理。 </div>
            <div class="actions">
                        <input type="hidden" name="reason" value="终止方案">
                <input type="hidden" id="pz_id" name="pz_id" value="<?php echo $pz_id;?>">
                <input class="submit" type="button" value="确认">
                <input class="cancel" type="button" value="关闭" onclick="closeWin()">
                <!--<input class="cancel" type="button" value="关闭" onclick="dlg.destroy()">-->
            </div>
        </form>
    </body>
</html>