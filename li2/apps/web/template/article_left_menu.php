<?php if($menuList){?>
<ul class="menu_left">
	 <?php foreach ($menuList as $menu){?>
      <li><a <?php if($pid==$menu['id']){echo 'class="cur"';}?> href="<?php echo \App::URL('web/article/view',array('pid'=> $menu['id']));?>"><?php echo $menu['name'];?></a></li>
      <?php }?>
 </ul>
 <?php }?>