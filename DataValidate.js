/**
 * 参考: 
 * http://www.cnblogs.com/gjl3355/archive/2013/04/26/3044365.html
 * http://www.cnblogs.com/Alexander-Lee/archive/2010/09/13/1825353.html
 */
//描述对字段验证的类  一个单位元素的验证绑定
function Field(params) {
    this.field_id = params.fid; //要验证的字段的ID
    this.validators = params.val; //验证器对象数组,对该值绑定多项验证
    this.on_suc = params.suc; //当验证成功的时候执行的事件
    this.on_error = params.err; //当验证失败的时候执行的事件
    this.checked = false; //是否通过验证
}

////////////////////////////////////--------Field 类的验证函数

//获取字段值的方法
Field.prototype.data = function() {
    return document.getElementById(this.field_id).value;
}

//设置验证器回调函数的方法
Field.prototype.set_callback = function(val) {
    var self = this; //换一个名字来存储this，不然函数的闭包中会覆盖这个名字
    //成功
    val.on_suc = function() { //验证成功的时候执行的方法
            self.checked = true; //字段设置为验证成功
            self.on_suc(val.tips); //执行验证成功的事件
        }
    //失败
    val.on_error = function() { //验证失败的时候执行的方法
        self.checked = false; //字段设置为验证失败
        self.on_error(val.tips); //执行验证失败的事件
    }
}

/**
 * // 扩展这个validate
 */
Field.prototype.validate = function() {
    for (var i = 0; i < this.validators.length; i++) { //循环每一个验证器
        if (this.validators[i] == null || this.validators[i] == "") //是否为空对象
            continue;
        this.set_callback(this.validators[i]); //执行验证器上的Validate方法，验证是否符合规则
        console.info(this.validators[i]);
        if (!this.validators[i].validate(this.data())) {
            break; //一旦任意一个验证器失败就停止
        }
    }
}


///////////////////////////////////////////----------验证类入口

//每一个控件的onblur事件绑定到validate的包装器上
function UserForm(items) {
    this.f_item = items; //把字段验证对象数组复制给属性
    for (idx = 0; idx < this.f_item.length; idx++) {
        if (this.f_item[idx] == null || this.f_item[idx] == "") //是否为空对象
            continue;
        var fc = this.get_check(this.f_item[idx]); //获取封装后的回调事件
        $("#" + this.f_item[idx].field_id).unbind("blur"); //事件存在删除，取反，主要为了不重复执行先前添加的事件
        $("#" + this.f_item[idx].field_id).blur(fc); //绑定到控件上
    }
}

//绑定验证事件的处理器，为了避开循环对闭包的影响
UserForm.prototype.get_check = function(v) {
    return function() {
        v.validate(); //返回包装了调用validate方法的事件
    }
}

//绑定提交事件到元件
UserForm.prototype.set_submit = function(bid, bind) {
    var self = this;
    $("#" + bid).bind("click", function() {
        //if (self.validate()) {
        bind(self.validate()); //提交的回调函数
        // }
    });
}

//元素重新验证一次
UserForm.prototype.validate = function() {
    var error_num = 0;

    for (var i = 0; i < this.f_item.length; i++) { //循环每一个验证器
        if (this.f_item[i] == null || this.f_item[i] == "") //是否为空对象
            continue;
        this.f_item[i].validate(); //再检测一遍
        if (!this.f_item[i].checked) {
            error_num++;
        }
    }
    if (error_num > 0) {
        return false; //如果错误就返回失败，阻止提交
    } else {
        return true; //一个都没错就返回成功执行提交
    }
}



/**
 * @param validataDocId 待验证的表单ID
 * @param messageDocId 提示信息Dom ID
 * @param objArray 验证规则, 是个数组
 * @param objArray 验证规则, 是个数组
 * @param action 输出错误的方式 true, 表示弹窗提示错误
 * // 验证元素ID ，提示信息元素ID,验证信息对象
 */
