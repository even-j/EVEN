<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <!--include file "common.php"-->
        <style>
            body{background: #fff}
        </style>
        <style>
            .cont{
                width:1000px;
                height:200px;
                margin: 100px auto;
            }
            .recharge-tips {
            background:url(/public/web/images/invest_ico.png) no-repeat;
                background-position:center -330px;
            height:48px;
            line-height:48px;
            color:#333;
            font-size:14px;
            font-weight:bold;
            overflow:hidden;
        }
        .mes{
            margin: 20px 0px;
            text-align: center;
            font-size: 24px;
            color:green;
            font-weight: 700;
        }
        </style>
    </head>
    <body>
        <div id="top">
            <!--include file "header.php"-->
            <!--include file "nav.php"-->
        </div>
        <div class="cont">
            <div class="recharge-tips">
            
            </div>
            <div class="mes"><?php echo $msg?></div>
            <div class="clear"></div>
        </div>
        <!--include file "footer.php"-->
    </body>
</html>


