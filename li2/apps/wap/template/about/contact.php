
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <!--include file "common.php"-->
        <script type="text/javascript" src="http://api.map.baidu.com/api?v=2.0&ak=4faIrUqgq1HKvtiuELObKQguAtFE6SpK"></script>
        <style>
            .bar{padding: 10px}
            .title1{line-height: 40px}
            .aboutM img {margin-bottom: 30px;width:80%;}
        </style>
        <style>
            .aboutus{margin-top: 40px;}
            .aboutus li{width:33.3%;float:left}
            .aboutus .title{color:#ee504f;font-size: 18px;text-align: center;margin-top: 10px}
            .aboutus .desc{font-size: 14px;line-height: 25px;color: #777;text-align: center;padding:10px 5px}
        </style>
    </head>

    <!-- Header Start -->
        <div id="top">
            <!--include file "header.php"-->
        </div>
    <div class="header">
            <h1>联系我们</h1>
            <a class="l-link" href="javascript:history.go(-1)"><span>返回</span></a> 
            <div class="top-menu">
                <!--<button type="button" class="btn"></button>-->
            </div>
        </div>
        <div style="height:40px;"></div>
        <link href="/public/web/css/article.css" rel="stylesheet" type="text/css" media="screen,projection" />
        <!-- Content Start -->
        <div class="bar">
            <div class="aboutM">
                <p style="font-size: 20px;font-weight: bold;text-align: center">广州栋供科技有限公司</p>
                <p style="font-size: 14px;text-align: center;color:#999">广州市天河区科韵北路100号1楼102室
</p
            ></div>
            <ul class="aboutus clearfix">
                <li>
                    <div class="img"><img src="/public/web/images/about/contact_04.png"/></div>
                    <div class="title"><strong>客服电话</strong></div>
                    <div class="desc"> 4000-039-678</div>
                </li>
                <!--<li>
                    <div class="img"><img src="/public/web/images/about/weixin.png"/></div>
                    <div class="title"><strong>微信号</strong></div>
                    <div class="desc">7373999</div>
                </li>-->

                <li>
                    <div class="img"><img src="/public/web/images/about/QQ.png"/></div>
                    <div class="title"><strong>客服QQ</strong></div>
                    <div class="desc"> 261438500  25972955</div>
                </li>
            </ul>
        </div>    	
        <div style="margin-top:10px">
                <div style="width:300px;height:250px;margin: 0 auto;border:#ccc solid 1px;font-size:12px" id="map"></div>
        </div>
        <div style="clear: both"></div>
        <!-- Content End -->
        <script type="text/javascript">
            $(function (e) {
                //                $(window).scroll(function () {
                //                    if ($(document).scrollTop() > 130) {
                //                        $('.aboutNav').css('position', 'fixed');
                //                        $('.aboutNav').css('top', '0px');
                //                        $('.aboutMain').css('margin-left', '190px');
                //                    } else {
                //                        $('.aboutNav').css('position', '');
                //                        $('.aboutMain').css('margin-left', '');
                //                    }
                //                });
            });
        </script>
        <script type="text/javascript">
            //创建和初始化地图函数：
            function initMap(){
              createMap();//创建地图
              setMapEvent();//设置地图事件
              addMapControl();//向地图添加控件
              addMapOverlay();//向地图添加覆盖物
            }
            function createMap(){ 
              map = new BMap.Map("map"); 
              map.centerAndZoom(new BMap.Point(113.391619,23.145336),16);
            }
            function setMapEvent(){
              map.enableScrollWheelZoom();
              map.enableKeyboard();
              map.enableDragging();
              map.enableDoubleClickZoom()
            }
            function addClickHandler(target,window){
              target.addEventListener("click",function(){
                target.openInfoWindow(window);
              });
            }
            function addMapOverlay(){
              var markers = [
                {content:"我的备注",title:"广州栋供科技有限公司",imageOffset: {width:0,height:3},position:{lat:23.145336,lng:113.391619}}
              ];
              for(var index = 0; index < markers.length; index++ ){
                var point = new BMap.Point(markers[index].position.lng,markers[index].position.lat);
                var marker = new BMap.Marker(point,{icon:new BMap.Icon("http://api.map.baidu.com/lbsapi/createmap/images/icon.png",new BMap.Size(20,25),{
                  imageOffset: new BMap.Size(markers[index].imageOffset.width,markers[index].imageOffset.height)
                })});
                var label = new BMap.Label(markers[index].title,{offset: new BMap.Size(25,5)});
                var opts = {
                  width: 200,
                  title: markers[index].title,
                  enableMessage: false
                };
                var infoWindow = new BMap.InfoWindow(markers[index].content,opts);
                marker.setLabel(label);
                addClickHandler(marker,infoWindow);
                map.addOverlay(marker);
              };
              var labels = [
                {position:{lng:113.391619,lat:23.145336},content:"我的标记"}
              ];
//              for(var index = 0; index < labels.length; index++){
//                var opt = { position: new BMap.Point(labels[index].position.lng,labels[index].position.lat )};
//                var label = new BMap.Label(labels[index].content,opt);
//                map.addOverlay(label);
//              };
            }
            //向地图添加控件
            function addMapControl(){
              var scaleControl = new BMap.ScaleControl({anchor:BMAP_ANCHOR_BOTTOM_LEFT});
              scaleControl.setUnit(BMAP_UNIT_IMPERIAL);
              map.addControl(scaleControl);
              var navControl = new BMap.NavigationControl({anchor:BMAP_ANCHOR_TOP_LEFT,type:BMAP_NAVIGATION_CONTROL_LARGE});
              map.addControl(navControl);
              //var overviewControl = new BMap.OverviewMapControl({anchor:BMAP_ANCHOR_BOTTOM_RIGHT,isOpen:true});
              //map.addControl(overviewControl);
            }
            var map;
              initMap();
          </script>
        <!--include file "footer.php"-->
    </body>
</html>