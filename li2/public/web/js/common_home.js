var dlg;
$(document).ready(function(){
	$(".rankingList").each(function(){$(this).find(".nember:lt(3)").addClass("top3");});
});

function slide(obj,dir){
	var _wrap=$(obj);var _direct=dir;var _interval=3000;var _moving;_wrap.hover(function(){clearInterval(_moving)},function(){_moving=setInterval(function(){var _field=_wrap.find('li:first');var _h=_field.height();var _w=_field.width();if(_direct=='Top'){_d={marginTop:-_h+'px'}}else{_d={marginLeft:-_w+'px'}}_field.animate(_d,300,function(){_field.css('margin'+_direct,0).appendTo(_wrap)})},_interval)}).trigger('mouseleave');
}
function dialog(content,title,onclose){
    if(!title){
    	title = '提示：';
    	content='<div class="alert">'+content+'</div>';
	}else{
		if(title=='error'||title=='success'||title=='alert'){
			content='<div class="'+title+'">'+content+'</div>';
			title = '操作结果：';
		}
	}
	
	dlg = new jBox('Modal', {onClose:onclose,closeOnClick: false,blockScroll: false,minWidth: 250,minHeight: 80,title: title,content: content,closeButton: 'title',animation: 'pulse',overlay: true}).open();
}

function dialog2(content,title,onclose){
    if(!title){
    	title = '提示：';
    	content='<div class="alert">'+content+'</div>';
	}else{
		if(title=='error'||title=='success'||title=='alert'){
			content='<div class="'+title+'">'+content+'</div>';
			title = '操作结果：';
		}
	}
	
	var dialog = new jBox('Modal', {onClose:onclose,closeOnClick: false,blockScroll: false,minWidth: 250,minHeight: 80,title: title,content: content,closeButton: 'title',animation: 'pulse',overlay: true}).open();
    return dialog;
}

$(document).ready(function() {
    var gotop = $(".qqkf");
    function goTop() {
        var st = $(document).scrollTop(); (st > 200) ? gotop.fadeIn() : gotop.stop(true, false).fadeOut();
    }
    $('#toTop').bind("click",
    function() {
        $("body,html").animate({
			scrollTop: 0
		}, 1E3)
    });
    $('.go-top').bind('click',
    function() {
        $("body,html").animate({
			scrollTop: 0
		}, 1E3)
    });
    var wechatindex = 0;
    $('#wechat').bind('mouseover',
    function() {
        wechatindex = layer.tips('<img width="150" src="/public/web/images/ewm2.jpg">', '#wechat', {
            tips: [4, '#fff'],
            time: 900000000,
            skin: 'wechattips'
        });
    });
    $('#wechat').bind('mouseleave',
    function() {
        layer.close(wechatindex);
    });
    var layerindex = 0;
    $("#app_download").bind("mouseover",function(){
        layerindex = layer.tips('<img width="150" src="/public/web/images/ewm.png" /><p style="text-align:center;color:#444">扫二维码下载</p>', '#app_download', {
            tips: [3, '#fff'],
            time: 900000000,
        });
    })
    $('#app_download').bind('mouseleave',function() {
        layer.close(layerindex);
    });
    
    
    var layerindex2 = 0;
    $("#f4_img").bind("mouseover",function(){
        layerindex2 = layer.tips('<img width="150" src="/public/web/images/add/ewm_weixin.png?v=2" /><p style="text-align:center;color:#444">微信客服</p>', '#f4_img', {
            tips: [4, '#fff'],
            time: 900000000,
        });
    })
    $('#f4_img').bind('mouseleave',function() {
        layer.close(layerindex2);
    });
    
//    $('#minidown400').bind('mouseover',
//    function() {
//        var phone = $("#site_phone").val();
//        tel400index = layer.tips('<div class="minidowndiv"><span>免费客服热线:</span><br><span class="keftel">'+phone+'</span></div>', '#minidown400', {
//            tips: [4, '#fff'],
//            time: 900000000,
//            skin: 'minidown400'
//        });
//    });
//    $('#minidown400').bind('mouseleave',
//    function() {
//        layer.close(tel400index);
//    });
});