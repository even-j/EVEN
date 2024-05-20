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
                    <input type="hidden" name="mod" value="qihuo" >
                    <input type="hidden" name="ac" value="fund" >
                    <table class="search-tab">
                        <tr>
                            <th width="80">实盘单号:</th>
                            <td><input class="common-text" placeholder="实盘单号" name="order_id" value="<?php echo $condition['order_id']?>" id="" type="text"></td>
                            <th width="50">状态:</th>
                            <td>
                                <select name="status" id="status" class="common-select">
                                    <option <?php echo $condition['status'] == ''?'selected="selected"':''?> value="">&nbsp;全部&nbsp; </option>
                                    <option <?php echo $condition['status'] == '1'?'selected="selected"':''?> value="1">未划拨</option>
                                    <option <?php echo $condition['status'] == '2'?'selected="selected"':''?> value="2">已划拨</option>
                                </select>
                            </td>
                            <th width="80">策略时间:</th>
                            <td><input class="common-text ui_timepicker" placeholder="开始时间" name="begindate" value="<?php echo $condition['begindate']?>" id="begindate" type="text"> — </td>
                            <td><input class="common-text ui_timepicker" placeholder="结束时间" name="enddate" value="<?php echo $condition['enddate']?>" id="enddate" type="text"></td>
                            <th width="80"><input class="btn btn-primary btn2" name="sub" value="查询" type="submit"></td>
                        </tr>
                    </table>
                </form>
            </div>
        </div>
      
        <div class="result-wrap">
            <form name="myform" id="myform" method="post">
                <div id="div_content" class="result-content" style="width:100%;overflow: auto">
                    <table class="result-tab" style="width:100%" >
                        <tr>
                            <th style="width: 100px;">策略类型</th>
                            <th style="width: 60px;">姓名</th>
                            <th style="width: 150px;">订单时间</th>
                            <th style="width: 100px;">证券账户</th>
                            <th style="width: 100px;">实盘金额<br>(万元)</th>
                            <th style="width: 60px;">倍数</th>
                            <th style="width: 100px;">风险保证金<br>(元)</th>
                            <th style="width: 100px;">借贷资金<br>(元)</th>
                            <th style="width: 100px;">风险警戒线<br>(元)</th>
                            <th style="width: 100px;">平仓止损线<br>(元)</th>
                            <th style="width: 100px;">开始时间</th>
                            <th style="width: 120px;">实盘单号</th>
                            <th style="width: 100px;">划拨状态</th>
                            <th style="width: 100px;">操作</th>
                        </tr>
                         														
                        <?php foreach ($list as $item){?>
                            <tr>
                                <td><?php echo \Model\Peizi\Peizi::getPzType($item['pz_type'])  ?></td>
                                <td><a target="_blank" href="/index.php?app=admin&mod=user&ac=info&uid=<?php echo $item['uid']?>" ><?php echo $item['true_name']?></a></td>
                                <td><?php echo date('Y-m-d H:i',$item['pz_time']) ?></td>
                                <td><?php echo $item['sp_user'] ?></td>
                                <td><?php echo floatval($item['trade_money_total'])/10000/100 ?></td>
                                <td><?php echo floatval($item['pz_ratio'])?></td>
                                <td><?php echo floatval($item['bond_total'])/100 ?></td>
                                <td><?php echo (floatval($item['trade_money_total'])-floatval($item['bond_total']))/100 ?></td>
                                <td><?php echo floatval($item['alarm_money'])/100 ?></td>
                                <td><?php echo floatval($item['stop_money'])/100 ?></td>
                                <td><?php echo date('Y-m-d',$item['start_time']) ?></td>
                                <td><?php echo date('Ymd',$item['pz_time']).$item['pz_id'] ?></td>
                                <td><?php echo $item['status']==1?'<span style="color:red">未划拔</span>':'已划拔' ?></td>
                                <td><?php echo '<a href="javascript:huabo('.$item['pz_id'].')">编辑</a>' ?></td>
                            </tr>
                        <?php }?>             
                    </table>
                    
                </div>
            </form>
        </div>
       <div class="list-page"><?php echo $pager;?></div>
    </div>
  
    <script>
        function huabo(pz_id){
            window.location.href = '/index.php?app=admin&mod=qihuo&ac=fundedit&pz_id='+pz_id;
        }
    </script>
    <!--/main-->
</div>
<!--include file "admin_bottom.php"-->