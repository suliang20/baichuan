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
    <!-- IE8及以下支持JSON -->
    <!--[if lt IE 9]>
    <script src="https://g.alicdn.com/aliww/ww/json/json.js" charset="utf-8"></script>
    <![endif]-->
    <!-- WSDK-->
    <script src="https://g.alicdn.com/aliww/h5.openim.sdk/1.0.6/scripts/wsdk.js"></script>

    <script>
        //        var sdk = new WSDK();
        //        var obj = {
        //            text: 'wsdk'
        //        };
        //        sdk.Event.on('START_RECEIVE_ONE', function (data) {
        //            console.log(data);
        //            console.log(this.text); // wsdk
        //        }, obj);
    </script>

</head>
<body>
<?php
require_once OPEN_IM_PROJECT . "common-link.php";
?>
<script>
    var sdk = new WSDK()
    is_login = false;

    var uid = "<?=$fromUserInfo['userid']?>"
    appkey = "<?=APPKEY?>"
    password = "<?=$fromUserInfo['password']?>";

    wsdk_login(sdk, uid, appkey, password);

    //  登录
    function wsdk_login(sdk, uid, appkey, password) {
        sdk.Base.login({
            uid: uid,
            appkey: appkey,
            credential: password,
            timeout: 4000,
            success: function (data) {
                // {code: 1000, resultText: 'SUCCESS'}
                console.log('login success', data);
                is_login = true;
            },
            error: function (error) {
                // {code: 1002, resultText: 'TIMEOUT'}
                console.log('login fail', error);
            }
        });
    }

    //  获取未读消息的条数
    function wsdk_getUnreadMsgCount(sdk) {
        var recentTribe = [];

        if (!is_login) {
            wsdk_login(sdk, uid, appkey, password)
        }

        //  获取未读消息的条数
        sdk.Base.getUnreadMsgCount({
            count: 10,
            success: function (data) {
                console.log(data);
                var list = data.data;
                list.forEach(function (item) {
                    if (item.contact.substring(0, 8) === 'chntribe') {
                        recentTribe.push(item);
                    } else {
                        console.log(item.contact.substring(8) + '在' + new Date(parseInt(item.timestamp) * 1000) + ',');
                        console.log('给我发了' + item.msgCount + '条消息，最后一条消息是在' + new Date(parseInt(item.lastmsgTime) * 1000) + '发的');
                    }
                });

                recentTribe.length && console.log('最近给我发消息的群', recentTribe);
            },
            error: function (error) {
                console.log('获取未读消息的条数失败', error);
            }
        });
    }

    //  获取最近联系人及最后一条消息内容
    function wsdk_getRecentContact(sdk) {
        sdk.Base.getRecentContact({
            count: 10,
            success: function (data) {
                console.log(data);
                data = data.data;
                var list = data.cnts,
                    type = '';

                list.forEach(function (item) {
                    console.log(item.uid.substring(8) + '在' + new Date(parseInt(item.time) * 1000) + '联系了你');
//                    console.log('他说：' + item.type == 2 ? '[语音]' : item.type == 1 ? '[图片]' : (item.msg && item.msg[1]);
                });
            },
            error: function (error) {
                console.log('获取最近联系人及最后一条消息内容失败', error);
            }
        });
    }

    //  开始接收当前登录用户的所有消息（单聊，群聊）
    function wsdk_startListenAllMsg(sdk) {
        var Event = sdk.Event;

        Event.on('START_RECEIVE_ALL_MSG', function (data) {
            console.log('我所有消息都能收到', data);
        });

        Event.on('MSG_RECEIVED', function (data) {
            console.log('我能收到成功的消息', data);
        });

        Event.on('CHAT.MSG_RECEIVED', function (data) {
            console.log('我能收到成功的单聊消息', data);
        });

        Event.on('TRIBE.MSG_RECEIVED', function (data) {
            console.log('我能收到成功的群聊消息', data);
        });

        Event.on('KICK_OFF', function (data) {
            console.log('啊，我被踢了', data);
        });

        sdk.Base.startListenAllMsg();
    }
</script>
</body>
</html>
