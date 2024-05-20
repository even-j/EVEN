<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:82:"D:\phpstudy\WWW\zhan\shua_li\pubic/../application/admin\view\task\review_task.html";i:1579275368;}*/ ?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>平台返款管理</title>
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
        .layui-layer {
            top: 50px!important;
        }
        .wgbz{
            color: red;
        }
        .layui-table-cell {
            font-size:16px;
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
<form class="layui-form">
    <blockquote class="layui-elem-quote quoteBox">
        <form class="layui-form">
            <div class="layui-inline">
                <label class="layui-form-label">追评编号：</label>
                <div class="layui-input-inline">
                    <input type="tel" name="task_number" lay-verify="task_number" autocomplete="off" class="layui-input id"
                           placeholder="追评编号">
                </div>
            </div>
            <div class="layui-inline">
                <label class="layui-form-label">买家旺旺ID:</label>
                <div class="layui-input-inline">
                    <input type="tel" name="wangwang" lay-verify="wangwang" autocomplete="off" class="layui-input wwid"
                           placeholder="买家旺旺ID">
                </div>
            </div>
            <div class="layui-inline">
                <label class="layui-form-label">卖家店铺名:</label>
                <div class="layui-input-inline">
                    <input type="tel" name="shopname" lay-verify="shopname" autocomplete="off" class="layui-input wwid"
                           placeholder="卖家店铺名">
                </div>
            </div>
            <div class="layui-inline">
                <label class="layui-form-label">添加时间：</label>
                <div class="layui-input-inline">
                    <input type="text" name="time" lay-verify="time" class="layui-input time" id="application-Time"
                           placeholder="添加时间">
                </div>
            </div>
            <div class="layui-inline">
                <label class="layui-form-label">状态：</label>
                <div class="layui-input-inline" style="width: 150px;">
                    <select name="state" id="state1" lay-verify="" >
                        <option value="" selected>全部</option><!-- 默认选中 -->
<!--                        <option value="0">未支付</option>&lt;!&ndash; 默认选中 &ndash;&gt;-->
                        <option value="1">已支付</option><!-- 禁用 -->
                        <option value="2">已审核</option>
                        <option value="3">已上传</option>
                        <option value="4">已完成</option>
                        <option value="5">已取消</option>
                        <option value="6">买手拒接</option>
                        <option value="7">已拒绝</option>
                    </select>
                </div>
            </div>
            <div class="layui-inline">
                <div class="layui-input-inline">
                    <a class="layui-btn search_btn" data-type="reload" lay-filter="reload" lay-submit><i class="layui-icon">&#xe615;</i>搜 索</a>
                </div>
            </div>
        </form>
    </blockquote>
    <table id="userList" lay-filter="userList"></table>
    <!--头部-->
    <script type="text/html" id="toolbarDemo">
<!--        <div class="layui-btn-container table-tool">-->
<!--            <button class="layui-btn layui-btn-normal delAll_btn" >确认批量发货 <i class="layui-icon">&#xe605;</i></button>-->
<!--            <button class="layui-btn layui-btn-normal refundsAll_btn" >确认批量返款 <i class="layui-icon">&#xe605;</i></button>-->
<!--        </div>-->
<button class="layui-btn layui-btn-normal delAll_btn">批量审核通过 <i class="layui-icon">&#xe605;</i></button>
<button class="layui-btn layui-btn-normal refundsAll_btn">批量返款 <i class="layui-icon">&#xe605;</i></button>
    </script>
    <!--审核状态-->
    <script type="text/html" id="state">
        {{#  if(d.newsStatus == "2"){ }}
        <span class="layui-red">不通过</span>
        {{#  } else if(d.newsStatus == "1"){ }}
        <span class="layui-blue">等待审核</span>
        {{#  } else if(d.newsStatus == "0"){ }}
        审核通过
        {{#  } else { }}
        无法识别
        {{#  }}}
    </script>
    <!--操作-->
    <script type="text/html" id="userListBar">
        <a class="layui-btn layui-btn-normal layui-btn-xs" lay-event="setTop">返 款</a>
        <a class="layui-btn layui-btn-xs" lay-event="see">查 看</a>
    </script>
</form>
<script type="text/javascript" src="/admin_style/layui/layui.js"></script>
<script type="text/javascript" src="/admin_style/review_task.js"></script>
<script src="/admin_style/assets/plugins/jquery/jquery.min.js"></script>

</body>
<script>
    layui.use(['form', 'layer', 'table', 'laytpl', 'laydate'], function () {
        var form = layui.form,
            layer = parent.layer === undefined ? layui.layer : top.layer,
            $ = layui.jquery,
            laytpl = layui.laytpl,
            table = layui.table;
        laydate = layui.laydate;
        /*点击回车登录*/
        $(document).on('keydown', function(e){
            if(event.keyCode == 13){
                e.preventDefault();//防止两次询问
                if($(".layui-layer-btn0").length<1){
                    // 搜索条件
                    var task_number = $("input[name=task_number]").val(); //任务编号
                    var wangwang = $("input[name=wangwang]").val(); //买家旺旺ID
                    var shopname = $("input[name=shopname]").val(); //卖家店铺名
                    var state = $('#state1 option:selected').val(); //状态
                    var time = $("input[name=time]").val(); //接单时间
                    var delivery_state = $("input[name=delivery_state]").val(); //发货状态
                    table.reload('userListTable', {
                        method: 'post'
                        , where: {
                            'task_number': task_number, //任务编号
                            'wangwang': wangwang,    //买家旺旺ID
                            'state': state, //状态
                            'shopname': shopname, //卖家店铺名
                            'time': time, //接单时间
                            'delivery_state': delivery_state, //发货状态
                        }
                        , page: {
                            curr: 1
                        }
                    });
                    setTimeout(function () {
                        //top.layer.close(index);
                        top.layer.msg("操作成功！");
                    }, 500);
                    return false;
                }
            }

        })
    })
</script>
</html>
