$(function(){
	//兼容IE8及以上版本
	// 暂时不做判断
	// try{
	// 	var browser=navigator.appName;
	// 	var b_version=navigator.appVersion;
	// 	var version=b_version.split(";"); 
	// 	var trim_Version=version[1].replace(/[ ]/g,""); 
	// 	function issettrim_Version(){
	// 		var arr = ["MSIE6.0", "MSIE7.0"];
	// 		if(arr.toString().indexOf(trim_Version) > -1) {
	// 			return false;
	// 		}
	// 		return true;
	// 	}
	// 	if(browser=="Microsoft Internet Explorer" && !issettrim_Version()  ) { 
	// 		$('body').prepend('<div id="ieMsg" style="height:100px;line-height:100px;text-align:center;backgroud: #ddd;font-size:30px;">请使用IE8或以上版本浏览更佳！</div>');
	// 		setTimeout(function(){$('#ieMsg').fadeOut();},10000);
	// 	} 
	// }catch(e){}
	
	//tab切换
	$('.tab-parent .tab-class').click(function(e){
		e.preventDefault();
		$(this).parents('.tab-parent').find('.tab-class-con').eq($(this).index()).show().siblings('.tab-class-con').hide();
		$(this).addClass('cur').siblings('.tab-class').removeClass('cur');
	 });

	var helptipStat = 1;
	$('.help-tip').hover(function(event) {
		if( !helptipStat ) return;
		helptipStat = 0;
		$(this).children().show().addClass('in');
	},function(){
		$(this).children().removeClass("in").addClass("out");
		var p = $(this).children();
		setTimeout(function(){
			p.hide().removeClass('out');
			helptipStat = 1; 
		},200)
	})

//    $(window).scroll(function () {
//        var scrollValue = $(window).scrollTop();
//        if( scrollValue>100 ){
//            $('#f5_img').height()==0 && $('#f5_img').stop().animate({'height': '60px','margin-top':'5px'},200);
//            $('#f5_img').show();
//        }else{
//            $('#f5_img').height()>0 && $('#f5_img').stop().animate({'height': 0,'margin-top':'0'},200);
//            $('#f5_img').hide();
//        }
//    });
//    $('#f5_img').click(function () {
//        $("html,body").animate({ scrollTop: 0 }, 200);
//    });  
//    $("#f3_img").bind("mouseover",function(){
//        $(this).find("div").show();
//    })
//    $("#f3_img").bind("mouseout",function(){
//        $(this).find("div").hide();
//    })

	$('.jiaxi').hover(function(e){
		var text = '';
		var month = parseInt($(this).attr('data-month'));
		var value = parseFloat($(this).attr('data-value'));
		var isFanXian = $(this).hasClass('fanxian');
		var dateTime = $(this).attr('data-time');
		var isGt = new Date(dateTime).getTime() > new Date('2018-1-10').getTime();
		if (value) {
			text = '单笔送'+value+'%'
		} else if (isFanXian && isGt) {
			switch (month){
				case 2:
				case 3:
					text = '单笔送1.0%';
					break;
				case 4:
				case 5:
				case 6:
					text = '单笔送2.0%';
					break;
				case 9:
					text = '单笔送2.5%';
					break;
				case 12:
					text = '单笔送3.5%';
					break;
				default:
					text = '';
					break;
			}	
		} else {
			switch (month){
				case 1:
					text = '单笔送0.5%';
					break;
				case 3:
					text = '单笔送1.0%';
					break;
				case 5:
					text = '单笔送2.0%';
					break;	
				case 6:
					text = '单笔送1.8%';
					break;
				case 9:
					text = '单笔送2.5%';
					break;
				case 12:
					text = '单笔送3.5%';
					break;
				default:
					text = '';
					break;
			}		
		}
  		window.layerTipIndex = layer.tips( text ,$(this),{time:100000})
	},function(){
		layer.close( window.layerTipIndex )
	})

	$('.jiaxi').each(function(){
		if( $(this).attr('data-time') && new Date( ($(this).attr('data-time').substr(0,19)) ).getTime() < new Date('2017-3-23').getTime() ){
			$(this).remove()
		}
	})
})

