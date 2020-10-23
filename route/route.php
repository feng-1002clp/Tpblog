<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006~2018 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------

Route::get('think', function () {
    return 'hello,ThinkPHP5!';
});

/*test测试附近门店数据显示*/
\think\facade\Route::rule('dirfiles', 'index/baobiao/dirfiles', 'get|post');
\think\facade\Route::rule('getFiles', 'index/baobiao/getFiles', 'get|post');
\think\facade\Route::rule('baobiao', 'index/baobiao/index', 'get|post');
\think\facade\Route::rule('nearbyme', 'index/baobiao/nearbyme', 'get|post');
\think\facade\Route::rule('cate/:id', 'index/index/index', 'get');
\think\facade\Route::rule('article-<id>', 'index/article/info', 'get');
\think\facade\Route::rule('/comment', 'index/article/comment', 'post');
\think\facade\Route::rule('/register', 'index/index/register', 'get|post');
\think\facade\Route::rule('/login/[:username]', 'index/index/login', 'get|post');
\think\facade\Route::rule('/loginout', 'index/index/loginout', 'post');
\think\facade\Route::rule('/search/[:keyword]', 'index/index/search', '');
\think\facade\Route::group('index', function () {
    \think\facade\Route::rule('/', 'index/index/index', 'get');
});


\think\facade\Route::group('admin', function () {
    \think\facade\Route::rule('', 'admin/index/index',
        'get|post');
    \think\facade\Route::rule('/', 'admin/index/index',
        'get|post');
    \think\facade\Route::rule('/login', 'admin/index/login',
        'get|post');
    \think\facade\Route::rule('/register', 'admin/index/register',
        'get|post');
    \think\facade\Route::rule('/forget', 'admin/index/forget',
        'get|post');
    \think\facade\Route::rule('/verify', 'admin/index/verify',
        'get');
    \think\facade\Route::rule('/personal', 'admin/index/personal',
        'get|post');
    \think\facade\Route::rule('/postpersonal', 'admin/index/postpersonal',
        'post');
    \think\facade\Route::rule('/pwdchanged', 'admin/index/pwdchanged',
        'post');

    \think\facade\Route::rule('/index', 'admin/home/index',
        'get|post');
    \think\facade\Route::rule('/loginout', 'admin/home/loginout',
        'post');

    \think\facade\Route::rule('/catelist', 'admin/cate/catelist',
        'get|post');
    \think\facade\Route::rule('/cateadd', 'admin/cate/cateadd',
        'get|post');
    \think\facade\Route::rule('/catesort', 'admin/cate/catesort',
        'get|post');
    \think\facade\Route::rule('/cateedit/[:id]', 'admin/cate/cateedit',
        'get|post');
    \think\facade\Route::rule('/catedel/[:id]', 'admin/cate/catedel',
        'get|post');

    \think\facade\Route::rule('/articlelist', 'admin/article/articlelist',
        'get|post');
    \think\facade\Route::rule('/articleadd', 'admin/article/articleadd',
        'get|post');
    \think\facade\Route::rule('/articledel', 'admin/article/articledel',
        'post');
    \think\facade\Route::rule('/articleedit/[:id]', 'admin/article/articleedit',
        'get|post');
    \think\facade\Route::rule('/articleistop', 'admin/article/articleistop',
        'post');


    \think\facade\Route::rule('/memberlist', 'admin/member/memberlist',
        'get|post');
    \think\facade\Route::rule('/memberadd', 'admin/member/memberadd',
        'get|post');
    \think\facade\Route::rule('/memberdel', 'admin/member/memberdel',
        'post');
    \think\facade\Route::rule('/memberedit', 'admin/member/memberedit',
        'get|post');


    \think\facade\Route::rule('/adminlist', 'admin/admin/adminlist',
        'get|post');
    \think\facade\Route::rule('/adminadd', 'admin/admin/adminadd',
        'get|post');
    \think\facade\Route::rule('/adminissuper', 'admin/admin/adminissuper',
        'get|post');
    \think\facade\Route::rule('/adminedit', 'admin/admin/adminedit',
        'get|post');
    \think\facade\Route::rule('/admindel', 'admin/admin/admindel',
        'get|post');
    \think\facade\Route::rule('/phpinfo', 'admin/admin/phpinfo',
        'get');
    \think\facade\Route::rule('/webhook', 'admin/admin/webhook',
        'get');


});


Route::get('hello/:name', 'index/hello');

return [

];


