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
                var begindate='<?php echo $search_param['begindate']?>';
                var enddate='<?php echo $search_param['enddate']?>';
                $.post("<?php echo \App::URL('wap/user/tuiguang_user_data');?>",{page : page,begindate:begindate,enddate:enddate},function(data){
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
                <form action="<?php echo \App::URL('wap/user/tuiguang_user');?>" method="get">
                    <input name="app" value="wap" type="hidden"/>
                    <input name="mod" value="user" type="hidden"/>
                    <input name="ac" value="tuiguang_user" type="hidden"/>
                    <div class="search-box">
                        <table>
                            <tbody>
                                <tr>
                                    <td><input class="" placeholder="开始时间" name="begindate" value="<?php echo $search_param['begindate']?>" id="begindate" type="date"></td>
                                    <td>至</td>
                                    <td><input class="" placeholder="结束时间" name="enddate" value="<?php echo $search_param['enddate']?>" id="enddate" type="date"></td>
                                    <td>
                                        <button class="btn" type="submit" style="background: #f53d52;border:none;color:#fff;line-height: 30px;width:40px;text-align: center">查 询</button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </form>
                <?php if($rows){ ?>
                <table>
                    <tbody id="record">
                        <tr>
                            <th>手机号</th>
                            <th>姓名</th>
                            <th>注册时间</th>
                        </tr>
                        <?php foreach ($rows as $row){?>
                        <tr>
                            <td class="w120"><span><?php echo $row['mobile'] ?></span></td>
                            <td class="w120"><span><?php echo $row['true_name'] ?></span></td>
                            <td class="w120"><span> <?php echo date('Y-m-d H:i:s',$row['reg_time']); ?> </span></td>
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
