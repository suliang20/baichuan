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

class ImUser extends Data
{
    public static $logFile = ROOT . 'data/openim/im-user.log';
    public static $userLastIdLogFile = ROOT . 'data/openim/user-last-id.log';

    /**
     * 用户添加
     * @param $data
     * @param $time
     * @return bool
     */
    public function add($data, $time)
    {
        try {
            if (empty($data['userid'])) {
                throw new BaiChuanException('用户ID不存在');
            }
            $userid = $data['userid'];
            if (file_exists(static::$logFile)) {
                $datas = file_get_contents(static::$logFile);
                $datas = unserialize($datas);
            } else {
                if (!$this->createFile(static::$logFile)) {
                    throw new BaiChuanException('创建用户文件失败');
                }
                $datas = [];
            }
            $userInfo = [];
            //  用户ID
            $userInfo['userid'] = $data['userid'];
            //  用户密码
            if (empty($data['password'])) {
                throw new BaiChuanException('用户密码不能为空');
            }
            $userInfo['password'] = !empty($data['password']) ? $data['password'] : '';
            //  昵称
            $userInfo['nick'] = !empty($data['nick']) ? $data['nick'] : '';
            $userInfo['icon_url'] = !empty($data['icon_url']) ? $data['icon_url'] : '';
            $userInfo['email'] = !empty($data['email']) ? $data['email'] : '';
            $userInfo['mobile'] = !empty($data['mobile']) ? $data['mobile'] : '';
            $userInfo['taobaoid'] = !empty($data['taobaoid']) ? $data['taobaoid'] : '';
            $userInfo['remark'] = !empty($data['remark']) ? $data['remark'] : '';
            $userInfo['extra'] = !empty($data['extra']) ? $data['extra'] : '';
            $userInfo['career'] = !empty($data['career']) ? $data['career'] : '';
            $userInfo['vip'] = !empty($data['vip']) ? $data['vip'] : '';
            $userInfo['address'] = !empty($data['address']) ? $data['address'] : '';
            $userInfo['name'] = !empty($data['name']) ? $data['name'] : '';
            $userInfo['age'] = !empty($data['age']) ? $data['age'] : '';
            $userInfo['gender'] = !empty($data['gender']) ? $data['gender'] : '';
            $userInfo['wechat'] = !empty($data['wechat']) ? $data['wechat'] : '';
            $userInfo['qq'] = !empty($data['qq']) ? $data['qq'] : '';
            $userInfo['weibo'] = !empty($data['weibo']) ? $data['weibo'] : '';
            $userInfo['status'] = 1;
            $userInfo['createTime'] = $time;
            $userInfo['updateTime'] = $time;
            $datas[$userid] = $userInfo;
            $datas = serialize($datas);
            file_put_contents(static::$logFile, $datas);
            return true;
        } catch (BaiChuanException $e) {
            $this->addError(__FUNCTION__, $e->getMessage(), $e->getFile(), $e->getLine());
        }
        return false;
    }

    /**
     * 用户更新
     * @param $data
     * @param $time
     * @return bool
     */
    public function update($data, $time)
    {
        try {
            if (empty($data['userid'])) {
                throw new BaiChuanException('用户ID不存在');
            }
            $userid = $data['userid'];
            if (file_exists(static::$logFile)) {
                $datas = file_get_contents(static::$logFile);
                $datas = unserialize($datas);
            } else {
                if (!$this->createFile(static::$logFile)) {
                    throw new BaiChuanException('创建用户文件失败');
                }
                $datas = [];
            }
            if (empty($datas[$userid])) {
                throw new BaiChuanException('用户不存在');
            }
            $userInfo = $datas[$userid];
            //  用户ID
            $userInfo['password'] = !empty($data['password']) ? $data['password'] : $userInfo['password'];
            //  昵称
            $userInfo['nick'] = !empty($data['nick']) ? $data['nick'] : $userInfo['nick'];
            $userInfo['icon_url'] = !empty($data['icon_url']) ? $data['icon_url'] : $userInfo['icon_url'];
            $userInfo['email'] = !empty($data['email']) ? $data['email'] : $userInfo['email'];
            $userInfo['mobile'] = !empty($data['mobile']) ? $data['mobile'] : $userInfo['mobile'];
            $userInfo['taobaoid'] = !empty($data['taobaoid']) ? $data['taobaoid'] : $userInfo['taobaoid'];
            $userInfo['remark'] = !empty($data['remark']) ? $data['remark'] : $userInfo['remark'];
            $userInfo['extra'] = !empty($data['extra']) ? $data['extra'] : $userInfo['extra'];
            $userInfo['career'] = !empty($data['career']) ? $data['career'] : $userInfo['career'];
            $userInfo['vip'] = !empty($data['vip']) ? $data['vip'] : $userInfo['vip'];
            $userInfo['address'] = !empty($data['address']) ? $data['address'] : $userInfo['address'];
            $userInfo['name'] = !empty($data['name']) ? $data['name'] : $userInfo['name'];
            $userInfo['age'] = !empty($data['age']) ? $data['age'] : $userInfo['age'];
            $userInfo['gender'] = !empty($data['gender']) ? $data['gender'] : $userInfo['gender'];
            $userInfo['wechat'] = !empty($data['wechat']) ? $data['wechat'] : $userInfo['wechat'];
            $userInfo['qq'] = !empty($data['qq']) ? $data['qq'] : $userInfo['qq'];
            $userInfo['weibo'] = !empty($data['weibo']) ? $data['weibo'] : $userInfo['weibo'];
            $userInfo['updateTime'] = $time;
            $datas[$userid] = $userInfo;
            $datas = serialize($datas);
            file_put_contents(static::$logFile, $datas);
            return true;
        } catch (BaiChuanException $e) {
            $this->addError(__FUNCTION__, $e->getMessage(), $e->getFile(), $e->getLine());
        }

        return false;
    }

