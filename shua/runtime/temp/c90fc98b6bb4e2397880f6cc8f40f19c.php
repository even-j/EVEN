<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:80:"D:\phpstudy\WWW\zhan\shua_li\pubic/../application/admin\view\system\settips.html";i:1571818790;}*/ ?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <title>系统配置</title>
    <meta name="renderer" content="webkit" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
    <meta name="apple-mobile-web-app-status-bar-style" content="black" />
    <meta name="apple-mobile-web-app-capable" content="yes" />
    <meta name="format-detection" content="telephone=no" />
    <link rel="stylesheet" href="/admin_style/layui/css/layui.css" media="all" />
    <link rel="stylesheet" href="/admin_style/css/public.css" media="all" />
    <link rel="stylesheet" href="//at.alicdn.com/t/font_1308190_7kttvg3l5i.css" media="all" />
    <!-- icons -->
    <link href="/admin_style/assets/plugins/simple-line-icons/simple-line-icons.min.css" rel="stylesheet" type="text/css" />
    <link href="/admin_style/assets/plugins/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
    <!--bootstrap -->
    <link href="/admin_style/assets/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <!-- Material Design Lite CSS -->
    <link rel="stylesheet" href="/admin_style/assets/plugins/material/material.min.css">
    <link rel="stylesheet" href="/admin_style/assets/css/material_style.css">
    <!-- animation -->
    <link href="/admin_style/assets/css/pages/animate_page.css" rel="stylesheet">
    <!-- Template Styles -->
    <link href="/admin_style/assets/css/style.css" rel="stylesheet" type="text/css" />
    <link href="/admin_style/assets/css/plugins.min.css" rel="stylesheet" type="text/css" />
    <link href="/admin_style/assets/css/pages/formlayout.css" rel="stylesheet" type="text/css" />
    <link href="/admin_style/assets/css/responsive.css" rel="stylesheet" type="text/css" />
    <link href="/admin_style/assets/css/theme-color.css" rel="stylesheet" type="text/css" />
    <!-- favicon -->
    <link rel="shortcut icon" href="/admin_style/assets/img/favicon.ico" />
    <style>
        .wgbz {
            color: red;
        }
    </style>
</head>

<body class="childrenBody">

    <form class="layui-form form-horizontal">
        <br>

        <div class="container">
            <table class="layui-table">
                <colgroup>
                    <col width="100">
                    <col width="150">
                    <col>
                </colgroup>
                <?php foreach($sellerList as $key=>$item): ?>
                <tr>
                    <?php if($key == 0): ?>
                    <td rowspan="<?php echo count($sellerList); ?>">商家：</td>
                    <?php endif; ?>
                    <td><?php echo $item['name']; ?></td>
                    <td>图片：<img onerror='imgError(this)' class="img-rounded" src="<?php echo $item['img']; ?>" alt="" style="width: 500px"></td>
                    <td>
                        <input type="text" class="name form-control change" name="name" value="<?php echo $item['content']; ?>" placeholder="请填写内容">
                        <input type="hidden" name="id" value="<?php echo $item['id']; ?>">
                    </td>
                </tr>
                <?php endforeach; foreach($userList as $key=>$item): ?>
                <tr>
                    <?php if($key == 0): ?>
                    <td rowspan="<?php echo count($userList); ?>">买手：</td>
                    <?php endif; ?>
                    <td><?php echo $item['name']; ?></td>
                    <td>图片：<img src="<?php echo $item['img']; ?>" class="img-rounded" alt="" style="height: 50px"></td>
                    <td>
                        <input type="text" class="name form-control change" name="name" value="<?php echo $item['content']; ?>" placeholder="请填写内容">
                        <input type="hidden" name="id" value="<?php echo $item['id']; ?>">
                    </td>
                </tr>
                <?php endforeach; ?>
            </table>
        </div>
        <div class="container layui-left">
            <div class="layui-inline">
                <p style="color: red"> * 修改时直接在后面文本里面修改，移开鼠标即提交修改！</p>
            </div>
        </div>

    </form>
    <div class="layui-inline">
        <div id="test12" class="demo-tree-more"></div>
    </div>
    <script type="text/javascript" src="/admin_style/layui/layui.js"></script>
    <script type="text/javascript" src="/admin_style/basicParameter.js"></script>
    <!-- start js include path -->
    <script src="/admin_style/assets/plugins/jquery/jquery.min.js"></script>
    <script src="/admin_style/assets/plugins/popper/popper.min.js"></script>
    <script src="/admin_style/assets/plugins/jquery-blockui/jquery.blockui.min.js"></script>
    <script src="/admin_style/assets/plugins/jquery-slimscroll/jquery.slimscroll.min.js"></script>
    <!-- bootstrap -->
    <script src="/admin_style/assets/plugins/bootstrap/js/bootstrap.min.js"></script>
    <script src="/admin_style/assets/plugins/bootstrap-inputmask/bootstrap-inputmask.min.js"></script>
    <script src="/admin_style/assets/plugins/bootstrap-colorpicker/js/bootstrap-colorpicker.js"></script>
    <script src="/admin_style/assets/plugins/bootstrap-colorpicker/js/bootstrap-colorpicker-init.js"></script>
    <script src="/admin_style/assets/plugins/bootstrap-datetimepicker/js/bootstrap-datetimepicker.js"></script>
    <script src="/admin_style/assets/plugins/bootstrap-datetimepicker/js/bootstrap-datetimepicker-init.js"></script>
    <!-- Common js-->
    <script src="/admin_style/assets/js/app.js"></script>
    <script src="/admin_style/assets/js/layout.js"></script>
    <script src="/admin_style/assets/js/theme-color.js"></script>
    <!-- Material -->
    <script src="/admin_style/assets/plugins/material/material.min.js"></script>
    <!-- animation -->
    <script src="/admin_style/assets/js/pages/ui/animations.js"></script>
    <!-- dropzone -->
    <script src="/admin_style/assets/plugins/dropzone/dropzone.js"></script>
    <!--tags input-->
    <script src="/admin_style/assets/plugins/jquery-tags-input/jquery-tags-input.js"></script>
    <script src="/admin_style/assets/plugins/jquery-tags-input/jquery-tags-input-init.js"></script>
    <!--select2-->
    <script src="/admin_style/assets/plugins/select2/js/select2.js"></script>
    <script src="/admin_style/assets/js/pages/select2/select2-init.js"></script>
    <script>
        $('.img-rounded').click(function(){
            var img = $(this).attr('src');
            layer.open({
                type: 1,
                skin: 'layui-layer-rim', //加上边框
                area: ['80%', '80%'], //宽高
                shadeClose: true, //开启遮罩关闭
                end: function (index, layero) {
                    return false;
                },
                content: '<div style="text-align:center"><img src='+img+' style="width:90%"/></div>'
            });
        })

        function imgError(e){
            e.src='/uploads/task/2019/09/05/1567649022364229.png';
        };
        $(function(){
            $('.change').change(function(){
                var id = $(this).next('input[name=id]').val();
                var content = $(this).val();
                $.post("<?php echo url('system/editTips'); ?>",{id:id,content:content},function(res){
                    if(res.code==1){
                        layer.msg(res.msg,{icon:1,time:1000});
                    }else{
                        layer.msg(res.msg,{icon:2},function(){
                            location.reload();
                        });
                    }
                })
            })
        })
    </script>
</body>

</html>
