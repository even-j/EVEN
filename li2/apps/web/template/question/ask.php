<!--include file "common.php"-->
<!--include file "header.php"-->
<!--include file "nav.php"-->
<link rel="stylesheet" href="/public/web/css/serviceCenter.css">
<div class="doNotDoThat"></div>
<div class="c1000 clearfix">


    <div class="seeYouAgain">
      <a href="<?php echo \App::URL('web/question/view',array('type'=>'new'));?>">客服中心首页</a> &gt; <a href="<?php echo \App::URL('web/question/ask');?>">选择问题类型</a>
    </div>
    <ul class="select-style mgt30 w330">
     <form id="form1" name="form1" method="post" action="ask">
      <li>
        <a class="a-advice" href="<?php echo \App::URL('web/question/askType',array('typeid'=>1));?>">我要咨询</a>
      </li>
      <li>
        <a class="a-complain" href="<?php echo \App::URL('web/question/askType',array('typeid'=>2));?>">我要投诉</a>
      </li>
      <li>
        <a class="a-suggest" href="<?php echo \App::URL('web/question/askType',array('typeid'=>3));?>">我要建议</a>
      </li>
     </form>
    </ul>

  
</div>
<!-- content -->

<!--include file "footer.php"-->
</body>
</html>