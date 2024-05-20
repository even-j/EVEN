<!--include file "admin_include.php"-->
<div class="container clearfix">
    <div class="main-wrap">
       <!--include file "admin_nav.php"-->
        <div class="search-wrap">
            <div class="search-content">
                <form action="/index.php" method="get">
                    <input type="hidden" name="app" value="admin" >
                    <input type="hidden" name="mod" value="user" >
                    <input type="hidden" name="ac" value="bank" >
                    <table class="search-tab">
                        <tr>
                            <th width="70">手机号:</th>
                            <td><input class="common-text" style="width:120px;" placeholder="手机号" name="mobile" value="<?php echo empty($_GET['mobile'])?'':$_GET['mobile']?>" id="" type="text"></td>
                            <td><input class="btn btn-primary btn10" name="sub" value="查询" type="submit"></td>
                         </tr>
                    </table>
                </form>
            </div>
        </div>
      <div class="toolbar-wrap pl20 mt10">
            <div class="toolbar-item">
                
            </div>
        </div>
        <div class="result-wrap">
            <form name="myform" id="myform" method="post">
                <div id="div_content" class="result-content" style="width:100%;overflow: auto">
                    <table class="result-tab" style="width:100%" >
                        <tr>
                            <!--<th class="tc" width="40px"><input class="allChoose" name="" type="checkbox"></th>-->
                            <th style="width:60px">用户ID</th>
                            <th style="width:100px">手机号码</th>
                            <th style="width:60px">真实姓名</th>
                            <th style="width:120px">身份证</th>
                            <th style="width:60px">银行卡号</th>
                            <th style="width:60px">银行名字</th>
                            <th style="width:60px">操作</th>

                        </tr>
                        <?php foreach ($list as $item){?>
                            <tr>
                                <!--<td class="tc"><input name="id[]" value="59" type="checkbox"></td>-->
                                <td><?php echo $item['uid'] ?></td>
                                <td><?php echo $item['mobile'] ?></td>
                                <td><?php echo $item['true_name'] ?></td>
                                <td><?php echo $item['id_card'] ?></td>
                                <td><?php echo $item['card_no'] ?></td>
                                <td><?php echo $item['bank_name'] ?></td>
                                <td align="center">
                                    &nbsp;&nbsp;<a class="link-del" href="/index.php?app=admin&mod=user&ac=bankedit&card_id=<?php echo $item['card_id'];?>">编辑</a>
                                    &nbsp;&nbsp;<a class="link-del" href="javascript:del(<?php echo $item['card_id'];?>)">删除</a>
                                </td>
                            </tr>
                        <?php }?>             
                    </table>
                    
                </div>
            </form>
        </div>
       <div class="list-page"><?php echo $pager;?></div>
    </div>
    <!--/main-->
</div>
<script>
    function del(card_id){
        if(window.confirm('你确定要删除银行卡吗？')){
            window.location.href = "/index.php?app=admin&mod=user&ac=bankdel&card_id="+card_id;
        }
    }
</script>
<!--include file "admin_bottom.php"-->