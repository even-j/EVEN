<!--include file "admin_include.php"-->
    
<div class="container clearfix">
    <div class="main-wrap">
        <!--include file "admin_nav.php"-->
        <div class="search-wrap">
            <div class="search-content">
                <form action="/index.php" method="get">
                	<input type="hidden" name="app" value="admin" >
                	<input type="hidden" name="mod" value="ad" >
                	<input type="hidden" name="ac" value="view" >
                    <table class="search-tab">
                        <tr>
                        	<th width="80">广告类型:</th>
                            <td>
                                <select name="type_id" id="type_id">
                                    <option value="">全部</option>
                                    <?php foreach ($ad_type as $key=>$val){
                                    	$selected = $condition['type_id'] && $val['id']==$condition['type_id'] ? 'selected="selected"' : '';
                                    ?>
                                    <option value="<?php echo $val['id'];?>" <?php echo $selected;?>><?php echo $val['type_name'];?></option>
                                    <?php }?>
                                </select>
                            </td>
                            <th width="120">广告标题:</th>
                            <td><input class="common-text" placeholder="名称" name="ad_name" value="<?php echo $condition['ad_name'];?>" id="ad_name" type="text"></td>
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
                        <a href="/index.php?app=admin&mod=ad&ac=add" target="mainFrame"><i class="icon-font"></i>添加广告</a>
                        <!--<a id="batchDel" href="javascript:void(0)"><i class="icon-font"></i>批量删除</a>
                        <a id="updateOrd" href="javascript:void(0)"><i class="icon-font"></i>更新排序</a>-->
                    </div>
                </div>
                <div class="result-content">
                    <table class="result-tab" width="100%">
                        <tr>
                            <th width="120">类型</th>
                            <th>广告名称</th>
                            <th>图片 / 链接</th>
                            <th>添加时间</th>
                            <th>状态</th>
                            <th>操作</th>
                        </tr>
                        <?php foreach ($dataList as $data){?>
                        <tr>
                            <td><?php echo $ad_type[$data['type_id']]['type_name'];?></td>
                            <td><?php echo $data['ad_name'];?></td>
                            <td><?php if($data['ad_pic']){?><img src="<?php echo $data['ad_pic'];?>" width="200" />&nbsp;&nbsp;<?php }?><?php echo $data['ad_pic'];?><br/><?php echo $data['ad_link'];?></td>
                            <td><?php echo date('Y-m-d H:i',$data['addtime']);?></td>
      						<td><?php echo $data['o_status'];?></td>
                            <td>
                                <a class="link-update" href="/index.php?app=admin&mod=ad&ac=edit&id=<?php echo $data['id'];?>" target="mainFrame">修改</a>
                                <a class="link-del" href="javascript:delAd('index.php?app=admin&mod=ad&ac=del&id=<?php echo $data['id'];?>');">删除</a>
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
	function delAd(url){
		if(confirm('您是否要删除该广告？')){
			location.href = url;
		}
	}
	
//-->
</script>
<!--include file "admin_bottom.php"-->