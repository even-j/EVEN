
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <!--include file "common.php"-->
        <style>
            .contain{background: url('/public/web/images/task/bg.png') repeat}
            .banner{height: 409px;background: url('/public/web/images/task/banner.png') no-repeat center}
            .task{width:1080px;margin: 0 auto;border: 8px solid #ee878f;border-radius: 10px;background: #ffffff80;padding:60px 60px}
            .task ul{}
            .task li{display: block;width:28%;float: left;text-align: center}
            .task li .title{color:#ff8b19;font-size:24px}
            .task li .desc{color:#bcbcbc;font-size:14px;margin: 10px 0px}
            .task li .money{color:#ff8b19;font-size:18px;margin-bottom: 20px}
            .task li .button a{display: block;background: #ff5064;border-radius: 4px;color:#fff;font-size:18px;text-align: center;line-height: 40px;width: 70%;margin: 0px auto}
            .task li.done .button a{display: block;background: #ccc;border-radius: 4px;color:#fff;font-size:18px;text-align: center;line-height: 40px;width: 70%;margin: 0px auto}
            .task .item{background: #fff;border-radius: 5px;padding: 40px 0;position: relative}
            .task .item .wc{position: absolute;right:0;top:0;width:141px;height:111px;background: url('/public/web/images/task/over.png') no-repeat;background-size: contain}
            .task .right{width:60px;height: 60px;background: url('/public/web/images/task/jt_right.png') no-repeat center;background-size: contain;margin: 86px auto}
            .task .left{width:60px;height: 60px;background: url('/public/web/images/task/jt_left.png') no-repeat center;background-size: contain;margin: 86px auto}
            .task .down{width:60px;height: 60px;background: url('/public/web/images/task/jt_down.png') no-repeat center;background-size: contain;margin: 10px 0px 10px 920px}
            .task .down2{width:60px;height: 60px;background: url('/public/web/images/task/jt_down.png') no-repeat center;background-size: contain;margin: 10px 0px 10px 118px}
            .guize{width:1200px;margin:0 auto;height:250px;background: url('/public/web/images/task/guize.png') no-repeat center 40px;padding-top: 120px }
            .guize li{line-height: 40px;color:#fff;font-size: 16px}
            .guize li i{display: inline-block;width: 26px;height:26px;line-height: 26px;text-align: center;border-radius: 26px;background: #ff5f4b;color: #fff}
        </style>
    </head>

    <body>
        <!-- Header Start -->
        <div id="top">
            <!--include file "header.php"-->
            <!--include file "nav.php"-->
        </div>
        <div class="contain">
            <div class="banner"></div>
            <div class="task">
                <ul class="clearfix">
                    <li class="item" style="background:url('/public/web/images/task/caishen.png') no-repeat center;background-size: contain;height: 152px">
                        
                    </li>
                    <li style="width:8%;">
                        <div class="right"></div>
                    </li>
                    <li class="item <?php if(isset($fund_rows['103'])){echo 'done';}?>">
                        <?php if(isset($fund_rows['103'])){?>
                        <div class="wc"></div>
                        <?php }?>
                        <div class="title">完成注册</div>
                        <div class="desc">打开策略新体验</div>
                        <div class="money">+<?php echo $params_send['regist'];?>元管理费</div>
                        <div class="button"><a href="<?php echo \App::URL('web/member/register');?>">前往注册</a></div>
                    </li>
                    <li style="width:8%">
                        <div class="right"></div>
                    </li>
                    <li class="item <?php if(isset($fund_rows['105'])){echo 'done';}?>">
                        <?php if(isset($fund_rows['105'])){?>
                        <div class="wc"></div>
                        <?php }?>
                        <div class="title">实名认证</div>
                        <div class="desc">真实身份信息认证</div>
                        <div class="money">+<?php echo $params_send['sfz'];?>元管理费</div>
                        <div class="button"><a href="<?php echo \App::URL('web/user/sfz');?>">前往实名</a></div>
                    </li>
                </ul>
                <div class="down"></div>
                <ul class="clearfix">
                    <li class="item <?php if(isset($fund_rows['107'])){echo 'done';}?>">
                        <?php if(isset($fund_rows['107'])){?>
                        <div class="wc"></div>
                        <?php }?>
                        <div class="title">首次策略</div>
                        <div class="desc">免费体验合约除外</div>
                        <div class="money">+<?php echo $params_send['peizi'];?>元管理费</div>
                        <div class="button"><a href="<?php echo \App::URL("web/peizi/month");?>">申请合约</a></div>
                    </li>
                    <li style="width:8%">
                        <div class="left"></div>
                    </li>
                    <li class="item <?php if(isset($fund_rows['111'])){echo 'done';}?>">
                        <?php if(isset($fund_rows['111'])){?>
                        <div class="wc"></div>
                        <?php }?>
                        <div class="title">首次充值</div>
                        <div class="desc">首次体验充值功能</div>
                        <div class="money">+<?php echo $params_send['recharge'];?>元管理费</div>
                        <div class="button"><a href="<?php echo \App::URL("web/user/recharge");?>">申请合约</a></div>
                    </li>
                    <li style="width:8%">
                        <div class="left"></div>
                    </li>
                    <li class="item <?php if(isset($fund_rows['106'])){echo 'done';}?>">
                        <?php if(isset($fund_rows['106'])){?>
                        <div class="wc"></div>
                        <?php }?>
                        <div class="title">绑定银行卡</div>
                        <div class="desc">开户名与实名认证同名</div>
                        <div class="money">+<?php echo $params_send['bank'];?>元管理费</div>
                        <div class="button"><a href="<?php echo \App::URL("web/user/bank");?>">前往绑定</a></div>
                    </li>
                </ul>
                <div class="down2"></div>
                <ul class="clearfix">
                    <li class="item <?php if(isset($fund_rows['108'])){echo 'done';}?>">
                        <?php if(isset($fund_rows['108'])){?>
                        <div class="wc"></div>
                        <?php }?>
                        <div class="title">首次追加策略</div>
                        <div class="desc">首次体验追加策略功能</div>
                        <div class="money">+<?php echo $params_send['add'];?>元管理费</div>
                        <div class="button"><a href="<?php echo \App::URL("web/user/account");?>">前往操作</a></div>
                    </li>
                    <li style="width:8%;">
                        <div class="right"></div>
                    </li>
                    <li class="item <?php if(isset($fund_rows['109'])){echo 'done';}?>">
                        <?php if(isset($fund_rows['109'])){?>
                        <div class="wc"></div>
                        <?php }?>
                        <div class="title">首次补亏</div>
                        <div class="desc">首次体验补亏功能</div>
                        <div class="money">+<?php echo $params_send['fill'];?>元管理费</div>
                        <div class="button"><a href="<?php echo \App::URL("web/user/account");?>">前往操作</a></div>
                    </li>
                    <li style="width:8%;">
                        <div class="right"></div>
                    </li>
                    <li class="item <?php if(isset($fund_rows['110'])){echo 'done';}?>">
                        <?php if(isset($fund_rows['110'])){?>
                        <div class="wc"></div>
                        <?php }?>
                        <div class="title">首次提盈</div>
                        <div class="desc">首次体验提盈功能</div>
                        <div class="money">+<?php echo $params_send['profit'];?>元管理费</div>
                        <div class="button"><a href="<?php echo \App::URL("web/user/account");?>">前往操作</a></div>
                    </li>
                    
                </ul>
            </div>
            <div style="height:40px"></div>
        </div>
        <!--include file "footer.php"-->
    </body>
</html>