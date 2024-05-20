<!--include file "admin_include.php"-->
<link rel="stylesheet" href="/public/kindeditor/themes/default/default.css" />
<script charset="utf-8" src="/public/kindeditor/kindeditor.js"></script>
<script charset="utf-8" src="/public/kindeditor/lang/zh_CN.js"></script>
<script>
	KindEditor.ready(function(K) {
		var editor = K.editor({
			allowFileManager : true
		});
		K('#image1').click(function() {
			editor.loadPlugin('image', function() {
				editor.plugin.imageDialog({
					imageUrl : K('#site_logo').val(),
					clickFn : function(url, title, width, height, border, align) {
						K('#site_logo').val(url);
						editor.hideDialog();
					}
				});
			});
		});

		K('#image2').click(function() {
			editor.loadPlugin('image', function() {
				editor.plugin.imageDialog({
					imageUrl : K('#site_weixin').val(),
					clickFn : function(url, title, width, height, border, align) {
						K('#site_weixin').val(url);
						editor.hideDialog();
					}
				});
			});
		});

	});
</script>

<div class="container clearfix">
    <div class="main-wrap">
        <!--include file "admin_nav.php"-->
        <div class="result-wrap">
        	<?php if($navList){?>
        	<div class="toolbar-wrap mb10 pl10 nav_bg">
	            <div class="toolbar-item">
	                <i class="icon-font"></i> 
	                <?php foreach ($navList as $nav){?>
	                <a href="/index.php?app=admin&mod=system&ac=view&type=<?php echo $nav['id'];?>" <?php if($type!=$nav['id']){?>class="gray9"<?php }?>><?php echo $nav['name'];?></a>&nbsp;&nbsp;|&nbsp;&nbsp;
	                <?php }?>
	            </div>
	        </div>
        	<?php }?>
        	
        	<?php if($type==1){?>
            <form action="/index.php?app=admin&mod=system&ac=doSiteBase" method="post" id="myform" name="myform">
                <div class="config-items">
                    <div class="config-title">
                        <h1><i class="icon-font">&#xe00a;</i>网站基本设置</h1>
                    </div>
                    <div class="result-content">
                        <table width="100%" class="insert-tab">
                            <tbody>
                            	 <tr>
	                                <th width="15%"><i class="require-red">*</i>网站名称：</th>
	                                <td><input type="text" id="site_name" placeholder="网站名称" value="<?php if(isset($site_base) && $site_base['site_name']){echo $site_base['site_name'];};?>" size="65" name="site_name" class="common-text">
									 <i class="tip left pd10"></i>
                                    </td>
	                            </tr>
	                             <tr>
	                                <th width="15%"><i class="require-red">*</i>网站Logo：</th>
	                                <td><input type="text" id="site_logo" placeholder="网站Logo" value="<?php if(isset($site_base) && $site_base['site_logo']){echo $site_base['site_logo'];};?>" size="57" name="site_logo" class="common-text"> <input type="button" id="image1" value="上传Logo" />
									 <i class="tip left pd10">图片大小：310*71</i>
                                    </td>
	                            </tr>
	                            
	                             <tr>
	                                <th width="15%"><i class="require-red">*</i>微信二维码：</th>
	                                <td><input type="text" id="site_weixin" placeholder="微信二维码" value="<?php if(isset($site_base) && isset($site_base['site_weixin'])){echo $site_base['site_weixin'];};?>" size="57" name="site_weixin" class="common-text"> <input type="button" id="image2" value="上传二维码" />
									 <i class="tip left pd10">图片大小：260*298</i>
                                    </td>
	                            </tr>
	
	                            <tr>
	                                <th width="15%"><i class="require-red">*</i>网站域名：</th>
	                                <td><input type="text" id="site_url" placeholder="例如：<?php echo DOMAIN;?>" value="<?php if(isset($site_base) && $site_base['site_url']){echo $site_base['site_url'];};?>" size="65" name="site_url" class="common-text">
									 <i class="tip left pd10"></i>
                                    </td>
	                            </tr>
                                    <tr>
                                    <th><i class="require-red">*</i>在线客服地址：</th>
                                    <td><input type="text" id="site_service_url" placeholder="在线客服地址" value="<?php if(isset($site_base) && $site_base['site_service_url']){echo $site_base['site_service_url'];};?>" size="65" name="site_service_url" class="common-text">
									 <i class="tip left pd10"></i>
                                    </td>
                                </tr>
                                <tr>
                                    <th>在线客服脚本：</th>
                                    <td>
                                        <textarea id="site_service_script" name="site_service_script" class="common-textarea required" style="width:600px;height:80px;"><?php if(isset($site_base) && $site_base['site_service_script']){echo $site_base['site_service_script'];};?></textarea>
                                        <i class="tip left pd10"></i>
                                    </td>
                                </tr>
	                            <tr>
                                    <th><i class="require-red">*</i>客服电话：</th>
                                    <td><input type="text" id="site_phone" placeholder="客服电话" value="<?php if(isset($site_base) && $site_base['site_phone']){echo $site_base['site_phone'];};?>" size="65" name="site_phone" class="common-text">
									 <i class="tip left pd10"></i>
                                    </td>
                                </tr>
                               
                                 <tr>
                                    <th><i class="require-red">*</i>企业QQ：</th>
                                    <td><input type="text" id="site_qq" placeholder="企业QQ" onkeyup="this.value=this.value.replace(/\D/g,'')" onafterpaste="this.value=this.value.replace(/\D/g,'')" value="<?php if(isset($site_base) && $site_base['site_qq']){echo $site_base['site_qq'];};?>"  size="65" name="site_qq" class="common-text">
                                    <i class="tip left pd10"></i>
                                    </td>
                                </tr>
                                 <tr>
                                    <th><i class="require-red">*</i>站点标题：</th>
                                    <td><input type="text" id="site_title" placeholder="网站标题" value="<?php if(isset($site_base) && $site_base['site_title']){echo $site_base['site_title'];};?>" size="65" name="site_title" class="common-text">
									<i class="tip left pd10"></i>
                                    </td>
                                </tr>
                                <tr>
                                    <th><i class="require-red">*</i>站点关键字：</th>
                                    <td><input type="text" id="site_keywords" placeholder="网站关键词" value="<?php if(isset($site_base) && $site_base['site_keywords']){echo $site_base['site_keywords'];};?>"  size="65" name="site_keywords" class="common-text">
									<i class="tip left pd10"></i>
                                    </td>
                                </tr>
                               
                                <tr>
                                    <th><i class="require-red">*</i>站点描述：</th>
                                    <td><input type="text" id="site_description" placeholder="网站描述" value="<?php if(isset($site_base) && $site_base['site_description']){echo $site_base['site_description'];};?>"  size="65" name="site_description" class="common-text"> 
                                    <i class="tip left pd10"></i></td>
                                </tr>
                                <tr>
                                    <th><i class="require-red">*</i>底部版权信息：</th>
                                    <td>
                                        <textarea id="site_copyright" name="site_copyright" class="common-textarea required" style="width:600px;height:80px;"><?php if(isset($site_base) && $site_base['site_copyright']){echo $site_base['site_copyright'];};?></textarea>
                                        <i class="tip left pd10"></i>
                                    </td>
                                </tr>
                                <tr>
                                    <th><i class="require-red">*</i>介绍人佣金比例（百分比）：</th>
                                    <td><input type="text" id="jsryj_per" placeholder="" value="<?php if(isset($site_base) && $site_base['jsryj_per']){echo $site_base['jsryj_per'];};?>"  size="65" name="jsryj_per" class="common-text"> 
                                    <i class="tip left pd10"></i></td>
                                </tr>
<!--                                <tr>
                                    <th><i class="require-red">*</i>充值赠送管理费（%）：</th>
                                    <td><input type="text" id="recharge_send_per" placeholder="充值金额的百分比" value="<?php if(isset($site_base) && $site_base['recharge_send_per']){echo $site_base['recharge_send_per'];};?>"  size="65" name="recharge_send_per" class="common-text"> 
                                    <i class="tip left pd10"></i></td>
                                </tr>
                                <tr>
                                    <th><i class="require-red">*</i>充值赠送最高（元）：</th>
                                    <td><input type="text" id="recharge_send_max" placeholder="按百分比计算，如果超过最高值，只送最高值的金额" value="<?php if(isset($site_base) && $site_base['recharge_send_max']){echo $site_base['recharge_send_max'];};?>"  size="65" name="recharge_send_max" class="common-text"> 
                                    <i class="tip left pd10"></i></td>
                                </tr>-->
                                <tr>
                                    <th></th>
                                    <td>
                                        <input type="submit" value="提交" class="btn btn-primary btn6 mr10">
                                        <input type="button" value="返回" onClick="history.go(-1)" class="btn btn6">
                                    </td>
                                </tr>
                            </tbody></table>
                    </div>
                </div>
                </form>
                <?php }?>
                <?php if($type==2){?>
           		 <form action="/index.php?app=admin&mod=system&ac=doPay" method="post" id="myform2" name="myform">
                <div class="config-items">
                    <div class="config-title">
                        <h1><i class="icon-font">&#xe00a;</i>支付接口设置</h1>
                    </div>
                    <div style="margin:20px">
                        <fieldset>
                            <legend>在线支付</legend>
                            <input type="radio" value="yeepay" name="pay_bus" <?php if(isset($site_pay) && $site_pay['pay_bus'] == 'yeepay'){echo 'checked="checked"' ;}?>>易宝支付&nbsp;&nbsp;&nbsp;&nbsp;
                            <input type="radio" value="ddbill" name="pay_bus" <?php if(isset($site_pay) && $site_pay['pay_bus'] == 'ddbill'){echo 'checked="checked"' ;}?>>多得宝 
                        </fieldset>
                    </div>
                    <div style="margin:20px">
                        <fieldset>
                            <legend>微信支付</legend>
                            <input type="radio" value="ddbill" name="pay_bus_wx" <?php if(isset($site_pay) && $site_pay['pay_bus_wx'] == 'ddbill'){echo 'checked="checked"' ;}?>>多得宝&nbsp;&nbsp;&nbsp;&nbsp;
                            <input type="radio" value="mbupay" name="pay_bus_wx" <?php if(isset($site_pay) && $site_pay['pay_bus_wx'] == 'mbupay'){echo 'checked="checked"' ;}?>>中信 
                        </fieldset>
                    </div>
                    <div style="margin:20px">
                        <fieldset>
                            <legend>支付宝支付</legend>
                            <input type="radio" value="ddbill" name="pay_bus_zfb" <?php if(isset($site_pay) && $site_pay['pay_bus_zfb'] == 'ddbill'){echo 'checked="checked"' ;}?>>多得宝&nbsp;&nbsp;&nbsp;&nbsp;
                            <input type="radio" value="mbupay" name="pay_bus_zfb" <?php if(isset($site_pay) && $site_pay['pay_bus_zfb'] == 'mbupay'){echo 'checked="checked"' ;}?>>中信 
                        </fieldset>
                    </div>
                    <div class="result-content" style="display: none">
                        <table width="100%" class="insert-tab">
                        	
                       	 <tr>
                                    <th><i class="require-red">*</i>支付名称：</th>
                                    <td><input type="text" id="pay_name" placeholder="支付名称" value="<?php if(isset($site_pay) && $site_pay['pay_name']){echo $site_pay['pay_name'];};?>"  size="65" name="pay_name" class="common-text">
									<i class="tip left pd10"></i>
                                    </td>
                              </tr>
                            <tr>
                                <th width="15%"><i class="require-red">*</i>是否开启：</th>
                                <td><input type="radio" <?php if(isset($site_pay) && $site_pay['pay_start']){echo 'checked="checked"' ;}?> value="1" name="pay_start">开启&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" <?php if(isset($site_pay) && !$site_pay['pay_start']){echo 'checked="checked"' ;}?> value="0" name="pay_start">关闭 
                                 <i class="tip left pd10"></i>
                                </td>
                            </tr>
                             <tr>
                                    <th><i class="require-red">*</i>商户号：</th>
                                    <td><input type="text" id="pay_id" placeholder="商户号" value="<?php if(isset($site_pay) && $site_pay['pay_id']){echo $site_pay['pay_id'];};?>"  size="65" name=pay_id class="common-text">
									<i class="tip left pd10"></i>
                                    </td>
                              </tr>
                                <tr>
                                    <th><i class="require-red">*</i>商户密钥：</th>
                                    <td><input type="text" id="pay_key" placeholder="商户密钥" value="<?php if(isset($site_pay) && $site_pay['pay_key']){echo $site_pay['pay_key'];};?>"  size="65" name=pay_key class="common-text">
									<i class="tip left pd10"></i>
                                    </td>
                              </tr>
  
                        </table>
                    </div>
                    
                    <input type="submit" value="提交" class="btn btn-primary btn6 mr10">
                    <input type="button" value="返回" onClick="history.go(-1)" class="btn btn6">
                </div>
            	</form>
                <?php }?>
                
                <?php if($type==3){?>
           		 <form action="/index.php?app=admin&mod=system&ac=doSms" method="post" id="myform3" name="myform">
                <div class="config-items">
                    <div class="config-title">
                        <h1><i class="icon-font">&#xe00a;</i>短信接口设置(云片网yunpian.com)</h1>
                    </div>
                    <div class="result-content">
                        <table width="100%" class="insert-tab">
                            <tr>
                                <th width="15%"><i class="require-red">*</i>短信接口APIKEY：</th>
                                <td><input type="text" id="mid" placeholder="短信接口mid" value="<?php if(isset($site_sms) && $site_sms['mid']){echo $site_sms['mid'];};?>" size="85" name="mid" class="common-text">  <i class="tip left pd10"></i></td>
                            </tr>
                              <tr>
                                <th width="15%"><i class="require-red">*</i>短信接口API_SECRET：</th>
                                <td><input type="password" id="mpass" placeholder="短信接口pass" value="<?php if(isset($site_sms) && $site_sms['mpass']){echo $site_sms['mpass'];};?>" size="85" name="mpass" class="common-text">  <i class="tip left pd10"></i> 
                                    <!--<br/>如要修改密码请点 <a href="http://self.zucp.net/default.htm">修改密码</a>-->
                                </td>
                            </tr>
                             <tr>
                                <th width="15%"><i class="require-red">*</i>短信签名：</th>
                                <td><input type="text" id="mqianming" placeholder="短信签名" value="<?php if(isset($site_sms) && $site_sms['mqianming']){echo $site_sms['mqianming'];}else{echo '【'.SITE_NAME.'】';}?>" size="85" name="mqianming" class="common-text"> 格式为: <font color="red">【你的签名】</font> <br/>
                                <a href="javascript:void(0);" onclick="show('短信接口测试','/index.php?app=admin&mod=user&ac=telmsg');">短信接口测试</a>
                                </td>
                            </tr>
                         	
                         	<!--<tr>
                                <th width="15%"><i class="require-red">*</i>短信信息：</th>
                                <td><span><b style='color:#ff0000'>短信测试失败</b>，失败原因：短信账户或者密码不能为空!</span></td>
                            </tr>-->

                                <tr>
                                    <th></th>
                                    <td>
                                        <input type="submit" value="提交" class="btn btn-primary btn6 mr10">
                                        <input type="button" value="返回" onClick="history.go(-1)" class="btn btn6">
                                    </td>
                                </tr>
                        </table>
                    </div>
                </div>
            	</form>
                <?php }?>
                
        </div>
    </div>
    <!--/main-->
