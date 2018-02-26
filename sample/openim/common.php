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

defined('ROOT') or define('ROOT', realpath(dirname(dirname(dirname(__FILE__)))) . '/');
defined('CONFIG_FILE') or define('CONFIG_FILE', ROOT . 'config/config.php');
defined('CONFIG_LOCAL_FILE') or define('CONFIG_LOCAL_FILE', ROOT . '/config/config-local.php');

if(file_exists(CONFIG_LOCAL_FILE)){
    require_once(CONFIG_LOCAL_FILE);
}else{
    require_once(CONFIG_FILE);
}
require '../../vendor/autoload.php';

$openIm = new \baichuan\OpenIm();
$openIm->appkey = APPKEY;
$openIm->secret = SECRET;
?>