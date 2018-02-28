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
    $return = $openIm->AppChatlogsGet($begTime, $endTime, $nextKey,100);
    if (!$return) {
        throw new \Exception($openIm->errors[0]['errorMsg']);
    }

    $data = [
        'messages' => !empty($return['result']['messages']['es_message']) ? $return['result']['messages']['es_message'] : [],
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



