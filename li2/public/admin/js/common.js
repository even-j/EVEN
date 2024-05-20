//内容层高度设置
$(function(){
//    var winHeight = $(window).height();
//    var crumbHeight = $('.crumb-list').height() || 0;
//    var searchHeight = $('.search-wrap').height()+31 || 0;
//    var toolHeight = $('.toolbar-wrap').height() || 0;
//    var pagerHeight = $('.list-page').height() || 60;
//    var conHeight = winHeight - crumbHeight - searchHeight - toolHeight - pagerHeight;
//    $('#div_content').height(conHeight);
})
//输入限制
function inputCheck(obj,type){
    var len = 0;
    switch(type){
        case "tel":
            len = 11;
            break;
        case "idcard":
            len = 18;
            break; 
        case "telcode":
            len = 4;
            break; 
        case "bankno":
            len = 19;
            break; 
        case "money":
            len = 10;
            break; 
        case "pwd":
            len = 20;
            break; 
    }
    var value = $(obj).val();
    //长度处理
    if(type == "tel"|| type == "idcard" || type == "telcode" || type == "bankno" || type=="pwd"){
        if(value.length>len){
            value = value.substr(0,len);
            $(obj).val(value);
        }
    }
    // 非数字判断处理
    if(type == "tel" || type == "telcode" || type == "bankno"){
        if(value.length>0){
            var lastbit = value.substr(value.length-1,1);
            // 非数字
            if(isNaN(lastbit)){
                value = value.substr(0,value.length-1);
                $(obj).val(value);
            }
        }
    }
    
    //money单独处理
    if(type == "money"){
        //长度处理
        if(value.indexOf('.') >=0){
            len = len+3;
        }
        if(value.length>len){
            value = value.substr(0,len);
            $(obj).val(value);
        }
        //第一位0处理
        if(value == '0'){
            value = '';
            $(obj).val(value);
        }
        //非数字判断处理,除了小数和数字可录入
        if(value.length>0){
            var lastbit = value.substr(value.length-1,1);
            if(lastbit!='.' && isNaN(lastbit)){
                value = value.substr(0,value.length-1);
                $(obj).val(value);
            }
        }
        //点后面超过3位截取
        if (value.length >= 4){
            var last4bit = value.substr(value.length-4,1);
            if(last4bit == '.'){
                value = value.substr(0,value.length-1);
                $(obj).val(value);
            }
        }
    }
    //中文判断
    var reg = /^[^\u4E00-\u9FA5]+$/i;
    value = value.replace(/[\u4E00-\u9FA5]/gi,'');
    $(obj).val(value);
}

