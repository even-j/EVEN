<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <!--include file "common.php"-->
        <script>
            var page =1;
            var pagesize = <?php echo $var['pagesize'];?>;
            var rowcount = <?php echo $var['rowcount'];?>;
            $(function(){
                if(pagesize*page >= rowcount){
                    $("#btn_more").hide();
                }
            })
            function get_data(){
                page++;
                $.post("<?php echo \App::URL('wap/user/tuiguang_fund_data');?>",{page : page},function(data){
                    $("#record").append(data);
                    if(pagesize*page >= rowcount){
                        $("#btn_more").hide();
                    }
                })
            }
        </script>
    </head>

    <body class="index">
        <div class="header">
            <h1>推广用户</h1>
            <a class="l-link" href="javascript:history.go(-1)"><span>返回</span></a> 
            <div class="top-menu">
                <!--<button type="button" class="btn"></button>-->
            </div>
        </div>
        <div style="height: 40px"></div>
        <div class="ms-c6-t">
            <!--include file "tuiguang_header.php"-->
        </div>
         <div class="space-main clearfix">
            <div class="ms-c6">
                <?php if($rows){ ?>
                <table>
                    <tbody id="record">
                        <tr class="hd" style="height:40px">
                            <th class="w200">策略id</th>
                            <th class="w200">佣金</th>
                            <th class="w120">时间</th>
                        </tr>
                        <?php foreach ($rows as $row){?>
                        <tr>
                            <td class="w120"><span><?php echo $row['pz_id']; ?></span></td>
                            <td class="w120"><span><?php echo $row['money']/100; ?>元</span></td>
                            <td class="w120"><span> <?php echo date('m-d H:i',$row['rtime']); ?> </span></td>
                        </tr>
                        <?php }?>
                    </tbody>
                </table>
                <div id="btn_more" onclick="get_data();" style="width:60px;height:20px;line-height: 20px;background: #ddd;text-align: center;font-size: 12px;margin: 10px auto">更多...</div>
                <?php }else{ ?>
                <div class="emptydata">
                    <p>呃...没有记录!</p>
                </div>
                <?php } ?>
            </div>
             
        </div>
    </body>
</html>
