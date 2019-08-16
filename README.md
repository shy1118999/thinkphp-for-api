# ThinkPHP 二次开发(对API友好)

## 一、开发环境
>`php 7.2.12`   
>`mysql 5.6`  
>`nginx服务器`  
>`ThinkPHP 5.1.38`

## 二、命名规范
采用ThinkPHP5.1命名规范[链接](https://www.kancloud.cn/manual/thinkphp5_1/353949)  
***请理解并尽量遵循以下命名规范，可以减少在开发过程中出现不必要的错误。***
### 目录和文件
+ 目录使用小写字母命名
+ 类库、函数文件统一使用`.php`为后缀
+ 类的文件名均以命名空间定义，并且命名空间的路径和类库文件所在路径一致
+ 类文件采用驼峰法命名（首字母大写），其它文件采用小写+下划线命名
+ **类名和类文件名保持一致**，统一采用驼峰法命名（首字母大写）
### 函数和类、属性命名
+ 类的命名采用驼峰法（首字母大写），例如 `User、UserType`，默认不需要添加后缀，例如`UserController`应该直接命名为`User`；
+ 函数的命名使用小写字母和下划线（小写字母开头）的方式，例如 `get_client_ip`；
+ 方法的命名使用驼峰法（首字母小写），例如 `getUserName`；
+ 属性的命名使用驼峰法（首字母小写），例如 `tableName、instance`；
+ 特例：以双下划线__打头的函数或方法作为魔术方法，例如 `__call` 和 `__autoload`；
### 常量和配置
+ 常量以大写字母和下划线命名，例如 `APP_PATH`；
+ 配置参数以小写字母和下划线命名，例如 `url_route_on` 和`url_convert`；
+ 环境变量定义使用大写字母和下划线命名，例如`APP_DEBUG`；
### 数据表和字段
+ 数据表和字段采用小写加下划线方式命名，并注意字段名不要以下划线开头，例如 `think_user` 表和 `user_name`字段，不建议使用驼峰和中文作为数据表及字段命名。

## 三、注释规范
### 类注释
+ 控制器类
```php 
/***
* [作用]
* [其他]
*/
```
+ 模型类
```php
/***
 * @table:[对应表名] 
 * [其他]
 */
```
+ 验证器类
```php
/***
 * [作用]
 * @field:[验证字段名]
 * [其他]
 */
```
+ 异常类
```php
/***
 * [作用]
 * [其他]
 */
```
### 方法注释
+ API接口方法
```php
/***
 * [功能]
 * @url [路由地址]
 * @http [GET/POST/DELETE/PUT]
 * @param [参数类型] [参数名] [备注]
 * @param [参数类型] [参数名] [备注]
 * [其他]
 */
```
+ 普通方法
```php
/***
 * [功能]
 * @param [参数类型] [参数名] [备注]
 * @param [参数类型] [参数名] [备注]
 * [其他]
 */
```
### 方法内部注释
+ 需要注释代码上一行同一缩进处使用 `// 双斜线` 注释。 
### 路由注释
+ 注释路由指向的方法作用


## 四、自定义配置
### 新增配置项
+ 在 `/config/setting.php` 文件内自定义配置项。
### 使用配置项
+ 使用助手函数 `config()` 使用配置项。【`config("setting.配置项名称")`】

## 五、自定义全局方法
+ 在 `/application/common.php` 内自定义。

## 六、命名空间
+  `application` 为 `app`
+ 其余按照路径定义
+ 使用命名空间时需要注意一下几点：  
    1. Model类需要 as XxxModel 例如【`use app\api\model\User as UserModel;`】
    2. Service类需要 as XxxService 例如【`use app\api\service\Token as TokenServices;`】

## 七、异常处理
### 采用自定义异常类处理
+ 异常类基类为 `app\lib\exception\BaseException` 
```php
<?php
namespace app\lib\exception;
use think\Exception;
class BaseException extends Exception{
    // HTTP 状态码 404,200
    public $code = 400;
    // 错误具体信息
    public $msg = "参数错误";
    // 自定义的错误码
    public $errorCode = 10000;

    public function __construct($params = []){
        parent::__construct();
        if(!is_array($params)){
            // throw new Exception("参数必须是数组");
            retuen ;
        }
        if(array_key_exists('code',$params)){
            $this->code = $params['code'];
        }
        if(array_key_exists('msg',$params)){
            $this->msg = $params['msg'];
        }
        if(array_key_exists('errorCode',$params)){
            $this->errorCode = $params['errorCode'];
        }
        
    }
}
```
+ 其他异常类请继承此类。
+ 其他异常以请以 `Exception.php` 为后缀。例:[`UserException.php`]
+ 继承时 请重写 `$code、$msg、$errorCode` 属性。
+ 在自定义异常发生处 请抛出此异常。`throw new XxxException()` 
+ `new` 异常类时可以传入一个数组，形式如下,其中 `code` 为HTTP状态码； `msg` 为异常信息； `errorCode` 为错误码。 
    ```php
    ["code"=>401,"msg"=>"异常信息","errorCode"=>10001]
    ```
+ 异常的错误码请在 `errorCode.txt` 文件下写明。
+ 例如：在exception下定义一个用户异常类：
    ```php
    <?php
    namespace app\lib\exception;
    /***
     * [用户异常类]
     * [用户异常重类：默认返回如下]
     */
    class UserException extends BaseException{
        public $code = 404;
        public $msg = "用户不存在";
        public $errorCode = 10001;
    }
    ```
    检测到用户不存在：
    ```php
    //获取用户信息
    $user = getUser();//伪代码
    if(!$user){
        // 使用前请引入 命名空间 use app\lib\exception\UserException;
        throw new UserException([
            "code"=>401,
            "msg"=>"用户不存在",
            "errorCode"=>10001
        ]);//可传入可选的参数，必须传入关联数组，三者可随意组合
    }
    //接下来的代码
    ```

## 八、数据返回
+ 后台已配置返回json数据，直接 `return` 数组即可。
+ 若请求无返回数据，请抛出返回： `throw new SucessMessage()` 其中SucessMessage的命名空间为 `app\lib\exception\SucessMessage` 。


## 九、模型类基类
+ 模型类基类为 `app\api\model\BaseModel`
```php
<?php
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
```
+ 模型公共方法请写在此基类。
+ 例如：新建一个用户模型类：User.php
    ```php
    <?php
    namespace app\api\model;
    /***
     * @table:daka_user 
     * [用户管理模型]
     */
    class User extends BaseModel{
        // 重写数据表主键
        protected $pk = 'user_id';
    }
    ```

## 十、控制器基类
+ 控制器基类为 `app\api\controller\v1\BaseController`
    ```php
    <?php
    namespace app\api\controller\v1;

    use think\Controller;
    use app\lib\enum\ScopeEnum;
    use app\lib\exception\ForbiddenException;
    use app\api\service\Token as TokenService;
    class BaseController extends Controller{
        /***
         * [Token验证权限问题]
         */
        protected function checkPrimaryScope(){
            $scope = TokenService::getCurrentTokenVar("scope");
            // echo $scope;die;
            if($scope){
                if($scope >= ScopeEnum::User){
                    return true;
                }else{
                    throw new ForbiddenException();
                }
            }else{
                throw new TokenException();
            }
        }
    }
    ```
## 十一、验证器
### 验证器基类
+ 验证器基类为 `app\api\validate\BaseValidate` 。
    ```php
    <?php
    namespace app\api\validate;
    use think\Validate;
    use think\Request;
    use think\Exception;
    use app\lib\exception\ParameterException;
    class BaseValidate extends Validate{
        /***
         * [参数验证方法]
         */
        public function gocheck(){
            $request = Request::instance();
            $param = $request->param();
            $res = $this->batch()->check($param);
            if(!$res){
                $error = $this->error;
                $e = new ParameterException([
                    'msg'=>"参数错误：".(implode('，',$error)),
                    // 'code'=>400,
                    // 'errorCode'=>10000
                ]);
                // $e->msg = "参数错误:".$error;
                throw $e;
            }else{
                return true;
            }
        }
        /***
         * [自定义验证规则：判断是否为正整数]
         * [判断ID时，可用此验证方法]
         */
        protected function isPositiveInt($value,$rule='',$date='',$field=''){
            if(is_numeric($value) && is_int($value + 0) && ($value + 0)>0){
                return true;
            }else{
                return false;
            }
        }
        /***
         * [自定义验证规则，非空]
         * [判断某个字段为必填时，可用此验证规则]
         */
        protected function isNotEmpty($value,$rule='',$date='',$field=''){
            if(empty($value)){
                return false;
            }else{
                return true;
            }
        }
        /***
         * [自定义验证规则：判断输入是否为11位手机号]
         */
        protected function isMobile($value,$rule='',$date='',$field=''){
            $rule = '^1(3|4|5|7|8)[0-9]\d{8}$^';
            $result = preg_match($rule, $value);
            if ($result) {
                return true;
            } else {
                return false;
            }
        }
        /***
         * [获取验证器验证参数的值]
         * @return array 返回经过该验证器验证的参数的键值对
         */
        public function getDataByRule($arrays){
            if(array_key_exists("user_id",$arrays) || array_key_exists("uid",$arrays)){
                throw new ParameterException([
                    "msg"=>"参数中包含非法的参数名user_id或者uid"
                ]);
            }
            $newArray = [];
            foreach($this->rule as $key=>$value){
                $newArray[$key] = $arrays[$key];
            }
            return $newArray;
        }
    }
    ```
+ 规定：所有的自定义验证方法全部放在基类验证器中。
+ 子类验证器必须继承这一验证器。
+ 子类继承时，请重写 `$rule,$message` 属性。
+ `protected $rule` 为验证规则。
+ `protected $message` 为该字段验证不通过返回的消息。
+ 使用该验证器直接 `new` 验证器对象并调用 `gocheck()` 方法即可.[`(new 验证器类名())->gocheck();`]
+ 例如：自定义ID必须为正整数验证器：
    ```php
    <?php
    namespace app\api\validate;
    use app\api\validate\BaseValidate;
    /***
     * [验证器子类：ID必须为正整数]
     */
    class IDMustBePositiveInt extends BaseValidate{
        protected $rule = [
            "id"=>"require|isPositiveInt",
        ];
        protected $message = [
            "id"=>"id必须是正整数"
        ];
    }
    ```
    使用该验证器：
    ```php
    // 使用前 请引入该验证器的命名空间
    (new IDMustBePositiveInt())->gocheck();
    ```

## 十二、Service层和Model层的区别
+ 与数据表紧密相关的操作写在Model层。
+ 与数据表无关紧要的操作写在Service层。（如：Token生成与验证）
+ 目前已写出小程序端Token生成与验证。
### service层中的Token类
+ post提交内容时，为保证数据安全，携带token进行提交，不要提交用户的user_id。
+ user_id由Token类从缓存中解析出来。
+ 根据Token获取user_id
    ```php
    // 根据token 获取用户uid
    // 使用前引入命名空间  use app\api\service\Token as TokenService;
    $user_id = TokenService::getCurrentUid();
    ```
## 十三、路由
+ 采用定义路由模式。
+ 采用强制路由模式【已设置】。
+ 采用 `get\post\delete\put` 四类。
+ 获取数据采用 `get` ;新增数据采用 `post` ;删除数据采用 `delete` ;更新数据采用 `put` 。
+ 可以使用路由分组的 请使用路由分组。【TP框架文档说使用路由分组效率高】
+ `route.php` 内部有一个例子。
+ `api/:version/` 为固定前缀。

## 十四、其他
+ 控制器采用分版本模式【方便升级，重写原有方法】