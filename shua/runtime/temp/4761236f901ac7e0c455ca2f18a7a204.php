<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:71:"/www/wwwroot/xbt.com/pubic/../application/admin/view/seller/bianji.html";i:1578363582;}*/ ?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>编辑资料</title>
    <meta name="renderer" content="webkit">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="format-detection" content="telephone=no">
    <link rel="stylesheet" href="/admin_style/layui/css/layui.css" media="all" />
    <link rel="stylesheet" href="/admin_style/css/public.css" media="all" />
    <link rel="stylesheet" href="//at.alicdn.com/t/font_1308190_7kttvg3l5i.css" media="all" />

    <link href="/admin_style/assets/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <link href="/admin_style/assets/plugins/summernote/summernote.css" rel="stylesheet">

    <link href="/admin_style/assets/plugins/simple-line-icons/simple-line-icons.min.css" rel="stylesheet" type="text/css" />
    <link href="/admin_style/assets/plugins/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css" />

    <!-- Template Styles -->
    <link href="/admin_style/assets/css/style.css" rel="stylesheet" type="text/css" />
    <link href="/admin_style/assets/css/plugins.min.css" rel="stylesheet" type="text/css" />
    <link href="/admin_style/assets/css/pages/formlayout.css" rel="stylesheet" type="text/css" />
    <link href="/admin_style/assets/css/responsive.css" rel="stylesheet" type="text/css" />
    <link href="/admin_style/assets/css/theme-color.css" rel="stylesheet" type="text/css" />
    <!-- 提示 -->
    <link rel="stylesheet" href="/admin_style/assets/plugins/jquery-toast/dist/jquery.toast.min.css">
</head>
<body class="childrenBody">
<input  type="hidden" name="dataid" lay-verify="beizhu" autocomplete="off" class="layui-input dataid">
<form class="layui-form">
    <div class="table-wrap">
        <div class="table-responsive text-center">
            <table class="table display product-overview mb-30 table-bordered" id="support_table5">
                <thead>
                <h3>用户信息</h3>
                </thead>
                <tbody>
                <tr>
                    <td>用户名</td>
                    <td>
                        <input type="text" class="name form-control" name="name" lay-verify="name" placeholder="用户名" readonly></td>
                    <td>手机号</td>
                    <td>
                        <input type="text" class="phone form-control" name="phone" lay-verify="phone" placeholder="手机号"></td>
                </tr>
                <tr><td>VIP到期时间</td>
                    <td>
                        <input type="text" name="time" lay-verify="time" autocomplete="off" class="time form-control layui-input time" id="application-Time"
                               placeholder="到期时间">
                    <td>银锭</td>
                    <td>
                        <input type="number" class="silverIngot form-control text-center" name="silverIngot" lay-verify="silverIngot" value="0" min="0" max="">
                    </td>
                </tr>
                <tr>
                    <td>QQ</td>
                    <td>
                        <input type="text" class="qq form-control" name="qq" lay-verify="qq" placeholder="QQ"></td>
                    <td>推荐人</td>
                    <td>
                        <input type="text"  class="recommender form-control" name="recommender" lay-verify="recommender" placeholder="推荐人"  readonly></td>
                </tr>
                <tr>
                    <td>本金</td>
                    <td>
                        <input type="number" class="principal form-control text-center" name="principal" lay-verify="principal" value="0" min="0" max="">
                    </td>
                    <td>是否VIP</td>
                    <td>
                        <select class="vip" name="vip"  lay-verify="vip" >
                            <!--                                        <option value="1">是</option>-->
                            <!--                                        <option value="0" >不是</option>-->
                        </select>
                    </td>
                </tr>
                <tr >
                    <td >财务备注</td>
                    <td colspan="3">
                        <textarea class="remarks form-control wgbz" rows="3" name="remarks" lay-verify="remarks"></textarea></td>
                </tr>
                </tbody>
            </table>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-type="reload" lay-filter="reload" lay-submit>保存</button>
            </div>
        </div>
    </div>
</form>
<script type="text/javascript" src="/admin_style/layui/layui.js"></script>

