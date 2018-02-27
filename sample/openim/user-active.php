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
//    var_dump($userinfo);exit;
} else {
    $result = [
        'error' => 0,
        'msg' => '提交错误',
    ];
    try {
        if (empty($_POST['userid'])) {
            throw new \Exception('数据错误');
        }
        //  检查用户是否存在
        if (!$imUser->hasUserid($_POST['userid'])) {
            throw new \Exception('用户不存在');
        }
        //  检查用户是否删除
        if (!$imUser->hasUserDelete($_POST['userid'])) {
            throw new \Exception('用户未删除');
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
        if (!$imUser->active($_POST, $_SERVER['REQUEST_TIME'])) {
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
    <title>用户激活</title>
    <?php
    require_once OPEN_IM_PROJECT . "common-js-style.php";
    ?>
</head>

<body>
<?php
require_once OPEN_IM_PROJECT . "common-link.php";
?>
<p><a href="user-add.php">添加</a></p>
<div>
    <form action="" id="BaiChuanForm" name="BaiChuanForm">
        <div>
            <div>
                <label for="userid">用户ID:</label>
                <input type="text" id="userid" name="userid" value="<?= $userinfo['userid'] ?>" readonly="readonly">
            </div>
            <div>
                <label for="nick">昵称:</label>
                <input type="text" id="nick" name="nick" value="<?= $userinfo['nick'] ?>">
            </div>
            <div>
                <label for="icon_url">头像url:</label>
                <input type="text" id="icon_url" name="icon_url" value="<?= $userinfo['icon_url'] ?>">
            </div>
            <div>
                <label for="email">email地址:</label>
                <input type="text" id="email" name="email" value="<?= $userinfo['email'] ?>">
            </div>
            <div>
                <label for="mobile">手机号码:</label>
                <input type="text" id="mobile" name="mobile" value="<?= $userinfo['mobile'] ?>">
            </div>
            <div>
                <label for="taobaoid">淘宝账号:</label>
                <input type="text" id="taobaoid" name="taobaoid" value="<?= $userinfo['taobaoid'] ?>">
            </div>
            <div>
                <label for="remark">remark:</label>
                <input type="text" id="remark" name="remark" value="<?= $userinfo['remark'] ?>">
            </div>
            <div>
                <label for="extra">扩展字段:</label>
                <input type="text" id="extra" name="extra" value="<?= $userinfo['extra'] ?>">
            </div>
            <div>
                <label for="career">职位:</label>
                <input type="text" id="career" name="career" value="<?= $userinfo['career'] ?>">
            </div>
            <div>
                <label for="vip">vip:</label>
                <input type="text" id="vip" name="vip" value="<?= $userinfo['vip'] ?>">
            </div>
            <div>
                <label for="address">地址:</label>
                <input type="text" id="address" name="address" value="<?= $userinfo['address'] ?>">
            </div>
            <div>
                <label for="name">名字:</label>
                <input type="text" id="name" name="name" value="<?= $userinfo['name'] ?>">
            </div>
            <div>
                <label for="age">年龄:</label>
                <input type="text" id="age" name="age" value="<?= $userinfo['age'] ?>">
            </div>
            <div>
                <label for="gender">性别:</label>
                <input type="text" id="gender" name="gender" value="<?= $userinfo['gender'] ?>">
            </div>
            <div>
                <label for="wechat">微信:</label>
                <input type="text" id="wechat" name="wechat" value="<?= $userinfo['wechat'] ?>">
            </div>
            <div>
                <label for="qq">qq:</label>
                <input type="text" id="qq" name="qq" value="<?= $userinfo['qq'] ?>">
            </div>
            <div>
                <label for="weibo">微博:</label>
                <input type="text" id="weibo" name="weibo" value="<?= $userinfo['weibo'] ?>">
            </div>
            <div>
                <label for="status">状态:</label>
                <input type="text" id="status" name="status" value="<?= $userinfo['status'] ?>" readonly="readonly">
            </div>
            <div>
                <label for="createTime">创建时间:</label>
                <input type="text" id="createTime" name="createTime" value="<?= $userinfo['createTime'] ?>"
                       readonly="readonly">
            </div>
            <div>
                <label for="updateTime">更新时间:</label>
                <input type="text" id="updateTime" name="updateTime" value="<?= $userinfo['updateTime'] ?>"
                       readonly="readonly">
            </div>
        </div>
        <button type="button" id="BaiChuanSumbit" baichuan-ajax-handler="" baichuan-ajax-redirect="">提交激活</button>
    </form>
</div>
</body>
</html>


