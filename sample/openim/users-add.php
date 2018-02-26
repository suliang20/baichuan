<?php
/**
 * Created by PhpStorm.
 * User: su
 * Date: 2018/2/26
 * Time: 14:29
 */

require_once 'common.php';


try {
    $imUser = new \baichuan\business\ImUser();

    $userInfoArrs = [];
    for ($i = 1; $i <= 1; $i++) {
        $newUserId = $imUser->getNewUserId();
        $userId = OPEN_IM_USER_PREFIX . $newUserId;
        $userInfoArrs[$userId] = [
            'userid' => $userId,
            'password' => Md5($userId)
        ];
    }
    $return = $openIm->usersAdd($userInfoArrs);
    if (!$return) {
        var_dump($openIm->errors);
        var_dump($openIm->responseErrors);
    } else {
        if (!empty($return['uid_succ']['string'])) {
            foreach ($return['uid_succ']['string'] as $uid) {
                if (!$imUser->add($userInfoArrs[$uid], $_SERVER['REQUEST_TIME'])) {
                    throw new \Exception($imUser->errors[0]['errorMsg']);
                }
            }
        }
    }
} catch (\Exception $e) {
    echo $e->getMessage();
}
exit;
?>


