<!--include file "admin_include.php"-->

<link rel="stylesheet" href="/public/kindeditor/themes/default/default.css" />
<link rel="stylesheet" href="/public/kindeditor/plugins/code/prettify.css" />
<script charset="utf-8" src="/public/kindeditor/kindeditor.js"></script>
<script charset="utf-8" src="/public/kindeditor/lang/zh_CN.js"></script>
<script charset="utf-8" src="/public/kindeditor/plugins/code/prettify.js"></script>
<script>
	 
</script>
	
<div class="container clearfix">
    <div class="main-wrap">
        <div class="crumb-wrap">
            <div class="crumb-list"><i class="icon-font"></i><a href="/index.php?app=admin&mod=index&ac=view" target="_top">首页</a><span class="crumb-step">&gt;</span><a class="crumb-name" href="/index.php?app=admin&mod=finance&ac=payset">支付设置</a><span class="crumb-step">&gt;</span><span><?php echo $nav_title;?></span></div>
        </div>
        <div class="result-wrap">
            <div class="result-content">
                <form action="/index.php?app=admin&mod=finance&ac=paysetDoedit" method="post" id="myform" name="myform" enctype="multipart/form-data">
                    <input type="hidden" id="id" name="id" size="50" value="<?php if($data && $data['id']){ echo $data['id']; }?>" />
                    <input type="hidden" name="controller" class="input-text" value="<?php if($data && $data['controller']){ echo $data['controller']; }?>" placeholder="控制器名称" />
                    
                    <input type="hidden" name="pay_type" class="input-text" value="<?php if($data && $data['pay_type']){ echo $data['pay_type']; }?>" placeholder="第三方支付方式" />
                    <input type="hidden" id="can_iframe" name="can_iframe" value="<?php if($data && $data['can_iframe']){echo $data['can_iframe'];}?>" placeholder="是否可以嵌在iframe里使用" />                    
 
                    <table class="insert-tab" width="100%">
                        <tbody>
                            <tr>
                                <th width="20%"><i class="require-red">*</i>支付方式：</th>
                                <td>
                                    <select name="manner" id="manner"  class="select" style="width:600px;">
                                        <option value="微信" <?php  if($data && $data['manner'] == '微信'){ echo 'selected="true"';}?>>微信</option>
                                        <option value="支付宝" <?php  if($data && $data['manner'] == '支付宝'){ echo 'selected="true"';}?>>支付宝</option>
                                        <option value="网银" <?php  if($data && $data['manner'] == '网银'){ echo 'selected="true"';}?>>网银</option>
                                    </select>
                                    <i class="tip left pd10"></i>
                                </td>
                            </tr>
                            <tr>
                                <th id="th_pay_channel"><i class="require-red">*</i>支付渠道：</th>
                                <td>
                                    <select name="pay_channel" id="pay_channel"  class="common-select required mr10" style="width:300px;">
                                        <option value=""></option>
	                                <?php foreach ($set_info as $key=>$val){
                                            $selected='';
                                            if($data && $data['controller'] && $key==$data['controller'])
                                            {
                                                $selected='selected="selected"';
                                            }
                                            ?>
                                            <option value="<?php echo $key;?>" <?php echo $selected;?> pay_type="<?php echo $val['pay_type'];?>" domain="<?php echo $val['domain'];?>" sid="<?php echo $val['sid'];?>" skey="<?php echo $val['skey'];?>" terminal_id="<?php echo $val['terminal_id'];?>" server_pub_key="<?php echo $val['server_pub_key'];?>" mem_pri_key="<?php echo $val['mem_pri_key'];?>" can_iframe="<?php echo $val['can_iframe'];?>" memo="<?php echo $val['memo'];?>"><?php echo $val['name'];?></option>
                                        <?php }?>
	                            </select>
                                    <i class="tip left pd10"></i>
                                    <span id="tips_memo" style="color:red"></span>
                                    <span class="" style="width:200px;" id="span_pay_type">
                                    <?php foreach ($set_info as $key_out=>$item){ ?>
                                        <select id="pay_type_<?php echo $key_out;?>" class="select" style="display: none" onchange="pay_type_change(this)">
                                            <option value="" <?php if ($key_out==$data['controller'] && empty($data['pay_type'])){?> selected="true"<?php }?></option>
                                            <?php foreach ($item['pay_type'] as $key_in=>$pay_type){ ?>
                                            <option value="<?php echo $key_in;?>" <?php if ($key_out==$data['controller'] && $key_in==$data['pay_type']){?> selected="true"<?php }?>><?php echo $pay_type;?></option>
                                            <?php }?>
                                        </select>
                                    <?php }?>
                                    </span>
                                </td>
                                
                                
                            </tr>
                            <tr>
                                <th id="th_name">接口编号：</th>
                                <td>
                                    <input type="text" class="common-text required" id="code" style="width:600px;" name="code" value="<?php if($data && $data['code']){echo $data['code'];}?>" placeholder="接口编号" /> 
                                    <span id="tips_name" style="color:red">必填</span>
                                </td>
                            </tr>
                            <tr>
                                <th id="th_name">接口名称：</th>
                                <td>
                                    <input class="common-text required"  id="name" style="width:600px;" name="name" value="<?php if($data && $data['name']){ echo $data['name']; }?>" type="text">
                                    <span id="tips_name" style="color:red">必填</span>
                                </td>
                            </tr>
                            <tr>
                                <th id="th_domain">接口域名：</th>
                                <td>
                                    <input class="common-text required"  id="domain" style="width:600px;" name="domain" value="<?php if($data && $data['domain']){ echo $data['domain']; }?>" type="text">
                                    <span id="tips_domain" style="color:red">必填</span>
                                </td>
                            </tr>
                            <tr>
                                <th id="th_sid">商户ID：</th>
                                <td>
                                    <input class="common-text required"  id="sid" style="width:600px;" name="sid" value="<?php if($data && $data['sid']){ echo $data['sid']; }?>" type="text">
                                    <span id="tips_sid" style="color:red"></span>
                                </td>
                            </tr>
                            <tr>
                                <th id="th_skey">商户密钥：</th>
                                <td>
                                    <input class="common-text required"  id="skey" style="width:600px;" name="skey" value="<?php if($data && $data['skey']){ echo $data['skey']; }?>" type="text">
                                    <span id="tips_skey" style="color:red"></span>
                                </td>
                            </tr>
                            <tr>
                                <th>状态：</th>
                                <td>
                                     <select name="status" id="status"  class="common-select required mr10" style="width:600px;">
                                     	<?php foreach ($status_arr as $key=>$val){?>
						<option value="<?php echo $key;?>" <?php if($data && $data['status']==$key) {echo 'selected="selected"';}?>><?php echo $val;?></option>
                                     	<?php }?>
                                     </select>
                                    <i class="tip left pd10"></i>
                                </td>
                            </tr>
                            <tr>
                                <th>显示端：</th>
                                <td>
                                    <select name="client_type" id="client_type"  class="select" style="width:600px;">
                                        <option value="1" <?php  if($data && $data['client_type'] == '1'){ echo 'selected="true"';}?>>电脑端</option>
                                        <option value="2" <?php  if($data && $data['client_type'] == '2'){ echo 'selected="true"';}?>>手机端</option>
                                        <option value="3" <?php  if($data && $data['client_type'] == '3'){ echo 'selected="true"';}?>>电脑&手机端</option>
                                    </select>
                                    <i class="tip left pd10"></i>
                                </td>
                            </tr>
                            <tr>
                                <th id="th_terminal_id">终端ID：</th>
                                <td>
                                    <input class="common-text required"  id="terminal_id" style="width:600px;" name="terminal_id" value="<?php if($data && $data['terminal_id']){ echo $data['terminal_id']; }?>" type="text">
                                    <span id="tips_terminal_id" style="color:red"></span>
                                </td>
                            </tr>
                            <tr>
                                <th id="th_server_pub_key">服务商公钥：</th>
                                <td>
                                    <textarea class="common-textarea required"  id="server_pub_key" name="server_pub_key" style="width:600px;height:80px;"><?php if($data && $data['server_pub_key']){ echo $data['server_pub_key']; }?></textarea>
                                    <span id="tips_server_pub_key" style="color:red"></span>
                                </td>
                            </tr>
                            <tr>
                                <th id="th_mem_pri_key">商户秘钥：</th>
                                <td>
                                    <textarea class="common-textarea required"  id="mem_pri_key"  name="mem_pri_key" style="width:600px;height:80px;"><?php if($data && $data['mem_pri_key']){ echo $data['mem_pri_key']; }?></textarea>
                                    <span id="tips_mem_pri_key" style="color:red"></span>
                                </td>
                            </tr>
                            <tr>
                                <th id="th_memo">备注：</th>
                                <td>
                                    <textarea class="common-textarea required"  id="memo" name="memo"   style="width:600px;height:80px;"><?php if($data && $data['memo'] ){ echo $data['memo']; }?></textarea>
                                </td>
                            </tr>
                            <tr>
                                <th></th>
                                <td>
                                    <input id="subBtn" onclick="subBtn()" class="btn btn-primary btn6 mr10" name="submit" value="提交" type="submit">
                                    <input class="btn btn6" onClick="history.go(-1)" value="返回" type="button">
                                </td>
                            </tr>
                        </tbody></table>
                </form>
            </div>
        </div>

    </div>
    <!--/main-->
