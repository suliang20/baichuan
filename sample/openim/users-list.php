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
    <title>用户列表</title>
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
            <th>更新时间</th>

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
                    <td><?= !empty($item['createTime']) ? date('Y-m-d H:i:s', $item['createTime']) : '--' ?></td>
                    <td><?= !empty($item['updateTime']) ? date('Y-m-d H:i:s', $item['updateTime']) : '--' ?></td>
                    <td>
                        <?php if ($item['status'] == 1): ?>
                            <a href="user-update.php?userid=<?= $item['userid'] ?>">更新</a>
                            <a href="user-delete.php?userid=<?= $item['userid'] ?>">删除</a>
                            <a href="user-syn.php?userid=<?= $item['userid'] ?>">用户同步</a>
                            <a href="user-im.php?userid=<?= $item['userid'] ?>">聊天</a>
                            <a href="custmsg-push.php?userid=<?= $item['userid'] ?>">发送自定义消息</a>
                            <a href="immsg-push.php?userid=<?= $item['userid'] ?>">发送标准消息</a>
                            <a href="relations-get.php?userid=<?= $item['userid'] ?>">获取聊天对象</a>
                        <?php elseif ($item['status'] == 2): ?>
                            <a href="user-active.php?userid=<?= $item['userid'] ?>">重新添加</a>
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endif; ?>
        <?php endforeach; ?>
    </table>
</div>
</body>
</html>


