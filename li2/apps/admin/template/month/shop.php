<!--include file "admin_include.php"-->
    
<div class="container clearfix">
    <div class="main-wrap">
        <!--include file "admin_nav.php"-->
        <div class="search-wrap">
            <div class="search-content">
                <form action="/index.php" method="get">
                    <input type="hidden" name="app" value="admin" >
                    <input type="hidden" name="mod" value="month" >
                    <input type="hidden" name="ac" value="shop" >
                    <table class="search-tab">
                        <tr>
                            <th width="80">商户名称:</th>
                            <td><input class="common-text" placeholder="商户名称" name="shop_name" value="<?php echo empty($_GET['shop_name'])?'':$_GET['shop_name']?>" id="" type="text"></td>
                          	<th width="80">商户状态:</th>
                            <td>
                                <select name="status"  class="common-select required mr10" style="width:120px;">
                                    <option value="" selected>全部</option>
                                    <option value="0" <?php if(isset($_GET['status']) && $_GET['status']=='0' ) {echo 'selected="selected"';}?> >禁用</option>
                                    <option value="1" <?php if(isset($_GET['status']) && $_GET['status']=='1' ) {echo 'selected="selected"';}?>>可用</option>
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
                    	<a href="/index.php?app=admin&mod=month&ac=shopAdd" target="mainFrame"><i class="icon-font"></i>添加商户</a>
                    </div>
                </div>
                <div class="result-content">
                    <table class="result-tab" width="100%">
                        <tr>
                        	<th style="width:5%;">ID</th>
                            <th style="width:10%;">名称</th>
                            <th style="width:10%;">商户户名</th>
                            <th style="width:10%;">开户银行名称</th>
                            <th style="width:15%;">卡号</th>
                            <th style="width:15%;">开户行地址</th>
                            <th style="width:10%;">状态</th>
                            <th style="width:15%;">操作</th>
                        </tr>
                        <?php foreach ($dataList as $data){?>
                        <tr>
                        	<td><?php echo $data['shop_id'];?></td>
                            <td><?php echo $data['shop_name'];?></td>
                            <td><?php echo $data['bank_realname'];?></td>
                            <td><?php echo $data['bank_name'];?></td>
                            <td><?php echo $data['card_no'];?></td>
                            <td><?php echo $data['bank_address'];?></td>
                             <td><?php echo $data['status'] ? '<span class="green">可用</span>' : '<span class="red">禁用</span>';?></td>
                            <td>
                                <a class="link-update" href="/index.php?app=admin&mod=month&ac=shopEdit&id=<?php echo $data['shop_id'];?>" target="mainFrame">修改</a>
                                <a class="link-del" href="javascript:delArticleType('/index.php?app=admin&mod=month&ac=shopDel&id=<?php echo $data['shop_id'];?>');">删除</a>
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