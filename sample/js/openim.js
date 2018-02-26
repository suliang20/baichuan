
//  提交后台
$(document).ready(function () {

    $("#OpenImSumbit").click(function () {
        $.ajax({
            cache: true,
            type: "POST",
            url: window.location.href,//提交的URL
            data: $('#openImForm').serialize(), // 要提交的表单,必须使用name属性
            async: false,
            dataType: 'json',
            success: function (data) {
                if (data.error == 0) {
                    alert(data.msg);
                } else if (data.error == 1) {
//                        console.log(data.data.businessData);
                    sendData(data.data.businessUrl, data.data.businessData);
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

