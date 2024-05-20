<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <!--include file "common.php"-->
    </head>

    <body class="index">
        <!-- Header Start -->
        <div id="top">
            <!--include file "header.php"-->
            <!--include file "nav.php"-->
        </div>
        <!--include file "user_header.php"-->
        <div class="bar">
            <div class="my-space">
                <div class="space-main clearfix">
                    <div class="space-left">
                        <!--include file "user_left_menu.php"-->
                    </div>
                    <?php if (\Model\User\UserInfo::checkBindInfo($user['uid'])){?>
                    <div class="space-right">
                        <h2><strong>实名认证</strong></h2>
<!--                        <div class="prompt-box">
                            <p><strong>实名认证审核中，请耐心等待...</strong></p>
                            <p>
                                <br>或者拨打华亿配资热线电话 021-26052950 进行咨询。
                            </p>
                        </div>-->
                        <div class="prompt-box">
                        <p><strong>已通过实名认证！</strong></p>
                            <p>
                                <br>如果还没有完成银行卡绑定，您可以选择&nbsp;<a href="<?php echo \App::URL("web/user/bank");?>">绑定银行卡</a>
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
                    <div class="space-right">
                        <h2><strong>实名认证</strong></h2>
                        <div class="ms-c6">
                            <div class="formbox">
                                <form enctype="multipart/form-data" method="post" id="idCardValidateForm" action="">
                                    <input name="id" id="id" value="42330" type="hidden">
                                        <table>
                                            <tbody>
                                                <tr>
                                                    <th>真实姓名：</th>
                                                    <td><input value="" name="realName" class="inp" id="name" type="text"></td>
                                                </tr>
                                                <tr>
                                                    <th>身份证号码：</th>
                                                    <td>
                                                        <input value="" name="identityCard" class="inp" id="number" type="text"/>
                                                        <input value="" name="province" id="province" type="hidden"/>
                                                        <input value="" name="birthday" id="birthday" type="hidden"/>
                                                        <input value="" name="age" id="age" type="hidden"/>
                                                        <input value="" name="sex" id="sex" type="hidden"/>
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <th></th>
                                                    <td>
                                                        <button id="submitBtn" class="btn-b" onclick="doSubmit();" type="button" style="margin:20px 0;">保存</button>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                        <input type="hidden" name="__hash__" value="8c3ce30f47a59bbbe1410313a2939a03_da2c496181183cb390c46db79e074707" /></form>
                                <div class="ms-c6-b">
                                    <dl>
                                        <dt>
                                            <font color="red">温馨提示：</font>
                                        </dt>
                                        <dd>认证后身份信息不可修改；且之后仅限添加本人的银行卡！</dd>
                                    </dl>
                                </div>
                            </div>
                        </div>
                        <script src="/public/web/js/uploader.js" type="text/javascript"></script>
                        <script src="/public/web/js/idvalidate.js" type="text/javascript"></script>
                        <script type="text/javascript">
                            function doSubmit() {
                                if ($('#name').val() == '') {
                                    top.dialog('请输入您的真实姓名！');
                                    return false;
                                }
                                //判断中文
                                var reg=/^[\u2E80-\u9FFF]+$/;//Unicode编码中的汉字范围
                                if(!reg.test($('#name').val())){
                                    top.dialog("输入姓名错误");
                                    return false;
                                }
                                if (!IdCardValidate($('#number').val())) {
                                    top.dialog('身份证号码不正确！');
                                    return false;
                                } else {
                                    setInfo($('#number').val(), 'sex', 'birthday', 'province', 'age');
                                }
                                $.post('<?php echo \App::URL("web/user/doindentity")?>', $('#idCardValidateForm').serialize(),function(res) {
                                    if (res.code != 0) {
//                                        top.dialog(res.info, 'success',
//                                        function() {
//                                            if (res.data != '') {
//                                                top.$('#mainFrame').attr('src', res.data);
//                                            }
//                                        });
                                        window.location.reload();
                                    } else {
                                        top.dialog(res.msg, 'error');
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
                    </div>
                    <?php }?>
                </div>
            </div>
        </div>
        <!--include file "footer.php"-->
    </body>
</html>