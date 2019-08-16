<?php
/*
 * @Author: shaohang-shy 
 * @Date: 2019-08-16 20:56:52 
 * @Last Modified by: shaohang-shy
 * @Last Modified time: 2019-08-16 21:01:46
 * @dec 自定义 基础验证器类 其余验证器类继承此类
 */

namespace app\api\validate;

use think\Validate;
use think\facade\Request;
use think\Exception;
use app\lib\exception\ParameterException;

class BaseValidate extends Validate
{
    /***
     * 验证方法
     */
    public function gocheck()
    {
        $request = Request::instance();
        $param = $request->param();

        $res = $this->batch()->check($param);

        if (!$res) {
            $error = $this->error;
            $e = new ParameterException([
                'msg' => "参数错误：" . (implode('，', $error)),
                // 'code'=>400,
                // 'errorCode'=>10000
            ]);
            // $e->msg = "参数错误:".$error;
            throw $e;
        } else {
            return true;
        }
    }
    /***
     * 验证是否是正整数
     */
    protected function isPositiveInt($value, $rule = '', $date = '', $field = '')
    {
        if (is_numeric($value) && is_int($value + 0) && ($value + 0) > 0) {
            return true;
        } else {
            return false;
        }
    }
    /***
     * 验证是否为空
     */
    protected function isNotEmpty($value, $rule = '', $date = '', $field = '')
    {
        if (empty($value)) {
            return false;
        } else {
            return true;
        }
    }
    /***
     * 验证是否是手机号
     */
    protected function isMobile($value, $rule = '', $date = '', $field = '')
    {
        $rule = '^1(3|4|5|7|8)[0-9]\d{8}$^';
        $result = preg_match($rule, $value);
        if ($result) {
            return true;
        } else {
            return false;
        }
    }
    /***
     * 获取数据通过验证器验证的数据
     * @return array 返回经过该验证器验证的参数的键值对
     */
    public function getDataByRule($arrays)
    {
        if (array_key_exists("user_id", $arrays) || array_key_exists("uid", $arrays)) {
            throw new ParameterException([
                "msg" => "参数中包含非法的参数名user_id或者uid"
            ]);
        }
        $newArray = [];
        foreach ($this->rule as $key => $value) {
            $newArray[$key] = $arrays[$key];
        }
        return $newArray;
    }
}
