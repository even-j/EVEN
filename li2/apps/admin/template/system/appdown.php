<!--include file "admin_include.php"-->
<link rel="stylesheet" href="/public/kindeditor/themes/default/default.css" />
<script charset="utf-8" src="/public/kindeditor/kindeditor.js"></script>
<script charset="utf-8" src="/public/kindeditor/lang/zh_CN.js"></script>
<script>
	KindEditor.ready(function(K) {
            var editor = K.editor({
                allowFileManager : true
            });
            
        });
</script>

<div class="container clearfix">
    <div class="main-wrap">
        <!--include file "admin_nav.php"-->
        <div class="result-wrap">
            <form action="/index.php?app=admin&mod=system&ac=doappdown" method="post" id="myform" name="myform">
                <div class="config-items">
                    <div class="result-content">
                        <table width="100%" class="insert-tab">
                            <tbody>
                                <tr>
                                    <th width="15%">是否开启自己下载页面：</th>
                                    <td width="85%">
                                        <select name="isdownapp" id="status">
                                            <option value="" ></option>
                                            <option value="off" <?php if($params_appdown['isdownapp']=='off'){ ?>selected=true<?php }?>>禁用</option>
                                            <option value="on" <?php if($params_appdown['isdownapp']=='on'){ ?>selected=true<?php }?>>启用</option>
                                        </select>
                                    </td>
                               </tr>
                               <tr>
                                    <th width="15%">下载域名：</th>
                                    <td width="85%">
                                        <input type="text" id="domain" name="domain" value="<?php if(isset($params_appdown['domain'])){echo $params_appdown['domain'];};?>" class="common-text" style="width:80%">
                                    </td>
                               </tr>
                               <tr>
                                    <th width="15%">下载苹果包的账号：</th>
                                    <td width="85%">
                                        <input type="text" id="merchantname" name="merchantname" value="<?php if(isset($params_appdown['merchantname'])){echo $params_appdown['merchantname'];};?>" class="common-text" style="width:80%">
                                    </td>
                               </tr>
                               <tr>
                                    <th width="15%">下载苹果包的秘钥：</th>
                                    <td width="85%">
                                        <input type="text" id="merchantcode" name="merchantcode" value="<?php if(isset($params_appdown['merchantcode'])){echo $params_appdown['merchantcode'];};?>" class="common-text" style="width:80%">
                                    </td>
                               </tr>
                               <tr>
                                    <th width="15%">苹果策略端AKEY：</th>
                                    <td width="85%">
                                        <input type="text" id="ios_site_index" name="ios_site_index" value="<?php if(isset($params_appdown['ios_site_index'])){echo $params_appdown['ios_site_index'];};?>" class="common-text" style="width:80%">
                                    </td>
                               </tr>
                               <tr>
                                    <th width="15%">苹果交易端AKEY：</th>
                                    <td width="85%">
                                        <input type="text" id="ios_trade_index" name="ios_trade_index" value="<?php if(isset($params_appdown['ios_trade_index'])){echo $params_appdown['ios_trade_index'];};?>" class="common-text" style="width:80%">
                                    </td>
                               </tr>
                               <tr>
                                    <th width="15%">安卓策略端下载路径：</th>
                                    <td width="85%">
                                        <input type="text" id="android_site_path" name="android_site_path" value="<?php if(isset($params_appdown['android_site_path'])){echo $params_appdown['android_site_path'];};?>" class="common-text" style="width:80%">
                                    </td>
                               </tr>
                               <tr>
                                    <th width="15%">安卓交易端下载路径：</th>
                                    <td width="85%">
                                        <input type="text" id="android_trade_path" name="android_trade_path" value="<?php if(isset($params_appdown['android_trade_path'])){echo $params_appdown['android_trade_path'];};?>" class="common-text" style="width:80%">
                                    </td>
                               </tr>
                               
                               
                                <tr>
                                    <th></th>
                                    <td>
                                        <input type="submit" value="提交" class="btn btn-primary btn6 mr10">
                                        <input type="button" value="返回" onClick="history.go(-1)" class="btn btn6">
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

<script type="text/javascript">

</script>
<!--include file "admin_bottom.php"-->