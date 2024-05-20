
<script src="/public/wap/js/jquery.js" type="text/javascript"></script>
<script src="/public/wap/js/layer_mobile/layer.js" type="text/javascript"></script>
<script src="/public/wap/js/common.js" type="text/javascript"></script>
<link href="/public/wap/css/dialog.css?v" rel="stylesheet" type="text/css"/>
<script type="text/javascript">
    $(function(){
        $('.submit').click(function(){
            var pz_id = $("#pz_id").val();
            var index = layerloading('提交中');
            $(this).attr("disabled","true");
            $.post("<?php echo \App::URL('wap/user/do_peizi_end')?>", {pz_id:pz_id},function(res){
                if(res.code==1){
                    layerconfirm(res.msg,['确定'],function(){
                        closewin();
                    })
                    //top.dialog2(res.msg,'success');
                }else{
                    layer.close(index);
                    layeralert(res.msg);
                    //top.dialog2(res.msg,'error');
                }                
            },'json');
            $(this).attr("disabled","false");
        });
    });
    function closewin(){
        parent.layer.closeAll();
    }
</script>
<form action="">
    <div class="tip" id="message">温馨提示：请确保账户内已经全部清仓完毕。 </div>
    <div class="actions">
		<input type="hidden" name="reason" value="终止方案">
        <input type="hidden" id="pz_id" name="pz_id" value="<?php echo $pz_id;?>">
        <input class="submit" type="button" value="确认">
        <input class="cancel" type="button" value="关闭" onclick="closewin()">
    </div>
</form>