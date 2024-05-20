<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:80:"D:\phpstudy\WWW\zhan\shua_li\pubic/../application/admin\view\system\backups.html";i:1570613568;}*/ ?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" />
    <title>平台返款管理</title>
    <meta name="renderer" content="webkit" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
    <meta name="apple-mobile-web-app-status-bar-style" content="black" />
    <meta name="apple-mobile-web-app-capable" content="yes" />
    <meta name="format-detection" content="telephone=no" />
    <link rel="stylesheet" href="/admin_style/layui/css/layui.css" media="all" />
    <link rel="stylesheet" href="/admin_style/css/public.css" media="all" />
    <link rel="stylesheet" href="//at.alicdn.com/t/font_1308190_7kttvg3l5i.css" media="all" />
    <script src="/static/seller/js/jquery.min.js"></script>
</head>

<body class="childrenBody">

    <div class="layui-inline">
        <div id="test12" class="demo-tree-more"></div>
    </div>
    <fieldset class="layui-elem-field layui-field-title" style="margin-top: 20px;">
        <legend>
            <button type="button" class="layui-btn layui-btn-lg layui-btn-normal beifen">点击备份</button>
        </legend>
    </fieldset>

    <div class="layui-form">
        <table class="layui-table">
            <colgroup>
                <col width="150">
                <col width="250">
                <col width="150">
                <col width="200">
                <col width="300">
                <col>
            </colgroup>
            <thead>
            <tr>
                <th>序号</th>
                <th>名字</th>
                <th>大小</th>
                <th>时间</th>
                <th>路径</th>
                <th>操作</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach($list as $key=>$item): ?>
            <tr>
                <td><?php echo $key+1; ?></td>
                <td><?php echo $item['name']; ?></td>
                <td><?php echo $item['size']; ?>(k)</td>
                <td><?php echo $item['time']; ?></td>
                <td><?php echo $item['path']; ?></td>
                <td>
                    <div class="layui-btn-group">
                        <button type="button" class="layui-btn"><a href="<?php echo $item['path']; ?>" style="color:#fff;">下载</a></button>
                        <button type="button" class="layui-btn" onclick="del('<?php echo $item['path']; ?>')">删除</button>
                    </div>
                </td>
            </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <script type="text/javascript" src="/admin_style/layui/layui.js"></script>
    <script charset="utf-8" src="/static/seller/layer/layer.js" type="text/javascript"></script>
    <script>
        function del(puth){
            $.post("<?php echo url('system/dbDel'); ?>",{file:puth},function (res) {
                if(res.code==1){
                    return layer.msg(res.msg,{icon:1},function(){
                        location.reload();
                    });
                }else{
                    layer.msg(res.msg,{icon:2});
                }
            })
        }
       $(function(){
           $('.beifen').click(function(){
               $.post("<?php echo url('system/backupAll'); ?>",{},function (res) {
                   if(res.code==1){
                       return layer.msg(res.msg,{icon:1},function(){
                           location.reload();
                       });
                   }else{
                       layer.msg(res.msg,{icon:2});
                   }
               })
           })
       })
    </script>
</body>

</html>
