// JavaScript Document
var formValidate = new formValidate();
$(function () {
    var veri_user_id = false;
    var veri_user_passwd = false;
    var veri_code = false;
    var veri_message_code = false;
    var veri_company = false;
    //var veri_mail = false;

    var veri_telphone = true;
    //var veri_cellphone = true;
    var veri_linkman = true;

    var InterValObj; //timer变量，控制时间
    var curCount;//当前剩余秒数

    //倒计时
    var SetRemainTime = function () {
        if (curCount == 0) {
            window.clearInterval(InterValObj);//停止计时器
            $("#getcode").removeAttr("disabled");//启用按钮
            $("#getcode").val("重新发送验证码");
        } else {
            curCount--;
            $("#getcode").val("请在" + curCount + "秒内输入验证码");
        }
    }
    
    $('#user_id').blur(function () {
        veri_user_id = formValidate.verify($(this));
        var reg = /^(?:13\d|15\d|17\d|18\d)\d{5}(\d{3}|\*{3})$/;
        var numpattern = /^[0-9]+$/;

        result = {"responseText" : '1'};
        if ($(this).val() != '') {
            get_usertype($(this).val());
            if (veri_user_id == true) {
                user_id = $(this).val();
                result = $.ajax({type:"POST", url: check_url,  data : {'account':user_id, 'type':$("#type").val()}, dataType: "text", async: false});
                if (result.responseText != '0') {
                    //veri_code = false;
                    //$(this).val('');
                    $(this).next().html('<b></b>用户名已注册!');
                    //$(this).focus();
                }
                else {
                    //veri_code = true;
                    $(this).next().html('<b class="ok"></b>');
                }
            }

            if (result.responseText == '0') {

                if (reg.test($(this).val())) {
                    $("#yanzhangma_code").attr('style', 'display:none');
                    $("#yanzhangma_shouji").attr('style', '');
                } else {
                    if (numpattern.test($(this).val())) {
                        $(this).next().html('<b></b>您填写的手机号格式有误，请输入11位有效手机号！');
                        //$(this).focus();
                        return false;
                    }
                    $("#yanzhangma_code").attr('style', '');
                    $("#yanzhangma_shouji").attr('style', 'display:none');
                }
            }
        }
    });

//    $('#user_passwd').blur(function () {
//        veri_user_passwd = formValidate.verify($(this));
//    });

    $('#user_passwd').keyup(function () {

        var numpattern = /^[0-9]+$/;
        var stringpattern1 = /^[a-z]+$/;
        var stringpattern2 = /^[A-Z]+$/;
        var stringpattern3 = /^[!@#$%^&*()_+|{}?]+$/;

        var stringpattern4 = /^[a-zA-Z0-9!@#$%^&*()_+|{}?]*$/;
        var

            len = $(this).val().length;
        span = $('.pswarp').children('span');

        str = $(this).val();

        passtype = '';
        if (numpattern.test(str) || stringpattern1.test(str) || stringpattern2.test(str) || stringpattern3.test(str) || len < 6) {
            passtype = 'low';
            veri_user_passwd = false;
            $('#user_passwd').next().html('');
            $('#user_passwd').next().html('<b></b>限6到14位字母和数字组合！');

        } else if (stringpattern4.test(str)) {
            $('#user_passwd').next().html('');
            veri_user_passwd = true;
            if (len >= 6 && len <= 10) {
                $('#user_passwd').next().html('');
                $('#user_passwd').next().html('<b class="ok"></b>');
                passtype = 'mid';
            } else if (len > 10 && len <= 14) {
                $('#user_passwd').next().html('');
                $('#user_passwd').next().html('<b class="ok"></b>');
                passtype = 'high';
            } else {
                passtype = 'high';
                veri_user_passwd = false;
                $('#user_passwd').next().html('');
                $('#user_passwd').next().html('<b></b>限6到14位字母和数字组合！');
            }
        }

        if (len == 0) {
            passtype = '';
            veri_user_passwd = false;
            $('#user_passwd').next().html('');
            $('#user_passwd').next().html('<b></b>限6到14位字母和数字组合！');
        }

        //alert(span.length);
        if (passtype == 'low') {
            span.eq(0).attr('class', 's_box s_box1');
            span.eq(1).attr('class', 's_box s_box');
            span.eq(2).attr('class', 's_box s_box');
        } else if (passtype == 'mid') {
            span.eq(0).attr('class', 's_box s_box');
            span.eq(1).attr('class', 's_box s_box2');
            span.eq(2).attr('class', 's_box s_box');
        } else if (passtype == 'high') {
            span.eq(0).attr('class', 's_box s_box');
            span.eq(1).attr('class', 's_box s_box');
            span.eq(2).attr('class', 's_box s_box3');
        } else {
            span.eq(0).attr('class', 's_box s_box');
            span.eq(1).attr('class', 's_box s_box');
            span.eq(2).attr('class', 's_box s_box');
        }

        /*
         if (len < 7 || passtype == 'low') {
         span.eq(0).attr('class', 's_box s_box1');
         span.eq(1).attr('class', 's_box s_box');
         span.eq(2).attr('class', 's_box s_box');
         } else if (len >= 7 && len <= 12) {
         span.eq(1).attr('class', 's_box s_box2');
         span.eq(2).attr('class', 's_box s_box');
         } else if (len > 12) {
         span.eq(2).attr('class', 's_box s_box3');
         } else {
         span.eq(0).attr('class', 's_box s_box');
         span.eq(1).attr('class', 's_box s_box');
         span.eq(2).attr('class', 's_box s_box');
         }
         */
    });

    $('#reuser_passwd').blur(function () {
        org_pw = $('#user_passwd').val();
        if (veri_user_passwd == true) {
            if (org_pw != $(this).val()) {
                veri_user_passwd = false;
                //$(this).val('');
                $(this).next().html('<b></b>密码不一致,再次输入您设定的密码!');
                //$(this).focus();
            }
            else {
                veri_user_passwd = true;
                $(this).next().html('<b class="ok"></b>');
            }
        }
    });

    $('#telphone').blur(function () {
        str1 = /^((0\d{2,3}))?(\d{7,8})(-(\d{3,}))?$/;
        str2 = /^(?:13\d|15\d|18\d|17\d)\d{5}(\d{3}|\*{3})$/;
        veri_telphone = formValidate.verify($(this));

        var_phone = $(this).val();
        if (veri_telphone == true && var_phone != '') {
            if (!(str1.test(var_phone) || str2.test(var_phone))) {
                $(this).next().html('');
                $(this).next().html('<b></b>联系电话格式不正确!');
                veri_telphone = false;
            } else {
                $(this).next().html('');
                $(this).next().html('<b class="ok"></b>');
            }
        }
    });

    $('#company').blur(function () {
        veri_company = formValidate.verify($(this));
    });

    $('#code').blur(function () {
        code = $(this).val();
        if (code == '') {
            $('#errorTip_code').html('');
            $('#errorTip_code').html('<b></b>验证码不能为空!');
            //$(this).focus();
            return false;
        }else {
            $('#errorTip_code').html('');
        }
    });

    //获取短信验证码
    $("#getcode").on('click', function () {
        var phonecode = $('#user_id').val();
        curCount = 60;
        $("#getcode").attr("disabled", "true");
        $("#getcode").val("请在" + curCount + "秒内输入验证码");
        InterValObj = window.setInterval(SetRemainTime, 1000); //启动计时器，1秒执行一次
        $.ajax({
            type: "POST",
            url: "/user/confirmtel",
            data: {phonecode: phonecode},
            datatype: "json",
            success: function (data) {
                var res = eval('(' + data + ')');
                if (res.states == 1) {
                    $('#errorTip_shouji').html('');
                    $('#errorTip_shouji').html(res.message);
                } else {
                    InterValObj = window.setInterval(SetRemainTime, 1);
                    $('#errorTip_shouji').html('');
                    $('#errorTip_shouji').html('<b></b>' + res.message);
                    $("#getcode").removeAttr("disabled");//启用按钮
                    $("#getcode").val("重新发送验证码");
                }
            }
        })
    })

    $('#phonecode').blur(function () {
        if ($('#phonecode').val() != '') {
            $.ajax({
                type: "POST",
                url: "/user/confirmcode",
                data: {
                    phonecode: $("#user_id").val(),
                    checkNo: $("#phonecode").val()
                },
                datatype: "json",
                success: function (data) {
                    var res = eval('(' + data + ')');
                    if (res.states == 0) {
                        veri_message_code = false;
                        $('#errorTip_shouji').html('');
                        $('#errorTip_shouji').html('<b></b>' + '你输入的短信激活码有误');
                        return false;
                    } else {
                        $('#errorTip_shouji').html('<b class="ok"></b>');
                        veri_message_code = true;
                    }
                }
            })
        } else {
            $('#errorTip_shouji').html('<b></b>短信验证码不能为空');
            //$("#phonecode").focus();
            return false;
        }
    });

    $("#registerButton").click(function () {
        
        
        if (veri_user_id == false) {
            $('#user_id').triggerHandler("blur");
            return false;
        }
        //alert(veri_user_passwd);
        if (veri_user_passwd == false) {
            $('#user_passwd').triggerHandler("keyup");
            //alert(veri_user_passwd);
            if (veri_user_passwd == false) {
                return false;
            }
        }
        //return false;
        if ($('#reuser_passwd').val() != $('#user_passwd').val()) {
            $('#reuser_passwd').next().html('<b></b>用户密码不一致，重新输入密码!');
            user_passwd.focus();
            return false;
        }

        if (veri_telphone == false) {
            $('#telphone').triggerHandler("blur");
            return false;
        }

       return true;
    });
})