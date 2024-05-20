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
                    <input type="hidden" name="ac" value="tixian" >
                    <table class="search-tab">
                        <tr>
                            <th width="70">用户ID:</th>
                            <td><input class="common-text" placeholder="用户ID" name="uid" value="<?php echo empty($_GET['uid'])?'':$_GET['uid']?>" id="" type="text"></td>
                            <th width="70">手机:</th>
                            <td><input class="common-text" placeholder="手机" name="mobile" value="<?php echo empty($_GET['mobile'])?'':$_GET['mobile']?>" id="" type="text"></td>
                            <th width="70">姓名:</th>
                            <td><input class="common-text" placeholder="姓名" name="true_name" value="<?php echo empty($_GET['true_name'])?'':$_GET['true_name']?>" id="" type="text"></td>
                            <th width="70">银行卡号:</th>
                            <td><input class="common-text" placeholder="银行卡号" name="card_no" value="<?php echo empty($_GET['card_no'])?'':$_GET['card_no']?>" id="" type="text"></td>
                            <th width="70">提现状态:</th>
                            <td>
                                <select name="status">
                                    <option value="" selected>全部</option>
                                    <option value="0" <?php if(isset($_GET['status']) && $_GET['status']=='0' ) {echo 'selected="selected"';}?> >待审核</option>
                                    <option value="1" <?php if(isset($_GET['status']) && $_GET['status']=='1' ) {echo 'selected="selected"';}?>>已审核</option>
                                    <option value="2" <?php if(isset($_GET['status']) && $_GET['status']=='2' ) {echo 'selected="selected"';}?>>已完成</option>
                                </select>
                            </td>
                            <td><input class="btn btn-primary btn2" name="sub" value="查询" type="submit"></td>
                        </tr>
                    </table>
                </form>
            </div>
        </div>
       <!--<div class="toolbar-wrap">
            <div class="toolbar-item">
                <a href="/index.php?app=admin&mod=user&ac=add"><i class="icon-font"></i>添加会员</a>
                <a id="batchDel" href="javascript:void(0)"><i class="icon-font"></i>批量删除</a>
                <a id="updateOrd" href="javascript:void(0)"><i class="icon-font"></i>更新排序</a>
            </div>
        </div>-->
        <div class="result-wrap">
            <form name="myform" id="myform" method="post">
                <div class="result-title">
                </div>
                <div id="div_content" class="result-content" style="width:100%;overflow: auto">
                    <table class="result-tab" style="width:100%" >
                        <tr>
                            <!--<th class="tc" width="40px"><input class="allChoose" name="" type="checkbox"></th>-->
                            <th style="width:60px">用户ID</th>
                            <th style="width:60px">姓名</th>
                            <th style="width:120px">手机</th>
                            <th style="width:80px">开户行</th>
                            <th style="width:100px">开户行地区</th>
                            <th style="width:180px">银行卡号</th>
                            <th style="width:120px">提现金额</th>
                            <th style="width:140px">提现时间</th>
                            <th style="width:80px">状态</th>
                            <th style="width:100px">操作</th>

                        </tr>
                        <?php foreach ($list as $item){?>
                            <tr>
                                <!--<td class="tc"><input name="id[]" value="59" type="checkbox"></td>-->
                                <td><?php echo $item['uid'] ?></td>
                                <td><a href="/index.php?app=admin&mod=user&ac=info&uid=<?php echo $item['uid']?>" ><?php echo $item['true_name']?></a></td>
                                <td><?php echo $item['mobile'] ?></td>
                                <td><?php echo $item['bank_name'] ?></td>
                                <td><?php echo $item['province_name'].$item['city_name'] ?></td>
                                <td><?php echo $item['card_no'] ?></td>
                                <td><a href="javascript:void(0);" onclick="show('个人资产情况','/index.php?app=admin&mod=finance&ac=info&uid=<?php echo $item['uid'];?>');" title="预览个人资产情况"><?php echo number_format((floatval($item['money']) /100),2) ?></a></td>
                                <td><?php echo date('Y-m-d H:i',$item['rtime']) ?></td>
                                <td><?php $status = array('<span class="red">待审核</span>','<span class="blue">已审核</span>','<span class="green">已完成</span>');echo $status[$item['status']];?></td>
                                <td>
                                    <?php if($item['status']==0){?>
                                    <a class="link-update" href="javascript:changeStatus(<?php echo $item['withdraw_id'];?>,2)">审核通过</a>
                                    <a class="link-update" href="javascript:changeStatus(<?php echo $item['withdraw_id'];?>,3)">拒绝通过</a>
                                    <?php }else{?>
                                    已完成
                                    <?php }?>
                                </td>
                            </tr>
                        <?php }?>             
                    </table>
                </div>
                <div class="list-page"><?php echo $pager;?></div>
            </form>
        </div>
    </div>
    <!--/main-->
</div>
<script>
    function changeStatus(withdraw_id,status){ 
        $.post('/index.php?app=admin&mod=finance&ac=tixianChangeStatus',{withdraw_id:withdraw_id,status:status},function(res){
            if(res.code == '1'){
            	layer.msg('操作成功');
                window.location.reload();
            }else{
            	layer.msg(res.msg);
            }
        },'json').error(function(XMLHttpRequest, textStatus, errorThrown){
	       	 alert(XMLHttpRequest.status+' \t '+XMLHttpRequest.readyState+' \t '+textStatus);
         });
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
