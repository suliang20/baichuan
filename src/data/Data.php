<?php
/**
 * Created by PhpStorm.
 * User: su
 * Date: 2018/1/6
 * Time: 19:21
 */

namespace baichuan\data;

use baichuan\BaiChuanException;

class Data
{
    public $errors = array();

    /**
     * 添加错误
     * @param $name
     * @param $errorMsg
     */
    public function addError($name, $errorMsg, $line = '', $file = '')
    {
        $this->errors[] = [
            'name' => $name,
            'errorMsg' => $errorMsg,
            'file' => $file,
            'line' => $line,
        ];
    }

    /**
     * 检查是否有错误
     * @return bool
     */
    public function hasErrors()
    {
        return !empty($this->errors);
    }


    /**
     * 创建文件
     * @param $file
     */
    public function createFile($file)
    {
        try {
            $dirname = dirname($file);
            if (!file_exists($dirname)) {
                if (!mkdir($dirname, 0777, true)) {
                    throw new BaiChuanException('创建文件夹失败');
                }
            }
            if (!file_exists($file)) {
                if (!touch($file)) {
                    throw new BaiChuanException('创建文件失败');
                }
            }
            return true;
        } catch (BaiChuanException $e) {
            $this->addError(__FUNCTION__, $e->getMessage(), $e->getFile(), $e->getLine());
        }
        return false;
    }
}