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
        $userid = OPEN_IM_USER_PREFIX . $imUser->getNewUserId();
    } catch (\Exception $e) {
        echo $e->getMessage();
    }
} else {
    $result = [
        'error' => 0,
        'msg' => '提交错误',
    ];
    try {
        if (empty($_POST['userid'])) {
            throw new \Exception('数据错误');
        }
        $_POST['password'] = md5($_POST['userid']);
        $return = $openIm->usersAdd([$_POST]);
        if (!$return) {
            throw new \Exception($openIm->errors[0]['errorMsg']);
        }
        if (empty($return['uid_succ']['string'])) {
            foreach ($return['uid_fail']['string'] as $uid_key => $uid) {
                throw new \Exception($return['fail_msg']['string'][$uid_key]);
            }
        }
        if (!$imUser->add($_POST, $_SERVER['REQUEST_TIME'])) {
            throw new \Exception($imUser->errors[0]['errorMsg']);
        }
        $result['error'] = 1;
        $result['msg'] = '更新成功';
    } catch (\Exception $e) {
        $result['msg'] = $e->getMessage();
    }
    echo json_encode($result, JSON_UNESCAPED_UNICODE);
    exit;
}
?>

<html>
<head>
    <title>用户添加</title>
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
        <div>
            <div>
                <input type="hidden" id="userid" name="userid" value="<?= $userid ?>"
                       readonly="readonly">
            </div>

            <div>
                <label for="nick">昵称:</label>
                <input type="text" id="nick" name="nick">
            </div>
            <div>
                <label for="icon_url">头像url:</label>
                <input type="text" id="icon_url" name="icon_url">
            </div>
            <div>
                <label for="email">email地址:</label>
                <input type="text" id="email" name="email">
            </div>
            <div>
                <label for="mobile">手机号码:</label>
                <input type="text" id="mobile" name="mobile">
            </div>
            <div>
                <label for="taobaoid">淘宝账号:</label>
                <input type="text" id="taobaoid" name="taobaoid">
            </div>
            <div>
                <label for="remark">remark:</label>
                <input type="text" id="remark" name="remark">
            </div>
            <div>
                <label for="extra">扩展字段:</label>
                <input type="text" id="extra" name="extra">
            </div>
            <div>
                <label for="career">职位:</label>
                <input type="text" id="career" name="career">
            </div>
            <div>
                <label for="vip">vip:</label>
                <input type="text" id="vip" name="vip">
            </div>
            <div>
                <label for="address">地址:</label>
                <input type="text" id="address" name="address">
            </div>
            <div>
                <label for="name">名字:</label>
                <input type="text" id="name" name="name">
            </div>
            <div>
                <label for="age">年龄:</label>
                <input type="text" id="age" name="age">
            </div>
            <div>
                <label for="gender">性别:</label>
                <input type="text" id="gender" name="gender">
            </div>
            <div>
                <label for="wechat">微信:</label>
                <input type="text" id="wechat" name="wechat">
            </div>
            <div>
                <label for="qq">qq:</label>
                <input type="text" id="qq" name="qq">
            </div>
            <div>
                <label for="weibo">微博:</label>
                <input type="text" id="weibo" name="weibo">
            </div>
        </div>
        <button type="button" id="BaiChuanSumbit" baichuan-ajax-handler=""
                baichuan-ajax-redirect="user-update.php?userid=<?= $userid ?>">提交编辑
        </button>
    </form>
</div>
</body>
</html>


