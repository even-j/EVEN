<!--include file "common.php"-->
<!--include file "header.php"-->
<!--include file "nav.php"-->
<link rel="stylesheet" href="/public/web/css/serviceCenter.css">
<div class="doNotDoThat"></div>
<div class="c1000 clearfix">

	<div class="search-box clearfix">
		<h2>客服中心</h2>
		<div class="ask-block">
			 <form name="form1" method="get" action="/index.php" onsubmit="return cksearch();">
	          <input type="hidden" name="app" value="web" />
	          <input type="hidden" name="mod" value="question" />
	          <input type="hidden" name="ac" value="view" />
	          <input class="ipt-txt" id="keyword_s" type="text" name="keyword" placeholder="请输入问题的关键字" value="<?php echo isset ( $_GET ['keyword'] ) ?  ( $_GET ['keyword'] ) :'';?>">
	          <input class="submit-btn" type="submit" value="搜索解答">
	          <em class="magnifier"></em>
	        </form>
		</div>
		<a class="ask-btn" href="<?php echo \App::URL('web/question/ask');?>">提问</a>
	</div>

	<script type="text/javascript">
<!--
function cksearch(){
	if (document.getElementById("keyword_s").value=='')
	{
		alert('关键字不能为空!');
		return false;
	}
}
//-->
</script>

	<link rel="stylesheet" type="text/css" href="/public/web/css/common.css">

		<!--问题详细页面导航-->

		<div class="div-back clearfix">
			<a class="back-list" href="<?php echo \App::URL('web/question/view',array('type'=>'new'));?>">
				<i class="l-ar"></i>
				返回列表
			</a>
		</div>
					<div class="user-msg-block clearfix">
			<div class="msg-title clearfix">
				<h3><?php echo $question ['type_name'];?></h3>
				<div class="right-view">
					查看：<a class="colorf60" href="#"><?php echo $question['views'];?></a>&nbsp;|&nbsp; 回复：<a class="colorf60" href="#"><?php echo count($answerList);?></a>
				</div>
			</div>
			<div class="user-cont clearfix">
				<div class="user-info">
					<dl class="uInfo">
						<dt><img src="<?php echo $question['photo'];?>" width="74" height="74" ></dt>
						<dd>
							<strong class="uName"><?php echo $question['username'];?></strong>
						</dd>
					</dl>
				</div>
				<div class="spec-msg">
					<div class="time-show">
			            发布时间：<?php echo date('Y-m-d H:i:s',$question['que_time']);?></div>
					<div class="cont-txt">
						<div class="c-text">
						<?php echo $question['content'];?>
						</div>
				  </div>

					<!--新加内容-->
                    <!-- <div class="speed_progress">
                     	<span class="progress_title">处理进度：</span>
                     	<i class="progress_img"></i>
                     	<strong class="progress_submit ">提交问题</strong>
                     	<strong class="progress_communicate ">客服沟通</strong>
                     	<strong class="progress_complete ">处理完成</strong>
                    </div> -->

				</div>
			</div>
			
			<!-- 回复的内容 -->
			<?php if($answerList){?>
			<?php foreach ($answerList as $answer){?>
			<div class="user-cont clearfix">
				<div class="user-info">
					<dl class="uInfo"><dt>
								<img src="/public/web/images/kf_0.jpg" width="80" height="80">
							</dt>
							<dd><strong class="uName"><?php echo $answer['user_name'];?></strong></dd>
							<dd><a href="javascript:;"><?php echo $answer['user_job'];?></a></dd>
					</dl>
				</div>
				<div class="spec-msg">
					<div class="time-show">回答时间：<?php echo \App::format_date($answer['ans_time']);?></div>
					<div class="service-as">
						<i class="s-as"></i>
						客服回答
					</div>
					<div class="cont-txt">
						<div class="c-text">
							<?php echo htmlspecialchars_decode(html_entity_decode($answer['content']));?>
						</div>
						<div class="bottom-text"></div>
					</div>

					<!--新加内容-->
												         
                     	                    


                  
				</div>
			</div>
			<?php }?>
			<?php }?>
									<div id="sent_the_answer_now"></div>
			<br>

			<!-- 发表回复 -->

			
	</div>
</div>

<script type="text/javascript">
$('#reply').on('click', function(){
    var data = {
    	content: $('#content').val(),
    	question_id: 4668,
    	resolve_content: $('#resolve').val(),
    	union_user_show: $('input[name=union_user_show]').val(),
        advice_show: $('input[name=advice_show]:checked').val(),
        finish_time: $('input[name=finish_time]').val(),
        fix_time: $('input[name=fix_time]').val()
    };
    if (!data.content) { alert('请填写回复内容！'); return false; }
        	if (!data.resolve_content) { alert('请填写回复方案！'); return false; }
	    if (!data.fix_time) { alert('请填写落实时间！'); return false; }
	    if (!data.finish_time) { alert('请填写完成时间！'); return false; }
        
	$.ajax({
		type: "POST",
	    url: "/YQuestion/reply",
	    data: data,
	    success: function(msg){
			if( msg == 1 ){
				window.location = "http://www.658.com/YQuestion";
				return false;
			}else{
				alert('回复失败！');
				return false;
			}
		}
	});
	
});
//点赞
$(document).ready(function(e) {
    //点赞实现
    $('a.dianzhan').click(function(){
        var r_id=$(this).attr('id'),
            $this = $(this);
        $.ajax({
            type: "POST",
            url: "/YQuestion/zan",
            data: "r_id="+r_id,
            success: function(msg){
                if( msg == -1 ){
                   // alert('只能点赞一次');
                    return false;
                } else {
                    $this.find('strong').find('span').html(msg);
                    $this.find('strong').css("background-position","26px -33px");
                }
            }
        });
    });
});

//解决方案
// $('input[name=resolve]').on('click', function () {
// 	var v = $(this).val();
// 	if (v == 1) {
// 		$('#resolve').show();
// 	} else {
// 		$('#resolve').hide();
// 	}
// });
// 解决方案仅当前用户可见 
$('input[name=union_user_show]').on('click', function () {
	var v = $(this).val();
	if (v == 1) {
		$(this).val(2);
	} else {
		$(this).val(1);
	}
});
</script>

<!-- content -->

<!--include file "footer.php"-->
</body>
</html>