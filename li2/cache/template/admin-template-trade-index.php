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
                	<input type="hidden" name="mod" value="trade" >
                	<input type="hidden" name="ac" value="view" >
                    <table class="search-tab">
                        <tr>
                            <th width="80">账户类型:</th>
                            <td>
                                <select name="type" id="status" class="common-select">
                                    <option <?php echo $condition['type'] == ''?'selected="selected"':''?> value="">&nbsp;全部&nbsp; </option>
                                    <option <?php echo $condition['type'] == '1'?'selected="selected"':''?> value="1">普通账号</option>
                                    <option <?php echo $condition['type'] == '2'?'selected="selected"':''?> value="2">免费体验账号</option>
                                </select>
                            </td>
                            <th width="80">账户状态:</th>
                            <td>
                                <select name="status" id="status">
                                    <option value="" selected>全部</option>
                                    <?php foreach ($status as $key=>$val){
                                    	$selected = $condition['status']!='' && $key==$condition['status'] ? 'selected="selected"' : '';
                                    ?>
                                    <option value="<?php echo $key;?>" <?php echo $selected;?>><?php echo $val;?></option>
                                    <?php }?>
                                </select>
                            </td>
                            <th width="120">交易账户名:</th>
                            <td><input class="common-text" placeholder="账户名" name="account" value="<?php echo $condition['account'];?>" id="account" type="text"></td>
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
                        <!--<a id="batchDel" href="javascript:void(0)"><i class="icon-font"></i>批量删除</a>
                        <a id="updateOrd" href="javascript:void(0)"><i class="icon-font"></i>更新排序</a>-->
                         <form action="/index.php?app=admin&mod=trade&ac=tradeAccountUp" method="post" enctype="multipart/form-data">
		                    <table class="search-tab">
		                        <tr>
		                        	<td><a href="/index.php?app=admin&mod=trade&ac=add" target="mainFrame"><i class="icon-font"></i>添加交易账户</a></td>
		                            <th width="100">交易账户导入:</th>
		                            <td><input type="file" class="common-text" name="ufile" id=""></td>
		                            <th width="80"><input class="btn btn-primary btn2" name="sub" value="上传" type="submit"></th>
		                        </tr>
		                    </table>
		                </form>
                    </div>
                </div>
                <div class="result-content">
                    <table class="result-tab" width="100%">
                        <tr>
                            <th style="width:10%;">账户类型</th>
                        	 <th style="width:10%;">母账户</th>
                            <th style="width:20%;">交易账户</th>
                            <th style="width:15%;">账户密码</th>
                             <th style="width:20%;">添加时间</th>
                            <th style="width:15%;">状态</th>
                            <th style="width:10%;">操作</th>
                        </tr>
                        <?php foreach ($dataList as $data){?>
                        <tr>
                            <td><?php echo Model\Trade\Account::getAccountType($data['type']) ;?></td>
                            <td><?php echo $data['parent_account'];?></td>
                            <td><?php echo $data['account'];?></td>
                            <td><?php echo $data['pwd'];?></td>
                            <td><?php echo date('Y-m-d H:i:s',$data['addtime']);?></td>
      						<td><?php echo $data['o_status'];?></td>
                            <td>
                                <a class="link-update" href="/index.php?app=admin&mod=trade&ac=edit&account=<?php echo $data['account'];?>" target="mainFrame">修改</a>
                                <a class="link-del" href="javascript:delAccount('/index.php?app=admin&mod=trade&ac=del&account=<?php echo $data['account'];?>');">删除</a>
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
<!--
	function delAccount(url){
		if(confirm('您是否要删除该交易账户吗？')){
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
