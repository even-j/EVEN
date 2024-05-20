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
        <!--include file "user_header.php"-->
        <div class="bar">
            <div class="my-space">
                <div class="space-main clearfix">
                    <div class="space-left">
                        <!--include file "user_left_menu.php"-->
                    </div>
                    <div class="space-right">
                        <h2><strong>推广赚钱</strong></h2>
                        <div class="ms-c6">
                            <div class="ms-c6-t">
                                <!--include file "tuiguang_header.php"-->
                            </div>
                            <div class="ms-c6-m">
                                <div class="ms-c6-ts">
                                    <div class="formbox">
                                        <div class="ms-c6-b">
                                            <dl>
                                                <dt>推广链接</dt>
                                                <dd>以下链接是您对外界进行推广的地址，您可以通过朋友、QQ、微信、博客、论坛或自己的网站进行推广，所有通过该链接访问注册的用户， 都属于您的推广用户。您可以获得推广用户在<?php echo SITE_NAME;?>操盘所产生利息 * <?php echo $site_base['jsryj_per'];?>% 的现金奖励。</dd>
                                            </dl>
                                            <table>
                                                <tbody>
                                                    <tr>
                                                        <td> 您的推广二维码：<img width="180" style="border:2px solid #eee;    margin-left: 20px;"  src="<?php echo App::URL("pay/pub/qrcode",array('text'=> urlencode($site_base['site_url'].'/index.php?intid='.$user['randid'])));?>" />
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td style="valign:bottom;">
                                                            您的推广链接：
                                                            <input id="id_union_url_txt" class="inp" value="<?php echo $site_base['site_url'].'/index.php?intid='.$user['randid'];?>" readonly="" style="width: 500px;" onclick="select()" type="text">
                                                                <button class="btn-b" type="button" id="id_union_rul_btn">复制链接</button>
                                                        </td>
                                                    </tr>
                                                    
                                                    <tr>
                                                        <td>
                                                            您也可以直接点击 <a href="<?php echo $site_base['site_url'].'/index.php?intid='.$user['randid'];?>" target="_blank"><?php echo $site_base['site_url'].'/index.php?intid='.$user['randid'];?></a> 为他们注册。
                                                            <span id="htmlBridge"></span></td>
                                                    </tr>
                                                    
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <script src="/public/wap/js/clipboard.min.js" type="text/javascript"></script>
        <script type="text/javascript">
            $(function(){
                var text = $("#id_union_url_txt").val();
                var clipboard = new Clipboard('#id_union_rul_btn', {
                    text: function() {
                        return text;
                    }
                });

                clipboard.on('success', function(e) {
                    layer.msg('<span style="color:#fff">复制成功</span>');
                });
            })
        </script>
        <!--include file "footer.php"-->
    </body>
</html>