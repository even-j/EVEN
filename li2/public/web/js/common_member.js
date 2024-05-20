$(function() {
    $('a[in="pop"]').click(function() {
        title = !$(this).attr('title') ? $(this).html() : $(this).attr('title');
        $.post($(this).attr('href'), {data: $(this).attr('data')}, function(res) {
            top.dialog(res, title);
        }, 'html');
        return false;
    });

    var rs = 60;
    $('.smscode').click(function() {
        if ($('#mobile').val().length != 11) {
            top.dialog('请输入正确的手机号！');
            return false;
        }
        var authcode = "";
        if($("#authcode").length>0 && $("#authcode").val() == ""){
            top.dialog('请输入验证码！');
            return false;
        }
        if($("#authcode").length>0){
            authcode = $("#authcode").val();
        }
        
        $.post('/index.php?app=web&mod=member&ac=regValidate',{mobile: $('#mobile').val()},function(ret){
            if (ret.code == 0) {
                $('#im').html(ret.msg);
            }
            else{
                if ($(this).attr('data') == 'bind') {
                    bind = 'true';
                } else {
                    bind = 'false';
                }
                $(this).val('重新发送(' + rs + ')');
                var int = setInterval(function() {
                    rs--;
                    if (rs < 1) {
                        rs = 60;
                        clearInterval(int);
                        $('.smscode').val('发送验证码');
                        $('.smscode').removeAttr('disabled');
                    } else {
                        $('.smscode').attr('disabled', true);
                        $('.smscode').val('重新发送(' + rs + ')');
                    }
                }, 1000);
                $.post('/index.php?app=web&mod=member&ac=getValidateCode', {mobile: $('#mobile').val(), authcode : authcode, bind: bind}, function(ret) {
                    if (ret.code == 0) {
                        $('.smscode').val('发送验证码');
                        $('#im').html(ret.msg);
                        $('.smscode').attr('disabled', false);
                        clearInterval(int);
                    }
                }, 'json');
            }
        },'json')
    });
});