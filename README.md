SimpleTask project
========================
 * 项目根目录下运行 `composer update`。
 * 在 config\database.php里配置数据库参数,或者可按文档提供的.envf方式添加配置信息。
 * 从qq群上传的sql文件里导入数据库结构。
 * 运行 `php artisan db:seed` 生产测试数据,目前只设置了分类数据。
 * Controller 前后台代码分别在app/Http/Controllers/Site和同级目录Admin目录里。
 * Models在app/Models目录内,Model核心方法为Search,可参考Category Model的写法。
 ###[TODO]
 * Oauth2 machanism setup for rest api
 * Theme machanism setup
 * Block function setup
