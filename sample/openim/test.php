<?php
/**
 * Created by PhpStorm.
 * User: su
 * Date: 2018/2/24
 * Time: 0:54
 */
require_once 'common.php';
//var_dump(ROOT);exit;
$userInfos = $openIm->usersGet(",local_u_2");
if(!$userInfos){
    var_dump($openIm->errors);
    var_dump($openIm->responseErrors);
}else{
    var_dump($userInfos);
}