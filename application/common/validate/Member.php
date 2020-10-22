<?php


namespace app\common\validate;


use think\Validate;

class Member extends Validate
{

    protected $rule = [
        'username|用户名' => 'require|unique:member',
        'nickname|昵称' => 'require',
        'email|邮箱' => 'require|email',
        'password|密码' => 'require',
        'conpass|确认密码' => 'require|confirm:password',
        'verify|验证码'=> 'require'
    ];

    //添加会员场景
    public function sceneMemberadd(){
        return $this->only([
            'username','password','nickname','email',
        ]);
    }


    //编辑会员用户场景
    public function sceneMemberedit(){
        return $this->only([
            'username','password','nickname','email',
        ]);
    }

    //用户注册场景
    public function sceneRegister(){
        return $this->only([
            'username','password','nickname','email','conpass','verify'
        ]);
    }


    //用户登录验证场景
    public function sceneLogin(){
        return $this->only([
            'username','password','verify'
        ])->remove('username','unique');
    }



}