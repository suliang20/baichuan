<?php
/**
 * Created by PhpStorm.
 * User: su
 * Date: 2018/2/26
 * Time: 14:29
 */

require_once 'common.php';

$userInfos = $openIm->usersGet(",local_u_2");
if(!$userInfos){
    var_dump($openIm->errors);
    var_dump($openIm->responseErrors);
}else{
    var_dump($userInfos);
}
?>


