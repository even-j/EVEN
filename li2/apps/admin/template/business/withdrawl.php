<!--include file "admin_include.php"-->
<div class="container clearfix">
    <div class="main-wrap">
    	 <div class="crumb-wrap">
            <div class="crumb-list"><i class="icon-font"></i><a href="/index.php?app=admin&mod=index&ac=view" target="_top">首页</a><span class="crumb-step">&gt;</span><a class="crumb-name" href="/index.php?app=admin&mod=month&ac=fund">资金划拔</a><span class="crumb-step">&gt;</span><span><?php echo $nav_title;?></span></div>
        </div>
        <div class="result-wrap">
            <div class="result-content">
             <form action="/index.php?app=admin&mod=business&ac=doWithdrawl" method="post" onclick="return validateForm();" id="myform" name="myform" enctype="multipart/form-data">
                 <input type="hidden" name="pz_id" value="<?php echo $_GET['pz_id']?>" />
                 <table class="insert-tab" width="100%">
                    <tbody>
                        <tr>
                            <th width="120">保证金(元)：</th>
                            <td><input type="text" name="money" value="<?php echo $pz_row['bond_init']/100  ?>" /> 
                                <input type="hidden" name="pz_id" value="<?php echo $pz_row['pz_id']  ?>"/>
                            </td>
                        </tr>
                        <tr>
                            <th></th>
                            <td>
                                <?php if(1){?>
                                <input class="btn btn-primary btn6 mr10" name="submit" value="申请提现" type="submit">
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
    var url = '/index.php?app=admin&mod=month&ac=fund';
    window.location.href = url;
}
</script>
<!--include file "admin_bottom.php"-->