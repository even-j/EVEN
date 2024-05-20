<!--include file "admin_include.php"-->
    
<div class="container clearfix">
    <div class="main-wrap">
        <!--include file "admin_nav.php"-->
        <div class="search-wrap">
            <div class="search-content">
                <form action="/index.php" method="get">
                	<input type="hidden" name="app" value="admin" >
                	<input type="hidden" name="mod" value="trade" >
                	<input type="hidden" name="ac" value="view" >
                    <table class="search-tab">
                        <tr>
                            <th width="80">账户类型:</th>
                            <td>
                                <select name="type" id="status" class="common-select">
                                    <option <?php echo $condition['type'] == ''?'selected="selected"':''?> value="">&nbsp;全部&nbsp; </option>
                                    <option <?php echo $condition['type'] == '1'?'selected="selected"':''?> value="1">普通账号</option>
                                    <option <?php echo $condition['type'] == '2'?'selected="selected"':''?> value="2">免费体验账号</option>
                                </select>
                            </td>
                            <th width="80">账户状态:</th>
                            <td>
                                <select name="status" id="status">
                                    <option value="" selected>全部</option>
                                    <?php foreach ($status as $key=>$val){
                                    	$selected = $condition['status']!='' && $key==$condition['status'] ? 'selected="selected"' : '';
                                    ?>
                                    <option value="<?php echo $key;?>" <?php echo $selected;?>><?php echo $val;?></option>
                                    <?php }?>
                                </select>
                            </td>
                            <th width="120">交易账户名:</th>
                            <td><input class="common-text" placeholder="账户名" name="account" value="<?php echo $condition['account'];?>" id="account" type="text"></td>
                            <td><input class="btn btn-primary btn10" name="" value="查询" type="submit"></td>
                        </tr>
                    </table>
                </form>
            </div>
        </div>
        <div class="result-wrap">
        	<span></span>
              <div class="result-title">
                    <div class="result-list">
                        <!--<a id="batchDel" href="javascript:void(0)"><i class="icon-font"></i>批量删除</a>
                        <a id="updateOrd" href="javascript:void(0)"><i class="icon-font"></i>更新排序</a>-->
                         <form action="/index.php?app=admin&mod=trade&ac=tradeAccountUp" method="post" enctype="multipart/form-data">
		                    <table class="search-tab">
		                        <tr>
		                        	<td><a href="/index.php?app=admin&mod=trade&ac=add" target="mainFrame"><i class="icon-font"></i>添加交易账户</a></td>
		                            <th width="100">交易账户导入:</th>
		                            <td><input type="file" class="common-text" name="ufile" id=""></td>
		                            <th width="80"><input class="btn btn-primary btn2" name="sub" value="上传" type="submit"></th>
		                        </tr>
		                    </table>
		                </form>
                    </div>
                </div>
                <div class="result-content">
                    <table class="result-tab" width="100%">
                        <tr>
                            <th style="width:10%;">账户类型</th>
                        	 <th style="width:10%;">母账户</th>
                            <th style="width:20%;">交易账户</th>
                            <th style="width:15%;">账户密码</th>
                             <th style="width:20%;">添加时间</th>
                            <th style="width:15%;">状态</th>
                            <th style="width:10%;">操作</th>
                        </tr>
                        <?php foreach ($dataList as $data){?>
                        <tr>
                            <td><?php echo Model\Trade\Account::getAccountType($data['type']) ;?></td>
                            <td><?php echo $data['parent_account'];?></td>
                            <td><?php echo $data['account'];?></td>
                            <td><?php echo $data['pwd'];?></td>
                            <td><?php echo date('Y-m-d H:i:s',$data['addtime']);?></td>
      						<td><?php echo $data['o_status'];?></td>
                            <td>
                                <a class="link-update" href="/index.php?app=admin&mod=trade&ac=edit&account=<?php echo $data['account'];?>" target="mainFrame">修改</a>
                                <a class="link-del" href="javascript:delAccount('/index.php?app=admin&mod=trade&ac=del&account=<?php echo $data['account'];?>');">删除</a>
                            </td>
                        </tr>
                        <?php }?>
                    </table>
                    <div class="list-page"><?php echo $pager;?></div>
                </div>
        </div>
    </div>
    <!--/main-->
</div>
<script type="text/javascript">
<!--
	function delAccount(url){
		if(confirm('您是否要删除该交易账户吗？')){
			location.href = url;
		}
	}
	
//-->
</script>
<!--include file "admin_bottom.php"-->