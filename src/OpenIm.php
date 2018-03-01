<?php
/**
 * Created by PhpStorm.
 * User: su
 * Date: 2018/2/24
 * Time: 0:51
 */

namespace baichuan;


class OpenIm extends \baichuan\data\Data
{
    public $appkey;
    public $secret;
    public $format = 'json';

    public $responseErrors = [];

    /**
     * 批量获取用户信息
     * @param $userIds
     * @return bool|mixed
     */
    public function usersGet($userIds)
    {
        try {
            $topClient = $this->getTopClient($this->format);

            $req = new \OpenimUsersGetRequest();
            $req->setUserids($userIds);
            $resp = $topClient->execute($req);

            $return = $this->toArray($resp, $this->format);
            if (!$return) {
                throw new BaiChuanException($this->errors[0]['errorMsg']);
            }
            if (!empty($return['code'])) {
                $this->ResponseError($return);
                throw new BaiChuanException($return['msg']);
            }
            return $return['userinfos']['userinfos'];
        } catch (BaiChuanException $e) {
            $this->addError(__FUNCTION__, $e->getMessage(), $e->getLine(), $e->getFile());
            return false;
        }
    }

    /**
     * 批量删除用户
     * @param $userIds
     * @return bool
     */
    public function usersDelete($userIds)
    {
        try {
            $topClient = $this->getTopClient($this->format);

            $req = new \OpenimUsersDeleteRequest();
            $req->setUserids($userIds);
            $resp = $topClient->execute($req);

            $return = $this->toArray($resp, $this->format);
            if (!$return) {
                throw new BaiChuanException($this->errors[0]['errorMsg']);
            }
            if (!empty($return['code'])) {
                $this->ResponseError($return);
                throw new BaiChuanException($return['msg']);
            }
            return true;
        } catch (BaiChuanException $e) {
            $this->addError(__FUNCTION__, $e->getMessage(), $e->getLine(), $e->getFile());
            return false;
        }
    }

    /**
     * 批量更新用户信息
     * userinfos    Userinfos []    必须
     * 最大列表长度：100
     * 用户信息列表
     * └ nick String 可选 king昵称，最大长度64字节
     * └ icon_url String 可选 http://xxx.com/xxx头像url，最大长度512字节
     * └ email String 可选 uid@taobao.comemail地址，最大长度128字节
     * └ mobile String 可选 18600000000手机号码，最大长度16字节
     * └ taobaoid String 可选 taobaouser淘宝账号，最大长度64字节
     * └ userid String 必须 imuserim用户名，最大长度64字节
     * └ password String 可选 xxxxxxim密码，最大长度64字节
     * └ remark String 可选 demoremark，最大长度128字节
     * └ extra String 可选 {}扩展字段（Json），最大长度4096字节
     * └ career String 可选 demo职位，最大长度128字节
     * └ vip String 可选 {}vip（Json），最大长度512字节
     * └ address String 可选 demo地址，最大长度512
     * └ name String 可选 demo名字，最大长度64
     * └ age Number 可选 123年龄
     * └ gender String 可选 M性别。M: 男。 F：女
     * └ wechat String 可选 demo微信，最大长度64字节
     * └ qq String 可选 demoqq，最大长度20字节
     * └ weibo String 可选 demo微博，最大长度256字节
     * @param $userInfoArr
     * @return bool
     */
    public function usersUpdate($userinfoArr)
    {
        try {
            $topClient = $this->getTopClient($this->format);

            $userinfoArrs = [];
            foreach ($userinfoArr as $userinfo) {
                if (empty($userinfo['userid'])) {
                    throw new BaiChuanException('im用户名不能为空');
                }
                $userinfos = new \Userinfos();
                $userinfos->userid = $userinfo['userid'];

                //  昵称
                if (!empty($userinfo['nick'])) {
                    $userinfos->nick = $userinfo['nick'];
                }
                //  头像url
                if (!empty($userinfo['icon_url'])) {
                    $userinfos->icon_url = $userinfo['icon_url'];
                }
                //  email地址
                if (!empty($userinfo['email'])) {
                    $userinfos->email = $userinfo['email'];
                }
                //  手机号码
                if (!empty($userinfo['mobile'])) {
                    $userinfos->mobile = $userinfo['mobile'];
                }
                //  淘宝帐号
                if (!empty($userinfo['taobaoid'])) {
                    $userinfos->taobaoid = $userinfo['taobaoid'];
                }
                //  密码
                if (!empty($userinfo['password'])) {
                    $userinfos->password = $userinfo['password'];
                }
                //  remark
                if (!empty($userinfo['remark'])) {
                    $userinfos->remark = $userinfo['remark'];
                }
                //  扩展字段
                if (!empty($userinfo['extra'])) {
                    $userinfos->extra = $userinfo['extra'];
                }
                //  职位
                if (!empty($userinfo['career'])) {
                    $userinfos->career = $userinfo['career'];
                }
                //  vip
                if (!empty($userinfo['vip'])) {
                    $userinfos->vip = $userinfo['vip'];
                }
                //  地址
                if (!empty($userinfo['address'])) {
                    $userinfos->address = $userinfo['address'];
                }
                //  名字
                if (!empty($userinfo['name'])) {
                    $userinfos->name = $userinfo['name'];
                }
                //  年龄
                if (!empty($userinfo['age'])) {
                    $userinfos->age = $userinfo['age'];
                }
                //  性别
                if (!empty($userinfo['gender'])) {
                    $userinfos->gender = $userinfo['gender'];
                }
                //  微信
                if (!empty($userinfo['wechat'])) {
                    $userinfos->wechat = $userinfo['wechat'];
                }
                //  qq
                if (!empty($userinfo['qq'])) {
                    $userinfos->qq = $userinfo['qq'];
                }
                //  微博
                if (!empty($userinfo['weibo'])) {
                    $userinfos->weibo = $userinfo['weibo'];
                }
                $userinfoArrs[] = $userinfos;
            }

            $req = new \OpenimUsersUpdateRequest();
            $req->setUserinfos(json_encode($userinfoArrs));

            $resp = $topClient->execute($req);
            $return = $this->toArray($resp, $this->format);
            if (!$return) {
                throw new BaiChuanException($this->errors[0]['errorMsg']);
            }
            if (!empty($return['code'])) {
                $this->ResponseError($return);
                throw new BaiChuanException($return['msg']);
            }
            return $return;
        } catch (BaiChuanException $e) {
            $this->addError(__FUNCTION__, $e->getMessage(), $e->getLine(), $e->getFile());
            return false;
        }
    }

