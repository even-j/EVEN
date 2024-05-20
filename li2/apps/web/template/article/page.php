
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <!--include file "common.php"-->
    </head>

    <body class="index">
        <!-- Header Start -->
        <div id="top">
            <!--include file "header.php"-->
            <!--include file "nav.php"-->
        </div>
        <link href="/public/web/css/article.css" rel="stylesheet" type="text/css" media="screen,projection" />
        <!-- Content Start -->
        <div class="bar">
            <div class="aboutNav">
                <!--include file "about_left_menu.php"-->
            </div>

            <div class="aboutMain">
                <p class="title1"><b>最新公告</b></p>
                <?php if($data['is_page']){?>
                <script>
                $(function(){
                    $('.about_content_bt .tab a').click(function(){
                                $('.about_content_bt .tab a').removeClass('cur');
                                $(this).addClass('cur');
                                $('.about_content_bt').nextAll().hide();
                                $('.'+$(this).attr('id')).show();
                    });

                });
                </script> 
                <div class="about_content">
                  <!--内容开始-->
                    <?php echo html_entity_decode(htmlspecialchars_decode($data['contents']));?>
                  <!--内容结束-->
                </div>
                <?php }else{?>
                    <div class="right-cont achieve about_content">
                      <div class="report-list clearfix">
                        <?php if($dataList){?>
                        <ul>
                            <?php foreach ($dataList as $item){?>
                          <li> <a title="<?php echo $item['title'];?>" href="<?php echo \App::URL('web/article/show',array('id'=>$item['id']));?>" target="_blank"><?php echo $item['title'];?></a> <span><?php echo date('Y-m-d',$item['addtime']);?></span> </li>
                          <?php }?>
                        </ul>
                        <?php }else{?>
                            <div class="doNotDoThat" style="text-align: center">
                                <p style="padding: 15px;color:#999">暂无记录</p>
                            </div>
                        <?php }?>
                      </div>
                        <div class="ui-page clearfix">
                        <div class="list-page clearfix"><?php echo $pager;?></div>
                        </div>
                    </div>


                <?php }?>
            </div>
            <div style="clear: both"></div>
        </div>
        <!-- Content End -->

        <!--include file "footer.php"-->
    </body>
</html>