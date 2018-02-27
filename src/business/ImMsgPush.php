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

class ImMsgPush extends Data
{
    public static $logFile = ROOT . 'data/openim/im-msg-push.log';

    /**
     * 标准消息推送加入
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
            $immsg['msgid'] = $msgid;
            $immsg['request_id'] = $data['request_id'];
            $immsg['from_user'] = !empty($data['from_user']) ? $data['from_user'] : '';
            $immsg['to_appkey'] = !empty($data['to_appkey']) ? $data['to_appkey'] : '';
            $immsg['to_users'] = !empty($data['to_users']) ? $data['to_users'] : '';
            $immsg['msg_type'] = !empty($data['msg_type']) ? $data['msg_type'] : '';
            $immsg['content'] = !empty($data['content']) ? $data['content'] : '';
            $immsg['media_attr'] = !empty($data['media_attr']) ? $data['media_attr'] : '';
            $immsg['from_taobao'] = !empty($data['from_taobao']) ? $data['from_taobao'] : '0';
            $immsg['createTime'] = $time;
            $datas[$msgid] = $immsg;
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