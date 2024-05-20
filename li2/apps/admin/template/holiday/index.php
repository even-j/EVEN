<!--include file "admin_include.php"-->
<link type="text/css" href="/public/admin/css/jquery-ui-1.8.17.custom.css" rel="stylesheet" />
<link type="text/css" href="/public/admin/css/jquery-ui-timepicker-addon.css" rel="stylesheet" />
<script type="text/javascript" src="/public/admin/js/jquery-ui-1.8.17.custom.min.js"></script>
<script type="text/javascript" src="/public/admin/js/jquery-ui-timepicker-addon.js"></script>
<script type="text/javascript" src="/public/admin/js/jquery-ui-timepicker-zh-CN.js"></script>
<script type="text/javascript">
    $(function () {
        $(".ui_timepicker").datetimepicker();
    })
</script>
<div class="container clearfix">
    <div class="main-wrap">
        <!--include file "admin_nav.php"-->
        <div class="search-wrap">
            <div class="search-content">
                <form action="/index.php" method="get">
                	<input type="hidden" name="app" value="admin" >
                	<input type="hidden" name="mod" value="holiday" >
                	<input type="hidden" name="ac" value="view" >
                    <table class="search-tab">
                        <tr>
                            <th width="80">日期:</th>
                            <td><input class="common-text ui_timepicker" placeholder="开始时间" name="begindate" value="<?php echo $condition['begindate']?>" id="begindate" type="text"> — </td>
                            <td><input class="common-text ui_timepicker" placeholder="结束时间" name="enddate" value="<?php echo $condition['enddate']?>" id="enddate" type="text"></td>
                            <th width="80"><input class="btn btn-primary ml10 btn10" name="sub" value="查询" type="submit"></td>
                        </tr>
                    </table>
                </form>
            </div>
        </div>
        <div class="search-wrap">
        	 <form action="/index.php?app=admin&mod=holiday&ac=doEdit" method="post" id="myform" name="myform" enctype="multipart/form-data">
        	 	   <table class="search-tab">
                        <tr>
                            <th width="90"><i class="require-red">*</i>节假日：</th>
                            <td><input class="common-text ui_timepicker" id="hdate" name="hdate" size="45" value="" type="text"></td>
                            <th width="80"><input class="btn btn-primary btn10 ml10" name="submit" value="添加" type="submit"></td>
                        </tr>
                    </table>
              </form>
        </div>
        <div class="result-wrap">
            	<div class="result-title">
                    <div class="result-list">
                        <!--<a href="/index.php?app=admin&mod=holiday&ac=edit" target="mainFrame"><i class="icon-font"></i>添加广告</a>
                        <a id="batchDel" href="javascript:void(0)"><i class="icon-font"></i>批量删除</a>
                        <a id="updateOrd" href="javascript:void(0)"><i class="icon-font"></i>更新排序</a>-->
                    </div>
                </div>
                <div class="result-content">
                    <table class="result-tab" width="100%">
                        <tr>
                            <th style="width:40%;">节假日编号</th>
                            <th style="width:40%;">节假日时间</th>
                            <th>操作</th>
                        </tr>
                        <?php foreach ($dataList as $data){?>
                        <tr>
                            <td><?php echo $data['id'];?></td>
                            <td title="双击可编辑哦" style="cursor:pointer;"><div class="edit"><span><?php echo $data['hdate'];?></span><input id="<?php echo $data['id'];?>" class="common-text none" style="width:100px;" type="text" name="hdate" value="<?php echo $data['hdate'];?>" /></div></td>
                            <td>
                                <!--<a class="link-update" href="#">修改</a>-->
                                <a class="link-del" href="/index.php?app=admin&mod=holiday&ac=del&id=<?php echo $data['id'];?>">删除</a>
                            </td>
                        </tr>
                        <?php }?>
                    </table>
                    <div class="list-page"><?php echo $pager;?></div>
                </div>
        </div>
    </div>
    <!--/main-->
</div>

<script type="text/javascript">
<!--
$(document).ready(function(){
	$('#myform').submit(function(){
		if($('#hdate').val()==""){
			layer.msg('请选择您要添加的节假日!');
			$('#hdate').focus();
			return false;
		}
		
		return true;
	});
});
//-->
</script>

<script type="text/javascript">
<!--
$(document).ready(function(){
  
  $(".edit").dblclick(function(){
	   var obj = $(this).find('span');
	   var input = $(this).find('input');
	   var id = input.attr('id');
       obj.hide();
	   input.show();
	   $('#'+id).blur(function(){
		    var hdate = $(this).val();
		    if(hdate!=''){
			       $.post('/index.php?app=admin&mod=holiday&ac=ajaxHdate',{"hdate":hdate,"id":id},function(res){
						 if(res.code=='1'){
							 obj.text(res.hdate);
						 }
						 obj.show();
						 input.hide();
					},'json').error(function(XMLHttpRequest, textStatus, errorThrown){
						 if(XMLHttpRequest.status==200){
							 layer.msg('你没有操作权限');
						 }else{
		                	  layer.msg(textStatus+' '+errorThrown);
		                  }
						 obj.show();
						 input.hide();
			        });
		     }else{
		    	//$(this).focus();
		    	 layer.msg('日期填写错误');
		     }
		});

	   input.focus();
	   input.val(input.val());
  });

  
});

//-->
</script>
<!--include file "admin_bottom.php"-->