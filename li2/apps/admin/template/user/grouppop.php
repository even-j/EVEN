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
                    <table class="result-tab" style="width:100%" >
                        <tr>
                            <th width="20">选择</th>
                            <th width="20">分组名</th>
                            <th width="20">创建时间</th>
                            <th width="130">备注</th>
                        </tr>
                        <?php foreach ($datalist as $row){?>
                            <tr>
                                <td><input type="checkbox" id="<?php echo $row['id'];?>" value="<?php echo $row['name'];?>" name="group" /></td>
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
    $(function(){
        var group_id = "<?php echo $search_param['group_id']; ?>";
        var group_ids = group_id.split(",");
        for (var i=0;i<group_ids.length;i++) {
            $("[name='group']").each(function() {
                if ($(this).attr("id") == group_ids[i]) {
                    $(this).get(0).checked = true;
                    $(this).parent().parent().css("background-color","Beige");
                }
            });
        }
    });

    function btn_check() {
        var group_id = "";
        var group_name = "";
        $("[name='group']").each(function() {
            if ($(this).get(0).checked) {
                if (group_id == "") {
                    group_id = $(this).attr("id");
                    group_name = $(this).val();
                } else {
                    group_id = $(this).attr("id") + "," + group_id;
                    group_name = $(this).val() + "," + group_name;
                }
            }
        });
        if (group_id == "" || group_name == "") {
            layer.msg("请选择用户组");
            return;
        }
        parent.group_id.value = group_id;
        parent.group_name.value = group_name;
     
        var index = parent.layer.getFrameIndex(window.name);
        parent.layer.close(index);
    }
</script>
<!--include file "admin_bottom.php"-->