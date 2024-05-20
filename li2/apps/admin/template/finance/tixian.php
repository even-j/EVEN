<!--include file "admin_include.php"-->
<div class="container clearfix">
    <div class="main-wrap">
       <!--include file "admin_nav.php"-->
        <div class="search-wrap">
            <div class="search-content">
                <form action="/index.php" method="get">
                    <input type="hidden" name="app" value="admin" >
                    <input type="hidden" name="mod" value="finance" >
                    <input type="hidden" name="ac" value="tixian" >
                    <table class="search-tab">
                        <tr>
                            <th width="70">用户ID:</th>
                            <td><input class="common-text" placeholder="用户ID" name="uid" value="<?php echo empty($_GET['uid'])?'':$_GET['uid']?>" id="" type="text"></td>
                            <th width="70">手机:</th>
                            <td><input class="common-text" placeholder="手机" name="mobile" value="<?php echo empty($_GET['mobile'])?'':$_GET['mobile']?>" id="" type="text"></td>
                            <th width="70">姓名:</th>
                            <td><input class="common-text" placeholder="姓名" name="true_name" value="<?php echo empty($_GET['true_name'])?'':$_GET['true_name']?>" id="" type="text"></td>
                            <th width="70">银行卡号:</th>
                            <td><input class="common-text" placeholder="银行卡号" name="card_no" value="<?php echo empty($_GET['card_no'])?'':$_GET['card_no']?>" id="" type="text"></td>
                            <th width="70">提现状态:</th>
                            <td>
                                <select name="status">
                                    <option value="" selected>全部</option>
                                    <option value="0" <?php if(isset($_GET['status']) && $_GET['status']=='0' ) {echo 'selected="selected"';}?> >待审核</option>
                                    <option value="1" <?php if(isset($_GET['status']) && $_GET['status']=='1' ) {echo 'selected="selected"';}?>>已审核</option>
                                    <option value="2" <?php if(isset($_GET['status']) && $_GET['status']=='2' ) {echo 'selected="selected"';}?>>已完成</option>
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
                <div id="div_content" class="result-content" style="width:100%;overflow: auto">
                    <table class="result-tab" style="width:100%" >
                        <tr>
                            <!--<th class="tc" width="40px"><input class="allChoose" name="" type="checkbox"></th>-->
                            <th style="width:60px">用户ID</th>
                            <th style="width:60px">姓名</th>
                            <th style="width:120px">手机</th>
                            <th style="width:80px">开户行</th>
                            <th style="width:100px">开户行地区</th>
                            <th style="width:180px">银行卡号</th>
                            <th style="width:120px">提现金额</th>
                            <th style="width:140px">提现时间</th>
                            <th style="width:80px">状态</th>
                            <th style="width:100px">操作</th>

                        </tr>
                        <?php foreach ($list as $item){?>
                            <tr>
                                <!--<td class="tc"><input name="id[]" value="59" type="checkbox"></td>-->
                                <td><?php echo $item['uid'] ?></td>
                                <td><a href="/index.php?app=admin&mod=user&ac=info&uid=<?php echo $item['uid']?>" ><?php echo $item['true_name']?></a></td>
                                <td><?php echo $item['mobile'] ?></td>
                                <td><?php echo $item['bank_name'] ?></td>
                                <td><?php echo $item['province_name'].$item['city_name'] ?></td>
                                <td><?php echo $item['card_no'] ?></td>
                                <td><a href="javascript:void(0);" onclick="show('个人资产情况','/index.php?app=admin&mod=finance&ac=info&uid=<?php echo $item['uid'];?>');" title="预览个人资产情况"><?php echo number_format((floatval($item['money']) /100),2) ?></a></td>
                                <td><?php echo date('Y-m-d H:i',$item['rtime']) ?></td>
                                <td><?php $status = array('<span class="red">待审核</span>','<span class="blue">已审核</span>','<span class="green">已完成</span>');echo $status[$item['status']];?></td>
                                <td>
                                    <?php if($item['status']==0){?>
                                    <a class="link-update" href="javascript:changeStatus(<?php echo $item['withdraw_id'];?>,2)">审核通过</a>
                                    <a class="link-update" href="javascript:changeStatus(<?php echo $item['withdraw_id'];?>,3)">拒绝通过</a>
                                    <?php }else{?>
                                    已完成
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
    <!--/main-->
</div>
<script>
    function changeStatus(withdraw_id,status){ 
        $.post('/index.php?app=admin&mod=finance&ac=tixianChangeStatus',{withdraw_id:withdraw_id,status:status},function(res){
            if(res.code == '1'){
            	layer.msg('操作成功');
                window.location.reload();
            }else{
            	layer.msg(res.msg);
            }
        },'json').error(function(XMLHttpRequest, textStatus, errorThrown){
	       	 alert(XMLHttpRequest.status+' \t '+XMLHttpRequest.readyState+' \t '+textStatus);
         });
    }
</script>
<!--include file "admin_bottom.php"-->