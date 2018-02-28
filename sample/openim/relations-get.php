<?php
/**
 * Created by PhpStorm.
 * User: su
 * Date: 2018/2/26
 * Time: 14:29
 */

require_once 'common.php';

$imUser = new \baichuan\business\ImUser();
if (!is_post()) {
    try {
        if (empty($_GET['userid'])) {
            throw new \Exception('参数错误');
        }
        $userid = $_GET['userid'];
        $userinfo = $imUser->getUserInfoByUserid($userid);
        if (!$userinfo) {
            throw new \Exception('用户不存在');
        }
    } catch (\Exception $e) {
        echo $e->getMessage();
        exit;
    }
} else {
    $result = [
        'error' => 0,
        'msg' => '提交错误',
    ];
    try {
        //  发送用户
        if (empty($_POST['uid'])) {
            throw new \Exception('用户userid不能为空');
        }
        //  检查用户是否存在
        if (!$imUser->hasUserid($_POST['uid'])) {
            throw new \Exception('用户不存在');
        }
        //  检查用户是否删除
        if ($imUser->hasUserDelete($_POST['uid'])) {
            throw new \Exception('用户已删除');
        }
        //  查询开始日期
        if (empty($_POST['begDate'])) {
            throw new \Exception('查询开始日期不能为空');
        }
        $begDate = $_POST['begDate'];
        //  查询结束日期
        if (empty($_POST['endDate'])) {
            throw new \Exception('查询结束日期不能为空');
        }
        $endDate = $_POST['endDate'];
        $userArr = [
            'uid' => $_POST['uid'],
        ];
        $return = $openIm->RelationsGet($begDate, $endDate, $userArr);
        if (!$return) {
            throw new \Exception($openIm->errors[0]['errorMsg']);
        }

        $result['error'] = 1;
        $result['msg'] = '查询成功';
        $result['data'] = !empty($return['users']['open_im_user']) ? $return['users']['open_im_user'] : [];
    } catch (\Exception $e) {
        $result['msg'] = $e->getMessage();
    }
    echo json_encode($result, JSON_UNESCAPED_UNICODE);
    exit;
}
?>

<html>
<head>
    <title>用户聊天关系</title>
    <?php
    require_once OPEN_IM_PROJECT . "common-js-style.php";
    ?>
    <script type="text/javascript">
        var currentDate = new Date();
        var lastMonthDate = new Date();
        lastMonthDate.setDate(lastMonthDate.getDate() - 30);
        laydate.render({
            elem: "#begDate",
            format: "yyyyMMdd",
            min: -30,
            max: 0,
            value: lastMonthDate,
            btns: ["confirm"],
        });
        laydate.render({
            elem: "#endDate",
            format: "yyyyMMdd",
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
    <form action="" id="BaiChuanForm" name="BaiChuanForm">
        <label for="uid">用户ID:</label>
        <input type="hidden" id="uid" name="uid" value="<?= $userinfo['userid'] ?>" readonly>
        <label for="begDate">查询开始日期:</label>
        <input type="text" id="begDate" name="begDate">
        <label for="endDate">查询结束日期:</label>
        <input type="text" id="endDate" name="endDate">
        <button type="button" id="BaiChuanSumbit" baichuan-ajax-handler="viewData"
                baichuan-ajax-redirect="">获取聊天对象
        </button>
    </form>
</div>
<div>
    <table border="2" id="relation">
        <tr>
            <th>uid</th>
            <th>taobao_account</th>
            <th>app_key</th>

            <th>操作</th>
        </tr>
    </table>
</div>
<script type="text/javascript">
    //  获取聊天对象数据
    function viewData(data) {
        $("#relation tr:not(:first)").html("");
        if (!isEmpty(data.data)) {
            var relation = data.data;
            for (var key in relation) {
                var tr =
                    "<tr>" +
                    "<td class='uid'>" + relation[key]['uid'] + "</td>" +
                    "<td class='app_key'>" + relation[key]['app_key'] + "</td>" +
                    "<td class='taobao_account'>" + relation[key]['taobao_account'] + "</td>" +
                    "<td><a href='javascript:;' onclick='viewChatlogs(this)'>查看聊天记录</a> </td>" +
                    "</tr>";
                $("#relation").append(tr);
//                console.log(relation[key]);
            }
        }
    }

    //  获取聊天数据
    function viewChatlogs(t) {
        var parentTr = $(t).parent().parent();
        var action = '<?=BASE_URL?>openim/chatlogs-get.php?userid=<?=$userid?>';
        var userinfo = {
            'to_uid': parentTr.children('.uid').html(),
            'to_app_key': parentTr.children('.app_key').html(),
            'to_taobao_account': parentTr.children('.taobao_account').html(),
        };

        //  模拟表单提交
        submitForm(action, userinfo);
    }

</script>
</body>
</html>


