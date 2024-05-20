<!--include file "admin_include.php"-->
<div class="container clearfix">
    <div class="main-wrap">
        <div class="crumb-wrap">
            <div class="crumb-list"><i class="icon-font"></i><a href="/index.php?app=admin&mod=index&ac=view" target="_top">首页</a><span class="crumb-step">&gt;</span><a class="crumb-name" href="/index.php?app=admin&mod=admin&ac=view">管理员管理</a><span class="crumb-step">&gt;</span><span><?php echo $nav_title; ?></span></div>
        </div>
        <div class="result-wrap">
            <div class="result-content">
                <form action="/index.php?app=admin&mod=admin&ac=doPay" method="post" onsubmit="return validateForm();" id="myform" name="myform" enctype="multipart/form-data">
                    <input type="hidden" name="uid" value="<?php echo $user['uid']; ?>" />
                    <input type="hidden" id="cur_balance" name="cur_balance" value="<?php echo ($user['balance'] / 100); ?>" />
                    <table class="insert-tab" width="100%">
                        <tbody>
                            <tr>
                                <th width="120">真实姓名：</th>
                                <td><?php echo $user['true_name']; ?></td>
                            </tr>
                            <tr>
                                <th width="120">手机账号：</th>
                                <td><?php echo $user['mobile']; ?></td>
                            </tr>
                            <tr>
                                <th width="120">当前余额：</th>
                                <td><?php echo '¥ ' . number_format(($user['balance'] / 100), 2); ?></td>
                            </tr>
                            <tr>
                                <th width="120">赠送余额：</th>
                                <td><?php echo '¥ ' . number_format(($user['send'] / 100), 2); ?></td>
                            </tr>
                            <tr>
                                <th><i class="require-red">*</i>操作类型：</th>
                                <td>
                                    <select class="common-select required" id="type" name="type" style="width: 430px;" onchange="selchange(this)">
                                        <option value="14">系统充值</option>
                                        <option value="15">系统扣除</option>
                                        <option value="100">赠送管理费</option>
                                        <option value="102">赠送管理费扣除</option>
                                    </select>
                                    <input type="checkbox" id="add_record" name="add_record" checked="true"/>
                                    <label for="add_record" id="lable_add_record">添加到充值</label>
                                    <i class="tip left pd10"></i>
                                </td>
                            </tr>
                            <tr>
                                <th><i class="require-red">*</i>操作金额：</th>
                                <td><input class="common-text required" id="balance" name="balance" size="50" value="" type="text"/> <i class="tip left pd10"></i></td>
                            </tr>

                            <tr>
                                <th></th>
                                <td>
                                    <input class="btn btn-primary btn6 mr10" name="submit" value="提交" type="submit">
                                    <input class="btn btn6" onClick="history.go(-1)" value="返回" type="button">
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    
                </form> 
                
            </div>
        </div>

    </div>
    <!--/main-->
</div>
<script type="text/javascript">
    function validateForm() {
        var balance = $('#balance');
        var cur_balance = parseInt($('#cur_balance').val());
        if (balance.val() == "") {
            balance.next().html('操作金额不能为空');
            return false;
        } else if ($('#type').val() == 15 && parseInt(balance.val()) > cur_balance) {
            balance.next().html(balance.val() + '系统扣除不能超过当前余额' + cur_balance);
            return false;
        }
        return true;
    }


    $("#balance").blur(function () {
        var objExp = /^[1-9](\d+)?\.?\d{0,2}$/;
        this.value = $.trim(this.value);
        if (!objExp.test(this.value)) {
            $(this).next().html('操作金额必须是大于0的正整数');
        } else {
            $(this).next().html('');
        }
    });

    function getCitys(provinceId) {
        var city_name = $('#city_name').val();
        $.ajax({
            url: "/index.php?app=admin&mod=user&ac=ajaxregion",
            dataType: "json",
            data: {
                provinceId: provinceId,
                subLength: 4,
                t: new Date().getTime()
            },
            success: function (data) {
                $("#city").html("");
                var str = " <option value='-1'>请选择</option>";
                $("#city").append(str);
                $.each(data, function (i, temp) {
                    var selected = '';
                    if (city_name == temp.name) {
                        selected = 'selected="selected"';
                    }
                    var str = "<option value='" + temp.id + "' " + selected + ">" + temp.name + "</option>";
                    $("#city").append(str);
                });
            }
        });
    }

    function selchange(obj){
        if($(obj).val() == '14'){
            $("#lable_add_record").html("添加到充值");
            $("#add_record").show();
            $("#lable_add_record").show();
        }
        else if($(obj).val() == '15'){
            $("#lable_add_record").html("添加到提现");
            $("#add_record").show();
            $("#lable_add_record").show();
        }
        else{
            $("#add_record").hide();
            $("#lable_add_record").hide();
        }
    }
</script>
<!--include file "admin_bottom.php"-->