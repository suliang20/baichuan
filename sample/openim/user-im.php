<?php
/**
 * Created by PhpStorm.
 * User: su
 * Date: 2018/2/26
 * Time: 14:29
 */

require_once 'common.php';

$imUser = new \baichuan\business\ImUser();
try {
    if (empty($_GET['userid'])) {
        throw new \Exception('用户ID不存在');
    }
    $userid = $_GET['userid'];
    $userinfo = $imUser->getUserInfoByUserid($userid);
} catch (\Exception $e) {
    echo $e->getMessage();
}
?>

<html>
<head>
    <title>用户聊天</title>
    <?php
    require_once OPEN_IM_PROJECT . "common-js-style.php";
    ?>
</head>

<body>
<?php
require_once OPEN_IM_PROJECT . "common-link.php";
?>
<div>
    <label for="uid">用户ID:</label>
    <input type="text" id="uid" name="uid" value="<?= $userinfo['userid'] ?>" readonly="readonly">
    <label for="touserid">聊天对象</label>
    <select name="touid" id="touid">
        <?php foreach ($imUser->getAll() as $key => $item): ?>
            <?php if ($key == $userid || $item['status'] != 1) continue; ?>
            <option value="<?= $key ?>"><?= $key ?></option>
        <?php endforeach; ?>
    </select>
    <a href="javascript:;" onclick="submitIm()">开始聊天</a>
</div>
<script type="text/javascript">
    function submitIm() {
        var uid = $("#uid").val();
        var touid = $("#touid").val();
        var url = "<?=BASE_URL?>openim/h5/im.php?uid=" + uid + "&touid=" + touid;
        window.location = url;
    }
</script>
</body>
</html>


