<?php
/*
 * @Author: shaohang-shy 
 * @Date: 2019-08-16 20:42:36 
 * @Last Modified by: shaohang-shy
 * @Last Modified time: 2019-08-16 20:43:21
 * @dec 无返回数据时 抛出该异常表示成功返回
 */
namespace app\lib\exception;

class SuccessMessage extends BaseException{
    public $code = 201;
    public $msg = "ok";
    public $errorCode = 0;
}