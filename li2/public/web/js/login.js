$(function() {
    $('#mobile').focus();
//	$('.codeimg').click(function(){
//		$('.yzmPic').attr('src','/member/authcode.html#'+new Date().getTime());
//	});
    $('#login').click(function() {
        if (!$('#username').val()) {
            $('#username').focus();
            $('#un').html('帐号不能为空');
        } else {
            $('#un').html('');
        }
        if (!$('#password').val()) {
            $('#up').html('密码不能为空');
        } else {
            $('#up').html('');
        }
        if (!$('#authcode').val()) {
            $('#ua').html('验证码不能为空');
        } else {
            $('#ua').html('');
        }
        if ($('#un').html() == '' && $('#up').html() == '') {
            $.post("/index.php?app=web&mod=member&ac=dologin", $("#loginForm").serialize(), function(res) {
                if (res.code == 0) {
                    //if(res.data=='ua'){
                    //$('.yzmPic').attr('src','/member/authcode.html#'+new Date().getTime());
                    //}
                    //$('.authcode').show();
                    $('#un').html(res.msg);

                } else {
                    var url = $('#from').val();
                    if(url==""){
                        url = "/index.php?app=web&mod=user&ac=account";
                    }
                    window.location = url;
                }
            }, 'json');
        }
    });

    $('#name').blur(function() {
        if ($('#name').val().length < 6 || $('#name').val().length > 20) {
            $('#iu').html($('#iu').attr('data'));
            $('#iu').attr('class', 'error');
        } else {
            $('#iu').attr('class', 'pass');
            $('#iu').html('通过');
        }
    });
    $('#mobile').blur(function() {
        if (!$('#mobile').val() || $('#mobile').val().length != 11 || isNaN($('#mobile').val())) {
            $('#im').html($('#im').attr('data'));
            $('#im').attr('class', 'error');
        } else {
            $('#im').attr('class', 'pass');
            $('#im').html('通过');
        }
    });
    $('#password').blur(function() {
        if (!$('#password').val() || $('#password').val().length < 6 || $('#password').val().length > 20) {
            $('#ip').html($('#ip').attr('data'));
            $('#ip').attr('class', 'error');
        } else {
            $('#ip').attr('class', 'pass');
            $('#ip').html('通过');
        }
    });

    $('#confirm').blur(function() {
        if ($('#password').val() != $('#confirm').val()) {
            $('#ic').html($('#ic').attr('data'));
            $('#ic').attr('class', 'error');
        } else {
            $('#ic').attr('class', 'pass');
            $('#ic').html('通过');
        }
    });

    $('#invitor').blur(function() {
        if ($('#invitor').val()) {
            if ($('#invitor').val().length != 32) {
                $('#ii').html($('#ii').attr('data'));
                $('#ii').attr('class', 'error');
            } else {
                $('#ii').attr('class', 'pass');
                $('#ii').html('通过');
            }
        } else {
            $('#ii').attr('class', 'tip');
            $('#ii').html('非推荐注册可不填');
        }
    });
    $('#smscode').blur(function() {
        if ($('#smscode').val() != '' && $('#smscode').val().length != 4) {
            $('#ia').html($('#is').attr('data'));
            $('#ia').attr('class', 'error');
        } else {
            $('#ia').attr('class', 'pass');
            $('#ia').html('');
        }
    });
    $('#register').click(function() {
        if (!$('#mobile').val()) {
            $('#mobile').focus();
            $('#im').html('手机号不能为空');
        } else {
            $('#im').html('');
        }
        if (!$('#smscode').val()) {
            $('#smscode').focus();
            $('#ia').html('验证码不能为空');
        } else {
            $('#ia').html('');
        }
        if (!$('#password').val()) {
            $('#password').focus();
            $('#ip').html('密码不能为空');
        } else {
            $('#ip').html('');
        }
        if ($('#password').val()!=$('#confirm').val()) {
            $('#confirm').focus();
            $('#ic').html('两次密码不一致');
        } else {
            $('#ic').html('');
        }
        $.post("/index.php?app=web&mod=member&ac=doregister", $("#registerForm").serialize(), function(res) {
            if (res.code == 0) {
                $('#im').html(res.msg);
                $('#im').attr('class', 'error');
            } else {
                window.location = '/index.php?app=web&mod=user&ac=account';
            }

        }, 'json');
    });
});
$(document).keypress(function(e) {
    if (e.which == 13) {
        $('#login').click();
        $('#register').click();
    }
}); 