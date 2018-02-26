<?php
/**
 * Created by PhpStorm.
 * User: su
 * Date: 2018/2/26
 * Time: 14:29
 */

require_once 'common.php';


//try {
//    $imUser = new \baichuan\business\ImUser();
//
//    $userInfoArrs = [];
//    for ($i = 1; $i <= 1; $i++) {
//        $newUserId = $imUser->getNewUserId();
//        $userId = OPEN_IM_USER_PREFIX . $newUserId;
//        $userInfoArrs[$userId] = [
//            'userid' => $userId,
//            'password' => Md5($userId)
//        ];
//    }
//    $return = $openIm->usersAdd($userInfoArrs);
//    if (!$return) {
//        var_dump($openIm->errors);
//        var_dump($openIm->responseErrors);
//    } else {
//        if (!empty($return['uid_succ']['string'])) {
//            foreach ($return['uid_succ']['string'] as $uid) {
//                if (!$imUser->add($userInfoArrs[$uid], $_SERVER['REQUEST_TIME'])) {
//                    throw new \Exception($imUser->errors[0]['errorMsg']);
//                }
//            }
//        }
//    }
//} catch (\Exception $e) {
//    echo $e->getMessage();
//}
//exit;
//var_dump((new \baichuan\business\ImUser())->getAll());exit;
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
    <table border="2">
        <tr>
            <th>用户ID</th>
            <th>用户密码</th>

            <th>昵称</th>
            <th>头像url</th>
            <th>email地址</th>
            <th>手机号码</th>
            <th>淘宝账号</th>
            <th>remark</th>
            <th>扩展字段</th>
            <th>职位</th>
            <th>vip</th>
            <th>地址</th>
            <th>名字</th>
            <th>年龄</th>
            <th>性别</th>
            <th>微信</th>
            <th>qq</th>
            <th>微博</th>

            <th>状态</th>
            <th>创建时间</th>

            <th>操作</th>
        </tr>
        <?php foreach ((new \baichuan\business\ImUser())->getAll() as $item): ?>
            <?php if (isset($item['userid'])): ?>
                <tr>
                    <td><?= $item['userid'] ?></td>
                    <td><?= $item['password'] ?></td>

                    <td><?= $item['nick'] ?></td>
                    <td><?= $item['icon_url'] ?></td>
                    <td><?= $item['email'] ?></td>
                    <td><?= $item['mobile'] ?></td>
                    <td><?= $item['taobaoid'] ?></td>
                    <td><?= $item['remark'] ?></td>
                    <td><?= $item['extra'] ?></td>
                    <td><?= $item['career'] ?></td>
                    <td><?= $item['vip'] ?></td>
                    <td><?= $item['address'] ?></td>
                    <td><?= $item['name'] ?></td>
                    <td><?= $item['age'] ?></td>
                    <td><?= $item['gender'] ?></td>
                    <td><?= $item['wechat'] ?></td>
                    <td><?= $item['qq'] ?></td>
                    <td><?= $item['weibo'] ?></td>

                    <td><?= $item['status'] ?></td>
                    <td><?= $item['createTime'] ?></td>


                    <td>
                        <a href="user-edit.php?userid=<?= $item['userid'] ?>">编辑</a>
                    </td>
                </tr>
            <?php endif; ?>
        <?php endforeach; ?>
    </table>
</div>
</body>
</html>


