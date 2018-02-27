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
            throw new \Exception('用户ID不存在');
        }
        $userid = $_GET['userid'];
        $userinfo = $imUser->getUserInfoByUserid($userid);
    } catch (\Exception $e) {
        echo $e->getMessage();
    }
} else {
    $result = [
        'error' => 0,
        'msg' => '提交错误',
    ];
    try {
        //  发送用户
        if (empty($_POST['uid'])) {
            throw new \Exception('发送用户不能为空');
        }
        //  检查用户是否存在
        if (!$imUser->hasUserid($_POST['uid'])) {
            throw new \Exception('用户不存在');
        }
        //  检查用户是否删除
        if ($imUser->hasUserDelete($_POST['uid'])) {
            throw new \Exception('用户已删除');
        }
        //  接收用户
        if (empty($_POST['touid'])) {
            throw new \Exception('接收用户不能为空');
        }
        //  检查用户是否存在
        if (!$imUser->hasUserid($_POST['touid'])) {
            throw new \Exception('用户不存在');
        }
        //  检查用户是否删除
        if ($imUser->hasUserDelete($_POST['touid'])) {
            throw new \Exception('用户已删除');
        }
        //  发送数据
        if (empty($_POST['data'])) {
            throw new \Exception('发送数据不能为空');
        }
        $custmsgArr = [
            'from_user' => $_POST['uid'],
            'to_users' => $_POST['touid'],
            'summary' => !empty($_POST['summary']) ? $_POST['summary'] : 'summary',
            'data' => $_POST['data'],
        ];
        $return = $openIm->custmsgPush($custmsgArr);
        if (!$return) {
            throw new \Exception($openIm->errors[0]['errorMsg']);
        }
        $custmsgArr['msgid'] = $return['msgid'];
        $custmsgArr['request_id'] = $return['request_id'];

        $custMsgPush = new \baichuan\business\CustMsgPush();
        if (!$custMsgPush->add($custmsgArr, $_SERVER['REQUEST_TIME'])) {
            throw new \Exception($custMsgPush->errors[0]['errorMsg']);
        }

        $result['error'] = 1;
        $result['msg'] = '发送成功';
        $result['return'] = $return;
    } catch (\Exception $e) {
        $result['msg'] = $e->getMessage();
    }
    echo json_encode($result, JSON_UNESCAPED_UNICODE);
    exit;
}
?>

<html>
<head>
    <title>用户发送自定义消息</title>
    <?php
    require_once OPEN_IM_PROJECT . "common-js-style.php";
    ?>
</head>

<body>
<?php
require_once OPEN_IM_PROJECT . "common-link.php";
?>
<div>
    <form action="" id="BaiChuanForm" name="BaiChuanForm">
        <label for="uid">用户ID:</label>
        <input type="text" id="uid" name="uid" value="<?= $userinfo['userid'] ?>" readonly>
        <label for="data">内容:</label>
        <input type="text" id="data" name="data">
        <label for="touserid">聊天对象</label>
        <select name="touid" id="touid">
            <?php foreach ($imUser->getAll() as $key => $item): ?>
                <?php if ($key == $userid || $item['status'] != 1) continue; ?>
                <option value="<?= $key ?>"><?= $key ?></option>
            <?php endforeach; ?>
        </select>
        <button type="button" id="BaiChuanSumbit" baichuan-ajax-handler=""
                baichuan-ajax-redirect="">发送自定义信息
        </button>
    </form>
</div>
</body>
</html>


