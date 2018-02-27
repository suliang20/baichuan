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
        $.ajax({
            cache: true,
            type: "POST",
            url: action,
            data: data,
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
    });
})