    /**
     * 添加用户
     * 名称    类型    是否必须    示例值    更多限制    描述
     * userinfos    Userinfos []    必须
     * 最大列表长度：100
     * 用户信息列表
     * └ nick String 可选 king昵称，最大长度64字节
     * └ icon_url String 可选 http://xxx.com/xxx头像url，最大长度512字节
     * └ email String 可选 uid@taobao.comemail地址，最大长度128字节
     * └ mobile String 可选 18600000000手机号码，最大长度16字节
     * └ taobaoid String 可选 taobaouser淘宝账号，最大长度64字节
     * └ userid String 必须 imuserim用户名，最大长度64字节
     * └ password String 必须 xxxxxxim密码，最大长度64字节
     * └ remark String 可选 demoremark，最大长度128字节
     * └ extra String 可选 {}扩展字段（Json），最大长度4096字节
     * └ career String 可选 demo职位，最大长度128字节
     * └ vip String 可选 {}vip（Json），最大长度512字节
     * └ address String 可选 demo地址，最大长度512
     * └ name String 可选 demo名字，最大长度64
     * └ age Number 可选 123年龄
     * └ gender String 可选 M性别。M: 男。 F：女
     * └ wechat String 可选 demo微信，最大长度64字节
     * └ qq String 可选 demoqq，最大长度20字节
     * └ weibo String 可选 demo微博，最大长度256字节
     * @param $userinfoArr
     * @return bool|mixed
     */
    public function usersAdd($userinfoArr)
    {
        try {
            $topClient = $this->getTopClient($this->format);

            $userinfoArrs = [];
            foreach ($userinfoArr as $userinfo) {
                //  IM用户名
                $userinfos = new \Userinfos();
                if (empty($userinfo['userid'])) {
                    throw new BaiChuanException('im用户名不能为空');
                }
                $userinfos->userid = $userinfo['userid'];
                //  IM密码
                if (empty($userinfo['password'])) {
                    throw new BaiChuanException('im密码未设置');
                }
                $userinfos->password = $userinfo['password'];
                //  昵称
                if (!empty($userinfo['nick'])) {
                    $userinfos->nick = $userinfo['nick'];
                }
                //  头像url
                if (!empty($userinfo['icon_url'])) {
                    $userinfos->icon_url = $userinfo['icon_url'];
                }
                //  email地址
                if (!empty($userinfo['email'])) {
                    $userinfos->email = $userinfo['email'];
                }
                //  手机号码
                if (!empty($userinfo['mobile'])) {
                    $userinfos->mobile = $userinfo['mobile'];
                }
                //  淘宝帐号
                if (!empty($userinfo['taobaoid'])) {
                    $userinfos->taobaoid = $userinfo['taobaoid'];
                }
                //  remark
                if (!empty($userinfo['remark'])) {
                    $userinfos->remark = $userinfo['remark'];
                }
                //  扩展字段
                if (!empty($userinfo['extra'])) {
                    $userinfos->extra = json_encode($userinfo['extra'], JSON_UNESCAPED_UNICODE);
                }
                //  职位
                if (!empty($userinfo['career'])) {
                    $userinfos->career = $userinfo['career'];
                }
                //  vip
                if (!empty($userinfo['vip'])) {
                    $userinfos->vip = json_encode($userinfo['vip'], JSON_UNESCAPED_UNICODE);
                }
                //  地址
                if (!empty($userinfo['address'])) {
                    $userinfos->address = $userinfo['address'];
                }
                //  名字
                if (!empty($userinfo['name'])) {
                    $userinfos->name = $userinfo['name'];
                }
                //  年龄
                if (!empty($userinfo['age'])) {
                    $userinfos->age = $userinfo['age'];
                }
                //  性别
                if (!empty($userinfo['gender'])) {
                    $userinfos->gender = $userinfo['gender'];
                }
                //  微信
                if (!empty($userinfo['wechat'])) {
                    $userinfos->wechat = $userinfo['wechat'];
                }
                //  qq
                if (!empty($userinfo['qq'])) {
                    $userinfos->qq = $userinfo['qq'];
                }
                //  微博
                if (!empty($userinfo['weibo'])) {
                    $userinfos->weibo = $userinfo['weibo'];
                }
                $userinfoArrs[] = $userinfos;
            }

            $req = new \OpenimUsersAddRequest();
            $req->setUserinfos(json_encode($userinfoArrs));

            $resp = $topClient->execute($req);
            $return = $this->toArray($resp, $this->format);
            if (!$return) {
                throw new BaiChuanException($this->errors[0]['errorMsg']);
            }
            if (!empty($return['code'])) {
                $this->ResponseError($return);
                throw new BaiChuanException($return['msg']);
            }
            return $return;
        } catch (BaiChuanException $e) {
            $this->addError(__FUNCTION__, $e->getMessage(), $e->getLine(), $e->getFile());
            return false;
        }
    }