function validateInfo(validataDocId, messageDocId, objArray, action) {
    //验证对象
    var validate = new Field({
        fid: validataDocId //验证元素ID 
            ,
        val: objArray ////验证对象数组
            ,
        suc: function(text) {
            $("#" + messageDocId).text("*"); //提示信息元素ID
        },
        err: function(text) {
            if (action) {
                alert(text);    // 弹框的错误提示
            } else {
                $("#" + messageDocId).text(text); //提示信息元素ID
            }
        }
    });
    return validate;
}


//描述对字段验证的类  一个单位元素的验证绑定
function FieldName(params) {
    this.field_id = params.fid; //要验证的字段的Name
    this.validators = params.val; //验证器对象数组,对该值绑定多项验证
    this.on_suc = params.suc; //当验证成功的时候执行的事件
    this.on_error = params.err; //当验证失败的时候执行的事件
    this.checked = false; //是否通过验证
}

////////////////////////////////////--------FieldName 类的验证函数

//获取字段值的方法
FieldName.prototype.data = function(index) {
    var val = $($("[name='" + this.field_id + "']")[index]).val();
    return val;
}

//设置验证器回调函数的方法
FieldName.prototype.set_callback = function(val, index) {
    var self = this; //换一个名字来存储this，不然函数的闭包中会覆盖这个名字
    //成功
    val.on_suc = function() { //验证成功的时候执行的方法
            self.checked = true; //字段设置为验证成功
            self.on_suc(val.tips, index); //执行验证成功的事件
        }
        //失败
    val.on_error = function() { //验证失败的时候执行的方法
        self.checked = false; //字段设置为验证失败
        self.on_error(val.tips, index); //执行验证失败的事件
    }
}

//扩展这个validate
FieldName.prototype.validate = function(index) {
    for (var i = 0; i < this.validators.length; i++) { //循环每一个验证器
        if (this.validators[i] == null || this.validators[i] == "") //是否为空对象
            continue;
        this.set_callback(this.validators[i], index); //执行验证器上的Validate方法，验证是否符合规则
        console.log(this.validators[i]);
        if (!this.validators[i].validate(this.data(index), index)) {
            //break; //一旦任意一个验证器失败就停止
            return false;
        }
    }
    return true;
}


///////////////////////////////////////////----------验证类入口

var validateItem = null;
//每一个控件的onblur事件绑定到validate的包装器上
function UserNameForm(items) {
    this.f_item = items; //把字段验证对象数组复制给属性
    validateItem = items; //后续作用
    for (idx = 0; idx < this.f_item.length; idx++) { //遍历元素
        if (this.f_item[idx] == null || this.f_item[idx] == "") //是否为空对象
            continue;
        var self = this;
        var item = this.f_item[idx];
        $("[name='" + this.f_item[idx].field_id + "']").each(function(index) {
            var fc = self.get_check(item, index); //获取封装后的回调事件  绑定触发验证
            $(this).unbind("blur"); //事件存在删除，取反，主要为了不重复执行先前添加的事件
            $(this).blur(fc); //绑定到控件上  //调用fc触发验证
        });
    }
}

//绑定验证事件的处理器，为了避开循环对闭包的影响
UserNameForm.prototype.get_check = function(v, index) {
    return function() { //返回包装了调用validate方法的事件
        return v.validate(index); //该函数返回验证结果 true false
    }
}

//元素重新验证一次
UserNameForm.prototype.validate = function(index) {
    var error_num = 0;
    if (index == null || typeof(index) == "undefined" || index == "") { //所有 name 元素验证 所以元素索引不清楚重新遍历 获取元素索引
        for (idx = 0; idx < validateItem.length; idx++) { //遍历元素
            if (validateItem[idx] == null || validateItem[idx] == "") //是否为空对象
                continue;
            var self = this;
            var item = validateItem[idx];
            $("[name='" + validateItem[idx].field_id + "']").each(function(index) {
                var fc = self.get_check(item, index); //获取封装后的回调事件  绑定触发验证
                if (!fc())
                    error_num++;
            });
        }
    } else { //单个 name 元素验证

        for (var i = 0; i < this.f_item.length; i++) { //循环每一个验证器
            if (this.f_item[i] == null || this.f_item[i] == "") //是否为空对象
                continue;
            this.f_item[i].validate(index); //再检测一遍
            if (!this.f_item[i].checked) {
                error_num++;
            }
        }
    }
    if (error_num > 0)
        return false; //如果错误就返回失败，阻止提交
    else
        return true; //一个都没错就返回成功执行提交
}

