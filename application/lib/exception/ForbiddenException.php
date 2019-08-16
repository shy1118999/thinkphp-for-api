<?php
/*
 * @Author: shaohang-shy 
 * @Date: 2019-08-16 20:43:59 
 * @Last Modified by: shaohang-shy
 * @Last Modified time: 2019-08-16 20:44:23
 * @dec 异常类 权限不够
 */
namespace app\lib\exception;

class ForbiddenException extends BaseException{
    public $code = 403;
    public $msg = "您没有权限";
    public $errorCode = 10001;
}