# merjiezoMVC：轻量级，好用，尚在更新

这是一个很年轻的框架，刚刚开始编写，很多功能尚在开发

为什么会编写这个框架呐，因为具体在给小朋友培训的时候，发现其实就技术方面很难在短时间形成，因为这个，所以编写出这个框架，让小伙伴能够更加快的上手，从这个微型框架上学到一些内容。当然，作为一名大学狗，还有很多需要学习，很多需要改进的，有任何的问题，欢迎邮件到我的邮箱：

**535381437@qq.com.**

## 程序入口（index.php）＋介绍文件目录

* 程序只有唯一入口！入口是index.php,程序猿不需要对其进行修改即可直接使用。
* config文件夹：     默认设置（数据库相关的内容）
* controller文件夹： 控制逻辑文件的存放位置
* lib文件夹：        框架核心逻辑文件位置
* models文件夹：     模型类文件位置
* public文件夹：     静态文件存放位置
* view文件夹：       html页面、缓存文件和布局文件存放位置

##角色控制（代码实现简单的角色控制）

```php
//rules is the function that cannot into this website page
//Guest is can show method

 public function behaviors() {
  return [
      'rules' => [
          [
              'actions'        => ['act22'],
              'matchAuthority' => $this->getSession('status', 1),
          ],
          [
              'actions'        => ['authority1'],
              'matchAuthority' => $this->getSession('status', 2),
          ],
          //游客
          [
              'actions'        => ['authority1', 'act22'],
              'matchAuthority' => $this->getSession('status', 0),
          ],
      ],
  ];
 }

```

##路由的catchAll
这是维护模式，默认为空，不为空的话，就跳转到指定页面！！！！

## controller文件夹

请先导入这个文件：include ('lib/MController.php');

通过URL，GET值r，r变量由两个内容组成，中间由斜杠分开：所以URL下的site/index的控制代码就写在SiteController.php文件夹下的Index方法下

例子：localhost/merjiezoMVC/index.php?r=site/index

注意⚠️：一定要按照这个命名规则命名，否则路由会因为定位不到报404错误❌

如果想要定位到view下的html文件，请在最后加上
	return $this->router('index');
这样会定位到这个文件名对应文件夹下的index.html文件，框架会读取文件显示在页面上

## models文件

＊这个文件下所有的文件命名方式是更具数据库表内的名字命名

注：一定要加上构造方法：（自动获取表名）

```php
	public function __construct() {
		$this->tableName = __CLASS__;
	}
```
models下的方法：
findOnlyOne方法、fingOneRecord、encrypt、jsonGet、Search、InsertInto、UpdateData、deleteOneRecord等。

###下面介绍罪行编写的PDO连接如何使用

```php
$sql     = 'SELECT * FROM studentlist';
$connect = new Connection();
print_r($connect->createCommand($sql)->queryOne());

//获取所有
$connect->createCommand($sql)->queryAll();

//获取一条记录
$connect->createCommand($sql)->queryOne();

$connect->createCommand()->insert('tableName', [
        'Column' => '1',
        'name'   => 'merjiezo',
    ]);

$connect->createCommand()->update('tableName', [
        'Column' => '1',
    ], [
        'id' => '6',
    ]);

$connect->createCommand()->delete('tableName', [
        'Column' => '1',
        'name'   => 'merjiezo',
    ]);
```

## 当然，现在就完成了部分功能，还有更多功能等待开发

## 如果你喜欢，请关注我，非常欢迎大家来纠错！