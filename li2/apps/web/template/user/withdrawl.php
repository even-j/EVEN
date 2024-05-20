<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <!--include file "common.php"-->
        <style>
            .withdraw td{text-align: left;padding-left: 40px!important}
        </style>
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
                        <h2><strong>我要提款</strong><span>提款到指定银行卡</span></h2>
                        <div class="ms-c6">
                            <div class="ms-c6-m" style="padding-top: 10px">
                                <div class="formbox">
                                    <form id="chargeMoney" name="chargeMoney">
                                        <table class="withdraw">
                                            <tbody>
                                                <tr>
                                                    <th>可提款金额：</th>
                                                    <td>
                                                        <strong class="red"><?php echo $userinfo ['aviable_money'];?></strong> 元
                                                        <input type="hidden" name="total" id="total" value="0.00">
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th>提款金额：</th>
                                                    <td>
                                                        <input id="money" name="money" value="" class="inp" style="width:200px;" type="text"> 元
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th>提款银行卡：</th>
                                                    <td>
                                                        <select name="bank" id="bank">
                                                            <option value="">请选择</option>
                                                            <?php foreach ($bankList as $key=>$bank){?>
                                                            <option value="<?php echo $bank['card_id'];?>"><?php echo $bank['bank_name'];?> ( <?php echo $bank['last_card_no'];?> )</option>    
                                                            <?php }?>
                                                        </select>
                                                    </td>
                                                </tr>
                                                <!--tr>
                                                    <th>绑定的手机：</th>
                                                    <td>                                
                                                                                            <input value="135*****010" type="text" disabled="disabled" class="inp" style="width:200px;background:#eee" autocomplete="off">
                                                            <input id="mobile" value="13599533010" type="hidden">
                                                            <input id="smscode" value="获取验证码" class="smscode" type="button">                            </td>
                                                </tr>
                                                <notempty name="data['phone']">
                                                <tr>
                                                    <th>验证码：</th>
                                                    <td>
                                                        <input id="code" name="smscode" class="inp" maxlength="8" style="width:200px;" type="text" autocomplete="off">
                                                    </td>
                                                </tr>
                                                </notempty-->
<!--                                                <tr>
                                                    <th>支付密码：</th>
                                                    <td>
                                                        <input id="password" name="password" class="inp" maxlength="20" style="width:200px;" type="password" autocomplete="off" >
                                                            <a href="/member/account/password.html" in="pop" data="forget">
                                                                设置支付密码                                </a>
                                                    </td>
                                                </tr>-->
                                                <tr>
                                                    <th></th>
                                                    <td>
                                                        <button id="withdraw" class="btn-b" type="button">提 交</button>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                        <input type="hidden" name="__hash__" value="5b026c8aaac4b88a7c7b961518428b06_80fa7ad077399374efe035f34166dc4b" /></form>
                                </div>
                                <div class="ms-c6-dl clearfix">
                                    <dl>
                                        <dt>最快<strong>秒</strong>到账</dt>
                                        <dd>工作时间内提款秒到账(节假日无休)</dd>
                                    </dl>
                                    <dl>
                                        <dt>提款<strong>0</strong>手续费</dt>
                                        <dd>提款产生的银行手续费全免</dd>
                                    </dl>
                                    <dl>
                                        <dt>支持银行多达<strong>几十</strong>家</dt>
                                        <dd>建议您使用大型银行提款，到账最快</dd>
                                    </dl>
                                   
                                        
                                         <p>温馨提示：1、禁止洗钱、信用卡套现、虚假交易等行为.</p>

                                        <p>温馨提示：2、若资金多次直充直提，我们将视为非法洗钱行为,申请提款将收取30%的手续费.</p>

                                        <p>温馨提示：3、建议提现时间：周一至周五 08:00-18:00 周末 10:00-17:00 提现1-10分钟到账.</p>

                                </div>
                            </div>
                        </div>
                        <script type="text/javascript">
						    
                            $(function() {
                                $('#withdraw').click(function() {
                                    var balance = <?php echo $userinfo ['balance'];?>;
                                    if ($('#money').val() == '') {
                                        top.dialog('请输入本次要提现的金额。');
                                        return false;
                                    } else if ($('#money').val() > balance) {
                                        top.dialog('提现金额不能大于可提款金额。');
                                        return false;
                                    }
                                    if ($('#bank').val() == '') {
                                        top.dialog('请选择要提现到那个银行卡。');
                                        return false;
                                    }
//                                    if ($('#code').val() == '') {
//                                        top.dialog('请输入手机收到的验证码。');
//                                        return false;
//                                    }
//                                    if ($('#password').val() == '') {
//                                        top.dialog('请输入支付密码。');
//                                        return false;
//                                    }
									$('#withdraw').attr("disabled","true");
                                    $.post('<?php echo \App::URL("web/user/withdrawalsMoney");?>', $('form').serialize(), function(res) {
                                        if (res.code == 1) {
                                            window.location.href = "<?php echo \App::URL("web/user/success",array('msg'=>'提现提交成功，请等待银行转账！'))?>"
                                        } else {
                                            top.dialog(res.msg, 'error');
                                        }
                                    }, 'json');
									$('#withdraw').attr("disabled","false");

                                });
                            });
							
                        </script>
                    </div>
                </div>
            </div>
        </div>
        <script type="text/javascript">
            $(function() {
                $('dd').click(function() {
                    $('dd').removeClass('current');
                    $(this).addClass('current');
                    $('#mainFrame').css('height', '0px');
                    $('#loading').css('display', 'block');
                });
            });
        </script>
        <!--include file "footer.php"-->
    </body>
</html>