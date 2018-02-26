<?php
/**
 * Created by PhpStorm.
 * User: su
 * Date: 2018/2/26
 * Time: 14:29
 */

require_once 'common.php';

$userinfoArr = [
    [
        'userid' => 'local_u_1',
    ],
    [
        'userid' => 'local_u_2',
    ],
];
$return = $openIm->usersUpdate($userinfoArr);
if (!$return) {
    var_dump($openIm->errors);
    var_dump($openIm->responseErrors);
} else {
    var_dump($return);
}
?>


