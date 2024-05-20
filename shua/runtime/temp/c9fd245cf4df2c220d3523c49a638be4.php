<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:72:"/www/wwwroot/xbt.com/pubic/../application/admin/view/buyer/addbuyer.html";i:1575881626;}*/ ?>
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
    <style>

    </style>
</head>

<body class="childrenBody">
    <form class="layui-form">
        <div class="table-wrap">
            <div class="table-responsive text-center">
                <table class="table display product-overview mb-30 table-bordered" id="support_table5">
                    <thead>
                        <h3>新增买家</h3>
                    </thead>
                    <tbody>
                        <tr>
                            <td>用户名</td>
                            <td>
                                <input type="text" class="name form-control" name="name" lay-verify="name"
                                    placeholder="用户名" ></td>
                            <td>手机号</td>
                            <td>
                                <input type="text" class="phone form-control" name="phone" lay-verify="phone"
                                    placeholder="手机号"></td>
                        </tr>
                        <tr>
                            <td>账号密码</td>
                            <td>
                                <input type="text" class="principal form-control text-center" name="password"
                                       lay-verify="password" value="" min="0" max="">
                            </td>
                            <td>确认密码</td>
                            <td>
                                <input type="text" class="principal form-control text-center" name="password2"
                                       lay-verify="password2" value="" min="0" max="">
                            </td>
                        </tr>
                        <tr>
                            <td>VIP到期时间</td>
                            <td>
                                <input type="text" name="time" lay-verify="time" autocomplete="off"
                                    class="time form-control layui-input time" id="application-Time" placeholder="到期时间">
                            </td>
                            <td>银锭</td>
                            <td>
                                <input type="number" class="silverIngot form-control text-center" name="silverIngot"
                                    lay-verify="silverIngot" value="0" min="0" max="">
                            </td>
                        </tr>
                        <tr>
                            <td>QQ</td>
                            <td>
                                <input type="text" class="qq form-control" name="qq" lay-verify="qq" placeholder="QQ">
                            </td>
                            <td>推荐人</td>
                            <td>
                                <input type="text" class="recommender form-control" name="recommender"
                                    lay-verify="recommender" placeholder="推荐人" ></td>
                        </tr>
                        <tr>
                            <td>本金</td>
                            <td>
                                <input type="number" class="principal form-control text-center" name="principal"
                                    lay-verify="principal" value="0" min="0" max="">
                            </td>
<!--                            <td>是否VIP</td>-->
<!--                            <td>-->
<!--                                <select class="vip" name="vip" lay-verify="vip">-->
<!--                                    <option value="0" selected>是</option>&lt;!&ndash; 是 &ndash;&gt;-->
<!--                                    <option value="1">否</option>&lt;!&ndash; 否 &ndash;&gt;-->
<!--                                </select>-->
<!--                            </td>-->
                        </tr>

                        <tr>
                            <td>备注</td>
                            <td colspan="3">
                                <textarea class="remarks form-control" rows="3" name="remarks"
                                    lay-verify="remarks"></textarea></td>
                        </tr>
                    </tbody>
                </table>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" data-type="reload" lay-filter="reload"
                        lay-submit>保存</button>
                </div>
            </div>
        </div>
    </form>
    <script type="text/javascript" src="/admin_style/layui/layui.js"></script>

    <!-- start js include path -->
    <script src="/admin_style/assets/plugins/jquery/jquery.min.js"></script>
    <!-- 提示 -->
    <script src="/admin_style/assets/plugins/jquery-toast/dist/jquery.toast.min.js"></script>
    <script src="/admin_style/assets/plugins/jquery-toast/dist/toast.js"></script>
    <script>

        layui.use(['form', 'layer', 'table', 'laytpl', 'laydate'], function () {
            var form = layui.form,
                layer = parent.layer === undefined ? layui.layer : top.layer,
                $ = layui.jquery,
                laytpl = layui.laytpl,
                table = layui.table;
            laydate = layui.laydate;
            //验证数据
            form.verify({
                phone: function (value, item) { //value：表单的值、item：表单的DOM对象
                    if (!/^1[3456789]\d{9}$/.test(value)) {
                        return '手机号码有误，请重填';
                    }
                }
                , qq: function (value, item) {
                    if (value.length > 100) {
                        return 'QQ有误，请重填';
                    }
                }
                //我们既支持上述函数式的方式，也支持下述数组的形式
                //数组的两个值分别代表：[正则匹配、匹配不符时的提示文字]
                , pass: [
                    /^[\S]{6,12}$/
                    , '密码必须6到12位，且不能出现空格'
                ]
            });
            //申请时间
            var date2 = laydate.render({
                elem: '#application-Time'
                , type: 'datetime'
                , format: 'yyyyMMdd'
            })
            //表单提交
            form.on("submit(reload)", function (data) {
                var field = data.field;
                //弹出loading 加载
                var index = top.layer.msg('数据提交中，请稍候', { icon: 16, time: false, shade: 0.8 });
                var name = field.name;  //姓名
                var phone = field.phone;  //手机号
                var password = field.password;//账号密码
                var password2 = field.password2;//确认密码
                var principal = field.principal;  //本金
                var silverIngot = field.silverIngot;  //银锭
                var qq = field.qq;  //qq
                var recommender = field.recommender;  //推荐人
                var vip = field.vip;  //VIP
                var time = field.time;  //到期时间
                var remarks = field.remarks;  //备注
                console.log(field);
                $.ajax({
                    type : 'POST',
                    url : "/index.php/admin/buyer/addbuyer",
                    async : true,
                    data : {
                        'name':name,
                        'login_pwd':password,
                        'login_pwd2':password2,
                        'balance':principal,
                        'reward':silverIngot,
                        'qq':qq,
                        'vip':vip,
                        'vip_time':time,
                        "mobile":phone,
                        'note':remarks
                    },
                    success : function(data){
                        if(data.code == 1){
                            layer.msg(data.msg, {icon: 1},function () {
                                layer.closeAll();
                                parent.window.location.reload();
                            });
                        }else{
                            layer.msg(data.msg, {icon: 2});
                            //layer.msg('删除失败', {icon: 2});
                        }
                    },
                    error : function(XMLHttpRequest, textStatus, errorThrown) {
                        alert(XMLHttpRequest.status + "," + textStatus);
                    }
                });
                // setTimeout(function () {
                //     //这里实在是关不掉模态 只能刷新父页面来关闭了
                //     top.layer.close(index);
                //     top.layer.msg("搜索成功！");
                //     layer.closeAll();
                //     //刷新父页面
                //     parent.location.reload();
                // }, 500);
                // return false;
            });

        })

    </script>
</body>

</html>
