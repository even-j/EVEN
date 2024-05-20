<!--include file "admin_include.php"-->
<div class="container clearfix">
    <div class="main-wrap">
        <!--include file "admin_nav.php"-->
        <div class="result-wrap">
            <form action="/index.php?app=admin&mod=system&ac=doSend" method="post" id="myform" name="myform" enctype="multipart/form-data">
                <div class="config-items">
                    <div class="result-content">
                        <table width="100%" class="insert-tab">
                            <tbody>
                                <tr>
                                    <th width="15%">注册赠送金额：</th>
                                    <td><input type="text" name="regist" id="regist" value="<?php echo $params_send['regist'] ?>" onkeyup="" size="50"  class="common-text"> 
                                        <i class="tip left pd10">（单位：元）</i></td>
                                </tr>
                                <tr>
                                    <th width="15%">实名认证赠送金额：</th>
                                    <td><input type="text" name="sfz" id="sfz" value="<?php echo $params_send['sfz'] ?>" onkeyup="" size="50"  class="common-text"> 
                                        <i class="tip left pd10">（单位：元）</i></td>
                                </tr>
                                <tr>
                                    <th width="15%">绑定银行卡赠送金额：</th>
                                    <td><input type="text" name="bank" id="bank" value="<?php echo $params_send['bank'] ?>" onkeyup="" size="50"  class="common-text"> 
                                        <i class="tip left pd10">（单位：元）</i></td>
                                </tr>
                                <tr>
                                    <th width="15%">首次充值赠送金额：</th>
                                    <td><input type="text" name="recharge" id="recharge" value="<?php echo $params_send['recharge'] ?>" onkeyup="" size="50"  class="common-text"> 
                                        <i class="tip left pd10">（单位：元）</i></td>
                                </tr>
                                <tr>
                                    <th width="15%">首次策略赠送金额：</th>
                                    <td><input type="text" name="peizi" id="peizi" value="<?php echo $params_send['peizi'] ?>" onkeyup="" size="50"  class="common-text"> 
                                        <i class="tip left pd10">（单位：元）</i></td>
                                </tr>
                                <tr>
                                    <th width="15%">首次追加赠送金额：</th>
                                    <td><input type="text" name="add" id="add" value="<?php echo $params_send['add'] ?>" onkeyup="" size="50"  class="common-text"> 
                                        <i class="tip left pd10">（单位：元）</i></td>
                                </tr>
                                <tr>
                                    <th width="15%">首次补亏赠送金额：</th>
                                    <td><input type="text" name="fill" id="fill" value="<?php echo $params_send['fill'] ?>" onkeyup="" size="50"  class="common-text"> 
                                        <i class="tip left pd10">（单位：元）</i></td>
                                </tr>
                                <tr>
                                    <th width="15%">首次提盈赠送金额：</th>
                                    <td><input type="text" name="profit" id="profit" value="<?php echo $params_send['profit'] ?>" onkeyup="" size="50"  class="common-text"> 
                                        <i class="tip left pd10">（单位：元）</i></td>
                                </tr>
                                <tr>
                                    <th width="15%">签到赠送金额：</th>
                                    <td><input type="text" name="sign" id="maxLimitMoney" value="<?php echo $params_send['sign'] ?>" onkeyup="" size="50"  class="common-text"> 
                                        <i class="tip left pd10">（单位：元）</i></td>
                                </tr>
                                <tr>
                                    <th width="15%">签到循环周期：</th>
                                    <td><input type="text" name="sign_cycle" id="maxLimitMoney" value="<?php echo $params_send['sign_cycle'] ?>" onkeyup="" size="50"  class="common-text"> 
                                        <i class="tip left pd10">（单位：天）</i></td>
                                </tr>

                                <tr>
                                    <th></th>
                                    <td>
                                        <input type="submit" value="提交" class="btn btn-primary btn10 mr10">
                                        <input type="reset" value="重置" class="btn btn10 mr10">
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </form>

        </div>
    </div>
    <!--/main-->
</div>
<script language="JavaScript" type="text/javascript">
    function clearNoNum(obj) {
        obj.value = obj.value.replace(/[^\d.]/g, "");  //清除“数字”和“.”以外的字符  
        obj.value = obj.value.replace(/^\./g, "");  //验证第一个字符是数字而不是. 
        obj.value = obj.value.replace(/\.{2,}/g, "."); //只保留第一个. 清除多余的.   
        obj.value = obj.value.replace(".", "$#$").replace(/\./g, "").replace("$#$", ".");
    }
</script>
<!--include file "admin_bottom.php"-->