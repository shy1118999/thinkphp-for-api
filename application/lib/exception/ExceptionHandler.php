<?php
/*
 * @Author: shaohang-shy 
 * @Date: 2019-08-16 20:38:34 
 * @Last Modified by: shaohang-shy
 * @Last Modified time: 2019-08-16 20:44:34
 * @dec 自定义异常处理handle类
 */
namespace app\lib\exception;

use think\exception\Handle;
use think\Exception;
use think\facade\Request;
use think\facade\Log;

class ExceptionHandler extends Handle{
    private $code;
    private $msg;
    private $errorCode;
    // 需要返回客户端当前请求的URL路径 
    public function render(\Exception $e){
        if($e instanceof BaseException){
            // 如果是自定义的异常
            $this->code = $e->code;
            $this->msg = $e->msg;
            $this->errorCode = $e->errorCode;
        }else{
            if(config("app_debug")){
                return parent::render($e);
            }else{
                $this->code = 500;
                $this->msg = "服务器错误";
                $this->errorCode = 999;
                $this->recordErrorLog($e);
            }
        }
        $request = Request::instance();
        $result = [
            'msg'=>$this->msg,
            'error_code'=>$this->errorCode,
            'request_url'=>$request->url()
        ];
        return json($result,$this->code);
    }
    private function recordErrorLog(\Exception $e){
        Log::init([
            'type'=>'File',
            'level'=>['error']
        ]);
        Log::record($e->getMessage(),'error');
    }
}