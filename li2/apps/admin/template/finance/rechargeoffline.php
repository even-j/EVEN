<!--include file "admin_include.php"-->
<div class="container clearfix">
    <div class="main-wrap">
       <!--include file "admin_nav.php"-->
        <div class="search-wrap">
            <div class="search-content">
                <form action="/index.php" method="get">
                    <input type="hidden" name="app" value="admin" >
                    <input type="hidden" name="mod" value="finance" >
                    <input type="hidden" name="ac" value="rechargeoffline" >
                    <table class="search-tab">
                        <tr>
                             <th width="70">用户ID:</th>
                            <td><input class="common-text" placeholder="用户ID" name="uid" value="<?php echo empty($_GET['uid'])?'':$_GET['uid']?>" id="" type="text"></td>
                            <th width="70">手机:</th>
                            <td><input class="common-text" placeholder="手机" name="mobile" value="<?php echo empty($_GET['mobile'])?'':$_GET['mobile']?>" id="" type="text"></td>
                            <th width="60">姓名:</th>
                            <td><input class="common-text" placeholder="姓名" name="true_name" value="<?php echo empty($_GET['true_name'])?'':$_GET['true_name']?>" id="" type="text"></td>
                            <th width="70">充值状态:</th>
                            <td>
                                <select name="status">
                                    <option value="" <?php if(!isset($_GET['status']) || $_GET['status']=='' ) {echo 'selected="selected"';}?>>全部</option>
                                    <option value="0" <?php if(isset($_GET['status']) && $_GET['status']=='0' ) {echo 'selected="selected"';}?> >未处理</option>
                                    <option value="1" <?php if(isset($_GET['status']) && $_GET['status']=='1' ) {echo 'selected="selected"';}?> >审核成功</option>
                                    <option value="2" <?php if(isset($_GET['status']) && $_GET['status']=='2' ) {echo 'selected="selected"';}?>>拒绝审核</option>
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
                            <th style="width:100px">用户ID</th>
                            <th style="width:100px">姓名</th>
                            <th style="width:120px">手机</th>
                            <th style="width:100px">渠道</th>
                            <th style="width:120px">充值金额</th>
                            <th style="width:120px">汇款人姓名</th>
                            <th style="width:140px">充值时间</th>
                            <th style="width:180px">充值状态</th>
                            <th style="width:180px">审核时间</th>
                            <th style="width: 160px;">操作</th>
                        </tr>
                        <?php foreach ($list as $item){
                            $statusname = '';
                            if($item['status']==0){
                                $statusname = '未处理';
                            }
                            elseif($item['status']==1){
                                $statusname = '审核通过';
                            }
                            elseif($item['status']==2){
                                $statusname = '拒绝审核';
                            }
                            ?>
                            <tr>
                                <!--<td class="tc"><input name="id[]" value="59" type="checkbox"></td>-->
                                <td><?php echo $item['id'] ?></td>
                                <td><?php echo $item['uid'] ?></td>
                                 <td><a href="/index.php?app=admin&mod=user&ac=info&uid=<?php echo $item['uid']?>" ><?php echo $item['true_name']?></a></td>
                                <td><?php echo $item['mobile'] ?></td>
                                <td><?php echo $item['channel'] ?></td>
                                <td><?php echo '¥ '.number_format((floatval($item['money']) /100),2) ?></td>
                                <td><?php echo $item['name'] ?></td>
                                <td><?php echo date('Y-m-d H:i',$item['add_time']) ?></td>
                                <td><?php echo $statusname; ?></td>
                                <td><?php echo $item['update_time']?date('Y-m-d H:i',$item['update_time']):'' ?></td>
                                <td>
                                    <?php if($item['status'] ==0){?>
                                    <?php echo '<a href="javascript:bianji('.$item['id'].')">编辑</a>&nbsp;&nbsp;<a href="javascript:pass('.$item['id'].')">通过</a>&nbsp;&nbsp;<a href="javascript:refuse('.$item['id'].')">拒绝</a>&nbsp;&nbsp;<a href="javascript:del('.$item['id'].')">删除</a>' ?>
                                    <?php }?>
                                </td>
                            </tr>
                        <?php }?>             
                    </table>
                </div>
                <div class="list-page"><?php echo $pager;?></div>
            </form>
        </div>
    </div>
    <script type="text/javascript" src="/public/admin/js/layer/extend/layer.ext.js"></script> 
    <script>
        function bianji(id){
            window.location.href = '/index.php?app=admin&mod=finance&ac=offlineedit&id='+id;
        }
        function pass(id){
            var recharge_rebate = "<?php echo \apps\Config::getInstance()->recharge_rebate;?>";
            if(recharge_rebate=="" || recharge_rebate=="0"){
                var index = layer.confirm('是否确认通过充值？', function(index) {
                    window.location.href = '/index.php?app=admin&mod=finance&ac=offlinepass&id='+id;
                });
            }
            else{
                //需引入扩展才可使用layer.prompt
                layer.config({
                    extend: '/public/admin/js/layer/extend/layer.ext.js'
                });
                layer.prompt({title: '输入返利金额（元）,并确定', formType: 2}, function(value, index,elem){
                    layer.close(index);
                    window.location.href = '/index.php?app=admin&mod=finance&ac=offlinepass&id='+id+"&money="+value;
                });
            }
        }
        function refuse(id){
            if(window.confirm("是否确认拒绝充值?")){
                window.location.href = '/index.php?app=admin&mod=finance&ac=offlinerefuse&id='+id;
            }
        }
        function del(id){
            if(window.confirm("是否确认删除记录?")){
                window.location.href = '/index.php?app=admin&mod=finance&ac=offlinedel&id='+id;
            }
        }
    </script>
    <!--/main-->
</div>

<!--include file "admin_bottom.php"-->