        <!--底部开始-->
        <div class="clear" style="height: 60px"></div>
        <div class="wap_footer"> 
            <ul>
                <li class="<?php if(!isset($_GET['mod']) || ($_GET['mod']=='index' && $_GET['ac']=='view')){echo 'active';}?>">
                    <a class="home" href="<?php echo \App::URL('wap/index/view')?>" >首页</a> 
                </li>
                <li class="<?php if($_GET['mod']=='peizi' ){echo 'active';}?>">
                    <a class="day" href="<?php echo \App::URL('wap/peizi/month')?>" >策略</a>
                </li>
                <li>
                    <a class="month" href="<?php echo \App::URL('wap/index/kefu')?>">客服</a>
                </li>
                <li class="<?php if($_GET['mod']=='user'){echo 'active';}?>">
                    <a class="user" href="<?php echo \App::URL('wap/user/account')?>">我的</a> 
                </li>
            </ul>
            
        </div>
        <script>
            $(function(){
                $("#nav_help").click(function(){
                    
                })
            })
        </script>
        <!--脚本开始-->
        <style>
            #MEIQIA-BTN-HOLDER{display:none !important}
        </style>

        <div style="display: none">
        <?php echo str_replace("&#039;", "'", html_entity_decode(SITE_SERVICE_SCRIPT))  ; ?> 
        </div>
        <!--脚本结束-->

        <!--底部结束-->
		</script>
        <script type="text/javascript" src="https://s96.cnzz.com/z_stat.php?id=1276284630&web_id=1276284630"></script>