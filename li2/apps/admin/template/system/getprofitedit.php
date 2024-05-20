<!--include file "admin_include.php"-->
<div class="container clearfix">
    <div class="main-wrap">
    	 <div class="crumb-wrap">
            <div class="crumb-list"><i class="icon-font"></i><a href="/index.php?app=admin&mod=index&ac=view" target="_top">首页</a><span class="crumb-step">&gt;</span><a class="crumb-name" href="/index.php?app=admin&mod=finance&ac=rechargeoffline">线下充值</a><span class="crumb-step">&gt;</span><span><?php echo $nav_title;?></span></div>
        </div>
        <div class="result-wrap">
            <div class="result-content">
             <form action="/index.php?app=admin&mod=system&ac=dogetprofitedit" method="post" onclick="return validateForm();" id="myform" name="myform" enctype="multipart/form-data">
                 <input type="hidden" name="id" value="<?php echo $_GET['id']?>" />
                 <table class="insert-tab" width="100%">
                    <tbody>
                        <tr>
                            <th width="120">用户姓名：</th>
                            <td><?php echo $user['true_name'];  ?></td>
                        </tr>
                        <tr>
                            <th>手机号：</th>
                            <td><?php echo $user['mobile'];  ?></td>
                        </tr>
                        <tr>
                            <th><i class="require-red">*</i>金额：</th>
                            <td><input type="text" id="money" name="money" value="<?php echo $row['money']/100 ?>" /><i class="tip left pd10"></i></td>
                        </tr>
                        
                         
                             <tr>
                            <th></th>
                            <td>
                                <?php if($row['status'] == 0){?>
                                <input class="btn btn-primary btn6 mr10" name="submit" value="提交" type="submit">
                                <?php }?>
                                <input class="btn btn6" onClick="goback()" value="返回" type="button">
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
	
	return true;
}
function goback(){
    var url = '/index.php?app=admin&mod=system&ac=getprofit';
    window.location.href = url;
}
</script>
<!--include file "admin_bottom.php"-->