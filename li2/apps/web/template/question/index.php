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


<div class="c1000 clearfix">
    <div class="qa-list">
      <ul class="subNav clearfix">
        <li <?php if($type!='my'){?>class="current"<?php }?>><a href="<?php echo \App::URL('web/question/view',array('type'=>'new'));?>">大家正在问</a></li>
        <li <?php if($type=='my'){?>class="current"<?php }?>><a href="<?php echo \App::URL('web/question/view',array('type'=>'my'));?>">我的提问(<?php echo $my_question_num;?>)</a>
        </li>
      </ul>
      <ul class="tags-menu clearfix">
        <li <?php if($type=='new'){?>class="current"<?php }?>>
          <a href="<?php echo \App::URL('web/question/view',array('type'=>'new'));?>">最新</a>
          <i class="ar-down"></i>
        </li>
        <li <?php if($type=='hot'){?>class="current"<?php }?>>
          <a href="<?php echo \App::URL('web/question/view',array('type'=>'hot'));?>">热门</a>
          <i class="ar-down"></i>
        </li>
        <li <?php if($type=='1'){?>class="current"<?php }?>>
          <a  href="<?php echo \App::URL('web/question/view',array('type'=>1));?>">咨询</a>
          <i class="ar-down"></i>
        </li>
        <li <?php if($type=='2'){?>class="current"<?php }?>>
          <a  href="<?php echo \App::URL('web/question/view',array('type'=>2));?>">投诉</a>
          <i class="ar-down"></i>
        </li>
        <li <?php if($type=='3'){?>class="current"<?php }?>>
          <a  href="<?php echo \App::URL('web/question/view',array('type'=>3));?>">建议</a>
          <i class="ar-down"></i>
        </li>
         <li <?php if($type=='4'){?>class="current"<?php }?>>
          <a  href="<?php echo \App::URL('web/question/view',array('type'=>4));?>">垃圾箱</a>
          <i class="ar-down"></i>
        </li>
        
      </ul>
      <div id="tip-list"><!--
-->
<table class="qa-table">
        <tbody><tr class="qa-th-bg">
          <th class="w280">问题描述</th>          
          <th>提问时间</th>
          <th>回答时间</th>
          <th>回复状态</th>
          <th>浏览量</th>
        </tr>

<!---->
		<?php foreach ($dataList as $data){?>
		 <tr><td height="20" title="" class="left w280"><?php echo $data['type_name'];?> 
		 <a href="<?php echo \App::URL('web/question/show',array('id'=>$data['que_id']));?>" target="_blank" title="<?php echo $data['content'];?>">
		 <?php echo \App::msubstr($data['content'],0,20);?></a>
		 </td>
         <td align="center" valign="middle"><?php echo date('Y-m-d H:i:s',$data['que_time']);?></td>
         <td align="center" valign="middle"><?php echo $data['reply_time'] ? \App::format_date($data['reply_time']) : '';?></td>
		 <td align="center" valign="middle"><?php echo $data['status'];?></td>
		 <td align="center" valign="middle"><?php echo $data['views'];?></td>
		 </tr>
		<?php }?>
	<!---->
        </tbody></table>	 
			  <div class="ui-page clearfix">
				  <div class="list-page clearfix">
				  <?php echo $pager;?>
				  </div>
			</div>
<!----></div>

    </div>
  </div>

  </div>  
<!-- content -->

<!--include file "footer.php"-->
</body>
</html>