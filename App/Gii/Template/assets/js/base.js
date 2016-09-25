//note userAgent
var BROWSER = {};
var USERAGENT = navigator.userAgent.toLowerCase();
BROWSER.ie = window.ActiveXObject && USERAGENT.indexOf('msie') != -1 && USERAGENT.substr(USERAGENT.indexOf('msie') + 5, 3);
BROWSER.firefox = document.getBoxObjectFor && USERAGENT.indexOf('firefox') != -1 && USERAGENT.substr(USERAGENT.indexOf('firefox') + 8, 3);
BROWSER.chrome = window.MessageEvent && !document.getBoxObjectFor && USERAGENT.indexOf('chrome') != -1 && USERAGENT.substr(USERAGENT.indexOf('chrome') + 7, 10);
BROWSER.opera = window.opera && opera.version();
BROWSER.safari = window.openDatabase && USERAGENT.indexOf('safari') != -1 && USERAGENT.substr(USERAGENT.indexOf('safari') + 7, 8);
BROWSER.other = !BROWSER.ie && !BROWSER.firefox && !BROWSER.chrome && !BROWSER.opera && !BROWSER.safari;
BROWSER.firefox = BROWSER.chrome ? 1 : BROWSER.firefox;


// JavaScript Document
function checkAll2(form, name) {
    for (var i = 0; i < form.elements.length; i++) {
        var e = form.elements[i];
        if (e.name.match(name)) {
            e.checked = form.elements['chkall'].checked;
        }
    }
}
/**
 * 全选，反选的效果
 * @returns {undefined}
 */
function selAll() {
    $form = $('form[name=listForm]');       // 操作的表单
    selectCheck = $('.selectAll[type=checkbox]', $form);
    otherCheck = $('[type=checkbox][name=id\\[\\]]', $form);
    btnSubmit = $('#btnSubmit', $form);

    selectCheck.click(function() {
        otherCheck.prop('checked', this.checked);

        // 批量删除的按钮是否可以点击
        btnSubmit.prop('disabled', otherCheck.filter(":checked").length == 0);
    });
    otherCheck.click(function() {
        var len1 = otherCheck.length;
        var len2 = otherCheck.filter(":checked").length;
        selectCheck.prop('checked', len1 === len2);

        // 批量删除的按钮是否可以点击
        btnSubmit.prop('disabled', otherCheck.filter(":checked").length == 0);
    });
}

// 全选、反选功能
function checkAll(chkall, name) {
    name = handleName(name) ;
    $('[name=' + name + ']').prop("checked", chkall.checked);
}

// 单条记录的操作
function oneAction() {

}

// 处理name属性
function handleName(name) {
    if (name.indexOf('[') || name.indexOf(']')) {
        name = name.replace('[', '\\[').replace(']', '\\]');
    }
    return name ;
}

// 批量操作
function batchAction(that, name) {
    var text = $(that).closest('tr').find('select option:selected').text();
    var val = $(that).closest('tr').find('select option:selected').val();
    name = handleName(name) ; 
    
    if (val == '' || val == '选择操作') {
        alert("必须选择一个操作");
        return false;
    }

    if (confirm('您在进行 【 ' + text + ' 】 操作，确定继续？')) {
        if ($('[type=checkbox][name=' + name + ']:checked').length == 0) {
            alert("没有选中的项, 无法进行【 " + text + " 】操作");
            return false;
        }
        // 对form的处理
        var action = that.form.action || batchUrl;
        alert(batchUrl);
        that.form.action = action;
        
        return true;
    } else {
        return false;
    }
}




//双击是扩大textarea
function textareasize(obj, op) {
    if (!op) {
        if (obj.scrollHeight > 70) {
            obj.style.height = (obj.scrollHeight < 300 ? obj.scrollHeight : 300) + 'px';
            if (obj.style.position == 'absolute') {
                obj.parentNode.style.height = obj.style.height;
            }
        }
    } else {
        if (obj.style.position == 'absolute') {
            obj.style.position = '';
            obj.style.width = '';
            obj.parentNode.style.height = '';
        } else {
            obj.parentNode.style.height = obj.parentNode.offsetHeight + 'px';
            obj.style.width = BROWSER.ie > 6 || !BROWSER.ie ? '90%' : '600px';
            obj.style.position = 'absolute';
        }
    }
}

function copyCode(s)
{
    if (window.clipboardData)
    {
        window.clipboardData.setData('text', s.val());
        alert('复制成功！\t\r请将已复制的代码粘贴到要加入微博秀功能的页面。');
    }
    else
    {
        alert('你的浏览器不支持脚本复制或你拒绝了浏览器安全确认。请尝试[Ctrl+C]复制代码并粘贴到要加入功能的页面。');
    }
}