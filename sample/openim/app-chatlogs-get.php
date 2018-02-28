<?php
/**
 * Created by PhpStorm.
 * User: su
 * Date: 2018/2/26
 * Time: 14:29
 */

require_once 'common.php';

?>

<html>
<head>
    <title>用户聊天记录</title>
    <?php
    require_once OPEN_IM_PROJECT . "common-js-style.php";
    ?>
    <script type="text/javascript">
        var currentDate = new Date();
        var lastMonthDate = new Date();
        lastMonthDate.setDate(lastMonthDate.getDate() - 30);
        laydate.render({
            elem: "#begTime",
            type: 'datetime',
            //            format: "yyyyMMddHHII",
            max: 0,
            value: lastMonthDate,
            btns: ["confirm"],
        });
        laydate.render({
            elem: "#endTime",
            type: 'datetime',
//            format: "yyyyMMdd",
            min: -30,
            max: 0,
            value: currentDate,
            btns: ["confirm"],
        });
    </script>
</head>

<body>
<?php
require_once OPEN_IM_PROJECT . "common-link.php";
?>
<div>
    <form action="<?= BASE_URL ?>openim/app-chatlogs-get-ajax.php" name="BaiChuanForm" class="BaiChuanForm">
        <label for="uid">用户ID:</label>
        <input type="hidden" id="next_key" name="next_key" value="">

        <label for="begTime">查询开始时间:</label>
        <input type="text" id="begTime" name="begTime">

        <label for="endTime">查询结束时间:</label>
        <input type="text" id="endTime" name="endTime">

        <button type="button" class="BaiChuanSumbit" baichuan-ajax-back-handler="viewData"
                baichuan-ajax-front-handler="handler"
                baichuan-ajax-redirect="">获取聊天记录
        </button>
        <button type="button" class="BaiChuanSumbit" id="moreBtn" baichuan-ajax-back-handler="viewMoreData"
                baichuan-ajax-redirect="" style="display:none;">更多
        </button>
    </form>
</div>
<div>
    <table border="2" id="relation">
        <tr>
            <th>uuid</th>
            <th>类型</th>
            <th>时间</th>
            <th>发送方</th>
            <th>接收方</th>
            <th>内容</th>

            <th>操作</th>
        </tr>
    </table>
</div>
<script type="text/javascript">
    //  发送前处理
    function handler(t) {
        $('#next_key').val('');
    }

    //  显示数据
    function viewData(data) {
        if (!isEmpty(data.data)) {
            var messages = data.data.messages;
            var next_key = data.data.next_key;
            if (next_key) {
                $("#moreBtn").show();
            } else {
                $("#moreBtn").hide();
            }
            $('#next_key').val(next_key);
            $("#relation tr:not(:first)").html("");
            addTr(messages)
        }else{
            alert(data.msg)
        }

    }

    //  加载更多数据
    function viewMoreData(data) {
        if (!isEmpty(data.data)) {
            var messages = data.data.messages;
            var next_key = data.data.next_key;
            if (next_key) {
                $("#moreBtn").show();
            } else {
                $("#moreBtn").hide();
            }
            $('#next_key').val(next_key);
            addTr(messages)
        }else{
            alert(data.msg)
        }
    }

    //  添加行
    function addTr(messages) {
        for (var key in messages) {
            var tr =
                "<tr>" +
                "<td>" + messages[key]['uuid'] + "</td>" +
                "<td>" + messages[key]['type'] + "</td>" +
                "<td>" + timetrans(messages[key]['time']) + "</td>" +
                "<td>" + messages[key]['from_id']['uid'] + "</td>" +
                "<td>" + messages[key]['to_id']['uid'] + "</td>" +
                "<td>" +
                //                    "<p>TYPE:" + messages[key]['content_list']['roaming_message_item'][0]['type'] + "</p>" +
                //                    "<p>VALUE:" + messages[key]['content_list']['roaming_message_item'][0]['value'] + "</p>" +
                messages[key]['content']['roaming_message_item'][0]['value'] +
                "</tr>";
            $("#relation").append(tr);
        }
    }

</script>
</body>
</html>


