<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:69:"/www/wwwroot/xbt.com/pubic/../application/admin/view/seller/shop.html";i:1577856944;}*/ ?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>押金</title>
    <meta name="renderer" content="webkit">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="format-detection" content="telephone=no">
    <link rel="stylesheet" href="/admin_style/layui/css/layui.css" media="all" />
    <link rel="stylesheet" href="/admin_style/css/public.css" media="all" />
    <link rel="stylesheet" href="//at.alicdn.com/t/font_1308190_7kttvg3l5i.css" media="all" />
    <style>
        .green{
            color: green;
        }
        .layui-table-cell {
            font-size:14px;
            padding:0 5px;
            height:auto;
            overflow:visible;
            text-overflow:inherit;
            white-space:normal;
            word-break: break-all;
        }
        .layui-table-fixed {
            display: none!important;
        }
        .layui-table-fixed-r{
            display: none!important;
        }
    </style>
</head>

<body class="childrenBody">
<input  type="hidden" name="dataid" lay-verify="beizhu" autocomplete="off" class="layui-input dataid">
<table id="userList" lay-filter="userList"></table>
<!--操作-->
<script type="text/html" id="userListBar">
    <a class="layui-btn layui-btn-xs layui-btn-normal" lay-event="edit">审核|编辑</a>
    <a class="layui-btn layui-btn-xs layui-btn-danger" lay-event="del">删除</a>
</script>
<script type="text/javascript" src="/admin_style/layui/layui.js"></script>
<script>
    layui.use(['form', 'layer', 'table', 'laytpl', 'laydate'], function () {
        var form = layui.form,
            layer = parent.layer === undefined ? layui.layer : top.layer,
            $ = layui.jquery,
            laytpl = layui.laytpl,
            table = layui.table;
        laydate = layui.laydate;
        //ip所在地截图
        var collectionNumber1 = function (d) {
            return '<img src="'+d.collectionNumber1+'" style="height: 170px; width: 200px;" >';
        };
        //旺旺档案截图
        var collectionNumber2 = function (d) {
            return '<img src="'+d.collectionNumber2+'" style="height: 170px; width: 200px;" >';
        };
        var type = function (d) {
            if(d.type==1){
                return '<span class="green">淘宝</span>';
            }else if(d.type==2){
                return '<span class="green">天猫</span>';
            }else if(d.type==3){
                return '<span class="green">飞猪</span>';
            }
        }
        var logistics = function (d) {
            if(d.logistics==0){
                return '<span style="color:green ">无需物流</span>';
            }else if(d.logistics==1){
                return '<span class="green">需要物流</span>';
            }
        }
        var state = function (d) {
            if(d.state==0){
                return '<span class="green">待审核</span>';
            }else if(d.state==1){
                return '<span class="green">已通过</span>';
            }else if(d.state==2){
                return '<span class="green">已拒绝</span>';
            }
        }
        var address = function (d) {
            return `<span>`+d.province+`-`+d.city+`-`+d.area+`-`+d.address+`</span>`
        };
        //用户列表
        var dataid = $(".dataid").val(); //id
        console.log(dataid);
        var tableIns = table.render({
            elem: '#userList',
            url: '/index.php/admin/seller/shop/id/'+dataid+'',
            method:'POST',
            //cellMinWidth: 95,
            page: true,
            height: "full-125",
            limits: [10, 15, 20, 25],
            limit: 10,
            id: "userListTable",
            cols: [[
                { field: 'id', title: '序号', minWidth: 50, width:60, align: "center" },
                { field: 'shop_name', title: '店铺名称', minWidth: 80, width:120, align: "center" },
                { field: 'wangwang', title: '旺旺号', minWidth: 80, width:115, align: "center" },
                { field: 'link', title: '店铺链接', minWidth: 80, width:350, align: "center" },
                { field: 'type', title: '店铺类型', minWidth: 95,width:80, align: "center", templet: type },
                { field: 'type', title: '状态', minWidth: 95,width:80, align: "center", templet: state },
                { field: 'state', title: '物流状态', minWidth: 50, width: 80, align: "center",templet: logistics },
                { field: 'address', title: '发件信息', minWidth: 95,width:250, align: "center", templet: address },
                { title: '操作', minWidth: 175, templet: '#userListBar',width:150, fixed: "right", align: "center" }
            ]]
        });

        //验证数据
        form.verify({
            phone: function (value, item) {
                //value：表单的值、item：表单的DOM对象
                //   if(!/^1[3456789]\d{9}$/.test(value)){
                //     return '手机号码有误，请重填';
                //   }
            }
            , name: function (value, item) {

            }
            , pass: [
                /^[\S]{6,12}$/
                , '密码必须6到12位，且不能出现空格'
            ]
        });
        //表单提交
        form.on("submit(reload)", function (data) {
            var field = data.field;
            //弹出loading 加载
            var index = top.layer.msg('数据提交中，请稍候', { icon: 16, time: false, shade: 0.8 });
            //第一种获取方法
            var name = $(".name").val(); //名字
            var beizhu = field.beizhu;  //qq号

            table.reload("userListTable", {
                page: {
                    curr: 1 //重新从第 1 页开始
                },
                where: {
                    name: name,    //姓名
                    beizhu: beizhu //备注
                }
            })
            setTimeout(function () {
                top.layer.close(index);
                top.layer.msg("搜索成功！");
            }, 500);
            return false;
        });
        //监听行工具事件
        table.on('tool(userList)', function (obj) {
            var layEvent = obj.event,
                data = obj.data;
            console.log(data);

            if (obj.event === 'del'){
                // layer.confirm('是否删除？', function (index) {
                //     layer.close(index);
                // });
                layer.confirm('您确定要删除该用户吗?',{btn: ['确定', '取消'],title:"提示"}, function(){
                    $.ajax({
                        type: "post",
                        url: '/index.php/admin/seller/del_shop',
                        data: {
                            'id':data.id
                        },
                        dataType: "json",
                        async:false,
                        success:function(data) {
                            if(data.code == 0){
                                uid = data.uid,
                                    console.log(uid);
                                layer.msg('删除成功', {icon: 1});
                                window.setTimeout("javascript:location.href='/index.php/admin/seller/shop/'", 2000);
                            }else{
                                layer.msg('删除失败', {icon: 2});
                            }
                        }
                    });
                });
            }else if (obj.event === 'edit'){
                maihaobianji(data);
            }
        });
    })
    function maihaobianji(edit) {
        layui.layer.open({
            type: 2,
            content: "maihaobianji.html",
            area: ['800px', '550px'],
            title: '编辑店铺信息',
            shadeClose: true,
            success : function(layero, index){
                var body = layui.layer.getChildFrame('body', index);
                //审核模态框中需要数据
                //因为名字我不知道 就简单写了两个 模仿即可
                if(edit){
                    //console.log(edit,1111111111111);
                    body.find(".dataid").val(edit.id);
                }
                setTimeout(function(){
                    layui.layer.tips('点击此处返回', '.layui-layer-setwin .layui-layer-close', {
                        tips: 3
                    });
                },500)
            }
        })
    }
</script>
</body>

</html>
