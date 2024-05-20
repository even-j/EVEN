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
            .formbox td{text-align: left}
        </style>
    </head>

    <body class="index">
        <div class="header">
            <h1>银行卡</h1>
            <a class="l-link" href="javascript:history.go(-1)"><span>返回</span></a> 
            <div class="top-menu">
                <!--<button type="button" class="btn"></button>-->
            </div>
        </div>
        <div style="height: 40px"></div>
        <?php if($bankList){?>
            <div style="padding:15px">您已认证的银行卡：</div>
            <?php foreach ($bankList as $key=>$bank){?>
                <div class="card">
                    <div class="bank-logo" style="width:120px;">
                        <?php if(array_key_exists($bank['bank_name'],$bank_arr)){?>
                        <img alt="<?php echo $bank['bank_name'];?>" src="/public/wap/images/bank/<?php echo $bank_arr[$bank['bank_name']];?>.png">
                        <?php } else{ ?>
                        <img alt="<?php echo $bank['bank_name'];?>" src="/public/wap/images/bank/union.png">
                        <?php }?>
                    </div>
                    <span>尾号：<strong><?php echo substr($bank ['card_no'], - 4);?></strong></span>
                    <div class="inpbox">
                        <i>已绑定</i>
                    </div>
                </div>   
            <?php }?>
        <?php }else{?>
        <div class="my-space">

            <div class="ms-c6">
                <div style="padding:15px">添加银行卡</div>
                <div style="padding:0px 15px 10px 15px"><span style="color:red;font-size:14px;line-height: 20px">（温馨提示：为了您的账户资金安全，银行卡绑定仅限实名认证本人的银行帐号）</span></div>
                <div class="formbox">
                    <form id="addMemberBank" method="POST">
                        <input id="bankCardType" name="bankCardType" value="1" type="hidden"/>
                        <input id="id" name="id" value="" type="hidden"/>
                        <table>
                            <tbody>
                                <tr>
                                    <td style="width:100px">帐户名：</td>
                                    <td>
                                        <?php echo $user['true_name'];?>
                                    </td>
                                </tr>
                                <tr>
                                    <td>开户银行：</td>
                                    <td>
                                         <input class="" id="bank" name="bank" value="" type="text" style="border:1px solid #999">
                                        <!--<select name="bank" style="height:30px">
                                            <option value="招商银行">招商银行</option>
                                            <option value="中国银行">中国银行</option>
                                            <option value="中国工商银行">中国工商银行</option>
                                            <option value="中国建设银行">中国建设银行</option>
                                            <option value="中国农业银行">中国农业银行</option>
                                            <option value="中国邮政储蓄银行">中国邮政储蓄银行</option>
                                            <option value="交通银行">交通银行</option>
                                            <option value="上海浦东发展银行">上海浦东发展银行</option>
                                            <option value="深圳发展银行">深圳发展银行</option>
                                            <option value="中国民生银行">中国民生银行</option>
                                            <option value="兴业银行">兴业银行</option>
                                            <option value="平安银行">平安银行</option>
                                            <option value="北京银行">北京银行</option>
                                            <option value="天津银行">天津银行</option>
                                            <option value="上海银行">上海银行</option>
                                            <option value="华夏银行">华夏银行</option>
                                            <option value="光大银行">光大银行</option>
                                            <option value="广发银行">广发银行</option>
                                            <option value="中信银行">中信银行</option>
                                            <option value="上海农商银行">上海农商银行</option>
                                            <option value="农村信用社">农村信用社</option>
                                            <option value="其他">其他</option>
                                        </select>-->
                                    </td>
                                </tr>
                                <tr id='otherbanktr' style='display: none'>
                                    <td>银行名称</td>
                                    <td>
                                        <input class="" id="otherbank" name="otherbank"  Placeholder='' value="" type="text" style="border:1px solid #999">
                                    </td>
                                </tr>
                                <tr>
                                    <td rowspan="2">开户行所在地：</td>
                                    <td>
                                        <select title="" class="sel" id="province" style="height:30px;line-height:18px; padding:2px" id="province" name="province">
                                            <option value="">请选择</option>
                                            <?php foreach ($province as $p){
                                                $selected = $bankinfo && $bankinfo['province_id']==$p['id'] ? 'selected="selected"' : '';	
                                            ?> 
                                            <option value="<?php echo $p['id']?>" <?php echo $selected;?>><?php echo $p['name']?></option>
                                            <?php }?>	
                                        </select>
                                        
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <select class="sel" style="height:30px;line-height:18px; padding:2px" id="city" name="city">
                                            <option value="">请选择</option>
                                        </select>
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
                                    <td>银行卡号：</td>
                                    <td>
                                        <div class="kh" style="display:none;"></div>
                                        <input class="" maxlength="20" id="number" name="number" value="" type="text" style="border:1px solid #999">
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        
                        <script type="text/javascript">
                            $(function() {
                                $(".sbox .inp").click(function() {
                                    $(this).parents(".sbox").children(".s-option").toggleClass("show");
                                });
                                $(".s-option li").click(function() {
                                    $(this).parents(".sbox").children().children(".inp").val($(this).html());
                                    $("#bankCode").val($(this).attr('li_val'));
                                    $(this).parents(".s-option").toggleClass("show");
                                });
                                $("select[name='bank']").change(function(){
                                    if($(this).find('option:selected').text()=="其他")
                                    {
                                        $("#otherbanktr").show();
                                    }
                                    else
                                    {
                                        $("#otherbanktr").hide();
                                        $("#otherbank").val("");
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
                                    if (!$('#province').val()) {
                                        layeralert("请选择开户行所在省份");
                                        return false;
                                    }
                                    if (!$('#province').val()) {
                                        layeralert("请选择开户行所在省份");
                                        return false;
                                    }
                                    if (!$('#city').val()) {
                                        layeralert("请选择开户行所在城市");
                                        return false;
                                    }
                                    if ($('#branch').val() == '') {
                                        layeralert("请输入支行名称");
                                        return false;
                                    }
                                    if ($('#number').val() == '') {
                                        layeralert("请输入正确的卡号");
                                        return false;
                                    }
                                    if($("select[name='bank']").find('option:selected').text()=="其他" && $.trim($("#otherbank").val())=="")
                                    {
                                        layeralert('请输入银行名称');
                                        return false;
                                    }
                                    $.post('<?php echo \App::URL('wap/user/bankinfoveried')?>', $('form').serialize(), function(res) {
                                        if (res.code == 1) {
                                            window.location.reload();
                                        } else {
                                            layeralert(res.msg);
                                        }
                                    }, 'json');
                                });
                            });
                            function getCitys(provinceId){
                                var city_name = $('#city_name').val();
                                $.ajax({
                                    url: "<?php echo \App::URL('wap/user/ajaxregion')?>",
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
                        <input type="hidden" id="province_name" name="province_name" value="">
                        <input type="hidden" id="city_name" name="city_name" value="">
                        
                    </form>
                </div>
                <div style="width:60%;margin: 0 auto">
                    <div id="saveWithdrawBank" class="btn_primary" type="button" class="btn-b">提 交</div>
                </div>
            </div>
        </div>
        <?php }?>    
    </body>
</html>