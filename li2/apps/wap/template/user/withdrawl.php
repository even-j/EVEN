<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <!--include file "common.php"-->
        <style>
            .formbox table{font-size: 14px}
            .formbox table td{text-align: left}
        </style>
         

    </head>

    <body class="index">
        
        <div class="header">
            <h1>提现</h1>
            <a class="l-link" href="javascript:history.go(-1)"><span>返回</span></a> 
            <div class="top-menu">
                <!--<button type="button" class="btn"></button>-->
            </div>
        </div>
        <div style="height: 40px"></div>
        <div class="ms-c6">
            <div class="ms-c6-m" style="padding-top: 10px">
                <div class="formbox" style="background:#fff">
                    <form id="chargeMoney" name="chargeMoney">
                        <table>
                            <tbody>
                                <tr>
                                    <td style="width:120px">可提款金额：</td>
                                    <td>
                                        <strong style="color:#F00;font-weight: bold"><?php echo $userinfo ['aviable_money'];?></strong> 元
                                        <input type="hidden" name="total" id="total" value="0.00">
                                    </td>
                                </tr>
                                <tr>
                                    <td>提款金额：</td>
                                    <td>
                                        <input id="money" name="money" value="" class="inp" style="width:70%" type="text"> 元
                                    </td>
                                </tr>
                                <tr>
                                    <td>提款银行卡：</td>
                                    <td>
                                        <select name="bank" id="bank" style="height:30px;width:100%">
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
                                
                            </tbody>
                        </table>
                </div>
                    <div id="withdraw" class="btn_primary" type="button">提 交</div>
                <div class="ms-c6-dl clearfix">
                    
                    <p>温馨提示：</p>
                   
                     <p>1、禁止洗钱、信用卡套现、虚假交易等行为.</p>

                                        <p>2、若资金多次直充直提，我们将视为非法洗钱行为,申请提款将收取30%的手续费.</p>

                                        <p>3、建议提现时间：周一至周五 08:00-18:00 周末 10:00-17:00 提现1-10分钟到账.</p>
                </div>
            </div>
        </div>
        <script type="text/javascript">
            $(function() {
                var boo = true;
                $('#withdraw').click(function() {
                    setTimeout(function () { boo = false }, 0)
                    if (boo) {
                      var balance = <?php echo $userinfo ['balance'];?>;
                    
                      if ($('#money').val() == '') {
                             boo = true;
                           layeralert('请输入本次要提现的金额。');
                          return false;
                      } else if ($('#money').val() > balance) {
                          boo = true;
                        layeralert('提现金额不能大于可提款金额。');
                        return false;
                      }
                      if ($('#bank').val() == '') {
                          boo = true;
                        layeralert('请选择要提现到那个银行卡。');
                        return false;
                      }

					  $(this).attr("disabled","true");
                    
                      $.post('<?php echo \App::URL("web/user/withdrawalsMoney");?>', $('form').serialize(), function(res) {
                           if (res.code == 1) {
                                  
						      	window.location.href = "<?php echo \App::URL("wap/user/account",array('msg'=>'提现提交成功，请等待银行转账！'))?>"
                             } else {
                                 
                                 layeralert(res.msg);
                          }
                         }, 'json');
                    }
                    boo = true;
					$(this).attr("disabled","false");
                });
            });
        </script>
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
    </body>
</html>