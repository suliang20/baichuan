<?php
/**
 * Created by PhpStorm.
 * User: su
 * Date: 2018/2/26
 * Time: 14:29
 */

date_default_timezone_set('Asia/Shanghai');
if (!ini_get('display_errors')) {
    ini_set('display_errors', '1');
}
error_reporting(E_ALL);

require '../../local/config.php';
require '../../vendor/autoload.php';

$openIm = new \baichuan\OpenIm();
$openIm->appkey = APPKEY;
$openIm->secret = SECRET;
?>