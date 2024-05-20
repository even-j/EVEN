<!--include file "admin_include.php"-->
    
<div class="container clearfix">
    <div class="main-wrap">
        <!--include file "admin_nav.php"-->
        <div class="result-wrap">
        	<span></span>
              <div class="result-title">
                    <div class="result-list">
                        <!--<a id="batchDel" href="javascript:void(0)"><i class="icon-font"></i>批量删除</a>
                        <a id="updateOrd" href="javascript:void(0)"><i class="icon-font"></i>更新排序</a>-->
		                <a href="/index.php?app=admin&mod=role&ac=add" target="mainFrame"><i class="icon-font"></i>添加角色</a>
                    </div>
                </div>
                <div class="result-content">
                    <table class="result-tab" width="100%">
                        <tr>
                        	 <th style="width:20%;">ID</th>
                            <th style="width:20%;">名称</th>
                            <th style="width:20%;">排序</th>
                            <th style="width:20%;">添加时间</th>
                            <th style="width:20%;">操作</th>
                        </tr>
                        <?php foreach ($dataList as $data){?>
                        <tr>
                        	<td><?php echo $data['id'];?></td>
                            <td><?php echo $data['name'];?></td>
                            <td><?php echo $data['order'];?></td>
                            <td><?php echo date('Y-m-d H:i:s',$data['addtime']);?></td>
                            <td>
                                <a class="link-update" href="/index.php?app=admin&mod=role&ac=edit&id=<?php echo $data['id'];?>" target="mainFrame">修改</a>
                                <a class="link-del" href="javascript:delRole('/index.php?app=admin&mod=role&ac=del&id=<?php echo $data['id'];?>');">删除</a>
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
	function delRole(url){
		if(confirm('您是否要删除该角色吗？删除后不可恢复')){
			location.href = url;
		}
	}
	
//-->
</script>
<!--include file "admin_bottom.php"-->