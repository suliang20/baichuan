<?php
/**
 * Created by PhpStorm.
 * User: su
 * Date: 2018/2/27
 * Time: 13:54
 */
require_once '../common.php';

$imUser = new \baichuan\business\ImUser();
try {
    if (empty($_GET['uid'])) {
        throw new \Exception('发送用户ID不能为空');
    }
    //  发送用户信息
    $uid = $_GET['uid'];
    $fromUserInfo = $imUser->getUserInfoByUserid($uid);
    if (!$fromUserInfo) {
        throw new \Exception('发送用户不存在');
    }
    if ($imUser->hasUserDelete($uid)) {
        throw new \Exception('发送用户已删除');
    }
    //  接收者用户信息
    if (empty($_GET['touid'])) {
        throw new \Exception('接收用户ID不能为空');
    }
    $touid = $_GET['touid'];
    $toUserInfo = $imUser->getUserInfoByUserid($touid);
    if (!$toUserInfo) {
        throw new \Exception('接收用户不存在');
    }
    if ($imUser->hasUserDelete($touid)) {
        throw new \Exception('接收用户已删除');
    }
} catch (\Exception $e) {

}
?>

<html>
<head>
    <title>聊天</title>
    <?php
    require_once OPEN_IM_PROJECT . "common-js-style.php";
    ?>
    <!--[if lt IE 9]>
    <script src="https://g.alicdn.com/aliww/ww/json/json.js" charset="utf-8"></script>
    <![endif]-->
    <!-- 自动适配移动端与pc端 -->
    <script src="https://g.alicdn.com/aliww/??h5.openim.sdk/1.0.6/scripts/wsdk.js,h5.openim.kit/0.3.3/scripts/kit.js"
            charset="utf-8"></script>
    <script>
        window.onload = function () {
            var options = {
                uid: '<?=$uid?>',
                appkey: '<?=APPKEY?>',
                credential: '<?=$fromUserInfo['password']?>',
                touid: '<?=$touid?>'
            };
//            console.log(options);return false;
            WKIT.init(options);
        }
    </script>
</head>
<body>
<?php
require_once OPEN_IM_PROJECT . "common-link.php";
?>
</body>
</html>
