<!--include file "admin_include.php"-->
    
<div class="container clearfix">
    <div class="main-wrap">
        <!--include file "admin_nav.php"-->
        <div class="search-wrap">
            <div class="search-content">
                <form action="/index.php" method="get">
                    <input type="hidden" name="app" value="admin" >
                    <input type="hidden" name="mod" value="articletype" >
                    <input type="hidden" name="ac" value="view" >
                    <table class="search-tab">
                    	  <tr>
                            <th width="80">栏目分类:</th>
                    		 <td><select id="pid" name="pid" style="width: 160px;" class="common-select required">
								<option value="0">根目录</option>
								<?php foreach ($cate_list as $cate){?>
								<option value="<?php echo $cate['id'];?>" <?php if(isset($_GET['pid']) && $_GET['pid']==$cate['id']){ echo 'selected="selected"';}?>><?php echo $cate['name'];?></option>
								<?php }?>
								</select>
						   </td>
                            <th width="80">栏目名称:</th>
                            <td><input class="common-text" placeholder="栏目名称" name="name" value="<?php echo empty($_GET['name'])?'':$_GET['name']?>" id="" type="text"></td>
                          
                            <th width="80">是否单页:</th>
                            <td>
                                <select name="is_page"  class="common-select required mr10" style="width:120px;">
                                    <option value="" selected>全部</option>
                                    <?php foreach ($typeArr as $key=>$type){?>
                                    <option value="<?php echo $key;?>" <?php if(isset($_GET['is_page']) && $_GET['is_page']!='' && $_GET['is_page']==$key ) {echo 'selected="selected"';}?> ><?php echo $type;?></option>
                                    <?php }?>
                                </select>
                            </td>
                            <th width="80">栏目状态:</th>
                            <td>
                                <select name="is_use"  class="common-select required mr10" style="width:120px;">
                                    <option value="" selected>全部</option>
                                    <option value="0" <?php if(isset($_GET['is_use']) && $_GET['is_use']=='0' ) {echo 'selected="selected"';}?> >禁用</option>
                                    <option value="1" <?php if(isset($_GET['is_use']) && $_GET['is_use']=='1' ) {echo 'selected="selected"';}?>>可用</option>
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
                    	<a href="/index.php?app=admin&mod=articletype&ac=add" target="mainFrame"><i class="icon-font"></i>添加栏目</a>
                    	<a id="updateOrd" href="javascript:void(0)"><i class="icon-font"></i>更新排序</a>
                        <a id="batchDel" href="javascript:void(0)"><i class="icon-font"></i>批量删除</a>
                    </div>
                </div>
                <div class="result-content">
                    <table class="result-tab" width="100%">
                        <tr>
                           <th class="tc" width="5%"><input class="allChoose" name="" type="checkbox"></th>
                            <th style="width:10%;">排序</th>
                        	<th style="width:10%;">ID</th>
                            <th style="width:40%;">名称</th>
                            <th style="width:10%;">父栏目</th>
                            <th style="width:10%;">可用</th>
                            <th style="width:15%;">操作</th>
                        </tr>
                        <?php foreach ($dataList as $data){?>
                        <tr>
                        	<td class="tc"><input name="id[]" value="<?php echo $data['id'];?>" type="checkbox"></td>
                        	<td><input name="ids[]" value="<?php echo $data['id'];?>" type="hidden"><input class="common-input sort-input" name="order[]" onkeyup="this.value=this.value.replace(/\D/g,'')" onafterpaste="this.value=this.value.replace(/\D/g,'')" value="<?php echo $data['order'];?>" type="text"></td>
                        	<td><?php echo $data['id'];?></td>
                            <td><?php echo $data['pid']>0 ? '&nbsp;&nbsp;&nbsp;&nbsp;—'.$data['name'] : $data['name'];?></td>
                            <td><?php echo $data['pid']>0 ? '否' : '是';?></td>
                             <td><?php echo $data['is_use'] ? '<span class="green">可用</span>' : '<span class="red">禁用</span>';?></td>
                            <td>
                            	<a class="link-insert" href="/index.php?app=admin&mod=articletype&ac=add&pid=<?php echo $data['id'];?>" target="mainFrame">添加子栏目</a>
                                <a class="link-update" href="/index.php?app=admin&mod=articletype&ac=edit&id=<?php echo $data['id'];?>" target="mainFrame">修改</a>
                                <a class="link-del" href="javascript:delArticleType('/index.php?app=admin&mod=articletype&ac=del&id=<?php echo $data['id'];?>');">删除</a>
                            </td>
                        </tr>
	                        <?php if($data['child']){?>
	                        	<?php foreach ($data['child'] as $child){?>
			                        <tr>
			                        	<td class="tc"><input name="id[]" value="<?php echo $child['id'];?>" type="checkbox"></td>
			                        	<td><input name="ids[]" value="<?php echo $child['id'];?>" type="hidden"><input class="common-input sort-input" name="order[]" onkeyup="this.value=this.value.replace(/\D/g,'')" onafterpaste="this.value=this.value.replace(/\D/g,'')" value="<?php echo $data['order'];?>" type="text"></td>
			                        	<td><?php echo $child['id'];?></td>
			                            <td><?php echo '&nbsp;&nbsp;&nbsp;&nbsp;—'.$child['name'].' ['.$typeArr[$child['is_page']].']';?></td>
			                            <td><?php echo $child['pid']>0 ? '否' : '是';?></td>
			                             <td><?php echo $child['is_use'] ? '<span class="green">可用</span>' : '<span class="red">禁用</span>';?></td>
			                            <td>
			                            	<a class="link-insert" href="/index.php?app=admin&mod=articletype&ac=add&pid=<?php echo $child['id'];?>" target="mainFrame">添加子栏目</a>
			                                <a class="link-update" href="/index.php?app=admin&mod=articletype&ac=edit&id=<?php echo $child['id'];?>" target="mainFrame">修改</a>
			                                <a class="link-del" href="javascript:delArticleType('/index.php?app=admin&mod=articletype&ac=del&id=<?php echo $child['id'];?>');">删除</a>
			                            </td>
			                        </tr>
		                        <?php }?>
	                        <?php }?>
                        <?php }?>
                    </table>
                    <div class="list-page"><?php //echo $pager;?></div>
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
               url: "/index.php?app=admin&mod=articletype&ac=ajaxSort", 
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
		               url: "/index.php?app=admin&mod=articletype&ac=ajaxDel", 
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

	function delArticleType(url){
		if(confirm('您是否要删除该栏目吗？删除后不可恢复')){
			location.href = url;
		}
	}
	

</script>
<!--include file "admin_bottom.php"-->