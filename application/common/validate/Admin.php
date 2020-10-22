<?php


namespace app\common\validate;


use think\Validate;

class Admin extends Validate
{

    protected $rule = [
        'username|管理员账户' => ['require', 'max' => 25, 'regex' => '/^[\w|\d]\w+/'],
        'password|密码' => 'require',
        'repassword|确认密码' => 'require|confirm:password',
        'nickname|昵称' => 'require',
        'email|邮箱' => 'require|email',
        'is_super|超级管理员权限' => 'require'
        ];

    protected $message = [
        'username.require' => '用户名不能为空',
        'username.max' => '用户名最多不能超过25个字符',
        'username.regex' => '用户名不得出现/^[\w|\d]\w+/字符',
        'password.require' => '密码不能为空',
        'repassword.confirm' => '两次输入的密码不一致',
        'nickname.require' => '昵称不能为空',
        'email.require' => '邮箱不能为空'
    ];


    //登录验证场景
    public function sceneLogin()
    {
        return $this->only(['username', 'password']);
    }

    //注册场景验证
    public function sceneRegister()
    {
        return $this->only([
            'username', 'password', 'repassword', 'email', 'nickname'])
            ->append('username', 'unique:admin');
    }

    //找回密码场景验证
    public function sceneForget()
    {
        return $this->only([
            'username','email'
        ]);

    }

    //密码更改
    public function scenePwdchanged(){
        return $this->only([
            'username','email','password', 'repassword',
        ]);
    }

    //更改管理员权限操作
    public function sceneAdminissuper(){
        return $this->only(['is_super']);
    }




}