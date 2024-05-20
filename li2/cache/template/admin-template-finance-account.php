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
        <div class="search-wrap">
            <div class="search-content">
                <form action="/index.php" method="get">
                	<input type="hidden" name="app" value="admin" >
                	<input type="hidden" name="mod" value="finance" >
                	<input type="hidden" name="ac" value="account" >
                    <table class="search-tab">
                        <tr>
                            <th width="40">名称:</th>
                            <td><input class="common-text" placeholder="" name="name" value="<?php echo $condition['name'];?>" id="name" type="text"></td>
                            <th width="80">收款类型:</th>
                            <td>
                                <select name="type" id="type">
                                    <option value="">全部</option>
                                    <?php foreach ($accountType_arr as $key=>$val){
                                    	$selected = $condition['type'] && $key==$condition['type'] ? 'selected="selected"' : '';
                                    ?>
                                    <option value="<?php echo $key;?>" <?php echo $selected;?>><?php echo $val;?></option>
                                    <?php }?>
                                </select>
                            </td>
                            <th width="80">收款开户人:</th>
                            <td><input class="common-text" placeholder="" name="holder" value="<?php echo $condition['holder'];?>" id="holder" type="text"></td>
                            <!--<th width="60">收款渠道:</th>
                            <td><input class="common-text" placeholder="" name="channel" value="<?php echo $condition['channel'];?>" id="channel" type="text"></td>
                            <th width="40">收款账号:</th>
                            <td><input class="common-text" placeholder="" name="account" value="<?php echo $condition['account'];?>" id="account" type="text"></td>
                            <th width="40">开户地址:</th>
                            <td><input class="common-text" placeholder="" name="address" value="<?php echo $condition['address'];?>" id="address" type="text"></td>-->
                            <th width="70">状态:</th>
                            <td>
                                <select name="status" id="status">
                                    <option value="" <?php if(!isset($condition['status']) || $condition['status']=='' )  {echo 'selected="selected"';}?>>全部</option>
                                    <option value="0" <?php if(isset($condition['status']) && $condition['status']=='0' ) {echo 'selected="selected"';}?>>禁用</option>
                                    <option value="1" <?php if(isset($condition['status']) && $condition['status']=='1' ) {echo 'selected="selected"';}?>>启用</option>
                                </select>
                            </td>
                            
                            <td><input class="btn btn-primary btn10" name="" value="查询" type="submit"></td>
                        </tr>
                    </table>
                </form>
            </div>
        </div>
        <div class="result-wrap">
        	<span></span>
              <div class="result-title">
                    <div class="result-list">
                        <a href="/index.php?app=admin&mod=finance&ac=accountEdit" target="mainFrame"><i class="icon-font"></i>添加账户</a>
                    </div>
                </div>
                <div class="result-content">
                    <table class="result-tab" width="100%">
                        <tr>
                            <th style="width:10%;">名称</th>
                            <th style="width:10%;">收款类型</th>
                            <th style="width:10%;">收款渠道</th>
                            <th style="width:10%;">收款开户人</th>
                            <th style="width:10%;">收款账号</th>
                            <th style="width:10%;">用户组</th>
                            <th style="width:10%;">二维码</th>
                            <th style="width:10%;">状态</th>
                            <th style="width:15%;">操作</th>
                        </tr>
                        <?php foreach ($dataList as $data){?>
                        <tr>
                            <td><?php echo $data['name'];?></td>
                            <td><?php echo $data['type_caption'];?></td>
                            <td><?php echo $data['channel'];?></td>
                            <td><?php echo $data['holder'];?></td>
                            <td><?php echo $data['account'];?></td>
                            <td><?php echo \Model\User\Group::idToName($data['group_id'])?></td>
                            <td><img src="<?php echo $data['path'];?>" style="height:50px"/></td>
                            <td><?php echo $data['status_caption'];?></td>
                            <td>
                                <a class="link-update" href="/index.php?app=admin&mod=finance&ac=accountEdit&id=<?php echo $data['id'];?>" target="mainFrame">修改</a>
                                <a class="link-del" href="javascript:delAccount('/index.php?app=admin&mod=finance&ac=accountDel&id=<?php echo $data['id'];?>');">删除</a>
                            </td>
                        </tr>
                        <?php }?>
                    </table>
                    <div class="list-page"><?php echo $pager;?></div>
                </div>
        </div>
    </div>
    <!--/main-->
</div>
<script type="text/javascript">
 function delAccount(url){
		if(confirm('您是否要删除该收款账户？删除后不可恢复')){
			location.href = url;
		}
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
