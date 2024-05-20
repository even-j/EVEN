<!--include file "common.php"-->
<!--include file "header.php"-->
<!--include file "nav.php"-->
 <div class="newhelp_box">
	 <div class="seeYouAgain">
        	<a href="/"><?php echo SITE_NAME;?>首页</a>&gt; <a href="<?php echo \App::URL('web/article/help')?>">帮助中心</a>
        </div>
    <h2 class="title_help">帮助中心</h2>
    <div class="sousuo_box">
    	<input type="text" id='search_key' value="搜索问题和答案" onfocus="if(value=='搜索问题和答案'){value=''}" onblur="if(value==''){value='搜索问题和答案'}" class="sousuo_help1">
    	<a href="javascript:void(0);" id="search">搜索</a>
    </div>
    <div class="lj_sousuo">
        <p class="box_ss"><?php if($keyword){?>关键词<em>“<?php echo $keyword;?>”</em>的所有搜索结果<?php }?></p>
        <ul class="ss_list">
	        <?php foreach ($articleList as $arc){
	        	$arc['title'] = str_replace($keyword, "<font color='#AF0000'>$keyword</font>", $arc['title']);
	        ?>
            <li><a href="<?php echo \App::URL('web/article/detail',array('pid'=> $arc['pid'],'id'=> $arc['id']));?>" target='_blank'><?php echo $arc['title'];?></a></li>
        <?php }?>
        </ul>
    </div>
</div>

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