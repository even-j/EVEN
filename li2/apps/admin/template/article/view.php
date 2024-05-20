<!--include file "admin_include.php"-->
    
<div class="container clearfix">
    <div class="main-wrap">
        <!--include file "admin_nav.php"-->
         <div class="search-wrap">
            <div class="search-content">
                <form action="/index.php" method="get">
                    <input type="hidden" name="app" value="admin" >
                    <input type="hidden" name="mod" value="article" >
                    <input type="hidden" name="ac" value="view" >
                    <table class="search-tab">
                        <tr>
                            <th width="50">标题: </th>
                            <td><input class="common-text" placeholder="标题" name="title" value="<?php echo empty($_GET['title'])?'':$_GET['title']?>" id="" type="text"></td>
                            
                            <th width="50">栏目: </th>
                            <td>
                            	 <select name="pid"  class="common-select required mr10">
                                    <option value="0">全部</option>
                                    <?php foreach ($cateList as $cate){?>
                                    <option value="<?php echo $cate['id']?>" <?php if(isset($_GET['pid']) && $_GET['pid']==$cate['id']) {echo 'selected="selected"';}?> ><?php echo $cate['name'];?></option>
                                    	<?php if(!empty($cate['child'])){?>
											<?php foreach ($cate['child'] as $child){?>
											<option value="<?php echo $child['id'];?>" <?php if(isset($_GET['pid']) && $_GET['pid']==$child['id']) {echo 'selected="selected"';}?>>—<?php echo $child['name'];?></option>
											<?php }?>
										<?php }?>
                                    <?php }?>
                                </select>
                            </td>
                            
                            <th width="50">分类: </th>
                            <td>
                            	 <select name="flag"  class="common-select required mr10">
                                    <option value="">全部</option>
                                    <?php foreach ($flagArr as $key=>$val){?>
                                    <option value="<?php echo $key;?>" <?php if(isset($_GET['flag']) && $_GET['flag']==$key) {echo 'selected="selected"';}?> ><?php echo $val;?></option>
                                    <?php }?>
                                </select>
                            </td>
                            
                            <th width="80">状态: </th>
                            <td>
                                <select name="status"  class="common-select required mr10" style="width:120px;">
                                    <option value="" selected>全部</option>
                                    <option value="1" <?php if(isset($_GET['status']) && $_GET['status']=='1' ) {echo 'selected="selected"';}?> >已发布</option>
                                    <option value="2" <?php if(isset($_GET['status']) && $_GET['status']=='2' ) {echo 'selected="selected"';}?>>草稿</option>
                                    <option value="3" <?php if(isset($_GET['status']) && $_GET['status']=='3' ) {echo 'selected="selected"';}?>>等待审核</option>
                                </select>
                            </td>
                            <td><input class="btn btn-primary btn10" name="sub" value="查询" type="submit"></td>
                        </tr>
                    </table>
                </form>
            </div>
        </div>
        
        <div class="result-wrap">
        	<span></span>
              <div class="result-title">
                    <div class="result-list">
                     	<a href="/index.php?app=admin&mod=article&ac=add" target="mainFrame"><i class="icon-font"></i>添加文章</a>
                    	<a id="updateOrd" href="javascript:void(0)"><i class="icon-font"></i>更新排序</a>
                        <a id="batchDel" href="javascript:void(0)"><i class="icon-font"></i>批量删除</a>
                    </div>
                </div>
                <div class="result-content">
                    <table class="result-tab" width="100%">
                        <tr>
                           <th class="tc" width="5%"><input class="allChoose" name="" type="checkbox"></th>
                            <th style="width:5%;">排序</th>
                             <th style="width:5%;">ID</th>
                        	<th style="width:10%;">栏目</th>
                            <th style="width:25%;">标题</th>
                            <th style="width:10%;">发布者</th>
                            <th style="width:15%;">添加时间</th>
                            <th style="width:10%;">状态</th>
                            <th style="width:15%;">操作</th>
                        </tr>
                        <?php foreach ($dataList as $data){?>
                        <tr>
                        	<td class="tc"><input name="id[]" value="<?php echo $data['id'];?>" type="checkbox"></td>
                        	<td><input name="ids[]" value="<?php echo $data['id'];?>" type="hidden"><input class="common-input sort-input" name="order[]" onkeyup="this.value=this.value.replace(/\D/g,'')" onafterpaste="this.value=this.value.replace(/\D/g,'')" value="<?php echo $data['order'];?>" type="text"></td>
                        	<td><?php echo $data['id'];?></td>
                        	<td><?php echo $data['cate']['name'];?></td>
                            <td><?php echo $data['title'];?> <?php echo $data['flag'];?></td>
                            <td><?php echo $data['user']['real_name'];?></td>
                            <td><?php echo date('Y-m-d H:i:s',$data['addtime']);?></td>
                            <td><?php echo $data['o_status'];?></td>
                            <td>
                                <a class="link-update" href="/index.php?app=admin&mod=article&ac=edit&id=<?php echo $data['id'];?>" target="mainFrame">修改</a>
                                <a class="link-del" href="javascript:delArticle('/index.php?app=admin&mod=article&ac=del&id=<?php echo $data['id'];?>');">删除</a>
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

$(document).ready(function(){
	//批量选中
	$('.allChoose').bind('click',function(){
		if($(this).attr("checked")){
			$('.result-tab input[type=checkbox][name=id[]]').each(function(){
				$(this).attr("checked",'true');
			});
		}else{
			$('.result-tab input[type=checkbox][name=id[]]').each(function(){
				$(this).removeAttr("checked");
			});
		}
	});

	//批量更新排序
	$('#updateOrd').bind('click',function(){
		var ids = '',order = '';
		$('.result-tab input[type=hidden][name=ids[]]').each(function(){
			ids+= $(this).val()+',';
		});

		$('.result-tab input[type=text][name=order[]]').each(function(){
			order+= $(this).val()+',';
		});

		$.ajax({ 
	           type: "post", 
               url: "/index.php?app=admin&mod=article&ac=ajaxSort", 
               data:{
                   'ids':ids,'order':order
               },
               dataType: "json", 
               success: function (data) { 
            	   if(data.code){
					   location.reload();
            	   }else{
            		   layer.msg(data.msg);	
            	   }
               }, 
               error: function (XMLHttpRequest, textStatus, errorThrown) { 
            	   if(XMLHttpRequest.status==200){
                	   layer.msg('你没有操作权限');
                   }else{
                	   layer.msg(textStatus+' '+errorThrown);
                   }
               } 
	      });
        
		
	});
	
	//批量删除
	$('#batchDel').bind('click',function(){
		var id = '';
		$('.result-tab input[type=checkbox][name=id[]]').each(function(){
			if($(this).attr("checked") && $(this).val()!='on'){
				id+= $(this).val()+',';
			}
		});
		if(id==''){
			layer.msg('请选中要删除的选项');
		}else{
			if(confirm('您是否确定要执行批量删除操作？删除后不可恢复')){
				$.ajax({ 
			           type: "post", 
		               url: "/index.php?app=admin&mod=article&ac=ajaxDel", 
		               data:{
		                   'id':id
		               },
		               dataType: "json", 
		               success: function (data) { 
		            	   if(data.code){
							   location.reload();
		            	   }else{
		            		   layer.msg(data.msg);	
		            	   }
		               }, 
		               error: function (XMLHttpRequest, textStatus, errorThrown) { 
		            	   if(XMLHttpRequest.status==200){
		                	   layer.msg('你没有操作权限');
		                   }else{
		                	   layer.msg(textStatus+' '+errorThrown);
		                   }
		               } 
			      });
			}
		}
		
	});
	
});

	function delArticle(url){
		if(confirm('您是否要删除该篇文章吗？删除后不可恢复')){
			location.href = url;
		}
	}
	
</script>
<!--include file "admin_bottom.php"-->