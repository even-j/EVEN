<!--include file "admin_include.php"-->
<div class="container clearfix">
    <div class="main-wrap">
       <!--include file "admin_nav.php"-->
        <div class="search-wrap">
            <div class="search-content">
                <form action="/index.php" method="get">
                    <input type="hidden" name="app" value="admin" >
                    <input type="hidden" name="mod" value="user" >
                    <input type="hidden" name="ac" value="group" >
                    <table class="search-tab">
                        <tr>
                            <th width="70">名称:</th>
                            <td><input class="common-text" style="width:120px;" placeholder="名称" id="name"  name="name" value="<?php echo empty($name)?'':$name?>" type="text"></td>
                            <td><input class="btn btn-primary btn10" name="sub" value="查询" type="submit"></td>
                         </tr>
                    </table>
                </form>
            </div>
        </div>
      <div class="toolbar-wrap pl20 mt10">
            <div class="toolbar-item">
                <a href="/index.php?app=admin&mod=user&ac=groupedit"><i class="icon-font"></i> 添加分组</a>
            </div>
        </div>
        <div class="result-wrap">
            <form name="myform" id="myform" method="post">
                <div id="div_content" class="result-content" style="width:100%;overflow: auto">
                    <table class="result-tab" style="width:100%" >
                        <tr>
                            <!--<th class="tc" width="40px"><input class="allChoose" name="" type="checkbox"></th>-->
                            <th style="width:60px">ID</th>
                            <th style="width:100px">名称</th>
                            <th style="width:60px">添加时间</th>
                            <th style="width:120px">备注</th>
                            <th style="width:60px">操作</th>

                        </tr>
                        <?php foreach ($list as $item){?>
                            <tr>
                                <!--<td class="tc"><input name="id[]" value="59" type="checkbox"></td>-->
                                <td><?php echo $item['id'] ?></td>
                                <td><?php echo $item['name'] ?></td>
                                <td><?php echo date('Y-m-d H:i:s',$item['add_time']) ?></td>
                                <td><?php echo $item['memo'] ?></td>
                                <td align="center">
                                    &nbsp;&nbsp;<a class="link-del" href="/index.php?app=admin&mod=user&ac=groupedit&id=<?php echo $item['id'];?>">编辑</a>
                                    <?php if($item['id']!=1) {?>
                                    &nbsp;&nbsp;<a class="link-del" href="javascript:del(<?php echo $item['id'];?>)">删除</a>
                                    <?php }?>
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
    function del(id){
        if(window.confirm('你确定要删除该分组吗？')){
            window.location.href = "/index.php?app=admin&mod=user&ac=groupdel&id="+id;
        }
    }
</script>
<!--include file "admin_bottom.php"-->