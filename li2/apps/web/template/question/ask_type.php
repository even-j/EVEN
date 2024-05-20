<!--include file "common.php"-->
<!--include file "header.php"-->
<!--include file "nav.php"-->
<link rel="stylesheet" href="/public/web/css/serviceCenter.css">
<script type="text/javascript" src="/public/web/js/layer.min.js"></script>
<div class="doNotDoThat"></div>
<div class="c1000 clearfix">

<div class="seeYouAgain">
      <a href="<?php echo \App::URL('web/question/view',array('type'=>'new'));?>">客服中心首页</a> &gt; <a href="<?php echo \App::URL('web/question/ask');?>">选择问题类型</a>
       &gt; <a href="<?php echo \App::URL('web/question/askType',array('typeid'=>$typeid));?>"><span><?php echo $type[$typeid];?></span>详情</a>
    </div>
<form id="form1" name="form1" method="post" action="<?php echo \App::URL('web/question/doQuestion');?>" onsubmit="return check_content();">


<div class="sug-sub-title clearfix">
    <img width="85" height="85" src="/public/web/images/kf_0.jpg">
    <p>您好，我是<?php echo SITE_NAME;?>客服，请告诉我您的问题，我将亲自为您解决。</p>
</div>


  <ul class="advice-form clearfix">
        <li>
          <div class="ad-item">
                <input type="hidden" name="typeid" value="<?php echo $typeid?>">
          </div>
        </li>
        <li>
          <div class="ad-item">
            <label><span style="color: red;">*</span><span><?php echo $type[$typeid];?></span>内容：</label>
            <textarea name="content" id="content" placeholder="请尽量清楚详细的表达您的问题，以便客服更准确地解答您的困惑哦" class="txta"></textarea>

          </div>
        </li>
        <?php if($typeid==2){?>
		<!--我的建议模块-->
         <li>
              <div class="ad-item">
                  <label><span></span>我的方案：</label>
                  <textarea name="advice" id="advice" placeholder="请告诉我们您的解决方案，以便我们参考，谢谢！" class="txta"></textarea>
              </div>
          </li>
      	<?php }?>
        <li style="padding-bottom:20px;">
          <div class="ad-item">
            <label>联系方式：</label>
            <div class="cont-ipt">
              <input class="contact" type="text" placeholder="手机" name="mobile" id="mobile" value="<?php echo $mobile;?>">
              <input class="contact" type="hidden" placeholder="QQ" name="oicq" id="oicq" >
              <input class="contact" type="hidden" placeholder="微信" name="wechat" id="wechat">
            </div>
          </div>
          <p class="pCont-tips" style="display:none;">必填手机号填一个(联系方式仅<?php echo SITE_NAME;?>客服可见)。</p>
        </li>
        <!--
        <li>
          <div class="ad-item">
            <label>验证码：</label>
            <input class="valid-ipt" type="text" />
            <img width="100" height="32" src="images/code_img.png" />
            <a class="change-tbn" href="javascrip:void(0);">看不清，换一张</a>
          </div>
        </li>
        -->
<script>
<!--
  $("#wechat").blur(function(){
    //alert(this.id);
    //alert(10);
    var val = this.value;
    var reg=/^[1-9][0-9]{4,}$/;
    if(!reg.test(val))
    {
        return false;
        //alert(this.id);
      }      
    });
    
  $("#oicq").blur(function(){
    //alert(this.id);
    //alert(10);
    var val = this.value;
    var reg=/^[1-9][0-9]{4,}$/;
    if(!reg.test(val))
    {
        return false;
        //alert(this.id);
      }      
    });

  $("#mobile").blur(function(){
    //alert(this.id);
    //alert(10);
    var val = this.value;
    var reg=/^1[3|4|5|8][0-9]\d{4,8}$/;
    if(!reg.test(val))
    {
        return false;
        //alert(this.id);
      }      
    });

-->
</script>  
            <input style="cursor:pointer" class="f-submit-btn" id="submit" type="submit" value="提交<?php echo $type[$typeid];?>">
        </li>
      </ul>
</form>

