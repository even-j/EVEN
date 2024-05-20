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
                        <h2><strong>银行卡管理</strong></h2>
                        <div class="ms-c6">
                            <div class="ms-c6-m" style="padding-top: 10px">
                                <div class="formbox">
                                    <table>
                                        <tbody>
                                            <tr>
                                                <th>您认证的银行卡：</th>
                                                <?php foreach ($bankList as $key=>$bank){?>
                                                <td>
                                                    <div class="card">
                                                        <div class="bank-logo" style="width:120px;">
                                                            <?php if(array_key_exists($bank['bank_name'],$bank_arr)){?>
                                                            <img alt="<?php echo $bank['bank_name'];?>" src="/public/web/images/bank/<?php echo $bank_arr[$bank['bank_name']];?>.png">
                                                            <?php } elseif($bank['type']==2){ ?>
                                                               虚拟币地址:
                                                            <?php } else{ ?>
                                                            <img alt="<?php echo $bank['bank_name'];?>" src="/public/web/images/bank/union.png">
                                                            <?php }?>
                                                        </div>
                                                        <span>尾号：<strong><?php echo substr($bank ['card_no'], - 4);?></strong></span>
                                                        <div class="inpbox" style="width:240px;">
                                                            <i>已绑定</i>
                                                        </div>
                                                    </div>                        
                                                </td>
                                                <?php }?>
                                                
                                            </tr>
                                        </tbody>
                                    </table>
                                    <h4>添加银行卡</h4>
                                    <span style="color:red">（温馨提示：为了您的账户资金安全，银行卡绑定仅限实名认证本人的银行帐号）</span>
                                    <form id="addMemberBank" method="POST">
                                        <input id="bankCardType" name="bankCardType" value="1" type="hidden"/>
                                        <input id="id" name="id" value="" type="hidden"/>
                                        <table>
                                            <tbody>

                                        <tr>
                                            <th>类型：</th>
                                            <td>

                                                <select class="sel" style="width:150px;height:30px;line-height:18px; padding:2px" id="type" name="type">
                                                    <option value="1">银行卡</option>
                                                    <option value="2">虚拟币地址</option>
                                                </select>
                                                <font id="province_error_msg" color="red">*</font>
                                            </td>
                                        </tr>
                                            </tbody>
                                        </table>

                                        <table id ='xunibi' style="display:none;">


                                            <tr >
                                                <th>虚拟币地址：</th>
                                                <td>
                                                    <div class="kh-box">
                                                        <div class="kh" style="display:none;"></div>
                                                        <input class="inp c-inp" maxlength="20" id="address" name="address" value="" type="text">
                                                        <font id="bankCardNumer_error_msg" color="red">*</font>
                                                    </div>
                                                </td>
                                            </tr>


                                            <tr>
                                                <th></th>
                                                <td>
                                                    <button id="saveWithdrawBank" type="button" class="btn-b">提 交</button>
                                                </td>
                                            </tr>
                                            </tbody>
                                        </table>

                                        <table id ='yinhangka'>
                                            <tbody>
                                                <tr>
                                                    <th>帐户名：</th>
                                                    <td>
                                                        <?php echo $user['true_name'];?>
                                                    </td>
                                                </tr>




                                                <tr>
                                                    <th>开户银行：</th>
                                                    <td>
                                                        <div class="kh-box">
                                                            <div class="kh" style="display:none;"></div>
                                                            <input class="inp c-inp" maxlength="50" id="bank" name="bank" value="" type="text">
                                                                <font id="bankCardNumer_error_msg" color="red">*</font>
                                                        </div>
                                                        <!--
                                                        <div class="sbox" style="float:left;">
                                                            <div>
                                                                <input class="inp" readonly="readonly" name="bank" value="中国银行" style="width:165px;">
                                                            </div>
                                                            <div class="s-option" style="width:175px;">
                                                                <ul>
                                                                    <li li_val="cmb">招商银行</li>
                                                                    <li li_val="boc">中国银行</li>
                                                                    <li li_val="icbc">中国工商银行</li>
                                                                    <li li_val="ccb">中国建设银行</li>
                                                                    <li li_val="abc">中国农业银行</li>
                                                                    <li li_val="psbc">中国邮政储蓄银行</li>
                                                                    <li li_val="bcom">交通银行</li>
                                                                    <li li_val="spdb">上海浦东发展银行</li>
                                                                    <li li_val="sf">深圳发展银行</li>
                                                                    <li li_val="ms">中国民生银行</li>
                                                                    <li li_val="cib">兴业银行</li>
                                                                    <li li_val="pa">平安银行</li>
                                                                    <li li_val="bj">北京银行</li>
                                                                    <li li_val="tj">天津银行</li>
                                                                    <li li_val="sh">上海银行</li>
                                                                    <li li_val="hx">华夏银行</li>
                                                                    <li li_val="gd">光大银行</li>
                                                                    <li li_val="gf">广发银行</li>
                                                                    <li li_val="zx">中信银行</li>
                                                                    <li li_val="ns">上海农商银行</li>
                                                                    <li li_val="xys">农村信用社</li>
                                                                    <li li_val="other">其他</li>
                                                                </ul>
                                                            </div>
                                                        </div>
                                                        <input class="inp c-inp" style='margin-top:3px;display: none'  type='text' name='otherbank' id='otherbank' Placeholder='请填写银行名称'/>-->


                                                        <input id="bankCode" name="bankCode" value="boc" type="hidden">
                                                           <!-- <font style="margin-top:10px;" id="bankCode_error_msg" color="red">*</font>-->
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th>开户行所在地：</th>
                                                    <td>
                                                        <select title="" class="sel" id="province" style="width:100px;height:30px;line-height:18px; padding:2px" id="province" name="province">
                                                            <option value="">请选择</option>
                                                            <?php foreach ($province as $p){
                                                                $selected = $bankinfo && $bankinfo['province_id']==$p['id'] ? 'selected="selected"' : '';	
                                                            ?> 
                                                            <option value="<?php echo $p['id']?>" <?php echo $selected;?>><?php echo $p['name']?></option>
                                                            <?php }?>	
                                                        </select>
                                                        <select class="sel" style="width:150px;height:30px;line-height:18px; padding:2px" id="city" name="city">
                                                            <option value="">请选择</option>
                                                        </select>
                                                        <font id="province_error_msg" color="red">*</font>
                                                    </td>
                                                </tr>
