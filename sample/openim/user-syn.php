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
        //  本地用户数据
        $userinfo = $imUser->getUserInfoByUserid($userid);
        if (!$userinfo) {
            throw new \Exception('用户不存在');
        }
        //  云旺用户数据
        $userinfoSyns = $openIm->usersGet($userid);
        if (!$userinfoSyns) {
            throw new \Exception($openIm->errors[0]['errorMsg']);
        }
        $userinfoSyn = $userinfoSyns[0];
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
        if ($imUser->hasUserDelete($_POST['userid'])) {
            throw new \Exception('用户已删除');
        }
        if (!$imUser->update($_POST, $_SERVER['REQUEST_TIME'])) {
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
    <title>用户同步</title>
    <?php
    require_once "common-js-style.php";
    ?>
</head>

<body>
<?php
require_once "common-link.php";
?>
<div>
    <form action="" id="BaiChuanForm" name="BaiChuanForm">
        <div>
            <div>
                <label for="userid">用户ID:</label>
                <input type="text" id="useridOld" name="useridOld" value="<?= $userinfo['userid'] ?>"
                       readonly="readonly">
                <input type="text" id="userid" name="userid" value="<?= $userinfoSyn['userid'] ?>" readonly="readonly">
            </div>
            <div>
                <label for="password">用户密码:</label>
                <input type="text" id="passwordOld" name="passwordOld" value="<?= $userinfo['password'] ?>"
                       readonly="readonly">
                <input type="text" id="password" name="password" value="<?= $userinfoSyn['password'] ?>"
                       readonly="readonly">
            </div>
            <div>
                <label for="nick">昵称:</label>
                <input type="text" id="nickOld" name="nickOld" value="<?= $userinfo['nick'] ?>" readonly>
                <input type="text" id="nick" name="nick" value="<?= $userinfoSyn['nick'] ?>" readonly>
            </div>
            <div>
                <label for="icon_url">头像url:</label>
                <input type="text" id="icon_urlOld" name="icon_urlOld" value="<?= $userinfo['icon_url'] ?>" readonly>
                <input type="text" id="icon_url" name="icon_url" value="<?= $userinfoSyn['icon_url'] ?>" readonly>
            </div>
            <div>
                <label for="email">email地址:</label>
                <input type="text" id="emailOld" name="emailOld" value="<?= $userinfo['email'] ?>" readonly>
                <input type="text" id="email" name="email" value="<?= $userinfoSyn['email'] ?>" readonly>
            </div>
            <div>
                <label for="mobile">手机号码:</label>
                <input type="text" id="mobileOld" name="mobileOld" value="<?= $userinfo['mobile'] ?>" readonly>
                <input type="text" id="mobile" name="mobile" value="<?= $userinfoSyn['mobile'] ?>" readonly>
            </div>
            <div>
                <label for="taobaoid">淘宝账号:</label>
                <input type="text" id="taobaoidOld" name="taobaoidOld" value="<?= $userinfo['taobaoid'] ?>" readonly>
                <input type="text" id="taobaoid" name="taobaoid" value="<?= $userinfoSyn['taobaoid'] ?>" readonly>
            </div>
            <div>
                <label for="remark">remark:</label>
                <input type="text" id="remarkOld" name="remarkOld" value="<?= $userinfo['remark'] ?>" readonly>
                <input type="text" id="remark" name="remark" value="<?= $userinfoSyn['remark'] ?>" readonly>
            </div>
            <div>
                <label for="extra">扩展字段:</label>
                <input type="text" id="extraOld" name="extraOld" value="<?= $userinfo['extra'] ?>" readonly>
                <input type="text" id="extra" name="extra" value="<?= $userinfoSyn['extra'] ?>"
                       readonly>
            </div>
            <div>
                <label for="career">职位:</label>
                <input type="text" id="careerOld" name="careerOld" value="<?= $userinfo['career'] ?>" readonly>
                <input type="text" id="career" name="career" value="<?= $userinfoSyn['career'] ?>" readonly>
            </div>
            <div>
                <label for="vip">vip:</label>
                <input type="text" id="vipOld" name="vipOld" value="<?= $userinfo['vip'] ?>" readonly>
                <input type="text" id="vip" name="vip" value="<?= $userinfoSyn['vip'] ?>" readonly>
            </div>
            <div>
                <label for="address">地址:</label>
                <input type="text" id="addressOld" name="addressOld" value="<?= $userinfo['address'] ?>" readonly>
                <input type="text" id="address" name="address" value="<?= $userinfoSyn['address'] ?>" readonly>
            </div>
            <div>
                <label for="name">名字:</label>
                <input type="text" id="nameOld" name="nameOld" value="<?= $userinfo['name'] ?>" readonly>
                <input type="text" id="name" name="name" value="<?= $userinfoSyn['name'] ?>" readonly>
            </div>
            <div>
                <label for="age">年龄:</label>
                <input type="text" id="ageOld" name="ageOld" value="<?= $userinfo['age'] ?>" readonly>
                <input type="text" id="age" name="age" value="<?= $userinfoSyn['age'] ?>" readonly>
            </div>
            <div>
                <label for="gender">性别:</label>
                <input type="text" id="genderOld" name="genderOld" value="<?= $userinfo['gender'] ?>" readonly>
                <input type="text" id="gender" name="gender" value="<?= $userinfoSyn['gender'] ?>" readonly>
            </div>
            <div>
                <label for="wechat">微信:</label>
                <input type="text" id="wechatOld" name="wechatOld" value="<?= $userinfo['wechat'] ?>" readonly>
                <input type="text" id="wechat" name="wechat" value="<?= $userinfo['wechat'] ?>" readonly>
            </div>
            <div>
                <label for="qq">qq:</label>
                <input type="text" id="qqOld" name="qqOld" value="<?= $userinfo['qq'] ?>" readonly>
                <input type="text" id="qq" name="qq" value="<?= $userinfo['qq'] ?>" readonly>
            </div>
            <div>
                <label for="weibo">微博:</label>
                <input type="text" id="weiboOld" name="weiboOld" value="<?= $userinfo['weibo'] ?>" readonly>
                <input type="text" id="weibo" name="weibo" value="<?= $userinfo['weibo'] ?>" readonly>
            </div>
        </div>
        <button type="button" id="BaiChuanSumbit" baichuan-ajax-handler="" baichuan-ajax-redirect="">提交编辑</button>
    </form>
</div>
</body>
</html>


