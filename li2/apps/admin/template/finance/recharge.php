<!--include file "admin_include.php"-->
<div class="container clearfix">
    <div class="main-wrap">
       <!--include file "admin_nav.php"-->
        <div class="search-wrap">
            <div class="search-content">
                <form action="/index.php" method="get">
                    <input type="hidden" name="app" value="admin" >
                    <input type="hidden" name="mod" value="finance" >
                    <input type="hidden" name="ac" value="recharge" >
                    <table class="search-tab">
                        <tr>
                             <th width="70">用户ID:</th>
                            <td><input class="common-text" placeholder="用户ID" name="uid" value="<?php echo empty($_GET['uid'])?'':$_GET['uid']?>" id="" type="text"></td>
                            <th width="70">姓名:</th>
                            <td><input class="common-text" placeholder="姓名" name="true_name" value="<?php echo empty($_GET['true_name'])?'':$_GET['true_name']?>" id="" type="text"></td>
                            <th width="70">充值状态:</th>
                            <td>
                                <select name="status">
                                    <option value="" <?php if(!isset($_GET['status']) || $_GET['status']=='' ) {echo 'selected="selected"';}?>>全部</option>
                                    <option value="0" <?php if(isset($_GET['status']) && $_GET['status']=='0' ) {echo 'selected="selected"';}?> >未支付</option>
                                    <option value="1" <?php if(isset($_GET['status']) && $_GET['status']=='1' ) {echo 'selected="selected"';}?>>已支付</option>
                                </select>
                            </td>
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
                <div class="result-title">
                </div>
                <div  id="div_content" class="result-content" style="width:100%;overflow: auto">
                    <table class="result-tab" style="width:100%" >
                        <tr>
                             <!--<th class="tc" width="40px"><input class="allChoose" name="" type="checkbox"></th>-->
                            <th style="width:100px">定单号</th>
                            <th style="width:140px">三方ID</th>
                            <th style="width:100px">用户ID</th>
                            <th style="width:100px">姓名</th>
                            <th style="width:120px">手机</th>
                             <th style="width:120px">充值金额</th>
                            <th style="width:140px">充值时间</th>
                            <th style="width:180px">充值状态</th>
                            <th style="width:180px">充值渠道</th>
                        </tr>
                        <?php foreach ($list as $item){?>
                            <tr>
                                <!--<td class="tc"><input name="id[]" value="59" type="checkbox"></td>-->
                                <td><?php echo $item['recharge_id'] ?></td>
                                <td><?php echo $item['order_id'] ?></td>
                                <td><?php echo $item['uid'] ?></td>
                                 <td><a href="/index.php?app=admin&mod=user&ac=info&uid=<?php echo $item['uid']?>" ><?php echo $item['true_name']?></a></td>
                                <td><?php echo $item['mobile'] ?></td>
                                <td><?php echo '¥ '.number_format((floatval($item['money']) /100),2) ?></td>
                                <td><?php echo date('Y-m-d H:i',$item['rtime']) ?></td>
                                <td><?php echo $item['status']==0 ?'<span class="red">未支付</span>':'<span class="green">已支付</span>' ?></td>
                                <td><?php echo $item['plat'] ?></td>
                            </tr>
                        <?php }?>             
                    </table>
                </div>
                <div class="list-page"><?php echo $pager;?></div>
            </form>
        </div>
    </div>
    <!--/main-->
</div>

<!--include file "admin_bottom.php"-->