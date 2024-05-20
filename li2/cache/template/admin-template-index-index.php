
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
<iframe src="/index.php?app=admin&mod=index&ac=top" height="50" width="100%" scrolling="no" frameborder="no"></iframe>
<div class="sidebar-wrap">
        <div class="sidebar-title">
            <h1>管理菜单</h1>
        </div>
        <div class="sidebar-content" style="overflow-y: auto">
            <ul class="sidebar-list">
                <?php $admin = \Common\Query::selone('admin_user', array('admin_id'=>$_SESSION['admin_id']));?>
                <?php $isfirst =true;?>
                <?php foreach ($modules as $module){?>
                <?php if(!empty($menus[$module['module_id']])){?>
               	 	<li>
	                    <a href="javascript:show_module('<?php echo $module['module_id']?>')"><i class="icon-font"><?php echo $module['icon']?></i><?php echo $module['caption']?></a>
	                    <ul id='modulecon_<?php echo $module['module_id']?>' class="sub-menu" style='<?php echo (!$isfirst)? 'display:none':''?>'>
	                	<?php foreach ($menus[$module['module_id']] as $menu){?>
		                     <?php if($menu['caption']=='管理员管理'){?>
			                     <?php if($admin['role_id']==1){ ?>
                                            <li><a data-href="<?php echo $menu['url']?>" target="mainFrame" style="cursor:pointer"><i class="icon-font"><?php echo $menu['icon']?></i><?php echo $menu['caption']?></a></li>
			                    <?php }?>
			                    <?php }else{
			                    if(!in_array($menu['menu_id'], array('9','10','29'))){?>
			                    <li><a data-href="<?php echo $menu['url']?>" target="mainFrame" style="cursor:pointer"><i class="icon-font"><?php echo $menu['icon']?></i><?php echo $menu['caption']?></a></li>
			                    <?php }}?>
		    		  		<?php }?>
	                    </ul>
	                </li>
                	<?php $isfirst =false;?>
                 <?php }?>
                <?php }?>
            </ul>
        </div>
</div>
<div style="position: absolute;top: 50px;right: 0;bottom: 0;left: 202px;overflow: hidden;">
    <div id="Hui-tabNav" class="Hui-tabNav">
        <div class="Hui-tabNav-wp">
            <ul id="min_title_list" class="acrossTab cl">
                <li class="active"><span title="首页" data-href="welcome.html">首页</span><em></em></li>
            </ul>
        </div>
        <div class="Hui-tabNav-more btn-group"><a id="js-tabNav-prev" class="lrbtn radius btn-default size-S" href="javascript:;" style="padding: 3px 8px;"><i class="Hui-iconfont"><</i></a><a id="js-tabNav-next" class="lrbtn radius btn-default size-S" href="javascript:;" style="padding: 3px 8px;"><i class="Hui-iconfont">></i></a></div>
    </div>
    <div id="iframe_box" class="Hui-article">
        <div class="show_iframe">
            <div style="display:none" class="loading"></div>
            <iframe id="iframe1" frameborder="0" src="/index.php?app=admin&mod=index&ac=main" height="550" width="100%" scrolling="yes" frameborder="no"></iframe>
        </div>
    </div>
</div>
<script type="text/javascript">
    function show_module(moduleid){
        $('.sub-menu').hide();
        $('#modulecon_'+moduleid).show();
    }
    var num=0;
    var oUl=$("#min_title_list");
    var hide_nav=$("#Hui-tabNav");
    $(function(){
        $(".sub-menu a").click(function(){
            openWin($(this).html(),$(this).data('href'));
        })
        $('#js-tabNav-next').click(function(){
		num==oUl.find('li').length-1?num=oUl.find('li').length-1:num++;
		toNavPos();
	});
	$('#js-tabNav-prev').click(function(){
		num==0?num=0:num--;
		toNavPos();
	});
        $(document).on("click","#min_title_list li",function(){
		var bStopIndex=$(this).index();
		var iframe_box=$("#iframe_box");
		$("#min_title_list li").removeClass("active").eq(bStopIndex).addClass("active");
		iframe_box.find(".show_iframe").hide().eq(bStopIndex).show();
	});
	$(document).on("click","#min_title_list li i",function(){
		var aCloseIndex=$(this).parents("li").index();
		$(this).parent().remove();
		$('#iframe_box').find('.show_iframe').eq(aCloseIndex).remove();	
		num==0?num=0:num--;
		tabNavallwidth();
	});
	$(document).on("dblclick","#min_title_list li",function(){
		var aCloseIndex=$(this).index();
		var iframe_box=$("#iframe_box");
		if(aCloseIndex>0){
			$(this).remove();
			$('#iframe_box').find('.show_iframe').eq(aCloseIndex).remove();	
			num==0?num=0:num--;
			$("#min_title_list li").removeClass("active").eq(aCloseIndex-1).addClass("active");
			iframe_box.find(".show_iframe").hide().eq(aCloseIndex-1).show();
			tabNavallwidth();
		}else{
			return false;
		}
	});
        tabNavallwidth();
    })
    function toNavPos(){
        oUl.stop().animate({'left':-num*100},100);
    }
    
    //弹窗
    var interval= window.setInterval("showWindow()",20000);
    function showWindow(){
            $.post('/index.php?app=admin&mod=index&ac=showWindow',{},function(res){
                     if(res.status=='1'){
                            $('.layui-layer').remove();
                            //iframe窗
                            layer.open({
                                type: 1,
                                title: '您有新的<b class="red"> '+res.num+' </b>条待办事项',
                                shade: false,
                                //skin: 'layui-layer-demo', //样式类名
                                area: ['340px', '315px'],
                                shadeClose: false, //开启遮罩关闭
                                offset: 'rb', //右下角弹出
                                content: '<div class="result-content"><ul id="wait-do" class="sys-info-list pt10">'+res.msg+'</ul></div><div style="display:none;"><audio controls="true" autoplay="autoplay" loop="loop"><source src="/public/admin/sound/music.mp3" /><source src="/public/admin/sound/music.ogg" /></audio></div>', 
                                end: function(){ 
                                    //window.clearInterval(interval);
                                }
                            });
                     }
            },'json');
    }
</script>

<!--/sidebar-->
</body>
</html>