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
            <h1><?php echo $row['name'];?></h1>
            <a class="l-link" href="javascript:history.go(-1)"><span>返回</span></a> 
            <div class="top-menu">
                <!--<button type="button" class="btn"></button>-->
            </div>
        </div>
        <div style="height: 40px"></div>
        <?php  if($type=='offline'){?> 
        <!--线下-->   
            <?php if($row['type']==0){?>
                
                <ul class="account">
                    <li>公司名称：<?php echo $row['holder'];?><span id="copy_name" onclick="">复制</span></li>
                    <li>公司账号：<?php echo $row['account'];?><span id="copy_no" onclick="">复制</span></li>
                    <li>开户地址：<?php echo $row['address'];?></li>
                     <?php if($row['remark']){?>
                    <li>备注:<?php echo str_replace('&quot;','"',str_replace('&amp;gt;','>',str_replace('&amp;lt;', '<', $row['remark'])));?></li>
                    <?php }?>
                </ul>
            <?php }else{?>
                <p style="font-size:12px;color:#777;padding:10px 15px">请先扫码成功付款后再"填写付款信息"确认提交</p>
                <ul class="account">
                    <?php if($row['holder']){?>
                    <li>收款人：<?php echo $row['holder'];?></li>
                    <?php }?>
                    <?php if($row['account']){?>
                    <li>收款账号：<?php echo $row['account'];?><span id="copy_no" onclick="">复制</span></li>
                    <?php }?>
                    <?php if($row['path']){?>
                    <li>
                        <p style="text-align:center;text-indent: 0px">
                            <img src="<?php echo $row['path'];?>" width="160" />
                        </p>
                        <p style="text-align:center;text-indent: 0px;font-size:12px;color:#999">截屏保存二维码到本地相册</p>
                    </li>
                    <?php }?>
                    <?php if($row['remark']){?>
                    <li>备注:<?php echo str_replace('&quot;','"',str_replace('&amp;gt;','>',str_replace('&amp;lt;', '<', $row['remark'])));?></li>
                    <?php }?>
                </ul>    
                
            <?php }?>
        
        <?php }else{?>  
        <!--线上-->
            <?php if ($row['memo']){?>
            <p style="color:orange;padding:20px 15px;font-size: 14px"><?php echo $row['memo'];?></p>
            <?php }?>
        <?php }?>
        
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
                var clipboard1 = new Clipboard('#copy_name', {
                    text: function() {
                        return '<?php echo $row['holder'];?>';
                    }
                });
                var clipboard2 = new Clipboard('#copy_no', {
                    text: function() {
                        return '<?php echo $row['account'];?>';
                    }
                });
                clipboard1.on('success', function(e) {
                    layermsg('复制成功');
                });
                clipboard2.on('success', function(e) {
                    layermsg('复制成功');
                });
            })
            
            var commpay=false;

            function submit(){
                var money = $("#money").val();
                var name = $("#name").val();
                var type = "<?php echo $type;?>";
                if(name=="" || name==null)
                {
                    layeralert("付款账号不能为空!");
                    return false;
                }
                if (!money.match(/^\d{1,7}(\.\d{1,2})?$/)) {
                    layeralert("转账金额格式错误");
                    return false;
                } else if (money < 1) {
                    layeralert("最低充值金额不小于1元");
                    return false;
                }
                if(type=='offline')
                {
                    var channel = '<?php echo $row['channel']?>';
                    var data = {p3_Amt : money,name : name,channel : channel};
                    if (!commpay) {
                    commpay=true;
                    $.post("/index.php?app=web&mod=recharge&ac=dorecharge_offline",data,function(res){
                        if(res.code == "1"){
                            commpay=false;
                            layeralert('<style>.layui-m-layercont{padding:20px;}</style><p style="font-size:16px;font-weight:bold;padding:10px">提交成功</p><p>请等待财务处理，如果长时间没有到账，请联系客服！</p>','返回个人中心',function(){
                                window.location.href= "<?php echo \App::URL('wap/user/account')?>";
                            });
                            //清空数据
                            commpay=false;
                            $("#money").val('');
                            $("#name").val('');
                        }
                        else{
                            commpay=false;
                            layeralert(res.msg);
                        }
                    },'json')
                }
                }
                else
                {
                    var type ="<?php echo $row['code']?>";
                    var domain ="<?php echo $row['domain']?>";
                    var controller ="<?php echo $row['controller']?>";
                    if(type=='jinm_zfb' && money<10)
                    {
                        layeralert("最低充值金额不小于10元");
                        return false;
                    }
                    var uid = <?php echo $uid;?>;
                    var can_iframe = '<?php echo $row['can_iframe']?>';
                    if(can_iframe == '1'){
                        window.open("/index.php?app=wap&mod=user&ac=recharge_iframe&url="+escape(domain+"/index.php?app=pay&mod="+controller+"&ac=saoma&uid="+uid+"&money="+money+"&name="+name)+"&code="+type);
                    }
                    else{
                        window.open(domain+"/index.php?app=pay&mod="+controller+"&ac=saoma&uid="+uid+"&money="+money+"&name="+escape(name)+"&code="+type);
                    }
                    return false;
                }
            }
        </script>
    </body>
    
</html>