    /**
     * 推送自定义openim消息
     * @param $custmsgArr
     * @return bool|mixed
     */
    public function custmsgPush($custmsgArr)
    {
        try {
            $topClient = $this->getTopClient($this->format);

            $req = new \OpenimCustmsgPushRequest();
            $custmsg = new \CustMsg();
            if (empty($custmsgArr['from_user'])) {
                throw new BaiChuanException('发送方userid不能为空');
            }
            $custmsg->from_user = $custmsgArr['from_user'];
            $custmsg->to_appkey = !empty($custmsgArr['to_appkey']) ? $custmsgArr['to_appkey'] : '0';
            if (empty($custmsgArr['to_users'])) {
                throw new BaiChuanException('接收方不能为空');
            }
            $custmsg->to_users = $custmsgArr['to_users'];
            if (empty($custmsgArr['summary'])) {
                throw new BaiChuanException('消息摘要不能为空');
            }
            $custmsg->summary = $custmsgArr['summary'];
            if (empty($custmsgArr['data'])) {
                throw new BaiChuanException('发送数据不能为空');
            }
            $custmsg->data = $custmsgArr['data'];
            if (!empty($custmsgArr['aps'])) {
                $custmsg->aps = $custmsgArr['aps'];
            }
            if (!empty($custmsgArr['apns_param'])) {
                $custmsg->apns_param = $custmsgArr['apns_param'];
            }
            $custmsg->invisible = !empty($custmsgArr['invisible']) ? "1" : "0";
            if (!empty($custmsgArr['from_nick'])) {
                $custmsg->from_nick = $custmsgArr['from_nick'];
            }
            $custmsg->from_taobao = "0";
            $req->setCustmsg(json_encode($custmsg));

            $resp = $topClient->execute($req);
            $return = $this->toArray($resp, $this->format);
            if (!$return) {
                throw new BaiChuanException($this->errors[0]['errorMsg']);
            }
            if (!empty($return['code'])) {
                $this->ResponseError($return);
                throw new BaiChuanException($return['msg']);
            }
            return $return;
        } catch (BaiChuanException $e) {
            $this->addError(__FUNCTION__, $e->getMessage(), $e->getLine(), $e->getFile());
            return false;
        }
    }

