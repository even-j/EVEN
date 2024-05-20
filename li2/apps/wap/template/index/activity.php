
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <!--include file "common.php"-->
    </head>
    <style>
        body{ background: #ee8792 url(public/wap/images/task/bg.png); background-size:8px ;}
        .cont{ background: rgba(255,255,255, .5);border-bottom:7px solid #ee878f;padding-bottom: 5%;}	
        .bankuai{ width: 90%; padding: 4% 5%; }
        .bankuai:after{display:block;clear:both;content:"";visibility:hidden;height:0} 
        .bankuai li{ width: 48%; margin-right: 4%; padding: 4% 0; position: relative; line-height: 32px; float: left; text-align: center; border-radius: 6px; background: #ffffff; box-shadow:0 4px 12px rgb(255, 156, 134);}
        .bankuai li:nth-child(2){ margin-right: 0;}
        .bankuai li h4{ font-size: 16px; color: #ff8b19;}
        .bankuai li p{ font-size: 12px; color: #a2a2a2;}
        .bankuai button { border: none; width: 80%; margin-top: 2%; border-radius: 3px; background: #ff5064; font-size: 16px; line-height: 30px; text-align: center; color: #ffffff;}
        .bankuai .done button{background: #ccc}
        .bankuai button a{color:#fff}
        .jt_down{ width: 31px;  height: 32px; display: block; margin: 0 auto; background: url(public/wap/images/task/jt_down.png) no-repeat; background-size: 31px;}
        .guize{ width: 90%; padding: 5%;}
        .guize img{ display: block; text-align: center; margin: 0 auto; width: 184px;}
        .guize p { font-size: 16px; color: #fff; padding-left: 31px; line-height: 26px; margin-top: 5px;}
        .guize p i{ width: 10px; height: 10px; border-radius: 50%; margin-left: -26px; text-align: center; background: #ff5f4b; display: block; float: left;
                    padding: 5px;line-height: 11px; margin-top: 4px;margin-right: 6px;}
        .over_icon{ width: 71px; background: url(public/wap/images/task/over.png) no-repeat; background-size: 71px;position: absolute; top: 0; right: 0; height: 56px;}
    </style>
    <body> 
        <div class="header">
            <h1>新手任务</h1>
            <a class="l-link" href="javascript:history.go(-1)"><span>返回</span></a> 
            <div class="top-menu">
                <!--<button type="button" class="btn"></button>-->
            </div>
        </div>
        <div style="height:40px;"></div>
        <div>
            <img src="/public/wap/images/task/banner.png" width="100%" />
        </div>
        <div class="cont">
            <ul class="bankuai">
                <li <?php if(isset($fund_rows['103'])){echo 'class="done"';}?>>
                    <?php if(isset($fund_rows['103'])){?>
                        <div class="over_icon"></div>
                    <?php }?>
                    <h4>完成注册</h4>
                    <p>打开策略新体验</p>
                    <h4>+<?php echo $params_send['regist']; ?>元</h4>
                    <button><a href="<?php echo \App::URL('wap/member/register'); ?>">前往注册</a></button>
                </li>

                <li <?php if(isset($fund_rows['105'])){echo 'class="done"';}?>>
                    <?php if(isset($fund_rows['105'])){?>
                        <div class="over_icon"></div>
                    <?php }?>
                    <h4>实名认证</h4>
                    <p>真实身份信息认证</p>
                    <h4>+<?php echo $params_send['sfz']; ?>元</h4>
                    <button><a href="<?php echo \App::URL('wap/user/sfz'); ?>">前往实名</a></button>
                </li>
            </ul>
            <div class="jt_down"></div>
            <ul class="bankuai">	
                <li <?php if(isset($fund_rows['106'])){echo 'class="done"';}?>>
                    <?php if(isset($fund_rows['106'])){?>
                        <div class="over_icon"></div>
                    <?php }?>
                    <h4>绑定银行卡</h4>
                    <p>充值提现同卡进出</p>
                    <h4>+<?php echo $params_send['bank']; ?>元</h4>
                    <button><a href="<?php echo \App::URL("wap/user/bank"); ?>">前往绑定</a></button>
                </li>
                <li <?php if(isset($fund_rows['111'])){echo 'class="done"';}?>>
                    <?php if(isset($fund_rows['111'])){?>
                        <div class="over_icon"></div>
                    <?php }?>
                    <h4>首次充值</h4>
                    <p>首次体验充值功能</p>
                    <h4>+<?php echo $params_send['recharge']; ?>元</h4>
                    <button><a href="<?php echo \App::URL("wap/user/recharge"); ?>">申请合约</a></button>
                </li>
            </ul>
            <div class="jt_down"></div>
            <ul class="bankuai">
                <li <?php if(isset($fund_rows['107'])){echo 'class="done"';}?>>
                    <?php if(isset($fund_rows['107'])){?>
                        <div class="over_icon"></div>
                    <?php }?>
                    <h4>首次策略</h4>
                    <p>免费体验合约除外</p>
                    <h4>+<?php echo $params_send['peizi']; ?>元</h4>
                    <button><a href="<?php echo \App::URL("wap/peizi/month"); ?>">申请合约</a></button>
                </li>
                <li <?php if(isset($fund_rows['108'])){echo 'class="done"';}?>>
                    <?php if(isset($fund_rows['108'])){?>
                        <div class="over_icon"></div>
                    <?php }?>
                    <h4>首次追加策略</h4>
                    <p>首次体验追加策略功能</p>
                    <h4>+<?php echo $params_send['add']; ?>元</h4>
                    <button><a href="<?php echo \App::URL("wap/user/account"); ?>">前往操作</a></button>
                </li>
                
            </ul>
            <div class="jt_down"></div>
            <ul class="bankuai">
                <li <?php if(isset($fund_rows['109'])){echo 'class="done"';}?>>
                    <?php if(isset($fund_rows['109'])){?>
                        <div class="over_icon"></div>
                    <?php }?>
                    <h4>首次补亏</h4>
                    <p>首次体验补亏功能</p>
                    <h4>+<?php echo $params_send['fill']; ?>元</h4>
                    <button><a href="<?php echo \App::URL("wap/user/account"); ?>">前往操作</a></button>
                </li>
                <li <?php if(isset($fund_rows['110'])){echo 'class="done"';}?>>
                    <?php if(isset($fund_rows['110'])){?>
                        <div class="over_icon"></div>
                    <?php }?>
                    <h4>首次提盈</h4>
                    <p>首次体验提盈功能</p>
                    <h4>+<?php echo $params_send['profit']; ?>元</h4>
                    <button><a href="<?php echo \App::URL("wap/user/account"); ?>">前往操作</a></button>
                </li>		
            </ul>			
        </div>
        <div style="height:40px"></div>

    </body>
</html>