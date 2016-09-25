function fleshVerify(identify) {
    // var identify = that.id || 'verify';
    var identify = identify || 'verifyImg';
    //重载验证码
    var timenow = new Date().getTime();
    document.getElementById(identify).src = URL + '/verify/' + timenow;
}
