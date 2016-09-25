// JavaScript Document
var formValidate = new formValidate();
$(function() {

    // 账号
    $('#user_id').blur(function() {
        veri_user_id = formValidate.verify($(this));
        var reg = /^(?:13\d|15\d|17\d|18\d)\d{5}(\d{3}|\*{3})$/;
        var numpattern = /^[0-9]+$/;

        if ($(this).val() == '') {
            $('#form_error_tip').html('');
            $('#form_error_tip').html('<b></b>账号不能为空!');
        } else {
            get_usertype($(this).val());
            $('#form_error_tip').html('');
        }
    });

    // 密码
    $('#user_passwd').blur(function() {
        val = $(this).val();
        if (val == '') {
            $('#form_error_tip').html('');
            $('#form_error_tip').html('<b></b>密码不能为空!');
            $(this).focus();
            return false;
        } else if(val.length<6 || val.length>14) {
            $('#form_error_tip').html('');
            $('#form_error_tip').html('<b></b>限6到14位字母和数字组合！');
            $(this).focus();
            return false;
        }else {
            $('#form_error_tip').html('');
        }
    });

    // 验证码
    $('#code').blur(function() {
        code = $(this).val();
        if (code == '') {
            $('#form_error_tip').html('');
            $('#form_error_tip').html('<b></b>验证码不能为空!');
            $(this).focus();
            return false;
        } else {
            $('#form_error_tip').html('');
        }
    });
});

    