<!--                                                <tr>
                                                    <th>支行名称：</th>
                                                    <td>
                                                        <input class="inp" maxlength="20" id="branch" name="branch" value="" type="text">
                                                            <font id="bankBranchName_error_msg" color="red"></font>
                                                    </td>
                                                </tr>-->
                                                <tr>
                                                    <th>银行卡号：</th>
                                                    <td>
                                                        <div class="kh-box">
                                                            <div class="kh" style="display:none;"></div>
                                                            <input class="inp c-inp" maxlength="20" id="number" name="number" value="" type="text">
                                                                <font id="bankCardNumer_error_msg" color="red">*</font>
                                                        </div>
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <th></th>
                                                    <td>
                                                        <button id="saveWithdrawBank" type="button" class="btn-b">提 交</button>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                        <input type="hidden" id="province_name" name="province_name" value="">
                                        <input type="hidden" id="city_name" name="city_name" value="">
                                        <input type="hidden" name="__hash__" value="f753a8639919e7e83497364fbd1dc74e_5242a73d036ed72d6f40c3f99e20a5d7" /></form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <script type="text/javascript">
            $(function() {
                $(".sbox .inp").click(function() {
                    $(this).parents(".sbox").children(".s-option").toggleClass("show");
                });
                $(".s-option li").click(function() {
                    $(this).parents(".sbox").children().children(".inp").val($(this).html());
                    $("#bankCode").val($(this).attr('li_val'));
                    $(this).parents(".s-option").toggleClass("show");

                    if($(this).attr('li_val')=="other")
                    {
                        $("#otherbank").show();
                    }
                    else
                    {
                        $("#otherbank").hide().val("");
                    }
                });

                $('#type').change(function() {
                    if($('#type').val() ==1){

                        $("#yinhangka").show();
                        $("#xunibi").hide();
                    }else{
                        $("#yinhangka").hide();
                        $("#xunibi").show();
                    }

                });

                $('#province').change(function() {
                    $('#province_name').val($(this).find('option:selected').text());
                    getCitys($(this).val());
                    //$.get('/member/area.html?parent=' + $(this).val(), function(data) {
                    //    $('#city').html(data);
                    //});
                });
                $("#city").change(function() {
                    $('#city_name').val($(this).find('option:selected').text());
                });
                //$.get('/member/area.html?parent=1', function(data) {
                //    $('#province').html('<option value="">请选择</option>' + data);
                //});

                $('#saveWithdrawBank').click(function() {
                    if($('#type').val()==1){
                    if (!$('#city').val()) {
                        top.dialog('请选择开户行所在城市。');
                        return false;
                    }
                    if (!$('#city').val()) {
                        top.dialog('请选择开户行所在城市。');
                        return false;
                    }
                    if ($('#branch').val() == '') {
                        top.dialog('请输入支行名称。');
                        return false;
                    }
                    if ($('#number').val() == '') {
                        top.dialog('请输入正确的卡号。');
                        return false;
                    }
                    if($("input[name='bank']").val()=="其他" && $.trim($("#otherbank").val())=="")
                    {
                        top.dialog('请输入银行名称。');
                        return false;
                    }
                    }else{
                        if ($('#address').val() == '') {
                            top.dialog('请输入虚拟币地址。');
                            return false;
                        }
                    }

                    $.post('<?php echo \App::URL('web/user/bankinfoveried')?>', $('form').serialize(), function(res) {
                        if (res.code == 1) {
                            window.location.reload();
                        } else {
                            top.dialog(res.msg, 'error');
                        }
                    }, 'json');
                });
            });
            function getCitys(provinceId){
                var city_name = $('#city_name').val();
                $.ajax({
                    url: "<?php echo \App::URL('web/user/ajaxregion')?>",
                    dataType: "json",
                    data: {
                        provinceId: provinceId,
                        subLength: 4,
                        t: new Date().getTime()
                    },
                    success: function(data) {
                        $("#city").html("");
                        var str = " <option value='-1'>请选择</option>";
                        $("#city").append(str);
                        $.each(data,function(i, temp) {
                            var selected = '';
                            if(city_name==temp.name){
                                selected = 'selected="selected"';
                            }
                            var str = "<option value='" + temp.id + "' "+selected+">" + temp.name + "</option>";
                            $("#city").append(str);
                        });
                    }
                });
            }
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
        <!--include file "footer.php"-->
    </body>
</html>