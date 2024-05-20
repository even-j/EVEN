<!--include file "admin_include.php"-->
<div class="container clearfix">
    <div class="main-wrap">
        <div class="pl-20 pr-20">
            <a class="btn btn-primary radius" style="margin:5px 0 5px 20px;" onclick="btn_check()" href="javascript:;">确定</a>
        </div>
        <!--导航按钮结束-->
            <!--内容-->
            <div class="result-wrap">
            <form name="myform" id="myform" method="post">
                <div id="div_content" class="result-content" style="width:100%;overflow: auto">
                    <input id="ids" type="hidden" value="<?php echo $ids; ?>"/>
                    <table class="result-tab" style="width:100%" >
                        <tr>
                            <th width="20">选择</th>
                            <th width="20">分组名</th>
                            <th width="20">创建时间</th>
                            <th width="130">备注</th>
                        </tr>
                        
                        <?php foreach ($datalist as $row){?>
                            <tr>
                                <td><input type="checkbox" id="<?php echo $row['id'];?>" class="rowcheck" value="<?php echo $row['name'];?>" name="group" /></td>
                                <td><?php echo $row['name'];?></td>
                                <td><?php echo date('Y-m-d H:i:s',$row['add_time']);?></td>
                                <td><?php echo $row['memo'];?></td>
                            </tr>
                        <?php }?>      
                    </table>
                </div>
            </form>
            <!--内容结束-->
        </div>
    </div>
    <!--/main-->
</div>
<script type="text/javascript">
    
 
</script>
<script type="text/javascript">
   

    function btn_check() {
                var ids=$("#ids").val();
                var checkedObj=$('.rowcheck:checked');
                var num=checkedObj.length; 
                if(ids=="" || ids==null)
                {
                    layer.msg('请勾选用户!');
                    return false;
                }
                if(num!=1)
                {
                    layer.msg('只能选择一个分组!');
                    return false;
                }
                var group_id =checkedObj.attr("id");
                if (group_id == "" ) {
                    layer.msg("请选择用户组");
                    return;
                }
                
                $("#btn_check").attr('disabled',true);
                $.post('/index.php?app=admin&mod=user&ac=groupupdate',{ids:ids,group_id:group_id},function(data){
                   if(data.ret == 0){
                        layer.msg('设置成功!');
                        setTimeout(function(){
                            parent.location.reload();
                        },1000)
                   }
                   else{
                        layer.msg(data.msg);
                        $("#btn_check").attr('disabled',false);
                    }
               },'json')
            }
</script>
<!--include file "admin_bottom.php"-->