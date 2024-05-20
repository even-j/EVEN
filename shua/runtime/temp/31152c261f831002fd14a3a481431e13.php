<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:78:"/www/wwwroot/xbt.com/pubic/../application/admin/view/notice/buyer_problem.html";i:1569048390;}*/ ?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>增加买家常见问题</title>
    <link rel="stylesheet" href="/admin_style/layui/css/layui.css" media="all" />
	<link rel="stylesheet" href="/admin_style/css/public.css" media="all" />
</head>

<body style="margin: 10px;">
    <!-- 表格 -->
    <div class="layui-inline">
        <table class="layui-hide" id="test" lay-filter="test"></table>
    </div>
    <script type="text/html" id="toolbarDemoo">
        <div class="layui-btn-container">
            <button class="layui-btn layui-btn addNews_btn" lay-event="getCheckData">
                <i class="layui-icon">&#xe608;</i>增加买家常见问题
            </button>
        </div>
    </script>
    <script type="text/html" id="barDemo">
        <a class="layui-btn layui-btn-sm" lay-event="edit">编辑</a>
        <a class="layui-btn layui-btn-danger layui-btn-sm" lay-event="del">删除</a>
    </script>

    <script src="https://cdn.bootcss.com/jquery/3.4.1/jquery.js"></script>
    <script type="text/javascript" src="/admin_style/layui/layui.js"></script>
    <script>
        layui.use(['form','table'], function () {
            var form = layui.form,
                table = layui.table;
            //数据表
            var tableIns = table.render({
                elem: '#test'
                , url: "<?php echo url('notice/BuyerProblem'); ?>"
                , method:'post'  //默认是get
                , toolbar: '#toolbarDemoo'
                , title: '增加买家常见问题'
                , cols: [[
                { field: 'id', title: 'ID', width: 440, align:"center" }
                    , { field: 'title', title: '标题', width: 420, align:"center" }
                    , { field: 'create_time', title: '加入时间', width: 420, align:"center" }
                    , {
                        field: 'newsTop',
                        title: '是否置顶',
                        align: 'center',
                        width: 100,
                        templet: function (d) {
                            var newstop = "";
                            if (d.newstop == "true") {
                                state = "<span>是</span>";
                                //state = "<input type='checkbox' value='" + d.id + "' id='status' lay-filter='switchTest' checked='checked' name='newsTop'  lay-skin='switch' lay-text='开启|关闭' >";
                            }
                            else {
                                state = "<span>否</span>";
                                //state = "<input type='checkbox' value='" + d.id + "' id='status' lay-filter='switchTest'  name='newsTop'  lay-skin='switch' lay-text='开启|关闭' >";
                            }
                            return state;
                        }

                    }
                    , { fixed: 'right', title: '操作', toolbar: '#barDemo', width: 350, align:"center" }
                ]]
                ,page: {    //支持传入 laypage 组件的所有参数（某些参数除外，如：jump/elem） - 详见文档
                    layout: ['limit', 'count', 'prev', 'page', 'next', 'skip'] //自定义分页布局
                    ,groups: 5    //只显示 1 个连续页码
                    ,count: 500     //总页数(设置没用 这个是从后台获取到的在json中)
                    ,first: false    //不显示首页
                    ,last: false    //不显示尾页
                    ,limits: [10, 15, 30, 60, 100]   //每页条数
                    ,jump: function(obj, first){   //当分页被切换时触发，函数返回两个参数：obj（当前分页的所有选项值）、first（是否首次，一般用于初始加载的判断）
                        //obj包含了当前分页的所有参数，比如：
                        console.log(obj.curr);  //得到当前页，以便向服务端请求对应页的数据。
                        console.log(obj.limit);  //得到每页显示的条数
                        //首次不执行
                        if(!first){
                        //do something
                        }
                    }
                }
            });

            $(".addNews_btn").click(function(){
                addNews();
            })
            //添加文章
            function addNews(edit){
                var index = layui.layer.open({
                    title : "增加买家常见问题",
                    type : 2,
                    area: ['700px', '950px'],
                    content : "<?php echo url('notice/newsAdd',['type'=>2]); ?>",
                    success : function(layero, index){  // 当前层DOM当前层 索引
                        //console.log(layero, index)
                        var body = layui.layer.getChildFrame('body', index);
                        console.log(body)
                        console.log(edit)
                        if(edit){
                            body.find(".newsName").val(edit.title);
                            body.find("#news_content").val(edit.content);
                            body.find(".id").val(edit.id);
                            if(edit.newstop == "true"){
                                edit.newstop = true;
                            } else if (edit.newstop == "false"){
                                edit.newstop = false;
                            }
                            body.find(".newsTop").prop("checked",edit.newstop);
                            form.render();
                        }
                        setTimeout(function(){
                            layui.layer.tips('点击此处返回', '.layui-layer-setwin .layui-layer-close', {
                                tips: 3
                            });
                        },500)
                    },
                    yes: function(index, layero){
                        //do something
                        layer.close(index);  //如果设定了yes回调，需进行手工关闭
                    }
                })
                layui.layer.full(index);
                //改变窗口大小时，重置弹窗的宽高，防止超出可视区域（如F12调出debug的操作）
                $(window).on("resize",function(){
                    layui.layer.full(index);
                })
            }
            //监听行工具事件
            table.on('tool(test)', function (obj) {

                var layEvent = obj.event,
                data = obj.data;
                if (obj.event === 'del') {  //删除
                    layer.confirm('真的删除行么', function (index) {
                        obj.del();
                        layer.close(index);
                        $.post("<?php echo url('notice/delete_notice'); ?>",{id:obj.data.id},function (res) {
                            return  layer.msg(res.msg);
                        })
                    });
                } else if (obj.event === 'edit') {  //编辑
                    console.log(data);
                    addNews(data);
                    // layer.prompt({
                    //     formType: 2
                    //     , value: data.email
                    // }, function (value, index) {
                    //     obj.update({
                    //         email: value
                    //     });
                    //     layer.close(index);
                    // });
                }
            });
        });
    </script>
</body>

</html>