</div>
<script type="text/javascript">

    var fields={};
    $(document).ready(function(){
        channel_set();
        $("#pay_channel").bind("change",function(){
            channel_set();
        })
        $('#myform').submit(function(){

            if($('#pay_channel').val()==""){
                alert("支付渠道不能为空!");
                return false;
            }
            if($('#name').val()==""){
                alert("接口名称不能为空!");
                return false;
            }
            if($('#domain').val()==""){
                alert("接口域名不能为空!");
                return false;
            }
            if(fields)
            {
                for(var key in fields)
                {
                    if(fields[key]=='notnull' && $("#"+key).val()=="")
                    {
                        alert($("#th_"+key).html().replace("：","")+'不能为空!');
                        return false;
                    }
                }
            }
            return true;
        });
    });

    function pay_type_change(obj){
        var pay_type = $(obj).val();
        $("[name='pay_type']").val(pay_type);
    }

    function channel_set(){
        if($("#pay_channel").val()==''){
            return;
        }
        var name = $("#pay_channel").find("option:selected").text();
        var domain = $("#pay_channel").find("option:selected").attr("domain");
        var pay_type = $("#pay_channel").find("option:selected").attr("pay_type");
        var sid = $("#pay_channel").find("option:selected").attr("sid");
        var skey = $("#pay_channel").find("option:selected").attr("skey");
        var terminal_id = $("#pay_channel").find("option:selected").attr("terminal_id");
        var server_pub_key = $("#pay_channel").find("option:selected").attr("server_pub_key");
        var mem_pri_key = $("#pay_channel").find("option:selected").attr("mem_pri_key");
        var can_iframe = $("#pay_channel").find("option:selected").attr("can_iframe");
        var memo = $("#pay_channel").find("option:selected").attr("memo");
        $("#pay_type").val(pay_type);
         fields = {sid : sid,skey : skey,terminal_id : terminal_id,server_pub_key : server_pub_key,mem_pri_key : mem_pri_key};

        for(var field in fields){  
            if(fields[field] == 'notnull'){
                $("#tips_"+field).html('必填');
            }
            else if(fields[field] == 'null'){
                $("#tips_"+field).html('');
            }
        }
        if(memo != ''){
            $("#tips_memo").html(memo);
        }
        else{
            $("#tips_memo").html('');
        }
        if($("[name='name']").val() == ""){
            $("[name='name']").val(name);
        }
        $("[name='controller']").val($("#pay_channel").val());
        $("[name='can_iframe']").val(can_iframe);

        //支付方式
        $("#span_pay_type select").hide();
        $("#pay_type_"+$("#pay_channel").val()).show();
    }


    //-->
</script>
<!--include file "admin_bottom.php"-->