//绑定提交事件到元件
UserNameForm.prototype.set_submit = function(bid, bind) {
    var self = this;
    $("[name='" + bid + "']").bind("click", function() {
        //if (self.validate()) {
        bind(self.validate()); //提交的回调函数
        // }
    });
}


// 验证元素Name ，提示信息元素Name,验证信息对象
function validateByNameInfo(validataDocId, messageDocId, objArray, action) {
    //验证对象
    var validate = new FieldName({
        fid: validataDocId //验证元素ID 
            ,
        val: objArray ////验证对象数组
            ,
        suc: function(text, index) {
            $(document.getElementsByName(messageDocId)[index]).text("*");
        },
        err: function(text, index) {
            if (action) {
                alert(text);
            } else {
                $(document.getElementsByName(messageDocId)[index]).text(text); //提示信息元素ID
            }
        }
    });
    return validate;
}


/////////////////////////////////--------验证函数

//空值验证
function Empty_val(tip) {
    this.tips = tip;
    this.on_suc = null;
    this.on_error = null;
}
Empty_val.prototype.validate = function(fd) {

    if (fd == null || typeof(fd) == "undefined" || fd == "") {
        this.on_error();
        return false;
    }
    this.on_suc();
    return true;
}

// 长度验证的验证器类
function Len_val(min_l, max_l, tip) {
    this.min_v = min_l;
    this.max_v = max_l;
    this.tips = tip;
    this.on_suc = null;
    this.on_error = null;
}
Len_val.prototype.validate = function(fd) {
    if (fd.length < this.min_v || fd.length > this.max_v) {
        this.on_error();
        return false;
    }
    this.on_suc();
    return true;
}

//正则表达式验证器类
function Exp_val(expresion, tip) {
    this.exps = expresion; //正则字符串
    this.tips = tip;
    this.on_suc = null;
    this.on_error = null;
}
Exp_val.prototype.validate = function(fd) {
    if (!fd) { //空值
        this.on_error();
        return false;
    }
    if (this.exps.test(fd)) { //正则验证成功
        this.on_suc();
        return true;
    } else { //正则验证失败
        this.on_error();
        return false;
    }
}

//远程验证器类
function Remote_val(url, tip) {
    this.p_url = url; //ajax访问地址
    this.tips = tip;
    this.on_suc = null;
    this.on_error = null;
}
Remote_val.prototype.validate = function(fd) {
    var self = this;
    $.post(
        this.p_url //url地址
        , {
            f: fd
        },
        function(data) {
            if (data.rs) {
                this.on_suc();
                return true;
            } else {
                this.on_error();
                return false;
            }
        }, "json"
    );
}

//自定义函数验证器类
function Man_val(func, tip) {
    this.tips = tip;
    this.val_func = func;
    this.on_suc = null;
    this.on_error = null;
}
Man_val.prototype.validate = function(fd) {
    if (this.val_func(fd)) {
        this.on_suc();
        return true;
    } else {
        this.on_error();
        return false;
    }
}

//非空验证
function IsEmpty(tip) {
    var obj = new Empty_val(tip);
    return obj;
}
//长度验证
function IsLength(min, max, tip) {
    var obj = new Len_val(min, max, tip);
    return obj;
}
//正则表达式验证
function IsRegular(expresion, tip) {
    var obj = new Exp_val(expresion, tip);
    return obj;
}
//远程验证器
function IsLongRange(url, tip) {
    var obj = new Remote_val(url, tip);
    return obj;
}
//自定义函数验证器
function IsCustomFn(func, tip) {
    var obj = new Man_val(func, tip);
    return obj;
}