function getParam(name) {
	var reg = new RegExp("(^|&)" + name + "=([^&]*)(&|$)");
	var r = decodeURI(decodeURI(window.location.search)).substr(1).match(reg);
	if (r != null)
		return unescape(r[2]);
	return '';
}
function getOrigin(){
	if (window["context"] == undefined) {
	    if (!window.location.origin) {
	        window.location.origin = window.location.protocol + "//" + window.location.hostname + (window.location.port ? ':' + window.location.port: '');
	    }
	    window["context"] = location.origin+"/V6.0";
	}
	return window.location.origin;
}
function success(msg,callback){
	var index =  layer.msg(msg,{icon:1},function(){
		layer.close(index);
		typeof(callback)!='undefined' && callback();
	})
}
function error(msg){
	layer.msg(msg,{icon:0})
}
function openVideo(){
	var ht = '<div id="video-bg" style="width:100%;height:100%;position:fixed;left:0;right:0;top:0;bottom:0;background:rgba(0,0,0,0.7);z-index:888"></div>'+
 				'<div id="video" style="position:fixed;left:50%;top:50%;margin-top:-322px;margin-left:-400px;width:800px;height:600px;z-index:999">'+
	    		'<div style="padding: 0 80px 0 20px;height: 42px;line-height: 42px;border-bottom: 1px solid #eee; font-size: 14px;color: #333;overflow: hidden;background-color: #F8F8F8;border-radius: 2px 2px 0 0;">华亿配资和掌柜介绍</div>'+
	   			'<iframe src="/gywm/videojs.html" width="800px" height="536px"  style="border:0" allowfullscreen></iframe>'+
	   			'<div id="video-close" style="position: absolute;right: 15px;top: 8px;font-size:20px;color:#666;cursor:pointer;">×</div>'+
	 		'</div>';
	$('body').append(ht);
	$('#video-bg, #video-close').on('click',function(){$('#video,#video-bg').remove()});
}
var browser={  
    versions:function(){   
           var u = navigator.userAgent, app = navigator.appVersion;   
           return {//移动终端浏览器版本信息   
                trident: u.indexOf('Trident') > -1, //IE内核  
                presto: u.indexOf('Presto') > -1, //opera内核  
                webKit: u.indexOf('AppleWebKit') > -1, //苹果、谷歌内核  
                gecko: u.indexOf('Gecko') > -1 && u.indexOf('KHTML') == -1, //火狐内核  
                mobile: !!u.match(/AppleWebKit.*Mobile.*/), //是否为移动终端  
                ios: !!u.match(/\(i[^;]+;( U;)? CPU.+Mac OS X/), //ios终端  
                android: u.indexOf('Android') > -1 || u.indexOf('Linux') > -1, //android终端或者uc浏览器  
                iPhone: u.indexOf('iPhone') > -1 , //是否为iPhone或者QQHD浏览器  
                iPad: u.indexOf('iPad') > -1, //是否iPad    
                webApp: u.indexOf('Safari') == -1 //是否web应该程序，没有头部与底部  
            };  
     }(),  
     language:(navigator.browserLanguage || navigator.language).toLowerCase()  
}
function appJump(appurl){
	if(browser.versions.mobile || browser.versions.ios || browser.versions.android ||   
	    browser.versions.iPhone || browser.versions.iPad){        
		window.location.href = appurl; 
	}
}

//检测手机号
function phoneCheck(phone, errMsg){
	var isNull = /^[\s]{0,}$/;
	var phoneNumber = /^(13|14|15|17|18)[0-9]{9}$/; 
	var _check = getOrigin()+'/user/account/check.htm';
	var re = false;
	
	if (isNull.test(phone)) {
		error("手机号不能为空");
		return false;
	}
	if (!phoneNumber.test(phone)) { 
		error("手机号格式错误");
		return false;
	}  
	$.ajax({ 
		type: "POST",
		url: _check,
		async: false,
		data: {value:phone,evencheck:'phone'},
		success: function(data){
  			if (data.indexOf("04")>=0) {    
				error( errMsg || "该手机号已被使用" );
			}else{
				re = true;
			}
		},
		error: function(){
		}
	});
	return re;
}
//发送验证码
function sendCode(mobile){
	var data3={"type":"phone","target":mobile};
	$.ajax({ 
		dataType: 'html',
	   	type: 'post',
       	url: getOrigin()+'/user/account/sendActivateCode.htm',  
		data : data3,
       	success: function (json) {
       		var ct = eval(json);
    	   	if(ct.length>0 && ct[0].msg=='sussess'){
    	   		CountDown();
		   	}else{
		   		error(json.msg);
		   	}
  	    },
	     error:function(json){
	        error('获取验证码失败')
	    }
    });	
}


function buildQr(url){
	var qr = $('#qrcode');
	if(qr.html()==''){
		qr.qrcode({
		    render: "table",
		    width: 270,
		    height: 270,
		    text: url
		});
	}
	//捕获页
	layer.open({
	  type: 1,
	  shade: false,
	  title: false, //不显示标题
	  content: '<div style="width:270px;padding:20px 30px;text-align:center"><h3 style="margin-bottom:20px;font-size:20px;color:#FF5D2E">给好友发1张豪车券<br/>手机扫一扫，立即转发给好友</h3>'+qr.html()+'</div>', //捕获的元素
	  cancel: function(index){
	    layer.close(index);
	  }
	});
}
function goTop(){
	$('body,html').animate({scrollTop:0},500);
}

// 弹出层，基于dialog封装
var mydialog = {
	fail: function(content){
		this.show( {icon: 1, content: content, title: '', callback: function(d){
			setTimeout(function () {
			    d.close().remove();
			}, 3000);			
		}} );
	},
	success: function(content){
		this.show( {icon: 2, content: content, title: '', callback: function(d){
			setTimeout(function () {
			    d.close().remove();
			}, 3000);	
		}} )
	},
	show: function( options ){
		var settings = {
			title: '温馨提示',     //默认标题
			autofocus: false
		}
		typeof(options)=='string' && (settings = {content : options});
		settings = $.extend( {},settings,options );
		// 是否显示取消
		((settings.cancel && settings.cancelValue!='') && (settings.cancelValue = '取 消'));
		//是否显示确定
		((settings.ok && !settings.okValue) && (settings.okValue = '确 定'));

		settings.icon && (settings.content = '<i class="dialog-icon dialog-icon'+settings.icon+'"></i><div style="margin-left:40px">'+settings.content+'</div>');

		var d = dialog( settings );

		//弹出方式
		if(  settings.type=='showModal' ){
			d.showModal();
		}else{
			d.show( settings.id ? document.getElementById( settings.id ) : '' );
		}
		settings.callback && settings.callback(d)
	} 
}

function getBiaoText(stat){
	var text;
	switch(stat){
		case 'DFB':
			text = '待发布';
			break;
		case 'MBZ':
			text = '当前已满标';
			break;
		case 'YJQ':
			text = '已结清';
			break;
		case 'YZF':
			text = '已作废';
			break;
		default:
			text = '立即投资';
			break;	
	}
	return text;
}

