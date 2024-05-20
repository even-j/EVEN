<!DOCTYPE html>
<html lang="zh-CN">
    <head>
        <!--include file "common.php"-->
        <link rel="stylesheet" href="/public/wap/css/index.css">
        <link rel="stylesheet" href="/public/wap/css/public.css">
        <link rel="stylesheet" href="/public/wap/css/flexslider.css">
        <script src="/public/wap/js/jquery.flexslider-min.js" type="text/javascript"></script>
        <style>
           
        </style>
        <script type="text/javascript">
            $(function(){
                var status=<?php if(isset($layer_param['status'])){ echo $layer_param['status'];} else{echo 0;}?>;
                var content=$('#layerpop').html();
                if(status==1 && content!=null && content!='')
                {
                    var sjc=Date.parse(new Date())/1000;
                    if(sjc>=<?php if(isset($layer_param['starttime'])){echo strtotime($layer_param['starttime']);}else{ echo time();}  ?>)
                    {
                        <?php if(isset($layer_param['type']) && $layer_param['type']=='img'){ ?>
                            content='<style>.layui-m-layercont{padding:0px !important; }  .layui-layer-dialog .layui-layer-content{padding:0px !important;}  .layui-m-layerchild{width:90%!important}.temp{height:300px;overflow:auto} .temp img{width:100%}</style><div class="temp">'+content+'</div>';
                        <?php }else{?>
                            content='<style> .layui-m-layercont{padding:8px 16px !important;}  .layui-m-layer0 .layui-m-layerchild{width:90%!important}.temp{height:300px;overflow:auto}.temp p{line-height:20px;padding:8px 0;text-align:left}</style><div class="temp">'+content+'</div>';
                        <?php }?>
                        layer.open({
                            content : content,
                            btn : '我知道了'
                        })
                    }
                }
            });
        </script>
    </head>
    <body>
        <div style="display: none" id="layerpop">
            <?php if(isset($layer_param['type']) && $layer_param['type']=='img'){ ?>
                 <?php if(isset($layer_param['content2'])){ echo str_replace('&quot;','"',str_replace('&gt;','>',str_replace('&lt;', '<', str_replace('&amp;', '&', $layer_param['content2']))));}?>
            <?php }else{?>
                  <?php if(isset($layer_param['content'])){ echo str_replace('&quot;','"',str_replace('&gt;','>',str_replace('&lt;', '<', str_replace('&amp;', '&', $layer_param['content']))));}?>
            <?php }?> 
        </div>
        <!--第二行-->
        <div class="clear"></div>
        <div style="width:100%;height:50px;text-align:center">
        </div>
        <?php 
            if(!isset($_SESSION)){
                session_start();
            }
            $uid = isset($_SESSION['uid'])?$_SESSION['uid']:0;
        ?>
        <?php if($uid>0){?>
        <div style="position:absolute;background:#fff;top:0;left:0;height:50px;width:100%;z-index: 999;text-align:center;margin">
            <img src="/public/web/images/add/logo.png?v=1" style="height:30px;margin-top:10px"/>
            <a style="position:absolute;right: 10px;top:15px;color:#ff595b" href="<?php echo \App::URL('wap/member/logout');?>">退出</a>
        </div>
        <?php }else{?>
        <div style="position:absolute;background:#fff;top:0;left:0;height:50px;width:100%;z-index: 999;text-align:center">
            <img src="/public/web/images/add/logo.png?v=1" style="height:30px;margin-top:10px"/>
            <a style="position:absolute;left: 10px;top:15px;color:#ff595b" href="<?php echo \App::URL('wap/member/register');?>">注册</a>
            <a style="position:absolute;right: 10px;top:15px;color:#ff595b" href="<?php echo \App::URL('wap/member/login');?>">登录</a>
        </div>
        <?php }?>
        <!---banner start---->
        <div id="home_slider" class="flexslider">
            <ul class="slides">
                <li>
                    <div class="slide" style="text-align: center;overflow: hidden;width: 100%">
                        <img src="/public/wap/images/sm01.png" alt="" />
                    </div>
                </li>
                <li>
                    <div class="slide" style="text-align: center;overflow: hidden;width: 100%">
                        <img src="/public/wap/images/sm02.png" alt="" />
                    </div>
                </li>
                <li>
                    <div class="slide" style="text-align: center;overflow: hidden;width: 100%">
                        <img src="/public/wap/images/sm03.png" alt="" />
                    </div>
                </li>
                <li>
                    <div class="slide" style="text-align: center;overflow: hidden;width: 100%">
                        <img src="/public/wap/images/sm04.png" alt="" />
                    </div>
                </li>
              </ul>
        </div>
        <script type="text/javascript">
                $(function () {
                    $('#home_slider').flexslider({
                        animation : 'slide',
                        controlNav : false,
                        directionNav : true,
                        animationLoop : true,
                        slideshow : true,
                        useCSS : false,
                        touch:true,
                        pauseOnHover: true,
                        after: function (slider) {
                            slider.pause();
                            slider.play();
                        },
                    });
                });
          </script>
        <!---banner end--->
        <!--notice start-->
        <div>
            <div style="float:left;width:28px;height: 34px"><img src="/public/wap/images/laba.png" width="18" style="margin-top:9px;margin-left: 8px"/></div>
            <div id="notice_slider" style="margin-left:28px;height:34px">

                <ul class="slides">
                    <?php foreach ($noticeList['data'] as $notice){?>
                    <li>
                        <div class="slide" style="text-align: left;overflow: hidden;line-height: 34px;overflow-x: auto;overflow-y: hidden;white-space: nowrap;width:95%;margin:0 auto">
                            <a style="color:#ff774f" id="bd_colors" href="<?php echo \App::URL('wap/article/show',array('id'=>  $notice['id']));?>"><?php echo date('Y-m-d',$notice['addtime']).' '.$notice['title'];?></a>
                        </div>
                    </li>
                    <?php }?>

                  </ul>
            </div>
        </div>
        
        <script type="text/javascript">
                $(function () {
                    $('#notice_slider').flexslider({
                        animation : 'slide',
                        controlNav : false,
                        directionNav : false,
                        animationLoop : true,
                        slideshow : true,
                        useCSS : false,
                        touch:true,
                        pauseOnHover: true,
//                        direction: "vertical", 
                        after: function (slider) {
                            slider.pause();
                            slider.play();
                        },
                    });
                });
          </script>
        <!--notice end-->
        <div class="am-content project-con">
            <ul>
                <li>
                    <a href="<?php echo \App::URL('wap/index/activity');?>">
                        <div class="index-img">
                            <img src="/public/wap/images/project-24.png" width="68%" border="0">                        </div>
                        <p>新手任务</p>
                  </a>
                </li>
                <li>
                    <a href="<?php echo \App::URL('wap/help/index');?>">
                        <div class="index-img">
                            <img src="/public/wap/images/project-22.png" width="68%">
                        </div>
                        <p>帮助中心</p>
                    </a>
                </li>
                <li>
                    <a href="<?php echo \App::URL('wap/about/index');?>">
                        <div class="index-img">
                            <img src="/public/wap/images/project-21.png" width="68%">
                        </div>
                        <p>关于我们</p>
                    </a>
                </li>
                <!-- <li>
                    <a href="<?php echo \App::URL('wap/article/view',array('pid'=>5));?>">
                        <div class="index-img">
                            <img src="/public/wap/images/project-23.png" width="68%">
                        </div>
                        <p>最新公告</p>
                  </a>
                </li> -->
                <li>
                    <a href="<?php echo \App::URL('wap/help/tradeapp',array('pid'=>5));?>">
                        <div class="index-img">
                            <img src="/public/wap/images/user/trade_logo.png" width="68%">
                        </div>
                        <p>交易端下载</p>
                  </a>
                </li>
                <li>
                    <a href="<?php echo \App::URL('wap/help/software');?>">
                        <div class="index-img">
                            <img src="/public/wap/images/user/site_logo.png" width="68%">
                        </div>
                        <p>APP下载</p>
                    </a>
                </li>
                <div style="clear:both"></div>
            </ul>
        </div>


        <!--配资炒股开始-->
        <div class="index-stock">
            <div class="index-stock-nav mui-clearfix" id="stock_switch">
                <ul>
                    <li id="stock1" class="on">按月策略</li>
                    <li id="stock2">按天策略</li>
                    <li id="stock3">免费体验</li>
                </ul>
            </div>
            <div class="index-stock-con">
                <div id="con_stock1">
                    <div class="index-stock-box">
                        <i class="tj">推荐</i>
                        <h3 class="mui-clearfix">
                            <span>资金：<strong>1000</strong>元起</span>
                            <span style="float:right">倍数：最高<strong>10</strong>倍</span>
                        </h3>
                        <p>极速开户,利率低至<span class="c-red">0.6%</span>/月</p>
                        <p>最低1月起配，未申请终止操盘，续费自动延期。</p>
                    </div>
                    <a href="<?php echo \App::URL('wap/peizi/month')?>" class="index-stock-btn">立即策略</a>
                </div>
                <div id="con_stock2" style="display:none">
                    <div class="index-stock-box">
                        <h3 class="mui-clearfix">
                            <span class="mui-pull-left">资金：<strong>100</strong>元起</span>
                            <span style="float:right">倍数：最高<strong>6</strong>倍</span>
                        </h3>
                        <p>极速开户,利率低至<span class="c-red">0.06%</span>/天</p>
                        <p>最低2天起配，未申请终止操盘，续费自动延期。</p>
                    </div>
                    <a href="<?php echo \App::URL('wap/peizi/day')?>" class="index-stock-btn">立即策略</a>
                </div>
                <div id="con_stock3" style="display:none">
                    <div class="index-stock-box">
                        <i class="tj">推荐</i>
                        <h3 class="mui-clearfix">
                            <span class="mui-pull-left">平台出：<strong>5000</strong>元</span>
                            <span style="float:right">你出：<strong>100</strong>元</span>
                        </h3>
                        <p>总共<span class="c-red">5000</span>元策略资金，2个交易日。</p>
                        <p>盈利全归你，平台不收取任何费用。</p>
                    </div>
                    <a href="<?php echo \App::URL('wap/peizi/free')?>" class="index-stock-btn">立即策略</a>
                </div>
            </div>
        </div>

        <!-- <div style=" width: 105px; height: 71px; position: fixed; z-index: 9999; left: 0px; bottom: 90px; display: block;">
            <div id="" onclick="$(this).parent().remove();" style=" border-radius: 50%; background-image: linear-gradient(to top, #f77062 0%, #fe5196 100%); font-family: '微软雅黑'; width: 20px; height: 20px;line-height: 19px; color: #ffffff;transform: rotate(-45deg);text-align: center; font-size: 18px; margin-left: 70px;cursor:pointer">+</div>
            <a href="/index.php?app=wap&mod=help&ac=tradeapp" style="width: 130px; height:100px; background: url(/public/web/images/add/down.png) no-repeat; background-size: 114px; display: block;margin-left: -15px;"></a>
        </div> -->
        <script>
        $(function(){
            $("#stock_switch li").click(function(){
                $("#stock_switch li").removeClass("on");
                $(this).addClass("on");
                $("#con_stock1,#con_stock2,#con_stock3").hide();
                $("#con_"+$(this).attr("id")).show();
            })
        })
        </script>
        <!--配资炒股结束-->
        
        


        <!--include file "footer.php"-->


    </body>
</html>