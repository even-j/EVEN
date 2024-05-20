<!--include file "admin_include.php"-->
<link rel="stylesheet" href="/public/kindeditor/themes/default/default.css" />
<script charset="utf-8" src="/public/kindeditor/kindeditor.js"></script>
<script charset="utf-8" src="/public/kindeditor/lang/zh_CN.js"></script>
<script>
	KindEditor.ready(function(K) {
            var editor = K.editor({
                allowFileManager : true
            });
            K('#btn_weixin_path').click(function() {
                editor.loadPlugin('image', function() {
                    editor.plugin.imageDialog({
                        imageUrl: K('#weixin_path').val(),
                        clickFn: function (url, title, width, height, border, align) {
                            K('#weixin_path').val(url);
                            K('#img_weixin_path').attr('src',url);
                            editor.hideDialog();
                        }
                    });
                });
            });
            K('#btn_gzh_path').click(function() {
                editor.loadPlugin('image', function() {
                    editor.plugin.imageDialog({
                        imageUrl: K('#gzh_path').val(),
                        clickFn: function (url, title, width, height, border, align) {
                            K('#gzh_path').val(url);
                            K('#img_gzh_path').attr('src',url);
                            editor.hideDialog();
                        }
                    });
                });
            });
            K('#btn_qq_path').click(function() {
                editor.loadPlugin('image', function() {
                    editor.plugin.imageDialog({
                        imageUrl: K('#qq_path').val(),
                        clickFn: function (url, title, width, height, border, align) {
                            K('#qq_path').val(url);
                            K('#img_qq_path').attr('src',url);
                            editor.hideDialog();
                        }
                    });
                });
            });
            K('#btn_peiziapp_path').click(function() {
                editor.loadPlugin('image', function() {
                    editor.plugin.imageDialog({
                        imageUrl: K('#peiziapp_path').val(),
                        clickFn: function (url, title, width, height, border, align) {
                            K('#peiziapp_path').val(url);
                            K('#img_peiziapp_path').attr('src',url);
                            editor.hideDialog();
                        }
                    });
                });
            });
            K('#btn_tradeapp_path').click(function() {
                editor.loadPlugin('image', function() {
                    editor.plugin.imageDialog({
                        imageUrl: K('#tradeapp_path').val(),
                        clickFn: function (url, title, width, height, border, align) {
                            K('#tradeapp_path').val(url);
                            K('#img_tradeapp_path').attr('src',url);
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
            <form action="/index.php?app=admin&mod=system&ac=doEwmSave" method="post" id="myform" name="myform">
                <div class="config-items">
                    <div class="result-content">
                        <table width="100%" class="insert-tab">
                            <tbody>
                               <tr>
                                    <th width="15%">网站APP：</th>
                                    <td>
                                        <img id="img_peiziapp_path" src="<?php if(isset($params_site_ewm['peiziapp_path'])){echo $params_site_ewm['peiziapp_path'];};?>" width="100" />
                                        <input type="hidden" id="peiziapp_path" name="peiziapp_path" value="<?php if(isset($params_site_ewm['peiziapp_path'])){echo $params_site_ewm['peiziapp_path'];};?>" class="common-text"> 
                                        <input type="button" id="btn_peiziapp_path" value="上传" />
                                        <br/>
                                        <input type="text" id="peiziapp_url" name="peiziapp_url" placeholder="地址" value="<?php if(isset($params_site_ewm['peiziapp_url'])){echo $params_site_ewm['peiziapp_url'];};?>" class="common-text" style="width:90%"> 
                                    </td>
                                    <th width="15%">交易APP：</th>
                                    <td>
                                        <img id="img_tradeapp_path" src="<?php if(isset($params_site_ewm['tradeapp_path'])){echo $params_site_ewm['tradeapp_path'];};?>" width="100" />
                                        <input type="hidden" id="tradeapp_path" name="tradeapp_path" value="<?php if(isset($params_site_ewm['tradeapp_path'])){echo $params_site_ewm['tradeapp_path'];};?>" class="common-text"> 
                                        <input type="button" id="btn_tradeapp_path" value="上传" />
                                        <br/>
                                        <input type="text" id="tradeapp_url" name="tradeapp_url" placeholder="地址" value="<?php if(isset($params_site_ewm['tradeapp_url'])){echo $params_site_ewm['tradeapp_url'];};?>" class="common-text" style="width:90%"> 
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