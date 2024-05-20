<style>
    .peizi_nav li{float:left;height: 35px;line-height: 35px;text-align: center;color: #f53d52;border: 1px solid #f53d52;width:26%;font-size:14px;margin: 10px 3.6%;box-sizing:border-box;-moz-box-sizing:border-box; /* Firefox */-webkit-box-sizing:border-box; /* Safari */}
    .peizi_nav li a{color:#f53d52}
    .peizi_nav li.active{background: #f53d52}
    .peizi_nav li.active a{color:#fff}
</style>
<div class="peizi_nav clearfix">
    <ul>
        <li <?php echo $_GET['ac']=='month'?'class="active"':''?>><a href="<?php echo \App::URL('wap/peizi/month')?>">按月策略</a></li>
        <li <?php echo $_GET['ac']=='day'?'class="active"':''?>><a href="<?php echo \App::URL('wap/peizi/day')?>">按天策略</a></li>
        <li <?php echo $_GET['ac']=='free'?'class="active"':''?>><a href="<?php echo \App::URL('wap/peizi/free')?>">免费体验</a></li>
    </ul>
</div>