    /**
     * openim标准消息改善
     * @param $immsgArr
     * @return bool|mixed
     */
    public function ImmsgPush($immsgArr)
    {
        try {
            $topClient = $this->getTopClient($this->format);

            $req = new \OpenimImmsgPushRequest();
            $immsg = new \ImMsg();
            if (empty($immsgArr['from_user'])) {
                throw new BaiChuanException('发送方userid不能为空');
            }
            $immsg->from_user = $immsgArr['from_user'];
            $immsg->to_appkey = !empty($immsgArr['to_appkey']) ? $immsgArr['to_appkey'] : '0';
            if (empty($immsgArr['to_users'])) {
                throw new BaiChuanException('接收方不能为空');
            }
            $immsg->to_users = $immsgArr['to_users'];
            if (!empty($immsgArr['msg_type'])) {
                $immsg->msg_type = $immsgArr['msg_type'];
            }
            if (!empty($immsgArr['context'])) {
                $immsg->context = $immsgArr['context'];
            }
            if (!empty($immsgArr['media_attr'])) {
                $immsg->media_attr = $immsgArr['apns_param'];
            }
            $immsg->from_taobao = "0";
            $req->setImmsg(json_encode($immsg));

            $resp = $topClient->execute($req);
            $return = $this->toArray($resp, $this->format);
            if (!$return) {
                throw new BaiChuanException($this->errors[0]['errorMsg']);
            }
            if (!empty($return['code'])) {
                $this->ResponseError($return);
                throw new BaiChuanException($return['msg']);
            }
            return $return;
        } catch (BaiChuanException $e) {
            $this->addError(__FUNCTION__, $e->getMessage(), $e->getLine(), $e->getFile());
            return false;
        }
    }

    /**
     * 获取openim帐号的聊天关系
     * @param $begDate
     * @param $endDate
     * @param $userInfo
     * @return bool|mixed
     */
    public function RelationsGet($begDate, $endDate, $userInfo)
    {
        try {
            $topClient = $this->getTopClient($this->format);


            $req = new \OpenimRelationsGetRequest();
            //  查询起始日期
            $newTime = strtotime(date('Y-m-d'));
            if (empty($begDate) || date('Ymd', strtotime($begDate)) != $begDate) {
                throw new  BaiChuanException('查询起始日期错误');
            }
            $begTime = strtotime($begDate);
            if (($newTime - $begTime) > 3600 * 24 * 30) {
                throw new BaiChuanException('查询起始日期不能大于一个月');
            }
            $req->setBegDate($begDate);
            //  查询结束日期
            if (empty($endDate) || date('Ymd', strtotime($endDate)) != $endDate) {
                throw new  BaiChuanException('查询结束日期错误');
            }
            $endTime = strtotime($endDate);
            if (($newTime - $endTime) > 3600 * 24 * 30) {
                throw new BaiChuanException('查询结束日期不能大于一个月');
            }
            if ($endTime < $begTime) {
                throw new BaiChuanException('查询结束日期不能大于查询起始时期');
            }
            $req->setEndDate($endDate);

            $user = new \OpenImUser();
            if (empty($userInfo['uid'])) {
                throw new BaiChuanException('查询用户ID不能为空');
            }
            $user->uid = $userInfo['uid'];

            $user->taobao_account = !empty($userInfo['taobao_account']) && $userInfo['taobao_account'] == true ? 'true' : "false";
            if (!empty($userInfo['app_key'])) {
                $user->app_key = $userInfo['app_key'];
            }
            $req->setUser(json_encode($user));

            $resp = $topClient->execute($req);
            $return = $this->toArray($resp, $this->format);
            if (!$return) {
                throw new BaiChuanException($this->errors[0]['errorMsg']);
            }
            if (!empty($return['code'])) {
                $this->ResponseError($return);
                throw new BaiChuanException($return['msg']);
            }
            return $return;
        } catch
        (BaiChuanException $e) {
            $this->addError(__FUNCTION__, $e->getMessage(), $e->getLine(), $e->getFile());
            return false;
        }
    }

