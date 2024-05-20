<!--include file "common.php"-->
<!--include file "header.php"-->
<!--include file "nav.php"-->
<!--新帮助中心开始-->
<?php if($data['id']==62){?>
<link rel="stylesheet" href="/public/web/css/cui.css" />
<link rel="stylesheet" href="/public/web/css/zijin.css" />
<style>
#zhuce_box .wf_box{margin:0;padding:0;border:0;}
</style>
<div class="h20"></div>
<div id="bd">
  	<div class="wp">
		<div id="zhuce_box">
			<div class="lujing"><a href="/"><?php echo SITE_NAME;?>首页</a>&gt; <a href="<?php echo \App::URL('web/article/help')?>">帮助中心</a> &gt; <?php echo $type['name'];?></div>
  			<?php echo $data['contents'] ? html_entity_decode(htmlspecialchars_decode($data['contents'])) : '<p>内容完善中...</p>';?>
  			<div class="clear">&nbsp;</div>
		</div>
		
	</div>
</div>

<?php }else{?>
<div class="newhelplist_box">
    <div class="help_newlist">
        <div class="seeYouAgain">
        	<a href="/"><?php echo SITE_NAME;?>首页</a>&gt; <a href="<?php echo \App::URL('web/article/help')?>">帮助中心</a> &gt; <span><?php echo $type['name'];?></span>
        </div>
        <!--include file "help_left_menu.php"-->
        <div class="help_listright">
            <div class="putIn_help"> 
                <input type="text" value="请输入您要搜索的关键字" onfocus="this.value=''" onblur="if(this.value==''){this.value='请输入您要搜索的关键字'}" id='search_key' style='margin:0'/>
                <label id='search'></label>
            </div>
                       

                <div class="tit_help_lbox clear"><h3><?php echo $data['title'];?></h3></div>
                <div class="help_content">
                <?php echo $data['contents'] ? html_entity_decode(htmlspecialchars_decode($data['contents'])) : '<p>内容完善中...</p>';?>
                </div>
            
        </div>
    </div>
</div>
<?php }?>
<!--新帮助中心结束-->
<script type="text/javascript">
    
$(function(){
    $help_listli = $('.help_listleft').find("li");
    $('.help_listleft li').hover(
        function(){
            $(this).addClass("bg_list");
            $(this).find("a").addClass("color_help");
        },
        function(){
            var id=parseInt($(this).attr("data-id"));
            var orign_id=<?php echo $id;?>;
            if(id==orign_id){ return false;}
            $(this).removeClass("bg_list");
            $(this).find("a").removeClass("color_help");
        }

        );


});


</script>

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