function IDCardCheck(num) {
    num = num.toUpperCase();
    //身份证号码为15位或者18位，15位时全为数字，18位前17位为数字，最后一位是校验位，可能为数字或字符X。   
    if (!(/(^\d{15}$)|(^\d{17}([0-9]|X)$)/.test(num))) {
        return false;
    }
    //校验位按照ISO 7064:1983.MOD 11-2的规定生成，X可以认为是数字10。 
    //下面分别分析出生日期和校验位 
    var len, re;
    len = num.length;
    if (len == 15) {
        re = new RegExp(/^(\d{6})(\d{2})(\d{2})(\d{2})(\d{3})$/);
        var arrSplit = num.match(re);

        //检查生日日期是否正确 
       
        var dtmBirth = new Date('19' + arrSplit[2] + '/' + arrSplit[3] + '/' + arrSplit[4]);
        var bGoodDay;
        bGoodDay = (dtmBirth.getYear() == Number(arrSplit[2])) && ((dtmBirth.getMonth() + 1) == Number(arrSplit[3])) && (dtmBirth.getDate() == Number(arrSplit[4]));
        if (!bGoodDay) {
            return false;
        }
        else {
            //将15位身份证转成18位 
            //校验位按照ISO 7064:1983.MOD 11-2的规定生成，X可以认为是数字10。 
            var arrInt = new Array(7, 9, 10, 5, 8, 4, 2, 1, 6, 3, 7, 9, 10, 5, 8, 4, 2);
            var arrCh = new Array('1', '0', 'X', '9', '8', '7', '6', '5', '4', '3', '2');
            var nTemp = 0, i;
            num = num.substr(0, 6) + '19' + num.substr(6, num.length - 6);
            for (i = 0; i < 17; i++) {
                nTemp += num.substr(i, 1) * arrInt[i];
            }
            num += arrCh[nTemp % 11];
            return true;
        }
    }
    if (len == 18) {
        re = new RegExp(/^(\d{6})(\d{4})(\d{2})(\d{2})(\d{3})([0-9]|X)$/);
        var arrSplit = num.match(re);
        //检查生日日期是否正确 
        var dtmBirth = new Date(arrSplit[2] + "/" + arrSplit[3] + "/" + arrSplit[4]);
        var bGoodDay;
        bGoodDay = (dtmBirth.getFullYear() == Number(arrSplit[2])) && ((dtmBirth.getMonth() + 1) == Number(arrSplit[3])) && (dtmBirth.getDate() == Number(arrSplit[4]));
        if (!bGoodDay) {
            return false;
        }
        else {
            //检验18位身份证的校验码是否正确。 
            //校验位按照ISO 7064:1983.MOD 11-2的规定生成，X可以认为是数字10。 
            var valnum;
            var arrInt = new Array(7, 9, 10, 5, 8, 4, 2, 1, 6, 3, 7, 9, 10, 5, 8, 4, 2);
            var arrCh = new Array('1', '0', 'X', '9', '8', '7', '6', '5', '4', '3', '2');
            var nTemp = 0, i;
            for (i = 0; i < 17; i++) {
                nTemp += num.substr(i, 1) * arrInt[i];
            }
            valnum = arrCh[nTemp % 11];
            if (valnum != num.substr(17, 1)) {
                return false;
            }
            return true;
        }
    }
    return false;
}
/*获取顶部选项卡总长度*/
function tabNavallwidth(){
	var taballwidth=0,
		$tabNav = $(".acrossTab"),
		$tabNavWp = $(".Hui-tabNav-wp"),
		$tabNavitem = $(".acrossTab li"),
		$tabNavmore =$(".Hui-tabNav-more");
	if (!$tabNav[0]){return}
	$tabNavitem.each(function(index, element) {
        taballwidth+=Number(parseFloat($(this).width()+60))});
	$tabNav.width(taballwidth+25);
	var w = $tabNavWp.width();
	if(taballwidth+25>w){
		$tabNavmore.show()}
	else{
		$tabNavmore.hide();
		$tabNav.css({left:0})}
}
//打开窗口
function openWin(title,url){
    var bStop=false;
    var bStopIndex=0;
    var _href=url;
    var _titleName=title;
    var topWindow=$(window.parent.document);
    var show_navLi=topWindow.find("#min_title_list li");
    show_navLi.each(function() {
        if($(this).find('span').attr("data-href")==_href){
            bStop=true;
            bStopIndex=show_navLi.index($(this));
            return false;
        }
    });
    if(!bStop){
        creatIframe2(_href,_titleName);
        min_titleList2();
    }
    else{
        show_navLi.removeClass("active").eq(bStopIndex).addClass("active");
        var iframe_box=topWindow.find("#iframe_box");
        iframe_box.find(".show_iframe").hide().eq(bStopIndex).show().find("iframe").attr("src",_href);
    }
}
function creatIframe2(href,titleName){
    var topWindow=$(window.parent.document);
    var show_nav=topWindow.find('#min_title_list');
    show_nav.find('li').removeClass("active");
    var iframe_box=topWindow.find('#iframe_box');
    show_nav.append('<li class="active"><span data-href="'+href+'">'+titleName+'</span><i></i><em></em></li>');
    tabNavallwidth2();
    var iframeBox=iframe_box.find('.show_iframe');
    iframeBox.hide();
    iframe_box.append('<div class="show_iframe"><div class="loading"></div><iframe frameborder="0" src='+href+'></iframe></div>');
    var showBox=iframe_box.find('.show_iframe:visible');
    showBox.find('iframe').attr("src",href).load(function(){
        showBox.find('.loading').hide();
    });
}
function min_titleList2(){
    var topWindow=$(window.parent.document);
    var show_nav=topWindow.find("#min_title_list");
    var aLi=show_nav.find("li");
};
function tabNavallwidth2(){
    var topWindow = $(window.parent.document);
	var taballwidth=0,
		$tabNav = topWindow.find(".acrossTab"),
		$tabNavWp = topWindow.find(".Hui-tabNav-wp"),
		$tabNavitem = topWindow.find(".acrossTab li"),
		$tabNavmore =topWindow.find(".Hui-tabNav-more");
	if (!$tabNav[0]){return}
	$tabNavitem.each(function(index, element) {
        taballwidth+=Number(parseFloat($(this).width()+60))});
	$tabNav.width(taballwidth+25);
	var w = $tabNavWp.width();
	if(taballwidth+25>w){
		$tabNavmore.show()}
	else{
		$tabNavmore.hide();
		$tabNav.css({left:0})}
}