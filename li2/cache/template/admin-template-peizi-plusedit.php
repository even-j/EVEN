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
    	 <div class="crumb-wrap">
            <div class="crumb-list"><i class="icon-font"></i><a href="/index.php?app=admin&mod=index&ac=view" target="_top">首页</a><span class="crumb-step">&gt;</span><a class="crumb-name" href="/index.php?app=admin&mod=peizi&ac=plus">追加实盘金划拔</a><span class="crumb-step">&gt;</span><span><?php echo $nav_title;?></span></div>
        </div>
        <div class="result-wrap">
            <div class="result-content">
             <form action="/index.php?app=admin&mod=peizi&ac=doPlusEdit" method="post" onclick="return validateForm();" id="myform" name="myform" enctype="multipart/form-data">
                 <input type="hidden" name="add_id" value="<?php echo $_GET['add_id']?>" />
                 <table class="insert-tab" width="100%">
                    <tbody>
                        <tr>
                            <th width="150">策略类型：</th>
                            <td><?php echo \Model\Peizi\Peizi::getPzType($pz_row['pz_type'])  ?></td>
                        </tr>
                        <tr>
                            <th>追加时间：</th>
                            <td><?php echo date('Y-m-d H:i',$add_row['add_time']);?></td>
                        </tr>
                        <tr>
                            <th>证券账户：</th>
                            <td><?php echo $pz_row['sp_user'] ?></td>
                        </tr>
                        <tr>
                            <th>追加保证金(元)：</th>
                            <td><?php echo floatval($add_row['add_bond'])/100 ?></td>
                        </tr>
                        <tr>
                            <th>倍数：</th>
                            <td><?php echo floatval($pz_row['pz_ratio']) ?></td>
                        </tr>
                        <tr>
                            <th>追加策略金额：</th>
                            <td><?php echo floatval($add_row['add_bond'])* intval($pz_row['pz_ratio'])/100 ?></td>
                        </tr>
                        <tr>
                            <th>追加操盘金额：</th>
                            <td><?php echo floatval($add_row['add_money'])/100 ?></td>
                        </tr>
                        <tr>
                            <th>追加后警戒线(元)：</th>
                            <td><?php echo floatval($add_row['alarm_money'])/100 ?></td>
                        </tr>
                        <tr>
                            <th>追加后止损线(元)：</th>
                            <td><?php echo floatval($add_row['stop_money'])/100 ?></td>
                        </tr>
                        <tr>
                            <th>实盘单号：</th>
                            <td><?php echo date('Ymd',$pz_row['pz_time']).$pz_row['pz_id'] ?></td>
                        </tr>
                        <tr>
                            <th><i class="require-red">*</i>划拔状态：</th>
                            <td>
                                <?php if($add_row['status'] == 0){?>
                                <select name="status" id="status">
                                    <option value="0">未划拔</option>
                                    <option value="1">已划拔</option>
                                </select>
                                <?php }else{?>
                                    已划拔
                                <?php }?>
                            </td>
                        </tr>
                         
                             <tr>
                            <th></th>
                            <td>
                                <?php if($add_row['status'] == 0){?>
                                <input class="btn btn-primary btn6 mr10" name="submit" value="提交" type="submit">
                                <?php }?>
                                <input class="btn btn6" onClick="goback()" value="返回" type="button">
                                
                            </td>
                        </tr>
                    </tbody>
                 </table>
                </form> 
            </div>
        </div>

    </div>
    <!--/main-->
</div>
<script type="text/javascript">
function validateForm(){
	
	return true;
}
function goback(){
    var url = '/index.php?app=admin&mod=peizi&ac=plus';
    window.location.href = url;
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
