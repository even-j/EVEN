<!--include file "common.php"-->
<!--include file "header.php"-->
<!--include file "nav.php"-->
<!--新帮助中心开始-->
<div style=" border-top:1px solid #ccc; clear:both; height:1px; width:100%"></div>
<div class="newhelp_box">
    <div class="seeYouAgain">
        <a href="/"><?php echo SITE_NAME;?>首页</a>&gt; <a href="<?php echo \App::URL('web/article/help')?>">帮助中心</a>
    </div>
    <h2 class="title_help">帮助中心</h2>
    <div class="sousuo_box">
        <label for="">问题分类</label>
        <input type="text" value="请输入查看问题" onfocus="if(value=='请输入查看问题'){value=''}" onblur="if(value==''){value='请输入查看问题'}" id='search_key'>
        <a href="#" id='search'>搜索</a>
    </div>
    <ul class="img_help">
    	<?php foreach($typeList as $key=>$type){
    		$index = $key+1;
    		if($key>6){
    			break;
    		}
    	?>
        <li class="li_<?php echo $index;?>">
            <a href="<?php echo \App::URL('web/article/detail',array('pid'=> $type['id'],'id'=> $type['id']));?>"><i><?php echo $type['name'];?></i></a>
        </li>
        <?php }?>
    </ul>
    <h3 class="title_1">常见问题</h3>
    <div class="btm_help">
        <p>
        	<?php foreach($typeList as $key=>$type){
        		if(!in_array($type['id'],array(2,3,4))){
        			continue;
        		}
        	?>
            <label for=""><?php echo $type['name'];?></label>
            <?php }?>
        </p>
        <?php foreach($typeList as $key=>$type){
        		if(!in_array($type['id'],array(2,3,4))){
        			continue;
        		}
        ?>
        	<ul>
        		<?php 
        			$list = \Model\Admin\Article::getArticleList($type['id']);
        			foreach ($list as $key=>$item){
        				if($key>5){break;}
        		?>
        		<li><i></i><a href="<?php echo \App::URL('web/article/detail',array('pid'=> $item['pid'],'id'=> $item['id']));?>" target="_blank"><?php echo $item['title'];?></a></li>
        		<?php }?>
        	</ul>
         <?php }?>
      
    </div>
</div>

<!--新帮助中心结束-->
<script>
$(document).ready(function(){
    $("#search").click(function(){
        var key=$("#search_key").val();
        if(!!!key || key=='搜索问题和答案'){
            alert('关键字不能为空');
            return false;
        }
        var url = "<?php echo \App::URL('web/article/search')?>";
        if(url.indexOf('?')>0){
			url = url + '&keyword='+key;
        }else{
        	url = url + '?keyword='+key;
        }
        window.location.href=url;
    });
});

</script>
<!-- content -->

<!--include file "footer.php"-->
</body>
</html>