    /**
     * 用户更新
     * @param $data
     * @param $time
     * @return bool
     */
    public function active($data, $time)
    {
        try {
            if (empty($data['userid'])) {
                throw new BaiChuanException('用户ID不存在');
            }
            $userid = $data['userid'];
            if (file_exists(static::$logFile)) {
                $datas = file_get_contents(static::$logFile);
                $datas = unserialize($datas);
            } else {
                if (!$this->createFile(static::$logFile)) {
                    throw new BaiChuanException('创建用户文件失败');
                }
                $datas = [];
            }
            if (empty($datas[$userid])) {
                throw new BaiChuanException('用户不存在');
            }
            $userInfo = $datas[$userid];
            //  用户ID
            $userInfo['password'] = !empty($data['password']) ? $data['password'] : $userInfo['password'];
            //  昵称
            $userInfo['nick'] = !empty($data['nick']) ? $data['nick'] : $userInfo['nick'];
            $userInfo['icon_url'] = !empty($data['icon_url']) ? $data['icon_url'] : $userInfo['icon_url'];
            $userInfo['email'] = !empty($data['email']) ? $data['email'] : $userInfo['email'];
            $userInfo['mobile'] = !empty($data['mobile']) ? $data['mobile'] : $userInfo['mobile'];
            $userInfo['taobaoid'] = !empty($data['taobaoid']) ? $data['taobaoid'] : $userInfo['taobaoid'];
            $userInfo['remark'] = !empty($data['remark']) ? $data['remark'] : $userInfo['remark'];
            $userInfo['extra'] = !empty($data['extra']) ? $data['extra'] : $userInfo['extra'];
            $userInfo['career'] = !empty($data['career']) ? $data['career'] : $userInfo['career'];
            $userInfo['vip'] = !empty($data['vip']) ? $data['vip'] : $userInfo['vip'];
            $userInfo['address'] = !empty($data['address']) ? $data['address'] : $userInfo['address'];
            $userInfo['name'] = !empty($data['name']) ? $data['name'] : $userInfo['name'];
            $userInfo['age'] = !empty($data['age']) ? $data['age'] : $userInfo['age'];
            $userInfo['gender'] = !empty($data['gender']) ? $data['gender'] : $userInfo['gender'];
            $userInfo['wechat'] = !empty($data['wechat']) ? $data['wechat'] : $userInfo['wechat'];
            $userInfo['qq'] = !empty($data['qq']) ? $data['qq'] : $userInfo['qq'];
            $userInfo['weibo'] = !empty($data['weiboupdate']) ? $data['weibo'] : $userInfo['weibo'];
            $userInfo['status'] = 1;
            $userInfo['updateTime'] = $time;
            $datas[$userid] = $userInfo;
            $datas = serialize($datas);
            file_put_contents(static::$logFile, $datas);
            return true;
        } catch (BaiChuanException $e) {
            $this->addError(__FUNCTION__, $e->getMessage(), $e->getFile(), $e->getLine());
        }

        return false;
    }

    /**
     * 用户删除
     * @param $userid
     * @param $time
     * @return bool
     */
    public function delete($userid, $time)
    {
        try {
            if (empty($userid)) {
                throw new BaiChuanException('用户ID不存在');
            }
            if (file_exists(static::$logFile)) {
                $datas = file_get_contents(static::$logFile);
                $datas = unserialize($datas);
            } else {
                if (!$this->createFile(static::$logFile)) {
                    throw new BaiChuanException('创建用户文件失败');
                }
                $datas = [];
            }
            if (empty($datas[$userid])) {
                throw new BaiChuanException('用户不存在');
            }
            if ($datas[$userid]['status'] != 1) {
                throw new BaiChuanException('删除状态异常');
            }

            $userInfo = $datas[$userid];

            $userInfo['updateTime'] = $time;
            $userInfo['status'] = 2;
            $datas[$userid] = $userInfo;
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

    /**
     * 检查清算通用户ID是否存在
     * @param $userId
     * @return bool
     */
    public function hasUserid($userid)
    {
        $allUser = $this->getAll();
        return !empty($allUser[$userid]) ? true : false;
    }

    /**
     * 根据用户ID获取用户信息
     * @param $userid
     * @return bool|mixed
     */
    public function getUserInfoByUserid($userid)
    {
        $allUser = $this->getAll();
        return !empty($allUser[$userid]) ? $allUser[$userid] : false;
    }

    /**
     * 用户已删除
     * @param $userid
     * @return bool
     */
    public function hasUserDelete($userid)
    {
        $allUser = $this->getAll();
        if (empty($allUser[$userid])) {
            return false;
        }
        if ($allUser[$userid]['status'] == 2) {
            return true;
        }
        return false;
    }

    /**
     * 获取新的用户ID
     * @return int|mixed
     */
    public function getNewUserId()
    {
        try {
            if (file_exists(static::$userLastIdLogFile)) {
                $lastUserId = file_get_contents(static::$userLastIdLogFile);
                if (floor($lastUserId) != $lastUserId) {
                    $newUserId = 1000;
                } else {
                    $newUserId = $lastUserId + 1;
                }
            } else {
                if (!$this->createFile(static::$userLastIdLogFile)) {
                    throw new BaiChuanException('创建最后用户ID文件失败');
                }
                $newUserId = 1000;
            }
            file_put_contents(static::$userLastIdLogFile, $newUserId);
            return $newUserId;
        } catch (BaiChuanException $e) {
            $this->addError(__FUNCTION__, $e->getMessage(), $e->getFile(), $e->getLine());
            return false;
        }
    }
}