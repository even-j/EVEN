<style>
    body {background: #f3f3f3;}
</style>
<ul>
    <li <?php if($_GET['mod']=='about' && $_GET['ac']=='us'){echo ' class="now"';}?>><a href="<?php echo \App::URL("web/about/us");?>" >公司简介</a></li>
    <li <?php if($_GET['mod']=='about' && $_GET['ac']=='qualification'){echo ' class="now"';}?>><a href="<?php echo \App::URL("web/about/qualification");?>" >证件荣誉</a></li>
    <li <?php if($_GET['mod']=='about' && $_GET['ac']=='job'){echo ' class="now"';}?>><a href="<?php echo \App::URL("web/about/job");?>" >人才招聘</a></li>
    <li <?php if($_GET['mod']=='about' && $_GET['ac']=='contact'){echo ' class="now"';}?>><a href="<?php echo \App::URL("web/about/contact");?>" >联系我们</a></li>
    <li <?php if($_GET['mod']=='article'){echo ' class="now"';}?>><a href="<?php echo \App::URL("web/article/view",array('pid'=>5));?>" >最新公告</a></li>
</ul>