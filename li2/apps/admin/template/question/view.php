<!--include file "admin_include.php"-->
    
<div class="container clearfix">
    <div class="main-wrap">
        <!--include file "admin_nav.php"-->
         <div class="search-wrap">
            <div class="search-content">
                <form action="/index.php" method="get">
                    <input type="hidden" name="app" value="admin" >
                    <input type="hidden" name="mod" value="question" >
                    <input type="hidden" name="ac" value="view" >
                    <table class="search-tab">
                        <tr>
                            <th width="62">关键词: </th>
                            <td><input class="common-text" placeholder="关键词" name="keywords" value="<?php echo empty($_GET['keywords'])?'':$_GET['keywords']?>" id="" type="text"></td>
                            <th width="50">分类: </th>
                            <td>
                            	 <select name="typeid"  class="common-select required mr10" style="width:120px;">
                                    <option value="0">全部</option>
                                    <?php foreach ($typeArr as $key=>$val){?>
                                    <option value="<?php echo $key;?>" <?php if(isset($_GET['typeid']) && $_GET['typeid']==$key) {echo 'selected="selected"';}?> ><?php echo $val;?></option>
                                    <?php }?>
                                </select>
                            </td>
                            <th width="50">状态: </th>
                            <td>
                                <select name="status"  class="common-select required mr10" style="width:120px;">
                                    <option value="" selected>全部</option>
                                    <option value="1" <?php if(isset($_GET['status']) && $_GET['status']=='1' ) {echo 'selected="selected"';}?>>待回复</option>
                                    <option value="2" <?php if(isset($_GET['status']) && $_GET['status']=='2' ) {echo 'selected="selected"';}?>>已回复</option>
                                    <option value="3" <?php if(isset($_GET['status']) && $_GET['status']=='3' ) {echo 'selected="selected"';}?>>已解决</option>
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
              <div class="result-keywords">
                    <div class="result-list">
                     	<a href="/index.php?app=admin&mod=question&ac=add&type=wenda" target="mainFrame"><i class="icon-font"></i>添加问答</a>
                    	<!--<a id="updateOrd" href="javascript:void(0)"><i class="icon-font"></i>更新排序</a>
                        <a id="batchDel" href="javascript:void(0)"><i class="icon-font"></i>批量删除</a>-->
                    </div>
                </div>
                <div class="result-content mt10">
                    <table class="result-tab" width="100%">
                        <tr>
                        	<th style="width:5%;">分类</th>
                            <th style="width:30%;">内容</th>
                            <th style="width:10%;">提问者</th>
                            <th style="width:15%;">提问时间</th>
                            <th style="width:15%;">回复时间</th>
                             <th style="width:5%;">浏览量</th>
                            <th style="width:5%;">状态</th>
                            <th style="width:15%;">操作</th>
                        </tr>
                        <?php foreach ($dataList as $data){?>
                        <tr>
                        	<td><?php echo $data['cate_name'];?></td>
                            <td class="pl20" style="text-align:left;"><?php echo \App::msubstr($data['content'],0,26);?></td>
                            <td><?php echo $data['user']['mobile'];?></td>
                            <td><?php echo date('Y-m-d H:i:s',$data['que_time']);?></td>
                            <td><?php echo $data['reply_time'] ? date('Y-m-d H:i:s',$data['reply_time']) : '';?></td>
                            <td><?php echo $data['views'];?></td>
                            <td><?php echo $data['o_status'];?></td>
                            <td>
                            	<a class="link-update" href="/index.php?app=admin&mod=question&ac=add&id=<?php echo $data['que_id'];?>&type=huifu" target="mainFrame">回复</a>
                                <a class="link-update" href="/index.php?app=admin&mod=question&ac=edit&id=<?php echo $data['que_id'];?>" target="mainFrame">修改</a>
                                <a class="link-del" href="javascript:delQuestion('/index.php?app=admin&mod=question&ac=del&id=<?php echo $data['que_id'];?>');">删除</a>
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

	function delQuestion(url){
		if(confirm('您是否要删除该提问吗？删除后不可恢复')){
			location.href = url;
		}
	}
	
</script>
<!--include file "admin_bottom.php"-->