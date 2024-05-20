<!--include file "admin_include.php"-->
<div class="container clearfix">
    <div class="main-wrap">
    	 <div class="crumb-wrap">
            <div class="crumb-list"><i class="icon-font"></i><a href="/index.php?app=admin&mod=index&ac=view" target="_top">首页</a><span class="crumb-step">&gt;</span><a class="crumb-name" href="/index.php?app=admin&mod=user&ac=view">用户管理</a><span class="crumb-step">&gt;</span><span><?php echo $nav_title;?></span></div>
        </div>
        <div class="result-wrap">
            <div class="result-content">
             <form action="/index.php?app=admin&mod=user&ac=dosms" method="post" id="myform" name="myform" onsubmit="return validateForm();" enctype="multipart/form-data">
                <input name="mobile" value="<?php echo $mobile;?>" type="hidden" />
                <table class="insert-tab" width="100%">
                	
                        <tbody>
                        	<tr>
                        		<td colspan="2" style="text-align: center;"><strong>用户短信群发</strong></td>
                        	</tr>
                            <tr>
                                <th><i class="require-red">*</i>群发内容：</th>
                                <td><textarea id="content" name="content" rows="10"></textarea><i class="tip left pl10"></i></td>
                            </tr>
                            
                       		 <tr class="mt20">
                                <th></th>
                                <td>
                                    <input class="btn btn-primary btn6 mr10" name="submit" value="发送" type="submit">
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
	var content = $('#content');
	if (content.val() == "") {
		content.next().html('群发内容不能为空');
		return false;
	}else{
		content.next().html('');
	}
	return true;
}

</script>
<!--include file "admin_bottom.php"-->