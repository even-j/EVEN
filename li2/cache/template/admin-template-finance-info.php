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
        <div class="result-wrap">
            <div class="result-content">
                <table class="insert-tab" width="100%">
                		<thead><caption class="mb10 font18"><h1>个人资产情况信息</h1></caption></thead>
                        <tbody>
                            <tr>
                                <th width="120">账号：</th>
                                <td><?php echo $user['mobile']?></td>
                            </tr>
                            <tr>
                                <th>姓名：</th>
                                <td><?php echo $user['true_name']?></td>
                            </tr>
                            <tr>
                                <th>身份证号：</th>
                                <td><?php echo $user['id_card']?></td>
                            </tr>
                            <tr>
                                <th>总充值：</th>
                                <td><?php echo number_format(($user['recharge']/100),2)?></td>
                            </tr>
                            <tr>
                                <th>总盈亏：</th>
                                <td><?php echo number_format(($user['yltq']/100),2)?></td>
                            </tr>
                            <tr>
                                <th>总提现：</th>
                                <td><?php echo $user['tixian']>0 ? '-'.number_format(($user['tixian']/100),2) : number_format(($user['tixian']/100),2)?></td>
                            </tr>
                            <tr>
                                <th>总管理费：</th>
                                <td><?php echo $user['gl_fee']>0 ? '-'.number_format(($user['gl_fee']/100),2) : number_format(($user['gl_fee']/100),2)?></td>
                            </tr>
                            <tr>
                                <th>冻结资金：</th>
                                <td><?php echo number_format(($user['frozen']/100),2)?></td>
                            </tr>
                            
                             <tr>
                                <th>余额：</th>
                                <td><?php echo number_format(($user['balance']/100),2)?>&nbsp;&nbsp;<a href="/index.php?app=admin&mod=finance&ac=fund&uid=<?php echo $user['uid'];?>">历史明细查看</a></td>
                            </tr>
                             <tr>
                                <th>收入-支出：</th>
                                <td class="red"><?php echo $user['yingkui']>0 ? number_format(($user['yingkui']/100),2) : number_format(($user['yingkui']/100),2);?></td>
                            </tr>
                            
                        </tbody>
                 </table>
                 
            </div>
        </div>

    </div>
    <!--/main-->
</div>

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
