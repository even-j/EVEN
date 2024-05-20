<!DOCTYPE HTML>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php if(isset($title)) echo $title.'_'?><?php echo SITE_NAME;?>—后台管理</title>
<link rel="stylesheet" type="text/css" href="/public/admin/css/common.css?v=201812202"/>
<link rel="stylesheet" type="text/css" href="/public/admin/css/main.css?v=5"/>
<script type="text/javascript" src="/public/admin/js/jquery-1.7.1.min.js"></script>
<script type="text/javascript" src="/public/admin/js/common.js?v=201812202"></script>
<script type="text/javascript" src="/public/admin/js/libs/modernizr.min.js"></script>
<script type="text/javascript" src="/public/admin/js/layer/layer.js"></script>

</head>

<body>
<?php $admin_user = \Model\Admin\User::getAdminInfo(array('admin_id'=>\Model\Admin\User::checks())); ?>
    
<div class="container clearfix">
    <div class="main-wrap">
        <div class="crumb-wrap">
  <div class="crumb-list"><i class="icon-font"></i><a href="/index.php?app=admin&mod=index&ac=view" target="_top">首页</a><span class="crumb-step">&gt;</span><span class="crumb-name"><?php if(isset($title)) echo $title?></span></div>
</div>   
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
<script type="text/javascript">

function show(title,url){
	//iframe层
    layer.open({
        type: 2,
        title: title,
        shadeClose: true,
        shade: 0.8,
        fix: false, //不固定
        maxmin: true,
        area: ['60%', '500px'],
        content: url //iframe的url
    }); 
}
var layerIndex = 0;
var isOpen=false;
var interval= window.setInterval("showWindow()",20000);
function showWindow(){
	$.post('/index.php?app=admin&mod=index&ac=showWindow',{},function(res){
		 if(res.status=='1'){
                    if(isOpen){
                        layer.close(layerIndex);
                    }
                    //iframe窗
                    layerIndex = layer.open({
                        type: 1,
                        title: '您有新的<b class="red"> '+res.num+' </b>条待办事项',
                        shade: false,
                        //skin: 'layui-layer-demo', //样式类名
                        area: ['340px', '315px'],
                        shadeClose: false, //开启遮罩关闭
                        offset: 'rb', //右下角弹出
                        content: '<div class="result-content"><ul id="wait-do" class="sys-info-list pt10">'+res.msg+'</ul></div><div style="display:none;"><audio controls="true" autoplay="autoplay" loop="loop"><source src="/public/admin/sound/music.mp3" /><source src="/public/admin/sound/music.ogg" /></audio></div>', 
                        end:function(){ // 点击右上角关闭按钮  
                            isOpen=false;
                            layerIndex=0;
                        }
                    });
                    isOpen = true;
		 }
	},'json');
}

</script>
</body>
</html>
