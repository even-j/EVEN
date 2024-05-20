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
                    <input type="hidden" name="mod" value="p2p" >
                    <input type="hidden" name="ac" value="end" >
                    <table class="search-tab">
                        <tr>
                            <th width="50">状态:</th>
                            <td>
                                <select name="status" id="status" class="common-select">
                                    <option <?php echo $condition['status'] == ''?'selected="selected"':''?> value="">&nbsp;全部&nbsp; </option>
                                    <option <?php echo $condition['status'] == '6'?'selected="selected"':''?> value="6">未结束</option>
                                    <option <?php echo $condition['status'] == '7'?'selected="selected"':''?> value="7">已结束</option>
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
                            <th style="width: 80px;">策略类型</th>
                            <th style="width: 120px;">实盘单号</th>
                            <th style="width: 60px;">姓名</th>
                            <th style="width: 150px;">策略时间</th>
                            <th style="width: 80px;">策略金额<br>(万元)</th>
                             <th style="width: 100px;">操盘账号<br></th>
                            <th style="width: 80px;">策略比例</th>
                            <th style="width: 60px;">年利率</th>
                            <th style="width: 80px;">分成比例</th>
                            <th style="width: 100px;">风险保证金<br>(元)</th>
                            <th style="width: 80px;">策略期限<br></th>
                            <th style="width: 110px;">实际开始时间</th>
                            <th style="width: 110px;">实际结束时间</th>
                            <th style="width: 60px;">状态</th>
                            <th style="width: 60px;">操作</th>
                        </tr>
                         														
                        <?php foreach ($list as $item){?>
                            <tr>
                                <td><?php echo \Model\Peizi\Peizi::getPzType($item['pz_type'])  ?></td>
                                <td><?php echo date('Ymd',$item['pz_time']).$item['pz_id'] ?></td>
                                <td><a target="_blank" href="/index.php?app=admin&mod=user&ac=info&uid=<?php echo $item['uid']?>" ><?php echo $item['true_name']?></a></td>
                                <td><?php echo date('Y-m-d H:i',$item['pz_time']) ?></td>
                                <td><?php echo floatval($item['pz_money'])/10000/100 ?></td>
                                 <td><?php echo $item['sp_user'];?></td>
                                <td><?php echo floatval($item['pz_ratio'])?></td>
                                <td><?php echo floatval($item['year_rate'])?>%</td>
                                <td><?php echo floatval($item['fencheng_rate'])?>%</td>
                                <td><?php echo floatval($item['bond_total'])/100 ?></td>
                                <td><?php echo $item['pz_times']. \Model\P2p\Peizi::getTimeUnitName($item['pz_times_unit']) ?></td>
                                <td><?php echo empty($item['start_time'])?'':date('m-d H:i',$item['start_time']) ?></td>
                                <td><?php echo empty($item['end_time'])?'':date('m-d H:i',$item['end_time']) ?></td>
                                <td><?php echo $item['p2pstatus']==7 ? '已结束': ($item['p2pstatus']==5 ? '用户申请结束' : \Model\Sys\Common::countdown($item['end_time']));?></td>
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
            window.location.href = '/index.php?app=admin&mod=p2p&ac=endedit&pz_id='+pz_id;
        }
    </script>
    <!--/main-->
</div>
<!--include file "admin_bottom.php"-->