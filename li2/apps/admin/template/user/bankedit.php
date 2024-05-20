<!--include file "admin_include.php"-->
<div class="container clearfix">
    <div class="main-wrap">
    	 <div class="crumb-wrap">
            <div class="crumb-list"><i class="icon-font"></i><a href="/index.php?app=admin&mod=index&ac=view" target="_top">首页</a><span class="crumb-step">&gt;</span><a class="crumb-name" href="/index.php?app=admin&mod=user&ac=view">用户管理</a><span class="crumb-step">&gt;</span><span><?php echo $nav_title;?></span></div>
        </div>
        <div class="result-wrap">
            <div class="result-content">
             <form action="/index.php?app=admin&mod=user&ac=doBankEdit" method="post" <?php if(!$beizhu){?>onclick="return validateForm();"<?php }?> id="myform" name="myform" enctype="multipart/form-data">
                	<input type="hidden" name="card_id" value="<?php echo $bank_card['card_id'];?>" />
                	<input type="hidden" id="province_name" name="province_name" value="<?php echo $bank_card['province_name'];?>" />
                	<input type="hidden" id="city_name" name="city_name" value="<?php echo $bank_card['city_name'];?>" />
                    <table class="insert-tab" width="100%">
                        <tbody>
                            <tr>
                            <th>开户行：</th>
                            <td><select class="common-select required" name="bank_name" id="bankValue" style="width: 480px;">
                                <option value="-1" selected>请选择</option>
                                <?php foreach ($bankList as $bank){?>	 
                                <option <?php if($bank_card['bank_name'] == $bank['name']){echo 'selected="true"';}?> value="<?php echo $bank['name']?>"><?php echo $bank['name']?></option>
                                <?php }?>	
                                </select>
                                <i class="tip left pd10"></i>
                    </td>
                        </tr>
                         <tr>
                            <th>开户行所在地：</th>
                            <td><select class="common-select required" id="province" name="province_id" style="width: 240px;">
                                    <?php foreach ($province as $p){?>	 
                                    <option <?php if($bank_card['province_id'] == $p['id']){echo 'selected="true"';}?> value="<?php echo $p['id']?>"><?php echo $p['name']?></option>
                                    <?php }?>	
                                </select>
                                 <select class="common-select required" id="city" name="city_id" style="width: 235px;">
                                     <?php if($bank_card['city_id']){?>
                                     <option value="<?php echo $bank_card['city_id'];?>" selected><?php echo $bank_card['city_name'];?></option>
                                     <?php }else{?>
                                    <option <?php if($bank_card['city_id'] == $p['id']){echo 'selected="true"';}?> value="-1" selected>请选择</option>
                                    <?php }?>
                                </select>
                                <i class="tip left pd10"></i>
                            </td>
                        </tr>
                         <tr>
                            <th>银行卡号：</th>
                            <td><input class="common-text required" id="card_no" name="card_no" size="50" value="<?php echo $bank_card['card_no'];?>" type="text" /> <i class="tip left pd10"></i></td>
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
function validateForm(){
    var mobile = $('#mobile');
	var true_name = $('#true_name');
	var id_card = $('#id_card');
	var bankValue = $('#bankValue');
	var city = $('#city');
	var card_no = $('#card_no');
	
   if (mobile.val() == "") {
		mobile.next().html('手机号不能为空');
		return false;
	}else{
		mobile.next().html('');
	}
	 /*if (true_name.val() == "") {
		true_name.next().html('姓名不能为空');
		return false;
	}else{
		true_name.next().html('');
	}

	if (id_card.val() == "") {
		id_card.next().html('身份证号码不能为空');
		return false;
	}else if(!IDCardCheck($.trim(id_card.val()))) {
		$(this).next().html('无效的身份证号码');
		return false;
	}else{
		true_name.next().html('');
	}*/

	/*if($('#is_audit').val()==2){
		if ($('#demo').val() == "") {
			$('#demo').next().html('请填写未通过的原因!');
			return false;
		}else{
			$('#demo').next().html('');
		}
	}
	if(bankValue.val()==-1){
		bankValue.next().html('开户银行不能为空');
		return false;
	}else{
		bankValue.next().html('');
	}
	if (city.val() == -1) {
		city.next().html('请选择城市');
		return false;
	}else{
		city.next().html('');
	}
	
	var objExp = /^[0-9]{16,19}$/;
	if (card_no.val() == "") {
		card_no.next().html('卡号不能为空');
		return false;
	} else if (!objExp.test(card_no.val())) {
		card_no.next().html('卡号输入有误');
		return false;
	}else{
		card_no.next().html('');
	}*/

	return true;
}

$("#bankValue").change(function() {
	var obj = $(this);
	if(obj.val()==-1){
		obj.next().html('开户银行不能为空');
	}else{
		obj.next().html('');
	}
});

$("#province").change(function(){
	var provinceId = $(this).val();
	if (!provinceId) {
		$(this).next().html('请选择省份');
		return;
	}
	$('#province_name').val($(this).find('option:selected').text());
	getCitys(provinceId);
});

if($("#province").val()>0){
	//getCitys($("#province").val());
	$('#province_name').val($("#province").find('option:selected').text());
}

$("#city").change(function() {
	if ($("#city").val() != -1) {
		$('#city_name').val($(this).find('option:selected').text());
	}else{
		$(this).next().html('请选择城市');
	}
});

$('#is_audit').change(function(){
	if($(this).val()==2){
		$('#tr_demo').show();
	}else{
		$('#tr_demo').hide();
	}
}
);



$("#card_no").blur(function() {
	var objExp = /^[0-9]{16,19}$/;
	this.value = $.trim(this.value);
	if ($("#bankCard").val() == "") {
		$(this).next().html('卡号不能为空');
	} else if (!objExp.test(this.value)) {
		$(this).next().html('卡号输入有误');
	}else{
		$(this).next().html('');
	}
});

function getCitys(provinceId){
	var city_name = $('#city_name').val();
	$.ajax({
		url: "/index.php?app=admin&mod=user&ac=ajaxregion",
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
<!--include file "admin_bottom.php"-->