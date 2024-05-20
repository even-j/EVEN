<!--include file "admin_include.php"-->
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
			                    <li><a href="<?php echo $menu['url']?>" target="mainFrame"><i class="icon-font"><?php echo $menu['icon']?></i><?php echo $menu['caption']?></a></li>
			                    <?php }?>
			                    <?php }else{
			                    if(!in_array($menu['menu_id'], array('9','10','29'))){?>
			                    <li><a href="<?php echo $menu['url']?>" target="mainFrame"><i class="icon-font"><?php echo $menu['icon']?></i><?php echo $menu['caption']?></a></li>
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
<script type="text/javascript">
    function show_module(moduleid){
        $('.sub-menu').hide();
        $('#modulecon_'+moduleid).show();
    }
</script>

<!--/sidebar-->
</body>
</html>