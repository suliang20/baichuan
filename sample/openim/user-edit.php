<?php
/**
 * Created by PhpStorm.
 * User: su
 * Date: 2018/2/26
 * Time: 14:29
 */

require_once 'common.php';


try {
    if (empty($_GET['userid'])) {
        throw new \Exception('用户ID不存在');
    }
    $userid = $_GET['userid'];
    $userinfo = (new \baichuan\business\ImUser())->getUserInfoByUserid($userid);


} catch (\Exception $e) {
    echo $e->getMessage();
}
?>

<html>
<head>
    <title>用户列表</title>
    <?php
    require_once "common-js-style.php";
    ?>
</head>

<body>
<?php
require_once "common-link.php";
?>
<p><a href="register.php">注册</a></p>
<div>
    <form id="openImForm" name="openImForm">
        <div>
            <div>
                <label for="userid">用户ID:</label>
                <input type="text" id="userid" name="userid" value="<?= $userinfo['userid'] ?>" readonly="readonly">
            </div>
            <div>
                <label for="password">用户密码:</label>
                <input type="text" id="password" name="password" value="<?= $userinfo['password'] ?>">
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
                <input type="text" id="mobile" name="nick" value="<?= $userinfo['mobile'] ?>">
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
            <button type="button" id="OpenImSumbit">提交编辑</button>
        </div>
    </form>
</div>
</body>
</html>


