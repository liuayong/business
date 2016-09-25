$(function() {
    $('#user_passwd').keyup(function() {
        var numpattern = /^[0-9]+$/;
        var stringpattern1 = /^[a-z]+$/;
        var stringpattern2 = /^[A-Z]+$/;
        var stringpattern3 = /^[!@#$%^&*()_+|{}?]+$/;

        var stringpattern4 = /^[a-zA-Z0-9!@#$%^&*()_+|{}?]*$/;
        var len = $(this).val().length;
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
});