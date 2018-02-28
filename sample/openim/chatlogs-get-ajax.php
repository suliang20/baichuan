<?php
/**
 * Created by PhpStorm.
 * User: su
 * Date: 2018/2/26
 * Time: 14:29
 */

require_once 'common.php';

$imUser = new \baichuan\business\ImUser();
$result = [
    'error' => 0,
    'msg' => '提交错误',
];
try {
    //  查询用户
    if (empty($_POST['userid'])) {
        throw new \Exception('用户userid不能为空');
    }
    //  检查用户是否存在
    if (!$imUser->hasUserid($_POST['userid'])) {
        throw new \Exception('用户不存在');
    }
    //  检查用户是否删除
    if ($imUser->hasUserDelete($_POST['userid'])) {
        throw new \Exception('用户已删除');
    }
    $userInfo1 = [
        'uid' => $_POST['userid'],
        'app_key' => '',
        'taobao_account' => 'false',
    ];


    //  查询用户
    if (empty($_POST['to_uid'])) {
        throw new \Exception('用户to_uid不能为空');
    }
    //  检查用户是否存在
    if (!$imUser->hasUserid($_POST['to_uid'])) {
        throw new \Exception('用户不存在');
    }
    //  检查用户是否删除
    if ($imUser->hasUserDelete($_POST['to_uid'])) {
        throw new \Exception('用户已删除');
    }
    $userInfo2 = [
        'uid' => $_POST['to_uid'],
        'app_key' => $_POST['to_app_key'],
        'taobao_account' => $_POST['to_taobao_account'],
    ];

    //  迭代key
    $nextKey = !empty($_POST['next_key']) ? $_POST['next_key'] : null;

    //  查询开始日期
    if (empty($_POST['begTime'])) {
        throw new \Exception('查询开始时间不能为空');
    }
    $begTime = strtotime($_POST['begTime']);
    //  查询结束日期
    if (empty($_POST['endTime'])) {
        throw new \Exception('查询结束时间不能为空');
    }
    $endTime = strtotime($_POST['endTime']);
    //  查询聊天记录
    $return = $openIm->ChatlogsGet($begTime, $endTime, $userInfo1, $userInfo2, $nextKey,20);
    if (!$return) {
        throw new \Exception($openIm->errors[0]['errorMsg']);
    }

    $data = [
        'messages' => !empty($return['result']['messages']['roaming_message']) ? $return['result']['messages']['roaming_message'] : [],
        'next_key' => !empty($return['result']['next_key']) ? $return['result']['next_key'] : '',
    ];

//    $data = $return;

    $result['error'] = 1;
    $result['msg'] = '查询成功';
    $result['data'] = $data;
} catch (\Exception $e) {
    $result['msg'] = $e->getMessage();
}
echo json_encode($result, JSON_UNESCAPED_UNICODE);
exit;

?>



