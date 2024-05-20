<!--include file "admin_include.php"-->

<div class="container clearfix">
    <div class="main-wrap">
        <!--include file "admin_nav.php"-->

        <div class="result-wrap">
            <span></span>
            <div class="result-title">
                <div class="result-list">
                    <a href="/index.php?app=admin&mod=finance&ac=paysetEdit" target="mainFrame"><i class="icon-font"></i>添加支付接口</a>
                </div>
            </div>
            <div class="result-content">
                <table class="result-tab" width="100%">
                    <tr>
                        <th class="tc" width="5%"><input class="allChoose" name="" type="checkbox"></th>
                        <th style="width:10%;">接口名称</th>
                        <th style="width:10%;">接口编号</th>
                        <th style="width:10%;">接口域名</th>
                        <th style="width:10%;">商户ID</th>
                        <th style="width:10%;">使用状态</th>
                        <th style="width:10%;">显示端</th>
                        <th style="width:10%;">备注</th>
                        <th style="width:15%;">操作</th>
                    </tr>
                    <?php foreach ($dataList as $data) { ?>
                        <tr>
                            <td class="tc"><input name="id[]" value="<?php echo $data['id']; ?>" type="checkbox"></td>
                            <td><?php echo $data['name']; ?></td>
                            <td><?php echo $data['code']; ?></td>
                            <td><?php echo $data['domain']; ?></td>
                            <td><?php echo $data['sid']; ?></td>
                            <td><?php echo $data['status_caption']; ?></td>
                            <td><?php echo $data['clienttype_caption']; ?></td>
                            <td><?php echo $data['memo']; ?></td>
                            <td>
                                <a class="link-update" href="/index.php?app=admin&mod=finance&ac=paysetEdit&id=<?php echo $data['id']; ?>" target="mainFrame">修改</a>
                                <a class="link-del" href="javascript:delPayset('/index.php?app=admin&mod=finance&ac=paysetDel&id=<?php echo $data['id']; ?>');">删除</a>
                            </td>
                        </tr>
                    <?php } ?>
                </table>
                <div class="list-page"><?php echo $pager; ?></div>
            </div>
        </div>
    </div>
    <!--/main-->
</div>
<script type="text/javascript">
    $(document).ready(function(){
        
    });
    function delPayset(url) {
        if (confirm('您是否要删除该支付接口信息？删除后不可恢复!')) {
            location.href = url;
        }
    }
</script>
<!--include file "admin_bottom.php"-->