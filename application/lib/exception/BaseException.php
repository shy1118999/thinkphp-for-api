<?php
/*
 * @Author: shaohang-shy 
 * @Date: 2019-08-16 20:41:33 
 * @Last Modified by: shaohang-shy
 * @Last Modified time: 2019-08-16 20:41:55
 * @dec 异常类基类
 */

namespace app\lib\exception;

use think\Exception;

class BaseException extends Exception
{
    // HTTP 状态码 404,200
    public $code = 400;
    // 错误具体信息
    public $msg = "参数错误";
    // 自定义的错误码
    public $errorCode = 10000;

    public function __construct($params = [])
    {
        parent::__construct();
        if (!is_array($params)) {
            // throw new Exception("参数必须是数组");
            return;
        }
        if (array_key_exists('code', $params)) {
            $this->code = $params['code'];
        }
        if (array_key_exists('msg', $params)) {
            $this->msg = $params['msg'];
        }
        if (array_key_exists('errorCode', $params)) {
            $this->errorCode = $params['errorCode'];
        }
    }
}
