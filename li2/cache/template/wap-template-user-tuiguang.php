<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0"/>
<meta name="format-detection" content="telephone=no" />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta charset="utf-8">
<title><?php if (isset($title)) echo $title ?></title>
<meta name="keywords" content="<?php if (isset($keywords)) echo $keywords ?>">
<meta name="description" content="<?php if (isset($description)) echo $description ?>">
<link rel="stylesheet" href="/public/wap/css/wap_style.css">
<link rel="stylesheet" href="/public/wap/css/wap_new.css">
<script src="/public/wap/js/jquery.js" type="text/javascript"></script>
<script src="/public/wap/js/layer_mobile/layer.js" type="text/javascript"></script>
<script src="/public/wap/js/common.js" type="text/javascript"></script>

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
                    <style>
            .ms-c6-t { height: 35px; background: #f4f4f4; }
            .ms-c6-t ul li { float: left; line-height: 36px;text-align: center; width: 20%; border-right: 1px solid #eceaea; font-size: 12px;box-sizing:border-box;-moz-box-sizing:border-box; /* Firefox */-webkit-box-sizing:border-box; /* Safari */}
            .ms-c6-t ul li.current { background: #fff; border-top: 3px solid #FFF; border-right: 1px solid #eee; border-left: 1px solid #eee; line-height: 30px; border-bottom: 3px solid #F30; }
            .ms-c6-t ul li a { color: #333 }
            .ms-c6-t ul li a:hover { color: #F30; }
        </style> 

                                <ul>
                                    <li <?php if($_GET['ac'] == 'tuiguang'){echo ' class="current"';}?>>
                                        <a href="<?php echo \App::URL('wap/user/tuiguang'); ?>">推广链接</a>
                                    </li>
                                    <li <?php if($_GET['ac'] == 'tuiguang_user'){echo ' class="current"';}?>>
                                        <a href="<?php echo \App::URL('wap/user/tuiguang_user'); ?>">注册用户</a>
                                    </li>
                                    <li <?php if($_GET['ac'] == 'tuiguang_recharge'){echo ' class="current"';}?>>
                                        <a href="<?php echo \App::URL('wap/user/tuiguang_recharge'); ?>">充值记录</a>
                                    </li>
                                    <?php 
                                        if(isset($user['introducer_type']) && $user['introducer_type']==1){
                                            if($_GET['ac'] == 'tuiguang_withdraw')
                                            {
                                                echo '<li class="current"><a href="'.\App::URL('wap/user/tuiguang_withdraw').'">提现记录</a></li>';
                                            }
                                            else
                                            {
                                                echo '<li ><a href="'.\App::URL('wap/user/tuiguang_withdraw').'">提现记录</a></li>';
                                            }
                                        }
                                    ?>
                                    <li <?php if($_GET['ac'] == 'tuiguang_peizi'){echo ' class="current"';}?>>
                                        <a href="<?php echo \App::URL('wap/user/tuiguang_peizi'); ?>">策略记录</a>
                                    </li>
                                    <?php if(!isset($user['introducer_type']) || $user['introducer_type']==0){?>
                                        <li <?php if($_GET['ac'] == 'tuiguang_fund'){echo ' class="current"';}?>>
                                            <a href="<?php echo \App::URL('wap/user/tuiguang_fund'); ?>">推广收入</a>
                                        </li>
                                    <?php }?>
                                </ul>
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