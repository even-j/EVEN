<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>网站APP下载</title>
        <!--include file "common.php"-->
        <style>
             body,html {margin:0;padding:0;background:white;}
            .init-wrapper {display:flex;flex-direction:column;padding:20px 20px 30px 20px;}
            .pattern {width:100%;height:200px;position:absolute;top:0;left:0;}
            .pattern .left {position:absolute;left:0;width:80px;}
            .pattern .right {position:absolute;right:0;width:80px;}
            .pattern img {width:100%;transition:all 1s;pointer-events:none;}
            .btn {position:relative;display:inline-block;padding:12px 46px;min-width:200px;border:1px solid #32B2A7;border-radius:40px;font-size:14px;background:#32B2A7;color:#fff;line-height:15px;}
            .list {padding:30px 20px 20px 20px;}
            div {text-align:center;}
            .logo {}
            .title {margin:20px 0;font-size:24px;}
            .fgx {margin:30px 0;padding:0 20%;}
            .version,.grade {color:#A9B1B3;font-size:14px;margin-bottom:6px;}
            .grade1 {margin-right:10px;}
            
            /*微信提示*/
            .wechat_tip {
                display: -webkit-box;display: -ms-flexbox;display: flex;-webkit-box-align: center;-ms-flex-align: center;align-items: center;-webkit-box-pack: center;-ms-flex-pack: center;justify-content: center;background: #3ab2a7;color: #fff;font-size: 14px;font-weight: 500;width: 135px;height: 60px;border-radius: 10px;top: 15px;
            }
            .wechat_tip, .wechat_tip>i {
                position: absolute;right: 10px;
            }
            .wechat_tip>i {
                top: -10px;width: 0;height: 0;border-left: 6px solid transparent;border-right: 6px solid transparent;border-bottom: 12px solid #3ab2a7;
            }
        </style>
    </head>

    <body>
        <?php if($is_weixin){ ?>"}
            <div class="wechat_tip">
                <i class="triangle-up"></i>
                请点击右上角<br>在浏览器中打开
            </div>
        <?php }else{?>
            <?php if (isset($_GET['from']) && $_GET['from'] != 'app'){?>
            <div class="header">
                <h1>下载{$downoper['title']}APP</h1>
                <a class="l-link" href="javascript:history.go(-1)"><span>返回</span></a> 
                <div class="top-menu">
                    <!--<button type="button" class="btn"></button>-->
                </div>
            </div>
            <div style="height:40px;"></div>
            <?php }?>
            <?php if ($error){?>
            <div style="font-size:18px;color:red;text-align: center">参数错误</div>
            <?php }?>
            <div class="pattern">
                <span class="left"><img src="/public/wap/images/download_pattern_left.png"></span>
                <span class="right"><img src="/public/wap/images/download_pattern_right.png"></span>
            </div>
            <div id="show-list" class="list"></div>
            <div id="show-des" class="list"></div>
            <div id="show-res" class="list"></div>

            <div class="init-wrapper" id="btnmain" style="display:none">
                <button onclick="down()" class="btn"></button>
            </div>
            <?php if ($type=='trade'){?>
            <div>
                <button  id="btn_copy" style="width:200px;position: relative;display: inline-block;padding: 12px 46px;min-width: 200px;border: 1px solid #fc8368;border-radius: 40px;font-size: 14px;background: #fc8368;color: #fff;line-height: 15px;">复制链接地址</button>
            </div>
            <?php }?>
        <?php }?>
        
    </body>
    <script type="text/javascript" src="https://vip.goceshi.com/gengu-1.1.0.min.js"></script>

    <script>
        var initData = {};
        let data;
        var ios_akey = "<?php echo $downoper['ios_akey'];?>";
        // genguAPI插件初始化
        gengu.CreatGenGu({
            merchantName: "<?php echo $downoper['merchantname'];?>",
            merchantCode: "<?php echo $downoper['merchantcode'];?>"
        }, CreatGenGuCall)
        // 获取当前下载步骤，并初始化页面
        function CreatGenGuCall(type) {
            fetchList()
            // 给按钮设置当前状态，也可根据返回的状态自己定义按钮文案
            document.getElementsByClassName('btn')[0].innerHTML = type
        }
        // 初始化APP列表
        function fetchList() {
            gengu.fetchList(fetchListCall)
        }
        function fetchListCall(res) { // 初始化回调，res为接口返回详情参数
            initData = res.data;
            console.log(initData);
            // 根据索引下载指定的APP
            fetchApp(ios_akey);//initData[ios_akey].akey
        }
        // 请求单个详情
        function fetchApp(id) {
            gengu.fetchApp(ios_akey, fetchApphCall);//initData[ios_akey].akey
        }
        function fetchApphCall(res, isDown) { // 请求单个详情回调，res为接口返回详情参数
            data = res.data
            document.getElementById('show-des').innerHTML = `
                <div class="logo"><img src='${data.in_icon}'></div>
                <div class="title">${data.row.in_name}</div>
                <div class="fgx"><hr></div>
                <div class="version">${data.row.in_version_info} version -${data.row.in_size}</div>
                <div class="grade"><span class="grade1">APP评分：${data.row.in_score}</span>评论数：${data.row.in_comment_num}</div>`;
            document.getElementById("btnmain").style.display = "block"//显示    
        }
        // 开始下载
        function down() {
            var type = 'android';
            var u = navigator.userAgent, app = navigator.appVersion;
            var isAndroid = u.indexOf('Android') > -1 || u.indexOf('Linux') > -1; //g
            var isIOS = !!u.match(/\(i[^;]+;( U;)? CPU.+Mac OS X/); //ios终端
            if (isAndroid) {
                //这个是安卓操作系统
                type = 'android';
            }
            if (isIOS) {
                //这个是ios操作系统
                type = 'ios';
            }
            if (type == 'ios')
            {
                // 判断是否是在手机并且是在Safari打开
                if (genguUtil.oauserFun().isSafari && genguUtil.oauserFun().isMobile) {
                    gengu.startDown(ios_akey, downCall);//initData[ios_akey].akey
                } else {
                    alert("请用Safari浏览器打开");
                }
            } else
            {
                var src = "<?php echo $downoper['andriod_path'];?>";
                var iframe = document.createElement('iframe');
                iframe.style.display = 'none';
                iframe.src = "javascript: '<script>location.href=\"" + src + "\"<\/script>'";
                document.getElementsByTagName('body')[0].appendChild(iframe);
            }
        }
        function downCall(type, time) {
            document.getElementById('show-res').innerHTML = `
                <div>当前打包状态：${type}</div>
                <div>当前打包进度：${time}</div>`
            if (type === 'success') {
                document.getElementsByClassName('btn')[0].innerHTML = '完成'
            }
        }
    </script>
    <script src="/public/wap/js/clipboard.min.js" type="text/javascript"></script>
    <script type="text/javascript">
        $(function(){
            var text = window.location.href;
            var clipboard = new Clipboard('#btn_copy', {
                text: function() {
                    return text;
                }
            });

            clipboard.on('success', function(e) {
                layermsg('复制成功');
            });
        })
    </script>
</html>

