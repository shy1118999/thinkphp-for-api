<?php
/*
 * @Author: shaohang-shy 
 * @Date: 2019-08-16 20:50:49 
 * @Last Modified by: shaohang-shy
 * @Last Modified time: 2019-08-16 20:51:51
 * @dec 自定义基础模型类 其余模型类继承此类
 */

namespace app\api\model;

use think\Model;
use think\model\concern\SoftDelete;

class BaseModel extends Model
{
    // 软删除
    use SoftDelete;
    protected $deleteTime = 'delete_time';
    // 表主键   继承请重写
    protected $pk = '';
    // 开启自动时间戳
    protected $autoWriteTimestamp = true;
    // 定义时间戳字段名
    protected $createTime = 'create_time';
    protected $updateTime = 'update_time';
    // 自定义隐藏字段
    protected $hidden = [];
}
