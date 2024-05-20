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
            <div class="crumb-list"><i class="icon-font"></i><a href="/index.php?app=admin&mod=index&ac=view" target="_top">首页</a><span class="crumb-step">&gt;</span><a class="crumb-name" href="/index.php?app=admin&mod=role&ac=view">角色管理</a><span class="crumb-step">&gt;</span><span><?php echo $nav_title;?></span></div>
        </div>
        <div class="result-wrap">
            <div class="result-content">
                <form action="/index.php?app=admin&mod=role&ac=doEdit" method="post" id="myform" name="myform" enctype="multipart/form-data">
                	<input class="common-text required" id="id" name="id" size="50" value="<?php if($data && $data['id']){ echo $data['id']; }?>" type="hidden">
                    <table class="insert-tab" width="100%">
                        <tbody>
                       	
                            <tr>
                                <th width="8%"><i class="require-red">*</i>角色名称：</th>
                                <td>
                                    <input class="common-text required" onblur="checkname()" id="name" name="name" size="50" value="<?php if($data && $data['name']){ echo $data['name']; }?>" type="text">
                                    <i class="tip left pd10"></i>
                                </td>
                            </tr>
                         	 <tr>
                                <th><i class="require-red">*</i>排序编号：</th>
                                <td>
                                    <input class="common-text required" id="order" name="order" onkeyup="this.value=this.value.replace(/\D/g,'')" onafterpaste="this.value=this.value.replace(/\D/g,'')" size="50" value="<?php if($data){ echo $data['order']; }?>" type="text">
                                    <i class="tip left pd10"></i>
                                </td>
                            </tr>
                            
                            <tr>
                                <th><i class="require-red">*</i>权限：</th>
                                <td>
                                <?php foreach ($menus as $item){
                                	$checked = $data['module'] && in_array($item['module_id'], $data['module']) ? 'checked="checked"' : '';
                                ?>
	                                <div class="bigclass"><strong><?php echo $item['caption']?></strong>
							 			<input id="<?php echo $item['module_id']?>" <?php echo $checked;?> value="<?php echo $item['module_id']?>" name="module[]" type="checkbox">
							 		</div>
							 		<?php if($item['menu']){?>
	                				<ul class="smallclass" id="menu<?php echo $item['module_id']?>">
	                					<?php 
	                					foreach ($item['menu'] as $menu){
	                						$arr = explode('=', str_replace('&ac', '', $menu['url']));
	                						$pur_name = $arr[2].'_'.$arr[3];
	                						$menu_list = array();
											if($menu['purview']){
												$purview = explode(',', $menu['purview']);
		                						foreach ($purview as $pur){
		                							$row = array();
		                							$temp = explode('|', $pur);
		                							if (is_array($temp)){
		                								$row['name'] = $temp[0];
		                								$row['title'] = $temp[1];
		                							}
		                							$menu_list[] =$row;
		                						}
											}
	                						
											
											$menu_checked = $data['purview'] && in_array($pur_name, $data['purview']) ? 'checked="checked"' : '';
	                					?>
												<li title="<?php echo $menu['caption']?>" class="blue"><input <?php echo $menu_checked;?> value="<?php echo $pur_name;?>" name="purview[]" id="<?php echo $pur_name?>" type="checkbox"> <?php echo $menu['caption']?></li>
	                							<?php foreach ($menu_list as $row){
	                								$menu_checked =  $data['purview'] && in_array($row['name'], $data['purview']) ? 'checked="checked"' : '';
	                							?>
												<li title="<?php echo $row['title']?>"><input <?php echo $menu_checked;?> value="<?php echo $row['name']?>" name="purview[]" id="<?php echo $row['name']?>" type="checkbox"> <?php echo $row['title']?></li>
												<?php }?>
												
	                					<?php }?>
									</ul>
									<?php }?>
									<div class="clear"></div>
               					<?php }?>
                
                                </td>
                            </tr>
                            
                        
                         <tr>
                                <th></th>
                                <td>
                                    <input class="btn btn-primary btn6 mr10" name="submit" value="提交" type="submit">
                                    <input class="btn btn6" onClick="history.go(-1)" value="返回" type="button">
                                </td>
                            </tr>
                        </tbody></table>
                </form>
            </div>
        </div>

    </div>
    <!--/main-->
</div>
<script type="text/javascript">
<!--
function checkname(){
	/*$.post('/index.php?app=admin&mod=trade&ac=ajaxCheckname',{"name": $('#name').val()},function(res){
		 if(res.status=='1'){
			 $('#name').next().html('该角色名称已存在！');
		 }else{
			 $('#name').next().html('');
		 }
	},'json');*/
	var name = $('#name').val();
	if(name!=""){
		$('#name').next().html('');
	}
}

$(document).ready(function(){
	$('.bigclass input[type=checkbox][name=module[]]').bind('click',function(){
		var id = $(this).attr('id');
		$('#menu'+id+' input[type=checkbox][name=purview[]]').each(function(){
			  if($(this).attr("checked")){
			   		$(this).removeAttr("checked");
			   }else{
			    	$(this).attr("checked",'true');
			   }
		});
	})
	//$("input[type=checkbox][name=purview[]][checked]").length;
	
	$('#myform').submit(function(){
		//alert($("input[type=checkbox][name=purview[]][checked]").length);
		var name = $('#name').val();
		if(name==""){
			$('#name').next().html('请输入角色名称！');
			$('#name').focus();
			return false;
		}else{
			$('#name').next().html('');
		}
			
		if($('#order').val()==""){
			$('#order').next().html('请输入排序编号！');
			$('#order').focus();
			return false;
		}else{
			$('#order').next().html('');
		}

		
		return true;
	});
});
//-->
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