    /**
     * openim聊天记录查询接口
     * @param $beginTime
     * @param $endTime
     * @param $userInfo1
     * @param $userInfo2
     * @param int $count
     * @param null $next_key
     * @return bool|mixed
     */
    public function ChatlogsGet($beginTime, $endTime, $userInfo1, $userInfo2, $next_key = null, $count = 100)
    {
        try {
            $topClient = $this->getTopClient($this->format);

            $req = new \OpenimChatlogsGetRequest();
            //  用户1数据
            $user1 = new \OpenImUser();
            if (empty($userInfo1) || !is_array($userInfo2)) {
                throw new BaiChuanException('用户1数据异常');
            }
            if (empty($userInfo1['uid'])) {
                throw new BaiChuanException('用户1userid不存在');
            }
            $user1->uid = $userInfo1['uid'];
            $user1->taobao_account = !empty($userInfo1['taobao_account']) ? $userInfo1['taobao_account'] : "false";
            if (!empty($userInfo1['app_key'])) {
                $user1->app_key = $userInfo1['app_key'];
            }
            $req->setUser1(json_encode($user1));
            //  用户2数据
            $user2 = new \OpenImUser();
            if (empty($userInfo2) || !is_array($userInfo2)) {
                throw new BaiChuanException('用户2数据异常');
            }
            if (empty($userInfo2['uid'])) {
                throw new BaiChuanException('用户2userid不存在');
            }
            $user2->uid = $userInfo2['uid'];
            $user2->taobao_account = !empty($userInfo2['taobao_account']) ? $userInfo2['taobao_account'] : "false";
            if (!empty($userInfo2['app_key'])) {
                $user2->app_key = $userInfo2['app_key'];
            }
            $req->setUser2(json_encode($user2));
            //  查询开始时间
            if (empty($beginTime)) {
                throw new BaiChuanException('查询开始时间不能为空');
            }
            $req->setBegin((string)$beginTime);
            //  查询结束时间
            if (empty($endTime)) {
                throw new BaiChuanException('查询结束时间不能为空');
            }
            $req->setEnd((string)$endTime);
            //  查询条数
            $req->setCount((string)$count);
            //  迭代key
            if (!empty($next_key)) {
                $req->setNextKey($next_key);
            }

            $resp = $topClient->execute($req);
            $return = $this->toArray($resp, $this->format);
            if (!$return) {
                throw new BaiChuanException($this->errors[0]['errorMsg']);
            }
            if (!empty($return['code'])) {
                $this->ResponseError($return);
                throw new BaiChuanException($return['msg']);
            }
            return $return;
        } catch
        (BaiChuanException $e) {
            $this->addError(__FUNCTION__, $e->getMessage(), $e->getLine(), $e->getFile());
            return false;
        }
    }

    /**
     * openim应用聊天记录查询
     * @param $beginTime
     * @param $endTime
     * @param null $next_key
     * @param int $count
     * @return bool|mixed
     */
    public function AppChatlogsGet($beginTime, $endTime, $next_key = null, $count = 100)
    {
        try {
            $topClient = $this->getTopClient($this->format);

            $req = new \OpenimAppChatlogsGetRequest();
            //  查询开始时间
            if (empty($beginTime)) {
                throw new BaiChuanException('查询开始时间不能为空');
            }
            $req->setBeg((string)$beginTime);
            //  查询结束时间
            if (empty($endTime)) {
                throw new BaiChuanException('查询结束时间不能为空');
            }
            $req->setEnd((string)$endTime);
            //  查询条数
            $req->setCount((string)$count);
            //  迭代key
            if (!empty($next_key)) {
                $req->setNext($next_key);
            }

            $resp = $topClient->execute($req);
            $return = $this->toArray($resp, $this->format);
            if (!$return) {
                throw new BaiChuanException($this->errors[0]['errorMsg']);
            }
            if (!empty($return['code'])) {
                $this->ResponseError($return);
                throw new BaiChuanException($return['msg']);
            }
            return $return;
        } catch
        (BaiChuanException $e) {
            $this->addError(__FUNCTION__, $e->getMessage(), $e->getLine(), $e->getFile());
            return false;
        }
    }

    public function test()
    {
        echo 'test', PHP_EOL;
    }

    /**
     * 获取TopClient对象
     * @param string $format
     * @return \TopClient
     */
    public function getTopClient($format = 'json')
    {
        $obj = new \TopClient();
        $obj->appkey = $this->appkey;
        $obj->secretKey = $this->secret;
        $obj->format = $format;
        return $obj;
    }

    /**
     * 返回对象转为数组
     * @param $jsonObj
     * @return bool|mixed
     */
    public function toArray($Obj, $format = 'json')
    {
        try {
            if ($format == 'json') {
                return json_decode(json_encode($Obj, JSON_UNESCAPED_UNICODE), true);
            } elseif ($format == 'xml') {
                return $Obj;
            } else {
                throw new BaiChuanException('未知格式');
            }
        } catch (BaiChuanException $e) {
            $this->addError(__FUNCTION__, $e->getMessage(), $e->getLine(), $e->getFile());
            return false;
        }
    }

    /**
     * 请求错误
     * @param $return
     */
    public function ResponseError($return)
    {
        $this->responseErrors = $return;
    }
}