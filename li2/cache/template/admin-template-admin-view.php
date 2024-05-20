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
  <div class="crumb-list"><i class="icon-font"></i><a href="/index.php?app=admin&mod=index&ac=view" target="_top">首页</a><span class="crumb-step">&gt;</span><span class="crumb-name"><?php if(isset($title)) echo $title?></span></div>
</div>   
      
        <div class="result-wrap">
        		 <div class="toolbar-wrap mb10">
		            <div class="toolbar-item">
		                <a href="/index.php?app=admin&mod=admin&ac=add"><i class="icon-font"></i> 添加管理员</a>
		                <!--<a id="batchDel" href="javascript:void(0)"><i class="icon-font"></i>批量删除</a>
		                <a id="updateOrd" href="javascript:void(0)"><i class="icon-font"></i>更新排序</a>-->
		            </div>
		        </div>
                <div id="div_content" class="result-content" style="width:100%;overflow: auto">
                    <table class="result-tab" style="width:100%" >
                        <tr>
                            <th style="width:60px">管理员ID</th>
                            <th style="width:120px">真实姓名</th>
                            <th style="width:120px">用户名</th>
                            <th style="width:120px">用户角色</th>
                            <th style="width:120px">手机号码</th>
                            <th style="width:120px">添加时间</th>
                            <th style="width:120px">添加IP</th>
                            <th style="width:120px">操作</th>
                        </tr>
                        <?php foreach ($list as $item){?>
                            <tr>
                                <td><?php echo $item['admin_id'];?></td>
                                <td><?php echo empty($item['real_name']) ? '未知' : $item['real_name'];?></td>
                                <td><?php echo $item['user_name']; ?></td>
                                <td><?php echo $item['role']['name']; ?></td>
                                <td><?php echo $item['mobile'] ? $item['mobile'] : '----'; ?></td>
                                <td><?php echo empty($item['addtime']) ? '未知':date('Y-m-d H:i',$item['addtime']); ?></td>
                                 <td><?php echo $item['lastip'] ?></td>
                                <td align="center">
                                    <a class="link-update" href="/index.php?app=admin&mod=admin&ac=edit&admin_id=<?php echo $item['admin_id'];?>">修改</a>
                                    &nbsp;&nbsp;<a class="link-del" href="javascript:delAdmin('/index.php?app=admin&mod=admin&ac=del&admin_id=','<?php echo $item['admin_id'];?>');">删除</a>
                                </td>
                            </tr>
                        <?php }?>             
                    </table>
                    
                </div>
        </div>
       <div class="list-page"><?php echo $pager;?></div>
    </div>
    
    <!--/main-->
</div>
<script type="text/javascript">
<!--
	function delAdmin(url,id){
		if(id==2){
			layer.msg('创始人不能删！');
			return;
		}
		url = url+id;
		if(confirm('您是否要删除该管理员？')){
			location.href = url;
		}
	}
	
//-->
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
