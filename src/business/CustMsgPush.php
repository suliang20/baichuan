<?php
/**
 * Created by PhpStorm.
 * User: su
 * Date: 2018/2/26
 * Time: 18:05
 */

namespace baichuan\business;

use baichuan\BaiChuanException;
use baichuan\data\Data;

class CustMsgPush extends Data
{
    public static $logFile = ROOT . 'data/openim/cust-msg-push.log';

    /**
     * 自定义消息推送加入
     * @param $data
     * @param $time
     * @return bool
     */
    public function add($data, $time)
    {
        try {
            if (empty($data['msgid'])) {
                throw new BaiChuanException('消息ID不能为空');
            }
            $msgid = $data['msgid'];
            if (file_exists(static::$logFile)) {
                $datas = file_get_contents(static::$logFile);
                $datas = unserialize($datas);
            } else {
                if (!$this->createFile(static::$logFile)) {
                    throw new BaiChuanException('创建用户文件失败');
                }
                $datas = [];
            }
            $custmsg['msgid'] = $msgid;
            $custmsg['request_id'] = $data['request_id'];
            $custmsg['from_user'] = !empty($data['from_user']) ? $data['from_user'] : '';
            $custmsg['to_appkey'] = !empty($data['to_appkey']) ? $data['to_appkey'] : '';
            $custmsg['to_users'] = !empty($data['to_users']) ? $data['to_users'] : '';
            $custmsg['summary'] = !empty($data['summary']) ? $data['summary'] : '';
            $custmsg['data'] = !empty($data['data']) ? $data['data'] : '';
            $custmsg['aps'] = !empty($data['aps']) ? $data['aps'] : '';
            $custmsg['apns_param'] = !empty($data['apns_param']) ? $data['apns_param'] : '';
            $custmsg['invisible'] = !empty($data['invisible']) ? $data['invisible'] : '0';
            $custmsg['from_nick'] = !empty($data['from_nick']) ? $data['from_nick'] : '';
            $custmsg['from_taobao'] = !empty($data['from_taobao']) ? $data['from_taobao'] : '0';
            $custmsg['createTime'] = $time;
            $datas[$msgid] = $custmsg;
            $datas = serialize($datas);
            file_put_contents(static::$logFile, $datas);
            return true;
        } catch (BaiChuanException $e) {
            $this->addError(__FUNCTION__, $e->getMessage(), $e->getFile(), $e->getLine());
        }
        return false;
    }

    public function getAll()
    {
        try {
            if (file_exists(static::$logFile)) {
                $datas = file_get_contents(static::$logFile);
                $datas = unserialize($datas);
            } else {
                $datas = [];
            }
            return $datas;
        } catch (BaiChuanException $e) {
            $this->addError(__FUNCTION__, $e->getMessage(), $e->getFile(), $e->getLine());
        }
        return false;
    }

}