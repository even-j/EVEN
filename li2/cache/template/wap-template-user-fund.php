<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0"/>
<meta name="format-detection" content="telephone=no" />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta charset="utf-8">
<title><?php if (isset($title)) echo $title ?></title>
<meta name="keywords" content="<?php if (isset($keywords)) echo $keywords ?>">
<meta name="description" content="<?php if (isset($description)) echo $description ?>">
<link rel="stylesheet" href="/public/wap/css/wap_style.css">
<link rel="stylesheet" href="/public/wap/css/wap_new.css">
<script src="/public/wap/js/jquery.js" type="text/javascript"></script>
<script src="/public/wap/js/layer_mobile/layer.js" type="text/javascript"></script>
<script src="/public/wap/js/common.js" type="text/javascript"></script>

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
                var fundtype = "<?php echo $fundtype;?>"
                $.post("<?php echo \App::URL('wap/user/fund_data');?>",{page : page,fundtype : fundtype},function(data){
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
            <h1>资金流水</h1>
            <a class="l-link" href="javascript:history.go(-1)"><span>返回</span></a> 
            <div class="top-menu">
                <!--<button type="button" class="btn"></button>-->
            </div>
        </div>
        <div style="height: 40px"></div>
         <div class="space-main clearfix">
            <div class="ms-c6">
                <?php if($rows){ ?>
                <table>
                    <tbody id="record">
                        <tr>
                            <th style="width:80px">发生时间</th>
                            <th style="width:100px">类型</th>
                            <th style="text-align:right">发生金额</th>
                            <th style="text-align:right">账户余额</th>
                            <th style="text-align:right">管理费</th>
                        </tr>
                        <?php foreach ($rows as $row){?>
                        <tr>
                            <td><?php echo date('m-d H:i',$row['rtime'])?></td>
                            <td><?php echo \Model\User\Fund::fundTypeName($row['type'])?></td>
                            <td class="r"><b>
                                <?php if($row['in_or_out']>0){?>
                                <span style="color:red"><?php echo number_format($row['in_or_out']*floatval($row['money'])/100,2) ?></span></b>
                                <?php }else{?>
                                <span style="color:green"><?php echo number_format($row['in_or_out']*floatval($row['money'])/100,2) ?></span></b>
                                <?php }?>
                            </td>
                            <td class="r"><?php echo number_format(floatval($row['balance'])/100,2) ?></td>
                            <td class="r"><?php echo number_format(floatval($row['send'])/100,2) ?></td>
                        </tr>
                        <?php }?>
                    </tbody>
                </table>
                <div id="btn_more" onclick="get_data();" style="width:60px;height:20px;line-height: 20px;background: #ddd;text-align: center;font-size: 12px;margin: 10px auto">更多...</div>
                <?php }else{ ?>
                <div class="emptydata">
                    <p>呃...没有注水记录!</p>
                </div>
                <?php } ?>
            </div>
             
        </div>
    </body>
</html>