<!-- start js include path -->
<script src="/admin_style/assets/plugins/jquery/jquery.min.js" ></script>
<!-- 提示 -->
<script src="/admin_style/assets/plugins/jquery-toast/dist/jquery.toast.min.js" ></script>
<script src="/admin_style/assets/plugins/jquery-toast/dist/toast.js" ></script>
<script>
    layui.use(['form', 'layer', 'table', 'laytpl', 'laydate'], function () {
        var form = layui.form,
            layer = parent.layer === undefined ? layui.layer : top.layer,
            $ = layui.jquery,
            laytpl = layui.laytpl,
            table = layui.table;
        laydate = layui.laydate;
        var dataid = $(".dataid").val(); //id
        console.log(dataid,1231);
        $.ajax({
            type: "post",
            url: '/index.php/admin/seller/bianji/id/'+dataid+'',
            data: {
                'id':dataid
            },
            dataType: "json",
            async:false,
            success:function(data) {
                if(data.code == 0){
                    console.log(data.data.vip);
                    var selected1 ='';
                    var selected2 ='';
                    if(data.data.vip==0){
                        selected1='selected'
                    }else if(data.data.vip==1){
                        selected2='selected'
                    }
                    $('.name').val(data.data.seller_name)//用户名
                    $('.phone').val(data.data.mobile)//手机号
                    $('.time').val(data.data.vip_time)//vip到期时间
                    $('.silverIngot').val(data.data.reward)//银锭
                    $('.qq').val(data.data.qq)//qq
                    $('.recommender').val(data.data.tjuser)//推荐人
                    $('.principal').val(data.data.balance)//本金
                    var optionStr = '<option value="0" '+selected1+'>否</option><option value="1" '+selected2+'>是</option>';
                    $('.vip').append(optionStr);
                    //$('.vip').val(data.data.vip)//是否VIP

                    //$('.wgbz').val(data.data.note)//违规备注
                }
            }
        });
        form.render();
        //刷新select选择框渲染

        //验证数据
        form.verify({
            phone: function (value, item) { //value：表单的值、item：表单的DOM对象
                if(!/^1[3456789]\d{9}$/.test(value)){
                    return '手机号码有误，请重填';
                }
            },
                /* qq: function (value, item) {
                if(value.length>10){
                    return 'QQ有误，请重填';
                }
            },*/
            //我们既支持上述函数式的方式，也支持下述数组的形式
            //数组的两个值分别代表：[正则匹配、匹配不符时的提示文字]
            pass: [
                /^[\S]{6,12}$/
                , '密码必须6到12位，且不能出现空格'
            ]
        });
        //申请时间
        var date2 = laydate.render({
            elem: '#application-Time'
            , type: 'datetime'
            , format: 'yyyy-MM-dd'
        })
        //表单提交
        form.on("submit(reload)", function (data) {
            layer.confirm('确定保存？', { icon: 3, title: '提示信息' }, function (index) {
            var field = data.field;
            var curr=$(".layui-laypage-em").next().html(); //当前页码值
            //弹出loading 加载
            var index = top.layer.msg('数据提交中，请稍候', { icon: 16, time: false, shade: 0.8 });
            var name = field.name;  //姓名
            var phone = field.phone;  //手机号
            var principal = field.principal;  //本金
            var silverIngot = field.silverIngot;  //银锭
            var qq = field.qq;  //qq
            var recommender = field.recommender;  //推荐人
            var vip = field.vip;  //VIP
            var time = field.time;  //到期时间
            var remarks = field.remarks;  //备注
            console.log(field)
            var dataid = $(".dataid").val(); //id
            var timestamp2 = Date.parse(new Date(time));
            console.log(vip,21);
            $.ajax({
                type: "post",
                url: '/index.php/admin/seller/edit_bianji/id/'+dataid+'',
                data: {
                    'id':dataid,
                    'username':name,
                    'mobile':phone,
                    'balance':principal,
                    'reward':silverIngot,
                    'qq':qq,
                    'tjuser':recommender,
                    'vip':vip,
                    'vip_time':timestamp2,
                    'note':remarks
                },
                dataType: "json",
                async:true,
                success:function(data) {
                    if(data.code == 1){
                        layer.msg(data.msg, {icon: 1},function () {
                            // 搜索条件
                            var name = $("input[name=name]").val(); //姓名
                            var expireTime = $("input[name=expireTime]").val(); //会员到期
                            var registerTime = $("input[name=registerTime]").val(); //注册时间
                            var phone = $("input[name=phone]").val(); //手机号
                            var state = $('#state1 option:selected').val(); //状态
                            var account = $("input[name=account]").val(); //账户
                            var username = $("input[name=username]").val(); //用户名
                            var qq = $("input[name=qq]").val(); //QQ号
                            var tjuser = $("input[name=tjuser]").val(); //来源id
                            parent.layui.table.reload('userListTable', {
                                method: 'post'
                                , where: {
                                    'name': name, //姓名
                                    'expireTime': expireTime,    //会员到期
                                    'registerTime': registerTime,    //注册时间
                                    'phone': phone,  //手机号
                                    'state': state, //状态
                                    'account': account, //账户
                                    'username': username, //用户名
                                    'qq': qq, //QQ号
                                    'tjuser': tjuser, //来源id
                                }
                                , page: {
                                    curr: curr
                                }
                            });
                            setTimeout(function () {
                                parent.layui.layer.closeAll();
                                top.layer.msg("操作成功！");

                            }, 500);
                            return false;
                        });
                    }else{
                        layer.msg(data.msg, {icon: 2});
                        //layer.msg('删除失败', {icon: 2});
                    }
                }
            })

            })

        });

    })

</script>
</body>

</html>
