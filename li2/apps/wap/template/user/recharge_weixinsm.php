<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <!--include file "common.php"-->
        <style>
            body{background: #f6f6f6}
            .account{background: #fff;padding:10px 15px}
            .account li{font-size: 14px;line-height: 28px;}
            .account li p{text-indent: 24px}
            .account li span{padding:2px 10px;color:blue;margin-left:10px; }
            .list li{display: block;position: relative;border-bottom: 1px solid #eee;background: #fff;height: 40px}
            .list li:last-child{border:0}
            .list li p{display: block;position: absolute;left:15px;top:8px;font-size: 14px;padding-top: 8px}
            .list li input{display: block;border:0;font-size: 14px;padding-top: 9px;color:#333;padding-left:100px;width: auto}
            .tishi{padding:10px 15px}
            .tishi p{line-height: 26px;font-size: 12px;color:#777}
        </style>

    </head>

    <body class="index">
        <div class="header">
            <h1>微信扫码</h1>
            <a class="l-link" href="javascript:history.go(-1)"><span>返回</span></a> 
            <div class="top-menu">
                <!--<button type="button" class="btn"></button>-->
            </div>
        </div>
        <div style="height: 40px"></div>
        <p style="font-size:12px;color:#777;padding:10px 15px">请先成功付款后再"填写付款信息"确认提交</p>
        <ul class="account">
            <li>
                <p style="text-align:center;text-indent: 0px">
                    <img src="/public/wap/images/shoukuanma1.png" width="160" />
                </p>
                <p style="text-align:center;text-indent: 0px;font-size:12px;color:#999">截屏保存二维码到本地相册</p>
            </li>
        </ul>
        <p style="font-size:12px;color:#777;padding:10px 15px">填写付款信息</p>
        <ul class="list">
            <li>
                <p>转账金额</p>
                <input id="money" type="text" placeholder="请输入转账金额"/>
            </li>
            <li>
                <p>付款账号</p>
                <input id="name" type="text" placeholder="请输入付款账号"/>
            </li>
        </ul>
        <div class="btn_primary" style="width:60%;margin-top: 20px" onclick="submit()">确认提交</div>
        <div class="tishi">
            <p style="color:#ff835f;font-size: 14px">温馨提示：</p>
            <p>1.为了您资金安全，请您充值前先实名认证和绑定银行卡号。</p>
			<p>2.转账金额最好有些零头(1000.18)，方便我们确认是您汇款。</p>
            <p>3.到账时间：08:00--18:00(十分钟内到账)，18:00以后(次日08:00前到账)</p>
			<p>4.充值过程遇到问题，请联系在线客服(微信客服、QQ客服)或拨打客服热线：4000-039-678</p>
        </div>
        <script src="/public/wap/js/clipboard.min.js" type="text/javascript"></script>
        <script type="text/javascript">
            $(function(){
                var clipboard1 = new Clipboard('#copy_account', {
                    text: function() {
                        return 'yhpz88@126.com';
                    }
                });
                

                clipboard1.on('success', function(e) {
                    layermsg('复制成功');
                });
            })
            
            function submit(){
                var money = $("#money").val();
                var name = $("#name").val();
                var type = "<?php echo $_GET['type'];?>";
                if (!money.match(/^\d{1,7}(\.\d{1,2})?$/)) {
                    layeralert("转账金额格式错误");
                    return false;
                } else if (money < 1) {
                    layeralert("最低充值金额不小于1元");
                    return false;
                }
                var channel = '微信扫码';
                var data = {p3_Amt : money,name : name,channel : channel};
                $.post("/index.php?app=web&mod=recharge&ac=dorecharge_offline",data,function(res){
                    if(res.code == "1"){
                        layeralert('<style>.layui-m-layercont{padding:20px;}</style><p style="font-size:16px;font-weight:bold;padding:10px">提交成功</p><p>请等待财务处理，如果长时间没有到账，请联系客服！</p>','返回个人中心',function(){
                            window.location.href= "<?php echo \App::URL('wap/user/account')?>";
                        });
                        //清空数据
                        $("#money").val('');
                        $("#name").val('');
                    }
                    else{
                        layeralert(res.msg);
                    }
                },'json')
            }
        </script>
    </body>
    
</html>