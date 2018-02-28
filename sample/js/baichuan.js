//  提交后台
$(document).ready(function () {
    $("#BaiChuanSumbit").click(function () {
        var action = $("#BaiChuanForm").attr('action');
        if (!action) {
            action = window.location.href;
        }
        var data = $("#BaiChuanForm").serialize();
        var handler = $(this).attr('baichuan-ajax-handler')
        var redirect = $(this).attr('baichuan-ajax-redirect')

        baichuanAjaxJson(action, data, handler, redirect, 'POST');
        return false;
    });
})
$(document).ready(function () {
    $(".BaiChuanSumbit").click(function () {
        var action = $(".BaiChuanForm").attr('action');
        if (!action) {
            action = window.location.href;
        }
        var data = $(".BaiChuanForm").serialize();
        var handler = $(this).attr('baichuan-ajax-handler')
        var redirect = $(this).attr('baichuan-ajax-redirect')

        baichuanAjaxJson(action, data, handler, redirect, 'POST');
        return false;
    });
})

//  ajax获取json数据
function baichuanAjaxJson(action, submitData, handler, redirect, submitType) {
    if (!submitType) {
        submitType = "POST";
    }

    $.ajax({
        cache: true,
        type: submitType,
        url: action,
        data: submitData,
        async: false,
        dataType: 'json',
        success: function (data) {
            //如果有自定义的处理函数，则用处理函数
            if (handler) {
                eval(handler + '(data);');
                return;
            }
            if (data.error == 0) {
                alert(data.msg);
            } else if (data.error == 1) {
                alert(data.msg);
                if (redirect) {
                    window.location = redirect;
                }
                // location.reload();
            } else {
                alert('数据异常');
            }
        },
        error: function (request) {
            alert("Connection error");
        }
    });
}

/*
 * 检测对象是否是空对象(不包含任何可读属性)。
 * 方法既检测对象本身的属性，也检测从原型继承的属性(因此没有使hasOwnProperty)。
 */
function isEmpty(obj) {
    for (var name in obj) {
        return false;
    }
    return true;
};

//  模拟表单提交
function submitForm(action, data) {
    var name,
        form = document.createElement("form"),
        node = document.createElement("input");

    form.action = action;
    form.method = 'post';

    for (name in data) {
        node.name = name;
        node.value = data[name].toString();
        form.appendChild(node.cloneNode());
    }

    // 表单元素需要添加到主文档中.
    form.style.display = "none";
    document.body.appendChild(form);

    form.submit();

    // 表单提交后,就可以删除这个表单,不影响下次的数据发送.
    document.body.removeChild(form);
}

