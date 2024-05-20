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
<script type="text/javascript">

function show(title,url){
	//iframe层
    layer.open({
        type: 2,
        title: title,
        shadeClose: true,
        shade: 0.8,
        fix: false, //不固定
        maxmin: true,
        area: ['60%', '500px'],
        content: url //iframe的url
    }); 
}
var layerIndex = 0;
var isOpen=false;
var interval= window.setInterval("showWindow()",20000);
function showWindow(){
	$.post('/index.php?app=admin&mod=index&ac=showWindow',{},function(res){
		 if(res.status=='1'){
                    if(isOpen){
                        layer.close(layerIndex);
                    }
                    //iframe窗
                    layerIndex = layer.open({
                        type: 1,
                        title: '您有新的<b class="red"> '+res.num+' </b>条待办事项',
                        shade: false,
                        //skin: 'layui-layer-demo', //样式类名
                        area: ['340px', '315px'],
                        shadeClose: false, //开启遮罩关闭
                        offset: 'rb', //右下角弹出
                        content: '<div class="result-content"><ul id="wait-do" class="sys-info-list pt10">'+res.msg+'</ul></div><div style="display:none;"><audio controls="true" autoplay="autoplay" loop="loop"><source src="/public/admin/sound/music.mp3" /><source src="/public/admin/sound/music.ogg" /></audio></div>', 
                        end:function(){ // 点击右上角关闭按钮  
                            isOpen=false;
                            layerIndex=0;
                        }
                    });
                    isOpen = true;
		 }
	},'json');
}

</script>
</body>
</html>
