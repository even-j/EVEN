<!--include file "admin_include.php"-->
<div class="container clearfix">
    <div class="main-wrap">
       <!--include file "admin_nav.php"-->
      
        <div class="result-wrap">
        		 <div class="toolbar-wrap mb10">
		            <div class="toolbar-item">
		                <a href="/index.php?app=admin&mod=admin&ac=add"><i class="icon-font"></i> 添加管理员</a>
		                <!--<a id="batchDel" href="javascript:void(0)"><i class="icon-font"></i>批量删除</a>
		                <a id="updateOrd" href="javascript:void(0)"><i class="icon-font"></i>更新排序</a>-->
		            </div>
		        </div>
                <div id="div_content" class="result-content" style="width:100%;overflow: auto">
                    <table class="result-tab" style="width:100%" >
                        <tr>
                            <th style="width:60px">管理员ID</th>
                            <th style="width:120px">真实姓名</th>
                            <th style="width:120px">用户名</th>
                            <th style="width:120px">用户角色</th>
                            <th style="width:120px">手机号码</th>
                            <th style="width:120px">添加时间</th>
                            <th style="width:120px">添加IP</th>
                            <th style="width:120px">操作</th>
                        </tr>
                        <?php foreach ($list as $item){?>
                            <tr>
                                <td><?php echo $item['admin_id'];?></td>
                                <td><?php echo empty($item['real_name']) ? '未知' : $item['real_name'];?></td>
                                <td><?php echo $item['user_name']; ?></td>
                                <td><?php echo $item['role']['name']; ?></td>
                                <td><?php echo $item['mobile'] ? $item['mobile'] : '----'; ?></td>
                                <td><?php echo empty($item['addtime']) ? '未知':date('Y-m-d H:i',$item['addtime']); ?></td>
                                 <td><?php echo $item['lastip'] ?></td>
                                <td align="center">
                                    <a class="link-update" href="/index.php?app=admin&mod=admin&ac=edit&admin_id=<?php echo $item['admin_id'];?>">修改</a>
                                    &nbsp;&nbsp;<a class="link-del" href="javascript:delAdmin('/index.php?app=admin&mod=admin&ac=del&admin_id=','<?php echo $item['admin_id'];?>');">删除</a>
                                </td>
                            </tr>
                        <?php }?>             
                    </table>
                    
                </div>
        </div>
       <div class="list-page"><?php echo $pager;?></div>
    </div>
    
    <!--/main-->
</div>
<script type="text/javascript">
<!--
	function delAdmin(url,id){
		if(id==2){
			layer.msg('创始人不能删！');
			return;
		}
		url = url+id;
		if(confirm('您是否要删除该管理员？')){
			location.href = url;
		}
	}
	
//-->
</script>
<!--include file "admin_bottom.php"-->