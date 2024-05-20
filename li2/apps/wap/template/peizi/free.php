
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <!--include file "common.php"-->
        <script type="text/javascript">
        //#####------------------------------------------------------------------------------------------------------
        $(function () {
            $('#subBtn').on('click', function () {
                $(this).prop('disabled',true);
                var uid = "<?php echo $uid;?>";
                if(uid == '0'){
                    layerconfirm('您还未登录！',['去登录','取消'],function(){
                        window.location.href = "<?php echo \App::URL('wap/member/login')?>";
                    });
                    return;
                }
                var status = <?php echo $params['status'] ?>;
                var isChaogeshu = <?php echo $var['isChaogeshu'] ?>;
                //活动暂停
                if(status==0){
                    return;
                }
                //超当天体验数
                if(isChaogeshu==1){
                    return;
                }
                var cpj = <?php echo $params['service_cost_rate']?>;//操盘金
                var deposit = <?php echo $params['baozheng_free']?>;//保证金
                var jgx = 0;//警告线
                var pcx = 0;//平仓线
                var glf = 0;//管理费
                var risk = cpj/deposit;//配资比例
                var duration = <?php echo $params['free_day']?>;//时间周期
                var url = "<?php echo \App::URL('web/peiziu/daywinadd')?>";
                var index = layerloading("提交...");
                $.post(url,{money: cpj,days: duration,pz_ratio: risk,pz_type:4},function(res){
                    if(res.status == 0){
                        layer.close(index);
                        layeralert(res.msg);
                        $(this).prop('disabled',false);
                    }
                    else{
                        window.location.href = "<?php echo \App::URL('wap/user/peizi');?>" + "&pz_type=4";
                    }
                },'json');
            });
        });

        </script> 
        
        <style>
            .borBox{width:90%;margin: 20px auto}
            #textBox dt,#textBox dd{width:100%;height:40px;line-height: 40px;text-align: center;border-radius: 5px;position: relative;margin-bottom: 20px;font-size: 18px}
            #textBox dt{background: #ff818f;color:#fff}
            #textBox dd{background: #eeeeee;color:#555}
            #textBox dt em,#textBox dd em{position: absolute;bottom: -15px;left:49%;width:0;height:0;}
            #textBox dt em{border-top: 15px solid #ff818f;border-left: 10px solid transparent;border-right: 10px solid transparent}
            #textBox dd em{border-top: 15px solid #eeeeee;border-left: 10px solid transparent;border-right: 10px solid transparent}
            .borBox b{color:#ee2c00;font-size: 18px} 
            .borBox span{color:#888888;font-size: 14px} 
            .ruleText{font-size: 12px;color: #555}
            .ruleText p{text-align: center}
        </style>
    </head>

    <body>
        <div class="header">
            <h1><?php echo SITE_NAME;?></h1>
            <a class="l-link" href="<?php echo \App::URL('wap/index/view');?>"><span>返回</span></a> 
            <div class="top-menu">
                <!--<button type="button" class="btn"></button>-->
            </div>
        </div>
        <div style="height:40px;"></div>
        <!--include file "peizi_menu.php"-->
        <div class="borBox" id="experienceBox">
            <dl id="textBox">
                <dt>每个新用户只有一次体验机会<em></em></dt>
                <dd><?php echo SITE_NAME?>出<b class="font1"><?php echo $params['service_cost_rate']?></b>元<span>（完全免费）</span><em></em></dd>
                <dd>您支付<b class="font1"><?php echo $params['baozheng_free']?></b>元<span>（体验费，体验结束全额退还）</span><em></em></dd>
                <dd>总计<b class="font1"><?php echo $params['service_cost_rate']?></b>元<span>（由您操盘）</span><em></em></dd>
                <dd>交易<b class="font1"><?php echo $params['free_day']?></b>天<span>（第二个交易日14:00前卖出）</span><em></em></dd>
                <dd>盈利全归你，超额亏损算我们<em></em></dd>
                <?php if (apps\Config::getInstance()->free_profit_to=='send'){?>
                <dd>盈利部分不能提现，只能当管理费使用<em></em></dd>
                <?php }?>
            </dl>

            <div class="ruleText">
                <!--p>免费体验"股票交易账户"会在下个交易日9点15分前开出</p-->
                <?php if($params['status']==1){?>
                    <?php if($var['isChaogeshu']==1){?>
                        <p>今日体验操盘帐号已分配完毕，请明日再来</p>
                        <p>小贴士：由于申请免费体验操盘人数众多，建议早上9点前申请</p>
                        <div style="width:80%;margin: 0 auto;margin-top:20px"><a class="btn_disabled" id="subBtn">免费体验</a></div>
                    <?php }else{?>
                        <p>只需支付<?php echo $params['baozheng_free']?>元就可以立刻获得<?php echo $params['service_cost_rate']?>元体验操盘帐号</p>
                        <div style="width:100%;margin: 0 auto;margin-top:20px; box-shadow: 0 4px 8px rgba(255, 69, 69, 0.3);"><a class="btn_primary" id="subBtn">免费体验</a></div>
                    <?php }?>    
                <?php }else{?>
                    <p>活动暂停</p>
                    <div style="width:100%;margin: 0 auto;margin-top:20px;box-shadow: 0 4px 8px rgba(255, 69, 69, 0.3);"><a class="btn_disabled" id="subBtn">免费体验</a></div>
                <?php }?>
            </div>
        </div>
    </body>
</html>