<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <!--include file "common.php"-->
        <style>
            body{background: #f6f6f6}
            .list li{display: block;position: relative;padding-left: 55px;border-bottom: 1px solid #eee;background: #fff;height: 50px}
            .list li:last-child{border:0}
            .list li img{position: absolute;top:10px;left:15px;width:30px;height:30px;}
            .list li p{font-size: 14px;padding-top: 9px}
            .list li i{display: block;font-size: 10px;padding-top: 6px;color:#999}
        </style>
        <script>
            $(function(){
                $(".list li").click(function(){
                    var type=$(this).attr('type');
                    var id=$(this).attr('id').replace('pay_','');
                    window.location.href = "<?php echo \App::URL('wap/user/recharge_pay')?>"+'&type='+type+"&id="+id;
                })
            })
        </script>
    </head>

    <body class="index">
        <div class="header">
            <h1>充值</h1>
            <a class="l-link" href="javascript:history.go(-1)"><span>返回</span></a> 
            <div class="top-menu">
                <!--<button type="button" class="btn"></button>-->
            </div>
        </div>
        <div style="height: 40px"></div>
        <p style="font-size:12px;color:#777;padding:10px 15px">选择充值方式</p>
        <ul class="list">
            <?php foreach($pay_list as $row) {?>
            <li type="online" channel="<?php echo $row['name'];?>" id="pay_<?php echo $row['code'];?>">
                <?php $img=''; 
                        switch($row['manner']){ 
                        case '微信': $img='b_weixin.png';break;
                        case '支付宝': $img='b_zfb.jpg';break;
                        case '网银': $img='b_bank.png';break;
                        default: $img='b_bank.png'; break;
                  }?>
                <img src="/public/wap/images/bank/<?php echo $img; ?>" />
                <p><?php echo $row['name'];?></p>
                <i>在线支付</i>
            </li>
            <?php }?>
            <?php foreach ($account_list as $key=>$row){?>
            <li type="offline" channel="<?php echo $row['channel'];?>" id="pay_<?php echo $row['id'];?>">
                <?php $img=''; 
                  switch($row['type']){ 
                        case 0: $img='b_bank.png';break;
                        case 1: $img='b_weixin.png';break;
                        case 2: $img='jdqb.png';break;
                        case 3: $img='b_zfb.jpg';break;
                        case 4: $img='qqqb.png';break;
                        case 5: $img='cft.png';break;
                        case 6: $img='baidu.png';break;
                        default: $img='b_bank.png'; break;
                  }?>
                <img src="/public/wap/images/bank/<?php echo $img; ?>" />
                <p><?php echo $row['name'];?></p>
                <i><?php echo $row['caption'];?></i>
            </li>
            <?php }?>
        </ul>
    </body>
</html>