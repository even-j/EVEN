<!--include file "admin_include.php"-->
<div class="container clearfix">
    <div class="main-wrap">
        <div class="search-wrap">
            <div class="search-content">
                <form action="/index.php" method="get">
                    <input type="hidden" name="app" value="admin" >
                    <input type="hidden" name="mod" value="user" >
                    <input type="hidden" name="ac" value="search_list" >
                    <table class="search-tab">
                        <tr>
                            <th width="70">用户ID:</th>
                            <td><input class="common-text" placeholder="用户ID" name="user_id" value="<?php echo empty($_GET['user_id'])?'':$_GET['user_id']?>" id="" type="text"></td>
                            <th width="70">昵称:</th>
                            <td><input class="common-text" placeholder="昵称" name="user_nick" value="<?php echo empty($_GET['user_nick'])?'':$_GET['user_nick']?>" id="" type="text"></td>
                            <th width="70">姓名:</th>
                            <td><input class="common-text" placeholder="姓名" name="user_name" value="<?php echo empty($_GET['user_name'])?'':$_GET['user_name']?>" id="" type="text"></td>
                            
                            <td><input class="btn btn-primary btn2" name="sub" value="查询" type="submit"></td>
                        </tr>
                    </table>
                </form>
            </div>
        </div>
       <!--<div class="toolbar-wrap">
            <div class="toolbar-item">
                <a href="/index.php?app=admin&mod=user&ac=add"><i class="icon-font"></i>添加会员</a>
                <a id="batchDel" href="javascript:void(0)"><i class="icon-font"></i>批量删除</a>
                <a id="updateOrd" href="javascript:void(0)"><i class="icon-font"></i>更新排序</a>
            </div>
        </div>-->
        <div class="result-wrap">
            <form name="myform" id="myform" method="post">
                <div id="div_content" class="result-content" style="width:100%;overflow: auto">
                    <table class="result-tab" style="width:100%" >
                        <tr>
                            <th class="tc" width="40px"><input class="allChoose" name="" type="checkbox"></th>
                            <th style="width:40px">ID</th>
                            <th style="width:120px">昵称</th>
                            <th style="width:80px">姓名</th>
                            <th style="width:100px">手机</th>
                            <th style="width:120px">注册时间</th>
                            <th style="width:40px">状态</th>
                            <!--<th style="width:120px">操作</th>-->

                        </tr>
                        <?php foreach ($list as $item){?>
                            <tr>
                                <td class="tc"><input name="id[]" id="<?php echo $item['user_id'] ?>" value="59" type="checkbox"></td>
                                <td><a href="javascript:void(0);" title="查看个人详细信息"><?php echo $item['user_id'] ?></a></td>
                                <td><?php echo $item['user_nick'] ?></td>
                                <td><?php echo $item['user_name'] ?></td>
                                <td><?php echo $item['mobile'] ?></td>
                                <td><?php echo empty($item['reg_time'])?'':date('Y-m-d H:i',$item['reg_time']) ?></td>
                                <td><?php echo empty($item['state'])?'<span class="red">停用</span>':'在用' ?></td>
                                <!--<td>
                                    <a class="link-update" href="#">修改</a>
                                    <a class="link-del" href="#">删除</a>
                                </td>-->
                            </tr>
                        <?php }?>             
                    </table>
                    
                </div>
            </form>
        </div>
       <div class="list-page"><?php echo $pager;?></div>
       <div style="text-align:center"><input class="btn-primary btn6" type="button" value="确定" onclick="window.close()"/></div>
    </div>
    <script>
        var selected_userid = {};
        $(function(){
            //显示已选择
            var table = $('.result-tab')[0];
            var uservalue = ','+$('#user_ids', window.opener.document).val()+','; 
            for(var i=1;i<table.rows.length;i++){
                var row = table.rows[i];
                var check = $(row.cells[0]).children().first();
                var id = check.attr('id');
                if(uservalue.indexOf(','+id+',')>=0){
                    check.attr('checked',true);
                    setRowColor(check[0]);
                }
            }
             $("input[type='checkbox']").click(function(){
                 var id = $(this).attr('id');
                 
                 if($(this).is(':checked')){
                     //selected_userid[id] = id;
                     addUserValue(id);
                     setRowColor(this);
                 }
                 else{
                     removeUserValue(id);
                     //delete selected_userid[id];
                     clearRowColor(this);
                 }
             });
        })
        $(function(){
            var winHeight = $(window).height();
            var crumbHeight = $('.crumb-list').height() || 0;
            var searchHeight = $('.search-wrap').height()+31 || 0;
            var toolHeight = $('.toolbar-wrap').height() || 0;
            var pagerHeight = $('.list-page').height() || 0;
            var conHeight = 360;//winHeight - crumbHeight - searchHeight - toolHeight - pagerHeight -120;
            $('#div_content').height(conHeight);
        })
        function setRowColor(obj){
            $(obj).parent().parent().css('background','red');
        }
        function clearRowColor(obj){
            $(obj).parent().parent().css('background','');
        }
        function addUserValue(id){
            var uservalue = $('#user_ids', window.opener.document).val();
            if(uservalue == ''){
                uservalue +=  id;
            }
            else{
                uservalue +=  ','+id;
            }
            $('#user_ids', window.opener.document).val(uservalue);
        }
        function removeUserValue(id){
            var uservalue = $('#user_ids', window.opener.document).val();
            var newvalue = '';
            var arr_user = uservalue.split(',');
            for(var i=0;i<arr_user.length;i++){
                if(arr_user[i]!=id){
                    if(newvalue==''){
                        newvalue += arr_user[i];
                    }
                    else{
                        newvalue += ','+arr_user[i];
                    }
                }
            }
            $('#user_ids', window.opener.document).val(newvalue);
        }
    </script>
    <!--/main-->
</div>
<!--include file "admin_bottom.php"-->