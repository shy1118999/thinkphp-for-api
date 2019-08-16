<?php
/*
 * @Author: shaohang-shy 
 * @Date: 2019-08-16 21:00:01 
 * @Last Modified by: shaohang-shy
 * @Last Modified time: 2019-08-16 21:00:50
 * @dec 验证器 id必须为正整数
 */

namespace app\api\validate;

use app\api\validate\BaseValidate;

class IDMustBePositiveInt extends BaseValidate
{
    protected $rule = [
        "id" => "require|isPositiveInt"
    ];
    protected $message = [
        "id" => "id必须是正整数"
    ];
}
