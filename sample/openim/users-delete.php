<?php
/**
 * Created by PhpStorm.
 * User: su
 * Date: 2018/2/26
 * Time: 14:29
 */

require_once 'common.php';

$userInfos = $openIm->usersDelete(",local_u_1");
if(!$userInfos){
    var_dump($openIm->errors);
    var_dump($openIm->responseErrors);
}else{
    var_dump($userInfos);
}
?>


