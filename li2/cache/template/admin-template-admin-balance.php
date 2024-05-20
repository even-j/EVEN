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
            <div class="crumb-list"><i class="icon-font"></i><a href="/index.php?app=admin&mod=index&ac=view" target="_top">首页</a><span class="crumb-step">&gt;</span><a class="crumb-name" href="/index.php?app=admin&mod=admin&ac=view">管理员管理</a><span class="crumb-step">&gt;</span><span><?php echo $nav_title; ?></span></div>
        </div>
        <div class="result-wrap">
            <div class="result-content">
                <form action="/index.php?app=admin&mod=admin&ac=doPay" method="post" onsubmit="return validateForm();" id="myform" name="myform" enctype="multipart/form-data">
                    <input type="hidden" name="uid" value="<?php echo $user['uid']; ?>" />
                    <input type="hidden" id="cur_balance" name="cur_balance" value="<?php echo ($user['balance'] / 100); ?>" />
                    <table class="insert-tab" width="100%">
                        <tbody>
                            <tr>
                                <th width="120">真实姓名：</th>
                                <td><?php echo $user['true_name']; ?></td>
                            </tr>
                            <tr>
                                <th width="120">手机账号：</th>
                                <td><?php echo $user['mobile']; ?></td>
                            </tr>
                            <tr>
                                <th width="120">当前余额：</th>
                                <td><?php echo '¥ ' . number_format(($user['balance'] / 100), 2); ?></td>
                            </tr>
                            <tr>
                                <th width="120">赠送余额：</th>
                                <td><?php echo '¥ ' . number_format(($user['send'] / 100), 2); ?></td>
                            </tr>
                            <tr>
                                <th><i class="require-red">*</i>操作类型：</th>
                                <td>
                                    <select class="common-select required" id="type" name="type" style="width: 430px;" onchange="selchange(this)">
                                        <option value="14">系统充值</option>
                                        <option value="15">系统扣除</option>
                                        <option value="100">赠送管理费</option>
                                        <option value="102">赠送管理费扣除</option>
                                    </select>
                                    <input type="checkbox" id="add_record" name="add_record" checked="true"/>
                                    <label for="add_record" id="lable_add_record">添加到充值</label>
                                    <i class="tip left pd10"></i>
                                </td>
                            </tr>
                            <tr>
                                <th><i class="require-red">*</i>操作金额：</th>
                                <td><input class="common-text required" id="balance" name="balance" size="50" value="" type="text"/> <i class="tip left pd10"></i></td>
                            </tr>

                            <tr>
                                <th></th>
                                <td>
                                    <input class="btn btn-primary btn6 mr10" name="submit" value="提交" type="submit">
                                    <input class="btn btn6" onClick="history.go(-1)" value="返回" type="button">
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
    function validateForm() {
        var balance = $('#balance');
        var cur_balance = parseInt($('#cur_balance').val());
        if (balance.val() == "") {
            balance.next().html('操作金额不能为空');
            return false;
        } else if ($('#type').val() == 15 && parseInt(balance.val()) > cur_balance) {
            balance.next().html(balance.val() + '系统扣除不能超过当前余额' + cur_balance);
            return false;
        }
        return true;
    }


    $("#balance").blur(function () {
        var objExp = /^[1-9](\d+)?\.?\d{0,2}$/;
        this.value = $.trim(this.value);
        if (!objExp.test(this.value)) {
            $(this).next().html('操作金额必须是大于0的正整数');
        } else {
            $(this).next().html('');
        }
    });

    function getCitys(provinceId) {
        var city_name = $('#city_name').val();
        $.ajax({
            url: "/index.php?app=admin&mod=user&ac=ajaxregion",
            dataType: "json",
            data: {
                provinceId: provinceId,
                subLength: 4,
                t: new Date().getTime()
            },
            success: function (data) {
                $("#city").html("");
                var str = " <option value='-1'>请选择</option>";
                $("#city").append(str);
                $.each(data, function (i, temp) {
                    var selected = '';
                    if (city_name == temp.name) {
                        selected = 'selected="selected"';
                    }
                    var str = "<option value='" + temp.id + "' " + selected + ">" + temp.name + "</option>";
                    $("#city").append(str);
                });
            }
        });
    }

    function selchange(obj){
        if($(obj).val() == '14'){
            $("#lable_add_record").html("添加到充值");
            $("#add_record").show();
            $("#lable_add_record").show();
        }
        else if($(obj).val() == '15'){
            $("#lable_add_record").html("添加到提现");
            $("#add_record").show();
            $("#lable_add_record").show();
        }
        else{
            $("#add_record").hide();
            $("#lable_add_record").hide();
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
