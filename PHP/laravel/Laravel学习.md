1. Laravel常用的插件：

   > - [barryvdh/laravel-ide-helper](https://github.com/barryvdh/laravel-ide-helper)
   > - [barryvdh/laravel-debugbar](https://github.com/barryvdh/laravel-debugbar)
   > - [briannesbitt/Carbon](https://github.com/briannesbitt/Carbon)
   > - [EasyWeChat](https://www.easywechat.com/) 
   > - [Guzzle](http://guzzle-cn.readthedocs.io/zh_CN/latest/quickstart.html)
   > - [Faker](https://github.com/fzaninotto/Faker)
   > - [Intervention/image](https://github.com/Intervention/image)
   > - [predis/predis](http://github.com/nrk/predis)
   > - [overtrue/laravel-lang](https://github.com/overtrue/laravel-lang)

2. 路由文件中通过`\`作为路由层级分割线。

   ###### 如： `Route::get('/','Home\IndexController@index');`

3. 获取`config`目录配置文件的参数

   ###### 如：`config('app.cipher')`或者`Illuminate\Support\Facades\Config::get('app.cipher')`

4. Laravel关于`php artisan key:generate --ansi`的分析：

   使用了`random_bytes ( int $length ) `方法，该方法使用版本为`PHP > 7.0`

   具体分析：

   ```php
   // 获取加密规则
   $cipher = Config::get('app.cipher');
   // 获取随机字符串
   $randomStr = random_bytes($cipher === 'AES-128-CBC' ? 16 : 32);
   // base64加密
   return 'base64:' . base64_encode($randomStr);
   ```

   [PHP 5.x 支持`random_bytes()` 和`random_int()`](https://github.com/paragonie/random_compat)

5. Laravel有`维护模式`，通过`php artisan down`启用，使用`php artisan up`关闭维护模式。

   通过修改 `resources/views/errors/503.blade.php` 模板文件来自定义默认维护模式模板。

6. `routes/web.php`提供了会话状态和 CSRF 保护等功能。 `routes/api.php` 中的路由都是无状态的，并且被分配了 `api` 中间件组。会自动添加 URL 前缀 `/api` 到此文件中的每个路由

7. Laravel的路由和ThinkPHP的路由大不一致。有时间研究。 [地址](https://learnku.com/docs/laravel/5.8/routing/3890)

8. 使用cmder代替git bash

   ![使用cmder代替git bash](https://raw.githubusercontent.com/Eachone-coder/aboutMe/master/image/Snipaste_2019-08-09_10-12-48.png)

9. 使用bat命令通过notepad++快速编辑host

   ```bash
   ::去除hosts文件只读属性
   attrib -R C:\windows\system32\drivers\etc\hosts
   
   ::用notepad编辑hosts文件
   cd C:\laragon\bin\notepad++
   start notepad++ C:\windows\system32\drivers\etc\hosts
   ```

   ![使用bat命令通过notepad++快速编辑host](https://raw.githubusercontent.com/Eachone-coder/aboutMe/master/image/Snipaste_2019-08-09_10-11-42.png)

10. [Laravel的Homestead搭建](https://learnku.com/search?q=Homestead%E6%90%AD%E5%BB%BA) 和 [如何使用 Homestead 作为 thinkphp tp5 的开发环境](https://blog.csdn.net/weixin_33735077/article/details/87665611)

11. [laravel打印执行的Sql语句](https://www.iphpt.com/detail/75)

    > - 创建查询监听
    >
    >     ```php
    >     php artisan make:listener QueryListener
    >     ```
    >
    > - 修改handle方法
    >
    > ```php
    > ...
    > use Illuminate\Database\Events\QueryExecuted;
    > use Illuminate\Support\Facades\Log;
    > ...
    > public function handle(QueryExecuted $event)
    > {
    >     $sql = str_replace("?", "'%s'", $event->sql);
    >     $log = vsprintf($sql, $event->bindings);
    >     Log::info($log);
    > }
    > ```
    >
    > - 在`app/Providers/EventServiceProvider.php`的`$listen` 中添加:
    >
    > ```php
    > ...
    > use Illuminate\Database\Events\QueryExecuted;
    > use App\Listeners\QueryListener;
    > ...
    > protected $listen = [
    >     ...
    >     QueryExecuted::class => [
    >         QueryListener::class,
    >     ]
    > ];
    > 
    > ```

12. **限制游客访问**：针对未登录用户可以访问需要登录才能访问的操作，使用 Laravel 提供身份验证（Auth）中间件来过滤未登录用户，如果用户未通过身份验证，则 Auth 中间件会把用户重定向到登录页面。如果用户通过了身份验证，则 Auth 中间件会通过此请求并接着往下执行。

    在控制器中可以这样用：

    ```php
    $this->middleware('auth', ['except' => ['index', 'show']]);
    ```

    `'except' => ['index', 'show']` —— 对除了 `index()` 和 `show()` 以外的方法使用 `auth` 中间件进行认证。

13. **用户只能编辑自己的资料** ：针对登录用户可以更新其它用户的个人信息，使用 [授权策略 (Policy)](https://learnku.com/docs/laravel/5.8/authorization#policies) 来对用户的操作权限进行验证，在用户未经授权进行操作时将返回 403 禁止访问的异常。

14. **自定义辅助函数**：存放于 `app/helpers.php` 文件中

    > - `$ touch app/helpers.php`创建helpers.php文件
    >
    > - 项目根目录下 `composer.json` 文件中的 `autoload` 选项里 `files` 字段加入该文件
    >
    >   ![](<https://raw.githubusercontent.com/Eachone-coder/aboutMe/master/image/Snipaste_2019-08-13_09-05-18.png>)
    >
    > - `$ composer dump-autoload`

15. **数据模型作用**：

    > - 创建数据模型
    >
    > ```shell
    > php artisan make:model Models/Category -m
    > ```
    >
    > `-m` 选项意为顺便创建数据库迁移文件（Migration）
    >
    > - 属性`$fillable`表示字段支持修改，格式为数组格式
    >
    > ```php
    > protected $fillable = [
    > 	'name', 'description',
    > ];
    > ```
    >
    > - 定义模型之间的关联关系（[模型关联](https://learnku.com/docs/laravel/5.8/eloquent-relationships/3932)）
    >
    >   > - [一对一](https://learnku.com/docs/laravel/5.8/eloquent-relationships/3932#one-to-one)
    >   > - [一对多](https://learnku.com/docs/laravel/5.8/eloquent-relationships/3932#one-to-many)
    >   > - [多对多](https://learnku.com/docs/laravel/5.8/eloquent-relationships/3932#many-to-many)
    >   > - [远程一对一](https://learnku.com/docs/laravel/5.8/eloquent-relationships/3932#has-one-through)
    >   > - [远程一对多](https://learnku.com/docs/laravel/5.8/eloquent-relationships/3932#has-many-through)
    >   > - [一对一 (多态关联)](https://learnku.com/docs/laravel/5.8/eloquent-relationships/3932#one-to-one-polymorphic-relations)
    >   > - [一对多 (多态关联)](https://learnku.com/docs/laravel/5.8/eloquent-relationships/3932#one-to-many-polymorphic-relations)
    >   > - [多对多 (多态关联)](https://learnku.com/docs/laravel/5.8/eloquent-relationships/3932#many-to-many-polymorphic-relations)
    >
    > - *本地作用域*^△^ （允许定义通用的约束集合以便在应用程序中重复使用）
    >
    >   本地作用域允许我们定义通用的约束集合以便在应用中复用。要定义这样的一个作用域，只需简单在对应 Eloquent 模型方法前加上一个 scope 前缀，作用域总是返回 [查询构建器](https://learnku.com/docs/laravel/5.8/queries)。一旦定义了作用域，则可以在查询模型时调用作用域方法。在进行方法调用时不需要加上 scope 前缀。如以下代码中的 `recent()` 和 `recentReplied()`
    >
    > ```php
    > ...
    > use Illuminate\Database\Eloquent\Builder;
    > ...
    > 
    > ...
    > 
    > public function scopeWithOrder($query, $order)
    > {
    >     // 不同的排序，使用不同的数据读取逻辑
    >     switch ($order) {
    >         case 'recent':
    >             $query->recent();
    >             break;
    >         default:
    >             $query->recentReplied();
    >             break;
    >     }
    >     // 预加载防止 N+1 问题
    >     return $query->with('user', 'category');
    > }
    > 
    > public function scopeRecentReplied($query)
    > {
    >     return $query->orderBy('updated_at', 'desc');
    > }
    > 
    > public function scopeRecent($query)
    > {
    >     return $query->orderBy('created_at', 'desc');
    > }
    > ...
    >    
    > 
    > 使用：
    > $users = User::popular()->orderBy('created_at')->get();
    > ```
    >
    > - 

16. **初始化数据**

    > - 创建
    >
    > `php artisan make:migration seed_{table_name}_data`
    >
    > - 创建数据
    >
    > ```php
    > public function up()
    > {
    >     $values = [
    >         [
    >             '{field}' => '{value}',
    >         ],
    >         ...
    >     ];
    >     DB::table('{table_name}')->insert($values);
    > }
    > 
    > public function down()
    > {
    >     DB::table('{table_name}')->truncate();
    > }
    > ```
    >
    > 

17. **数据填充**

    *下方以User模型为例：*

    > 相关文件：
    >
    > 1. 数据模型 User.php
    > 2. 用户的数据工厂 database/factories/UserFactory.php
    > 3. 用户的数据填充 database/seeds/UsersTableSeeder.php
    > 4. 注册数据填充 database/seeds/DatabaseSeeder.php
    >
    > 步骤：
    >
    > - 创建数据模型
    >
    > `php artisan make:model Models/User -m`
    >
    > - 设置数据工厂
    >
    > `php artisan make:factory UserFactory`
    >
    > ```php
    > use App\Models\User;
    > use Faker\Generator as Faker;
    > use Illuminate\Database\Eloquent\Factory;
    > use Illuminate\Support\Str;
    > 
    > /**
    > * @var Factory $factory
    > */
    > $factory->define(User::class, function (Faker $faker) {
    > return [
    >     'username' => $faker->name,
    >     ...
    > ];
    > });
    > ```
    >
    > - 数据填充
    >
    > `php artisan make:seeder UsersTableSeeder`
    >
    > ```php
    > ...
    > use App\Models\User;
    > ... 
    > public function run(){
    > // 准备数据
    > $avatars = ...;
    > ...
    > // 获取 Faker 实例
    > $faker = app(Faker\Generator::class);
    > 
    > $users = factory(User::class)
    >                 ->times(10)
    >                 ->make()
    >                 ->each(function ($user, $index) use ($avatars, $faker){
    >                      // 从头像数组中随机取出一个并赋值
    >                      $user->avatar = $faker->randomElement($avatars);
    >                      ...
    >             });
    > 
    > // 将数据集合转换为数组，并插入到数据库中
    > User::insert($users->toArray());
    > }
    > 
    > ```
    >
    > - 注册数据填充
    >
    > 在*database/seeds/DatabaseSeeder.php* 
    >
    > ```php
    > public function run()
    > {
    > $this->call(UsersTableSeeder::class);
    > }
    > ```
    >
    > -  执行数据填充命令
    >
    > `php artisan migrate:refresh --seed`
    >
    > 
    >
    > *☆☆☆ 对于模型中隐藏 `$hidden` 的字段，需要使用 makeVisible () 方法来暂时停止 hidden, 避免写入数据库时出错*
    >
    > *☆☆☆ Laravel Eloquent：临时禁用 Laravel 的模型观察者：`Model::unsetEventDispatcher();`，Model为对应的模型*

18. **模型事件监控器:Observer (观察者|模型观察器)**

    参考资料[☟☟☟](https://learnku.com/articles/6657/model-events-and-observer-in-laravel)

    Eloquent 模型会触发许多事件（Event），我们可以对模型的生命周期内多个时间点进行监控： creating, created, updating, updated, saving, saved, deleting, deleted, restoring, restored。事件让你每当有特定的模型类在数据库保存或更新时，执行代码。当一个新模型被初次保存将会触发 `creating` 以及 `created` 事件。如果一个模型已经存在于数据库且调用了 `save` 方法，将会触发 `updating` 和 `updated` 事件。在这两种情况下都会触发 `saving` 和 `saved` 事件。

    Eloquent 观察器允许我们对给定模型中进行事件监控，观察者类里的方法名对应 Eloquent 想监听的事件。每种方法接收 `model` 作为其唯一的参数。代码生成器已经为我们生成了一个观察器文件，并在 `AppServiceProvider` 中注册。

    方法一：（以User为例：将用户的名称置为小写字母）

    > - 创建观察器文件，一个普通类，不需要继承什么
    >
    > ```php
    > class UserObserver
    > {
    >   	...
    > }
    > ```
    >
    > - 针对需要的事件，编写对应的 `~ing` 或 `~ed` 方法，方法接收 `model` 作为唯一参数
    >
    > ```php
    > ...
    > public function saving(User $user)
    > {
    >     $user->username = strtolower($user->username);
    > }    
    > ...    
    > ```
    >
    > - 在 `AppServiceProvider` 中注册或者在`UserModel`的`boot()`中使用
    >
    > ```php
    > // 在 AppServiceProvider 方法中
    > use ...
    > ...
    > public function boot(User $user)
    > {
    >     ...
    >     User::observe(UserObserver::class);
    >     ...
    > }
    > ...
    > 
    > ```

    方法二：

    > ```php
    >     // 在 YourModel 方法中
    >     ...
    >     protected static function boot()
    >     {
    >         parent::boot(); // TODO: Change the autogenerated stub
    >     
    >         // 监听模型创建事件，在写入数据库前触发
    >         static::creating(function ($model) {
    >             ...
    >         });
    >     }
    >     ...
    > ```

19. **数据库**

    > - 索引很多时不利于数据库进行 insert，delete，update 的操作，因为 数据变更后会在进行维护和 索引的重新建立，如果where条件用了索引，速度自然是快。但是update对位图索引消耗的代价比较大，索引对查询有利，但是对DML操作都是有负担的，特别是insert，delete操作，会产生大量的回退、日志，并且不会回收高水位，自然会产生性能影响

20. **Laravel新增**

    > ```php
    > DB::table('articles')->insert($data);
    > ```
    >
    > 不会触发模型观察器
    >
    > ```php
    > Article::insert($data);
    > ```
    >
    > 不会触发模型观察器
    >
    > ```php
    > Article::create($data);
    > ```
    >
    > 会触发模型观察器，必须设置`$fillable`属性
    >
    > ```php
    > $article->title = '测试标题';
    > $article->content = '测试内容';
    > $result4 = $article->save();
    > ```
    >
    > 会触发模型观察器
    >
    > 
    >
    > 前面两个`insert()`调用的是`Illuminate\Database\Query\Builder`，支持传入多维格式相同的数组
    >
    > 后面两个`create()`调用的是` Illuminate\Database\Eloquent\Model`

21. *faker 类`randomElement ()`*

    > `array_random()` 和`randomElement()` 
    >
    > - `array_random () `实际上是借助了 PHP 原生函数 [array_rand](https://secure.php.net/manual/en/function.array-rand.php), 它产生的是伪随机数。
    > - `randomElement ()` 借助了 [mt_rand](https://secure.php.net/manual/en/function.mt-rand.php)，它产生的是一个质量更好，速度更快的随机数。

22. *seed 文件中声明 faker 实例时使用 `app()` 方法*

    > `app()` 方式是去容器中获取
    >
    > 直接声明：`$faker = Faker\Factory::create ()`

23. **laravel-debugbar**

    > - 安装
    >
    >   ```sh
    >   composer require "barryvdh/laravel-debugbar:~3.1" --dev
    >   ```
    >
    > - 生成配置文件 `config/debugbar.php`
    >
    >   ```sh
    >   php artisan vendor:publish --provider="Barryvdh\Debugbar\ServiceProvider"
    >   ```
    >
    > - 配置启用条件
    >
    >   ```php
    >   // config/debugbar.php
    >   
    >   'enabled' => env('APP_DEBUG', false),
    >   ```

24. **Laravel 中解决 N + 1 问题**

    >- 使用预加载功能
    >- 使用`with()`方法，会做缓存，`with()` 中放需要查询的关联属性

25. ~~Laravel中的先关联在筛选和先筛选在关联返回数据的结果有差异？~~

    ~~如：先`with()`在`where()`和先`where()`在`with()`返回数据的结果在有些情况下是差异~~

    ~~前者是在关联的结果里面筛选，后者是先筛选在列出关联数据~~

26. **「Mass Assignment」安全问题 **：将一大堆数据同时传递给模型的 `create()` 方法来新建一行的方式

    `Laravel` 提供了保护 `Mass-Assignment` 的方法，那就是在模型上定义 `fillable` 或 `guarded` 的属性。在执行 `create()` 方法时，`Eloquent` 模型会先使用 `fill()` 方法对数据进行过滤，去掉 `$fillable`以外的字段（白名单），或去掉 `$guarded` 中的字段（黑名单），来保证只获取预期的表单字段。参考文章  [☟☟☟](https://learnku.com/articles/6096/the-real-meaning-of-laravel-mass-assignment-batch-assignment)

27. **表单验证类**

    命名空间：`\app\Http\Requests`

    ```php
    class UserRequest extends FormRequest
    {
        /**
         * 确定是否授权用户发出此请求
         */
        public function authorize()
        {
            return true;
        }
    
        /**
         * 获取应用于请求的验证规则
         */
        public function rules()
        {
            return [
                'title' => 'required|unique:posts|max:255',
                //
            ];
        }
        /**
     	* 获取已定义验证规则的错误消息
     	*/
        public function messages()
        {
            return [
                'title.required' => 'A title is required',
            ];
        }
        /**
     	* 获取验证错误的自定义属性。
     	*
     	* @return array
     	*/
        public function attributes()
        {
            return [
                'email' => 'email address',
            ];
        }
    }
    ```

28. **XSS 安全漏洞**

    XSS 也称跨站脚本攻击 (Cross Site Scripting)，恶意攻击者往 Web 页面里插入恶意 JavaScript 代码，当用户浏览该页之时，嵌入其中 Web 里面的 JavaScript 代码会被执行，从而达到恶意攻击用户的目的。

    一种比较常见的 XSS 攻击是 Cookie 窃取。我们都知道网站是通过 Cookie 来辨别用户身份的，一旦恶意攻击者能在页面中执行 JavaScript 代码，他们即可通过 JavaScript 读取并窃取你的 Cookie，拿到你的 Cookie 以后即可伪造你的身份登录网站。（扩展阅读 —— [IBM 文档库：跨站点脚本攻击深入解析 ](https://www.ibm.com/developerworks/cn/rational/08/0325_segal/)）

    有两种方法可以避免 XSS 攻击：

    - 第一种，对用户提交的数据进行过滤；
    - 第二种，Web 网页显示时对数据进行特殊处理，一般使用 `htmlspecialchars()` 输出。

    附：

    [浅谈 XSS 攻击的那些事（附常用绕过姿势）](https://zhuanlan.zhihu.com/p/26177815)

29. *打印Sql语句*

    ```php
    \DB::enableQueryLog();
    
    // 这里写查询
    
    dd(\DB::getQueryLog());
    ```

30. **问题：视图异常报错**

    ![](E:/github/aboutMe/image/Snipaste_2019-08-15_10-53-11.png)

    ​		原因：在 `resources/views/layouts/app.blade.php` 中使用 `mix()` 方法，而我们还未运行 Laravel Mix 进行编译，找不到 `mix-manifest.json` 文件，所以报错

    ​		解决：**运行 Laravel Mix**

    Laravel Mix 一款前端任务自动化管理工具，使用了工作流的模式对制定好的任务依次执行。Mix 提供了简洁流畅的 API，让你能够为你的 Laravel 应用定义 Webpack 编译任务。Mix 支持许多常见的 CSS 与 JavaScript 预处理器，通过简单的调用，你可以轻松地管理前端资源。

    使用 Mix 很简单，首先你需要使用以下命令安装 npm 依赖即可。我们将使用 Yarn 来安装依赖，在这之前，因为国内的网络原因，我们还需为 Yarn 配置安装加速：

    ```php
    $ yarn config set registry https://registry.npm.taobao.org
    ```

    使用 Yarn 安装依赖：

    ```bash
    $ yarn install
    ```

    安装成功后，运行以下命令即可：

    ```bash
    $ npm run watch-poll
    ```

    `watch-poll` 会在你的终端里持续运行，监控 `resources` 文件夹下的资源文件是否有发生改变。在 `watch-poll`命令运行的情况下，一旦资源文件发生变化，Webpack 会自动重新编译。

31. **数据迁移**

    - 自定义模型中的创建时间和修改时间，定义软删除字段

      ```php
      // 创建时间，默认为当前时间
      $table->timestamp('created_at')->nullable(false)->default(DB::raw('CURRENT_TIMESTAMP'));
      // 修改时间，默认为当前修改时间
      $table->timestamp('updated_at')->nullable(false)->default(DB::raw('CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP'));
      // 软删除时间，默认为空
      $table->softDeletes();
      ```

    - 执行回滚或迁移

      `php artisan migrate:refresh --seed`

32. **用户认证脚手架**

    - 首先执行认证脚手架命令，生成代码：

      ```bash
      $ php artisan make:auth
      ```

    - 替换路由文件中的

      ```php
      Auth::routes();
      ```

      替换为：

      ```php
      // 用户身份验证相关的路由
      Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
      Route::post('login', 'Auth\LoginController@login');
      Route::post('logout', 'Auth\LoginController@logout')->name('logout');
      
      // 用户注册相关路由
      Route::get('register', 'Auth\RegisterController@showRegistrationForm')->name('register');
      Route::post('register', 'Auth\RegisterController@register');
      
      // 密码重置相关路由
      Route::get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('password.request');
      Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
      Route::get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset');
      Route::post('password/reset', 'Auth\ResetPasswordController@reset')->name('password.update');
      
      // Email 认证相关路由
      Route::get('email/verify', 'Auth\VerificationController@show')->name('verification.notice');
      Route::get('email/verify/{id}', 'Auth\VerificationController@verify')->name('verification.verify');
      Route::get('email/resend', 'Auth\VerificationController@resend')->name('verification.resend');
      ```

33. **Laravel使用验证码**

    

34. **Laravel 登录与登出**

    

35. **Laravel 集合（Collection）**

    [☟☟☟点击跳转原网址](https://learnku.com/laravel/t/27647)

    ## filter()

    filter，最有用的 laravel 集合方法之一，允许您使用回调过滤集合。 它只传递那些返回 true 的项。 所有其他项目都被删除。 `filter` 返回一个新实例而不更改原始实例。 它接受 `value` 和 `key` 作为回调中的两个参数。

    ```php
    $filter = $collection->filter(function($value, $key) {
        if ($value['user_id'] == 2) {
            return true;
        }
    });
    ```

    ## search()

    `search` 方法可以用给定的值查找集合。如果这个值在集合中，会返回对应的键。如果没有数据项匹配对应的值，会返回 `false`。

    ```php
    $names = collect(['Alex', 'John', 'Jason', 'Martyn', 'Hanlin']);
    
    $names->search('Jason');
    
    // 2
    ```

    `search` 方法默认使用松散比较。你可以在它的第二个参数传 `true` 使用严格比较。

    你也可以传你自己的回调函数到 `search` 方法中。将返回通过回调真值测试的第一个项的键。

    ```php
    $names = collect(['Alex', 'John', 'Jason', 'Martyn', 'Hanlin']);
    
    $names->search(function($value, $key) {
        return strlen($value) == 6;
    });
    
    // 3
    ```

    ## chunk()

    `chunk` 方法将集合分割为多个给定大小的较小集合。将集合显示到网格中非常有用。

    ```php
    $prices = collect([18, 23, 65, 36, 97, 43, 81]);
    
    $prices = $prices->chunk(3);
    
    $prices->toArray();
    ```

    以上代码生成效果。

    ```php
    [
        0 => [
            0 => 18,
            1 => 23,
            2 => 65
        ],
        1 => [
            3 => 36,
            4 => 97,
            5 => 43
        ],
        2 => [
            6 => 81
        ]
    ]
    ```

    ## map()

    `map` 方法用于遍历整个集合。 它接受回调作为参数。 `value` 和 `key` 被传递给回调。 回调可以修改值并返回它们。 最后，返回修改项的新集合实例。

    ```php
    $changed = $collection->map(function ($value, $key) {
        $value['user_id'] += 1;
        return $value;
    });
    
    return $changed->all();
    ```

    基本上，它将 `user_id` 增加 1。

    上面代码的响应如下所示。

    ```php
    [
        [
            "user_id" => 2,
            "title" => "Helpers in Laravel",
            "content" => "Create custom helpers in Laravel",
            "category" => "php"
        ],
        [
            "user_id" => 3,
            "title" => "Testing in Laravel",
            "content" => "Testing File Uploads in Laravel",
            "category" => "php"
        ],
        [
            "user_id" => 4,
            "title" => "Telegram Bot",
            "content" => "Crypto Telegram Bot in Laravel",
            "category" => "php"
        ]
    ];
    ```

    ## zip()

    Zip 方法会将给定数组的值与集合的值合并在一起。相同索引的值会添加在一起，这意味着，数组的第一个值会与集合的第一个值合并。在这里，我会使用我们在上面刚刚创建的集合。这对 Eloquent 集合同样有效。

    ```php
    $zipped = $collection->zip([1, 2, 3]);
    
    $zipped->all();
    ```

    如果数组的长度小于集合的长度，Laravel 会给剩下的 `Collection` 类型的元素末尾添加 `null`。类似地，如果数组的长度比集合的长度大，Laravel 会给 `Collection` 类型的元素添加 `null`，然后再接着数组的值。

    ## whereNotIn()

    您可以使用 `whereNotIn` 方法简单地按照给定数组中未包含的键值过滤集合。 它基本上与 `whereIn` 相反。 此外，此方法在匹配值时使用宽松比较 `==`。

    让我们过滤 `$collection`，其中 `user_id` 既不是 `1` 也不是 `2` 的。

    ```php
    $collection->whereNotIn('user_id', [1, 2]);
    ```

    上面的语句将只返回 `$collection` 中的最后一项。 第一个参数是键，第二个参数是值数组。 如果是 eloquent 的话，第一个参数将是列的名称，第二个参数将是一个值数组。

    

    ## max()

    `max` 方法返回给定键的最大值。 你可以通过调用 max 来找到最大的 `user_id`。 它通常用于价格或任何其他数字之类的比较，但为了演示，我们使用 `user_id`。 它也可以用于字符串，在这种情况下，`Z> a`。

    ```php
    $collection->max('user_id');
    ```

    上面的语句将返回最大的 `user_id`，在我们的例子中是 `3`。

    

    ## pluck()

    `pluck` 方法返回指定键的所有值。 它对于提取一列的值很有用。

    ```php
    $title = $collection->pluck('title');
    $title->all();
    ```

    结果看起来像这样。

    ```php
    [
      "Helpers in Laravel",
      "Testing in Laravel",
      "Telegram Bot"
    ]
    ```

    使用 eloquent 时，可以将列名作为参数传递以提取值。 `pluck` 也接受第二个参数，对于 eloquent 的集合，它可以是另一个列名。 它将导致由第二个参数的值作为键的集合。

    ```php
    $title = $collection->pluck('user_id', 'title');
    $title->all();
    ```

    结果如下：

    ```php
    [
        "Helpers in Laravel" => 1,
        "Testing in Laravel" => 2,
        "Telegram Bot" => 3
    ]
    ```

    

    ## each()

    `each` 是一种迭代整个集合的简单方法。 它接受一个带有两个参数的回调：它正在迭代的项和键。 Key 是基于 0 的索引。

    ```php
    $collection->each(function ($item, $key) {
        info($item['user_id']);
    });
    ```

    上面代码，只是记录每个项的 `user_id`。

    在迭代 eloquent 集合时，您可以将所有列值作为项属性进行访问。 以下是我们如何迭代所有帖子。

    ```php
    $posts = App\Post::all();
    
    $posts->each(function ($item, $key) {
        // Do something
    });
    ```

    如果回调中返回 false，它将停止迭代项目。

    ```php
    $collection->each(function ($item, $key) {
        // Tasks
        if ($key == 1) {
            return false;
        }
    });
    ```

    

    ## tap()

    `tap()` 方法允许你随时加入集合。 它接受回调并传递并将集合传递给它。 您可以对项目执行任何操作，而无需更改集合本身。 因此，您可以在任何时候使用 tap 来加入集合，而不会改变集合。

    ```php
    $collection->whereNotIn('user_id', 3)
        ->tap(function ($collection) {
            $collection = $collection->where('user_id', 1);
            info($collection->values());
        })
        ->all();
    ```

    在上面使用的 tap 方法中，我们修改了集合，然后记录了值。 您可以对 tap 中的集合做任何您想做的事情。 上面命令的响应是：

    ```php
    [
        [
            "user_id" => "1",
            "title" => "Helpers in Laravel",
            "content" => "Create custom helpers in Laravel",
            "category" => "php"
        ],
        [
            "user_id" => "2",
            "title" => "Testing in Laravel",
            "content" => "Testing File Uploads in Laravel",
            "category" => "php"
        ]
    ]
    ```

    你可以看到 tap 不会修改集合实例。

    

    ## pipe()

    `pipe` 方法非常类似于 `tap` 方法，因为它们都在集合管道中使用。 `pipe` 方法将集合传递给回调并返回结果。

    ```php
    $collection->pipe(function($collection) {
        return $collection->min('user_id');
    });
    ```

    上述命令的响应是 `1`。 如果从 `pipe` 回调中返回集合实例，也可以链接其他方法。

    

    ## contains()

    `contains` 方法只检查集合是否包含给定值。 只传递一个参数时才会出现这种情况。

    ```php
    $contains = collect(['country' => 'USA', 'state' => 'NY']);
    
    $contains->contains('USA');
    // true
    
    $contains->contains('UK');
    // false
    ```

    如果将 键 / 值 对传递给 contains 方法，它将检查给定的键值对是否存在。

    ```php
    $collection->contains('user_id', '1');
    // true
    
    $collection->contains('title', 'Not Found Title');
    // false
    ```

    您还可以将回调作为参数传递给回调方法。 将对集合中的每个项目运行回调，如果其中任何一个项目通过了真值测试，它将返回 `true` 否则返回 `false`。

    ```php
    $collection->contains(function ($value, $key) {
        return strlen($value['title']) < 13;
    });
    // true
    ```

    回调函数接受当前迭代项和键的两个参数值。 这里我们只是检查标题的长度是否小于 13。在 `Telegram Bot` 中它是 12，所以它返回 `true`。

    

    ## forget()

    `forget` 只是从集合中删除该项。 您只需传递一个键，它就会从集合中删除该项目。

    ```php
    $forget = collect(['country' => 'usa', 'state' => 'ny']);
    
    $forget->forget('country')->all();
    ```

    上面代码响应如下：

    ```php
    [
        "state" => "ny"
    ]
    ```

    `forget` 不适用于多维数组。

    

    ## avg()

    `avg` 方法返回平均值。 你只需传递一个键作为参数，`avg` 方法返回平均值。 你也可以使用 `average` 方法，它基本上是 `avg` 的别名。

    ```php
    $avg = collect([
        ['shoes' => 10],
        ['shoes' => 35],
        ['shoes' => 7],
        ['shoes' => 68],
    ])->avg('shoes');
    ```

    上面的代码返回 `30` ，这是所有四个数字的平均值。 如果你没有将任何键传递给 `avg` 方法并且所有项都是数字，它将返回所有数字的平均值。 如果键未作为参数传递且集合包含键 / 值对，则 `avg` 方法返回 0。

    ```php
    $avg = collect([12, 32, 54, 92, 37]);
    
    $avg->avg();
    ```

36. **控制反转，依赖注入**

    控制反转

    实例：用户登录需要提供记录日志的功能，可以选择使用文件或者数据库。

    `Log接口类`

    ```php
    // 定义写日志的接口规范
    interface Log
    {
        public function write();   
    }
    ```

    `FileLog类`

    ```php
    // 文件记录日志
    class FileLog implements Log
    {
        public function write(){
            echo 'file log write...';
        }   
    }
    ```

    `DatabaseLog类`

    ```php
    // 数据库记录日志
    class DatabaseLog implements Log
    {
        public function write(){
            echo 'database log write...';
        }   
    }
    ```

    程序操作类

    ```php
    // 程序操作类
    class User 
    {
        protected $fileLog;
    
        public function __construct()
        {
            $this->fileLog = new FileLog();   
        }
    
        public function login()
        {
            // 登录成功，记录登录日志
            echo 'login success...';
            $this->fileLog->write();
        }
    
    }
    
    $user = new User();
    $user->login();
    ```

    上面的写法可以实现记录日志的功能，但是有一个问题，假设现在想用数据库记录日志的话，我们就得修改 User 类，这份代码没达到解耦合，也不符合编程开放封闭原则，那如何修改呢？我们可以把日志处理类通过构造函数方式传递进去。下面我们试着修改 User 类的代码。

    ```php
    class User 
    {
        protected $log;
    
        public function __construct(Log $log)
        {
            $this->log = $log;   
        }
    
        public function login()
        {
            // 登录成功，记录登录日志
            echo 'login success...';
            $this->log->write();
        }
    
    }
    
    $user = new User(new DatabaseLog());
    $user->login();
    ```

    这样想用任何方式记录操作日志都不需要去修改 User 类了，只需要通过构造函数参数传递就可以实现，其实这就是 “控制反转”。不需要自己内容修改，改成由外部传递。这种由外部负责其依赖需求的行为，我们可以称其为 “控制反转（IoC）”。

    那什么是依赖注入呢？，其实上面的例子也算是依赖注入，不是由自己内部 new 对象或者实例，通过构造函数，或者方法传入的都属于 依赖注入（DI） 。

37. 

```shell
php -S localhost:8888 -t public
```