</div>

<script type="text/javascript">
<!--
$(document).ready(function(){
	//网站基本设置
	$('#myform').submit(function(){
		var site_name = $('#site_name').val();
		var site_logo = $('#site_logo').val();
		var site_url = $('#site_url').val();
		var site_phone = $('#site_phone').val();
		var site_qq = $('#site_qq').val();
		var site_title = $('#site_title').val();
		var site_keywords = $('#site_keywords').val();
		var site_description = $('#site_description').val();
		var site_copyright = $('#site_copyright').val();
		
		if(site_name==""){
			$('#site_name').next().html('请输入网站名称！');
			$('#site_name').focus();
			return false;
		}else{
			$('#site_name').next().html('');
		}
		if(site_logo==""){
			$('#site_logo').next().next().html('请上传网站logo图片！');
			$('#site_logo').focus();
			return false;
		}else{
			$('#site_logo').next().next().html('');
		}

		if(site_url==""){
			$('#site_url').next().html('请输入网站域名！');
			$('#site_url').focus();
			return false;
		}else{
			$('#site_url').next().html('');
		}

		if(site_phone==""){
			$('#site_phone').next().html('请输入客服电话！');
			$('#site_phone').focus();
			return false;
		}else{
			$('#site_phone').next().html('');
		}

		if(site_qq==""){
			$('#site_qq').next().html('请输入企业QQ！');
			$('#site_qq').focus();
			return false;
		}else{
			$('#site_qq').next().html('');
		}

		if(site_title==""){
			$('#site_title').next().html('请输入站点标题！');
			$('#site_title').focus();
			return false;
		}else{
			$('#site_title').next().html('');
		}

		if(site_keywords==""){
			$('#site_keywords').next().html('请输入站点关键词！');
			$('#site_keywords').focus();
			return false;
		}else{
			$('#site_keywords').next().html('');
		}
		if(site_description==""){
			$('#site_description').next().html('请输入站点描述！');
			$('#site_description').focus();
			return false;
		}else{
			$('#site_qq').next().html('');
		}
		if(site_copyright==""){
			$('#site_copyright').next().html('请输入底部版权信息！');
			$('#site_copyright').focus();
			return false;
		}else{
			$('#site_copyright').next().html('');
		}
		return true;
	});

	//支付接口设置
	$('#myform2').submit(function(){
		var pay_name = $('#pay_name').val();
		var pay_id = $('#pay_id').val();
		var pay_key = $('#pay_key').val();
		
		/*if(pay_name==""){
			$('#pay_name').next().html('请输入支付名称！');
			$('#pay_name').focus();
			return false;
		}else{
			$('#pay_name').next().html('');
		}

		if(pay_id==""){
			$('#pay_id').next().html('请输入商户号！');
			$('#pay_id').focus();
			return false;
		}else{
			$('#pay_id').next().html('');
		}

		if(pay_key==""){
			$('#pay_key').next().html('请输入商户密钥！');
			$('#pay_key').focus();
			return false;
		}else{
			$('#pay_key').next().html('');
		}*/

		return true;

	});
	
	//短信接口设置
	$('#myform3').submit(function(){
		var mid = $('#mid').val();
		var mpass = $('#mpass').val();
		var mqianming = $('#mqianming').val();
		
		if(mid==""){
			$('#mid').next().html('请输入短信接口mid！');
			$('#mid').focus();
			return false;
		}else{
			$('#mid').next().html('');
		}

		if(mpass==""){
			$('#mpass').next().html('请输入短信接口pass！');
			$('#mpass').focus();
			return false;
		}else{
			$('#mpass').next().html('');
		}

		if(mid==""){
			$('#mid').next().html('请输入短信接口mid！');
			$('#mid').focus();
			return false;
		}else{
			$('#mid').next().html('');
		}

		return true;

	});
});
//-->
</script>
<!--include file "admin_bottom.php"-->