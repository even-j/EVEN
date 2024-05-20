
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <!--include file "common.php"-->
        <style>
            .article li{line-height: 40px;display: block;margin: 0 15px;border-bottom: 1px dashed #eee;font-size: 14px}
        </style>
        <script>
            var page =1;
            var pagesize = <?php echo $pagesize;?>;
            var rowcount = <?php echo $rowcount;?>;
            $(function(){
                if(pagesize*page >= rowcount){
                    $("#btn_more").hide();
                }
            })
            function get_data(){
                page++;
                var pid = "<?php echo $_GET['pid'];?>"
                $.post("<?php echo \App::URL('wap/article/view_data');?>",{page : page,pid : pid},function(data){
                    $(".article").append(data);
                    if(pagesize*page >= rowcount){
                        $("#btn_more").hide();
                    }
                })
            }
        </script>
    </head>

    <body class="index">
        <!-- Header Start -->
        <div id="top">
            <!--include file "header.php"-->
        </div>
        <div class="header">
            <h1>最新公告</h1>
            <a class="l-link" href="javascript:history.go(-1)"><span>返回</span></a> 
            <div class="top-menu">
                <!--<button type="button" class="btn"></button>-->
            </div>
        </div>
        <div style="height:40px;"></div>
        <link href="/public/web/css/article.css" rel="stylesheet" type="text/css" media="screen,projection" />
        <!-- Content Start -->
        <div class="bar">
            <?php if ($data['is_page']) { ?>
                <div class="about_content">
                    <!--内容开始-->
                    <?php echo html_entity_decode(htmlspecialchars_decode($data['contents'])); ?>
                    <!--内容结束-->
                </div>
            <?php } else { ?>
                <div class="article">
                    <?php if ($dataList) { ?>
                        <ul>
                            <?php foreach ($dataList as $item) { ?>
                                <li> <a title="<?php echo $item['title']; ?>" href="<?php echo \App::URL('wap/article/show', array('id' => $item['id'])); ?>"><?php echo $item['title']; ?></a>  </li>
                            <?php } ?>
                        </ul>
                    <?php } else { ?>
                        <div class="doNotDoThat" style="text-align: center">
                            <p style="padding: 15px;color:#999">暂无记录</p>
                        </div>
                    <?php } ?>
                </div>
                <div id="btn_more" onclick="get_data();" style="width:60px;height:20px;line-height: 20px;background: #ddd;text-align: center;font-size: 12px;margin: 10px auto">更多...</div>
            <?php } ?>
        </div>
        <div style="clear: both"></div>
        </div>
        <!-- Content End -->
    </body>
</html>