<script language="javascript">
$(function () {
	$("#content").on('click', function(){
		$("#submit").show();
	});
	$("#mobile").on('click', function(){
		$("#submit").show();
	});
	
	  $("#submit").on('click',function(){
		  $("#submit").hide();
		
	    if($("#content").val()  == '' ||　$("#content").val().length < 10 ){
	          	var con = $("#content").val().length;
	            layer.tips('内容不能为空,且不能少于10个字符', $("#content"), {
	                time: 3,
	                style: ['background-color:#F4A460; color:#fff', '#F4A460'],
	                maxWidth:240
	             });
	          	return false;
	      
	      }else if($("#mobile").val() != ''){

				  var tel = $("#mobile").val();
		    	  var regPartton=/1[3-8]+\d{9}/;
		    	  if(!regPartton.test(tel)){
		    		  layer.tips('请输入正确手机号', $("#mobile"), {
			   	           time: 3,
			   	           style: ['background-color:#F4A460; color:#fff', '#F4A460'],
			   	           maxWidth:240
			   	         });
			   	       return false;	
			    	}
	     }else{
// 	    	var str = $('#content').val();
// 		 		if(str.match(/^(\d+)$/) || str.match(/^([a-zA-Z]+)$/)) {
// 		 			layer.tips('内容不为纯数字与字母!!', $("#content"), {
// 		 				time: 3,
// 		 		        style: ['background-color:#F4A460; color:#fff', '#F4A460'],
// 		 		        maxWidth:240,
// 		 		     });
// 		 			$.ajax({
// 				  		   type: "POST",
// 				  		   url: "/yAsk/ajaxFilterIp",
// 					  	   async : false,
// 				  		   success: function(msg){
// 					  		     alert(msg);
// 					  			 return false;
// 								 if(msg==1 ){
// 					  				 msg="请勿恶意提交";
// 						  			alert(msg);
						  			
// 					  				}
				  				
// 				  		   }
// 				  		});
// 		 		}
// 	         $("form1").submit();
	    	 
	     }
	  });
});

//失去焦点事件
$("#content").blur( function () { 
		var	str = $('#content').val();
		if(str == '' ||　str.length < 10 ){
			layer.tips('内容不能为空,且不能少于10个字符', $("#content"), {
			time: 3,
	        style: ['background-color:#F4A460; color:#fff', '#F4A460'],
	        maxWidth:240
	     });
	     	return false;
	  	}
});

function check_content(){
	/*$.ajax({
		   type: "POST",
		   url:  "<?php echo \App::URL('web/question/ajaxFilterIp')?>",
	  	   async : false,
		   success: function(msg){
				 if(msg==1 ){
	  				 msg="您提交的时间太过频繁，请稍后再试！！";
					 alert(msg);
					 return false;
	  			  }else{

			  	  }
		   }
		});*/
	
	var str = $('#content').val();
	var stt = (str.replace(/[ ]/g,""));

	var patt1 = new RegExp(/^(\d+)$/);
	var result1 =  patt1.test(str);
	var patt2 =  new RegExp(/^([a-zA-Z]+)$/);
	var result2 =  patt2.test(str);
	var patt3 =  new RegExp(/^[A-Za-z0-9]+$/);
	var result3 =  patt3.test(str);
	if(result1 == true || result2 == true|| result3 ==true){
		layer.tips('内容不为纯数字与字母!!', $("#content"), {
			time: 3,
	        style: ['background-color:#F4A460; color:#fff', '#F4A460'],
	        maxWidth:240,
	     });
	     return false;
	}
	
	 var tel = $("#mobile").val();
	  var regPartton=/1[3-8]+\d{9}/;
	  if(!regPartton.test(tel)){
		  layer.tips('请输入正确手机号', $("#mobile"), {
 	           time: 3,
 	           style: ['background-color:#F4A460; color:#fff', '#F4A460'],
 	           maxWidth:240
 	         });
 	       return false;	
  	}

		
}

function strFilter(str1){
    str1 = str1.replace('^', '', str1);
    str1 = str1.replace('&', '', str1);
    str1 = str1.replace('\\', '', str1);
    str1 = str1.replace('\'', '', str1);
    str1 = str1.replace('/', '', str1);
    $str = str1.replace('　', '', $str);
    return str1;
}


</script>




</div>
<!-- content -->

<!--include file "footer.php"-->
</body>
</html>