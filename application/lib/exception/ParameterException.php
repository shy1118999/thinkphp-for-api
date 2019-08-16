<?php
/*
 * @Author: shaohang-shy 
 * @Date: 2019-08-16 20:45:16 
 * @Last Modified by: shaohang-shy
 * @Last Modified time: 2019-08-16 20:45:49
 * @dec 异常类  参数错误
 */

namespace app\lib\exception;

/***
 * [参数错误类]
 * [验证器参数错误时，抛出此异常]
 */
class ParameterException extends BaseException
{
    public $code = 400;
    public $msg = "参数错误";
    public $errorCode = 10003;
}
