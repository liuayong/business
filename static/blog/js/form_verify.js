/*
 * 通用JS验证类
 */
var formValidate = function() {

    var _this = this;

    this.options = {
        number: {
            reg: /^[0-9]+$/,
            str: '必须为数字'
        },
        decimal: {
            reg: /^[-]{0,1}(\d+)[\.]+(\d+)$/,
            str: '必须为DECIMAL格式'
        },
        english: {
            reg: /^[A-Za-z]+$/,
            str: '必须为英文字母'
        },
        upper_english: {
            reg: /^[A-Z]+$/,
            str: '必须为大写英文字母'
        },
        lower_english: {
            reg: /^[a-z]+$/,
            str: '必须为小写英文字母'
        },
        email: {
            reg: /^([a-zA-Z0-9]+[_|\_|\.]?)*[a-zA-Z0-9]+@([a-zA-Z0-9]+[_|\_|\.]?)*[a-zA-Z0-9]+\.[a-zA-Z]{2,3}$/,
            str: 'Email格式不正确'
        },
        chinese: {
            reg: /[\u4E00-\u9FA5\uf900-\ufa2d]/ig,
            str: '必须含有中文'
        },
        url: {
            reg: /^[a-zA-z]+:\/\/[^s]*/,
            str: 'URL格式不正确'
        },
        phone: {
            reg: /^((0\d{2,3}))?(\d{7,8})(-(\d{3,}))?$/,
            str: '电话号码格式不正确'
        },
        mobile: {
            reg: /^(?:13\d|15\d|18\d|17\d)\d{5}(\d{3}|\*{3})$/,
            str: '手机号码格式不正确'
        },
        ip: {
            reg: /^(\d+)\.(\d+)\.(\d+)\.(\d+)$/,
            str: 'IP地址格式不正确'
        },
        money: {
            reg: /^[0-9]+[\.][0-9]{0,3}$/,
            str: '金额格式不正确'
        },
        number_letter: {
            reg: /^[0-9a-zA-Z\_@.]+$/,
            str: '只允许输入英文字母、数字、_@.'
        },
        zip_code: {
            reg: /^[a-zA-Z0-9 ]{3,12}$/,
            str: '邮政编码格式不正确'
        },
        account: {
            reg: /^[a-zA-Z][a-zA-Z0-9_]{4,15}$/,
            str: '账号名不合法，允许5-16字符，字母下划线和数字'
        },
        qq: {
            reg: /[1-9][0-9]{4,}/,
            str: 'QQ账号不正确'
        },
        card: {
            reg: /^(\d{6})(18|19|20)?(\d{2})([01]\d)([0123]\d)(\d{3})(\d|X)?$/,
            str: '身份证号码不正确'
        },
    };

    //初始化 绑定表单 选项
    this.init = function(options) {
        this.setOptions(options);
        this.checkForm();
    };

    //设置参数
    this.setOptions = function(options) {
        for (var key in options) {
            if (key in this.options) {
                this.options[key] = options[key];
            }
        }
    };

    this.objnames = {
        user_id: '用户名',
        user_passwd: '密码',
        company: '企业名称',
        cellphone: '手机号码',
        telphone: '电话号码',
        linkman: '联系人',
    };

    this.verify = function(obj) {


        return_result = true;

        isempty = obj.attr('empty'); //是否为空
        min = obj.attr('min');
        max = obj.attr('max');
        errobj = obj.next();
        objid = obj.attr('id');
        vertype = obj.attr('validate');
        value = obj.val();
        len = value.length;

        if (vertype) {
            //var type = child.attr('validate');
            var result = _this.check(value, vertype);
            if (result != true) {

                if (errobj) {
                    errobj.html('');
                    errobj.html('<b></b>' + result);
                    //obj.focus();
                    return false;
                }
            }
            else {
                if (len != 0)
                    errobj.html('<b class="ok"></b>');
                else
                    errobj.html('');
            }

        }

        if (isempty == 'no') {
            if (len == 0) {
                if (errobj) {
                    errobj.html('');
                    errobj.html('<b></b>' + this.objnames[objid] + '不能为空');
                    //obj.focus();
                    return false;
                }
            } else {
                errobj.html('<b class="ok"></b>');
            }
        }

        if (min && max) {
            if (len < min || len > max) {
                if (errobj) {
                    errobj.html('');
                    errobj.html('<b></b>' + this.objnames[objid] + '长度在' + min + '与' + max + '之间');
                    //obj.focus();
                    return false;
                }
            }
            else {
                if (errobj) {
                    errobj.html('<b class="ok"></b>');
                }
            }
        } else if (min) {
            if (len < min) {
                if (errobj) {
                    errobj.html('');
                    errobj.html('<b></b>' + this.objnames[objid] + '长度应大于' + min);
                    //obj.focus();
                    return false;
                }
                else {
                    if (errobj) {
                        errobj.html('<b class="ok"></b>');
                    }
                }
            }
        } else if (max) {
            if (len > max) {
                if (errobj) {
                    errobj.html('');
                    errobj.html('<b></b>' + this.objnames['objid'] + '长度应小于' + max);
                    //obj.focus();
                    return false;
                }
                else {
                    if (errobj) {
                        errobj.html('<b class="ok"></b>');
                    }
                }
            }
        }

        return true;

    }
    //检测单个正则选项
    this.check = function(value, type) {
        if (value.length == 0)
            return true;
        if (this.options[type]) {
            var val = this.options[type]['reg'];
            if (!val.test(value)) {
                return this.options[type]['str'];
            }
            return true;
        } else {
            return '找不到该表单验证正则项';
        }
    };
}


// 获得用户的类型， 用户名， 手机， 邮箱地址 ？？？
function get_usertype(val) {
    var tel = /^1\d{10}$/;
    var email = /^([a-zA-Z0-9]+[_|\_|\.]?)*[a-zA-Z0-9]+@([a-zA-Z0-9]+[_|\_|\.]?)*[a-zA-Z0-9]+\.[a-zA-Z]{2,3}$/;
    var ret = '';
    if (tel.test(val)) {
        ret = 'tel';
    } else if (email.test(val)) {
        ret = 'email';
    } else {
        ret = 'username';
    }
    $("#type").val(ret);
    return ret;
}