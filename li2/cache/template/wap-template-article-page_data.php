<ul>
    <?php foreach ($dataList as $item) { ?>
        <li> <a title="<?php echo $item['title']; ?>" href="<?php echo \App::URL('wap/article/show', array('id' => $item['id'])); ?>"><?php echo $item['title']; ?></a>  </li>
    <?php } ?>
</ul>