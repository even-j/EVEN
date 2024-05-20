<style>
    body {background: #f3f3f3;}
</style>
<ul>
    <li <?php if($_GET['mod']=='help' && $_GET['ac']=='guide'){echo ' class="now"';}?>><a href="<?php echo \App::URL("web/help/guide");?>" >新手指南</a></li>
    <li <?php if($_GET['mod']=='help' && $_GET['ac']=='member'){echo ' class="now"';}?>><a href="<?php echo \App::URL("web/help/member");?>" >常见问题</a></li>
    <li <?php if($_GET['mod']=='help' && $_GET['ac']=='storck'){echo ' class="now"';}?>><a href="<?php echo \App::URL("web/help/storck");?>" >策略相关</a></li>
    <li <?php if($_GET['mod']=='help' && $_GET['ac']=='agreement'){echo ' class="now"';}?>><a href="<?php echo \App::URL("web/help/agreement");?>" >注册协议</a></li>
    <li <?php if($_GET['mod']=='help' && $_GET['ac']=='software'){echo ' class="now"';}?>><a href="<?php echo \App::URL("web/help/software");?>" >APP下载</a></li>
</ul>