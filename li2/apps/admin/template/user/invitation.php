<!--include file "admin_include.php"-->
<div class="container clearfix">
    <div class="main-wrap">
       <!--include file "admin_nav.php"-->
        <div class="search-wrap">
            <div class="search-content">
                <form action="/index.php" method="get">
                    <input type="hidden" name="app" value="admin" >
                    <input type="hidden" name="mod" value="user" >
                    <input type="hidden" name="ac" value="invitation" >
                    <table class="search-tab">
                        <tr>
                            <th width="70">手机号:</th>
                            <td><input class="common-text" style="width:120px;" placeholder="手机号" name="mobile" value="<?php echo $condition['mobile'];?>" id="" type="text"></td>
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
                            <th style="width:60px">推荐人数</th>
                            <th style="width:60px">等级</th>
                            <th style="width:60px">操作</th>

                        </tr>
                        <?php foreach ($list as $item){?>
                            <tr <?php if($item['invit_count']>=5){echo 'style="background:yellow"';}?>>
                                <!--<td class="tc"><input name="id[]" value="59" type="checkbox"></td>-->
                                <td><?php echo $item['uid'] ?></td>
                                <td><?php echo $item['mobile'] ?></td>
                                <td><?php echo $item['true_name'] ?></td>
                                <td><?php echo $item['invit_count'] ?></td>
                                <td><?php echo $item['level']==0?'普通会员':'<span style="color:red">VIP会员</span>' ?></td>
                                <td align="center">
                                    <a class="link-del" target="_blank" href="/index.php?app=admin&mod=peizi&ac=invitview&introducer_id=<?php echo $item['uid'];?>">查看策略记录</a>
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

<!--include file "admin_bottom.php"-->