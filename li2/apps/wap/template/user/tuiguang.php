<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <!--include file "common.php"-->
    </head>

    <body class="index">
        <div class="header">
            <h1>推广链接</h1>
            <a class="l-link" href="javascript:history.go(-1)"><span>返回</span></a> 
            <div class="top-menu">
                <!--<button type="button" class="btn"></button>-->
            </div>
        </div>
        <div style="height: 40px"></div>
        <div class="ms-c6-t">
            <!--include file "tuiguang_header.php"-->
        </div>
        
        <div class="formbox">
            <div class="ms-c6-b">
                <dl>
                    <dt>推广链接</dt>
                    <dd>以下链接是您对外界进行推广的地址，您可以通过朋友、QQ、微信、博客、论坛或自己的网站进行推广，所有通过该链接访问注册的用户， 都属于您的推广用户。您可以获得推广用户在<?php echo SITE_NAME;?>操盘所产生利息 * <?php echo $site_base['jsryj_per'];?>% 的现金奖励。</dd>
                </dl>
            </div>
        </div>
        <div style="padding: 15px;color:#F60">您的推广二维码：</div>
        <div style="text-align: center">
            <img width="180" style="border:2px solid #eee;" src="<?php echo App::URL("pay/pub/qrcode",array('text'=> urlencode($site_base['site_url'].'/index.php?intid='.$user['randid'])));?>" />
         </div>
        <div style="padding: 15px;color:#F60">您的推广链接：</div>
        <div style="padding:0 15px 15px 15px; color: #666;word-wrap:break-word; line-height: 22px;" id="div_url"><?php echo $site_base['site_url'].'/index.php?intid='.$user['randid'];?></div>
        <div style="margin: 0 15px 20px">
            <button class="btn-b" type="button" id="id_union_rul_btn">复制链接</button>
        </div>

        <script src="/public/wap/js/clipboard.min.js" type="text/javascript"></script>
        <script type="text/javascript">
            $(function(){
                var text = $("#div_url").html();
                var clipboard = new Clipboard('.btn-b', {
                    text: function() {
                        return text;
                    }
                });

                clipboard.on('success', function(e) {
                    layermsg('复制成功');
                });
            })
        </script>
    </body>
</html>