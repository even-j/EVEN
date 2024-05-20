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

        <style>
            .formbox td{text-align: left;font-size:14px}
        </style>
    </head>

    <body class="index">
        <div class="header">
            <h1>实名认证</h1>
            <a class="l-link" href="javascript:history.go(-1)"><span>返回</span></a> 
            <div class="top-menu">
                <!--<button type="button" class="btn"></button>-->
            </div>
        </div>
        <div style="height: 40px"></div>
        <div class="space-main clearfix">
            <?php if (\Model\User\UserInfo::checkBindInfo($user['uid'])){?>
            <div class="space-right">
                <div style="padding:10px;border:1px solid #ff835f;background: #fff;margin:15px 15px;line-height: 25px">
                    <p style="color:#F60;font-size: 14px">您已通过实名认证！</p>
                    <p style="color:#777;font-size: 12px">
                        如果还没有完成银行卡绑定，您可以选择&nbsp;<a style="color:#069" href="<?php echo \App::URL("wap/user/bank");?>">绑定银行卡</a>
                    </p>
                </div>
                <div class="formbox">
                    <table>
                        <tbody>
                            <tr>
                                <th>真实姓名：</th>
                                <td><?php echo substr_replace($user ['true_name'], '****', 3);?></td>
                            </tr>
                            <tr>
                                <th>证件类型：</th>
                                <td>身份证</td>
                            </tr>
                            <tr>
                                <th>证件号码：</th>
                                <td><?php echo substr_replace($user ['id_card'], '****', 10, 4); ?></td>
                            </tr>
                            <tr>
                                <th>认证状态：</th>
                                <td>
                                    <strong style="color:gray">已认证</strong></td>
                            </tr>
                            <!--tr>
                                <th>认证申请时间：</th>
                                <td>1970-01-01 08:00:00</td>
                            </tr-->
                        </tbody>
                    </table>
                </div>
            </div>
            <?php } else{?>
            
            <div class="formbox">
                <form enctype="multipart/form-data" method="post" id="idCardValidateForm" action="">
                    <input name="id" id="id" value="42330" type="hidden"/>
                    <table>
                        <tbody>
                            <tr>
                                <td style="width:100px">真实姓名：</td>
                                <td><input value="" name="realName" class="" id="name" type="text" style="width:98%;border:1px solid #aaa;height: 26px"></td>
                            </tr>
                            <tr>
                                <td>身份证号码：</td>
                                <td>
                                    <input value="" name="identityCard" class="" id="number" type="text" style="width:98%;border:1px solid #aaa;height: 26px"/>
                                    <input value="" name="province" id="province" type="hidden"/>
                                    <input value="" name="birthday" id="birthday" type="hidden"/>
                                    <input value="" name="age" id="age" type="hidden"/>
                                    <input value="" name="sex" id="sex" type="hidden"/>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </form>
            </div>
            <div style="width:60%;margin: 0 auto">
                <div id="submitBtn" class="btn_primary" onclick="doSubmit();" type="button" style="margin:20px 0;">保存</div>
            </div>
            <div style="font-size:12px;line-height: 20px;padding: 15px">
                <dl>
                    <dt>
                        <font color="red">温馨提示：认证后身份信息不可修改；且之后仅限添加本人的银行卡！</font>
                    </dt>
                </dl>
            </div>
            <script src="/public/wap/js/uploader.js" type="text/javascript"></script>
            <script src="/public/wap/js/idvalidate.js" type="text/javascript"></script>
            <script type="text/javascript">
                function doSubmit() {
                    if ($('#name').val() == '') {
                        layeralert("请输入您的真实姓名");
                        return false;
                    }
                    //判断中文
                    var reg=/^[\u2E80-\u9FFF]+$/;//Unicode编码中的汉字范围
                    if(!reg.test($('#name').val())){
                        layeralert("输入姓名错误");
                        return false;
                    }
                    if (!IdCardValidate($('#number').val())) {
                        layeralert("身份证号码不正确");
                        return false;
                    } else {
                        setInfo($('#number').val(), 'sex', 'birthday', 'province', 'age');
                    }

                    $.post('<?php echo \App::URL("wap/user/doindentity")?>', $('#idCardValidateForm').serialize(),function(res) {
                        if (res.code != 0) {
                            window.location.reload();
                        } else {
                            layeralert(res.msg);
                        }
                    },
                    'json');
                }
                function ajaxFileUpload(id) {
                    var div = id == 'idCardFront' ? '.i-z': '.i-f';
                    $(div).css('background', 'url(/tpl/Member/default/Res/img/bg23.gif) no-repeat center center');
                    $.ajaxFileUpload({
                        url: './upload.html',
                        secureuri: false,
                        fileElementId: id + 'File',
                        dataType: 'json',
                        success: function(ret, status) {
                            if (ret.status == 0) {
                                $('#' + id).val(ret.data);
                                $(div).css('background', 'url(' + ret.data + ') no-repeat center center');
                                $(div).css('background-size', '120px 80px');
                            } else {
                                top.dialog(ret.info);
                            }
                        },
                        error: function(data, status, e) {
                            alert(e);
                        }
                    });
                    return false;
                }
            </script>
            <?php }?>
        </div>
    </body>
</html>