<?php

namespace app\admin\controller;

use think\captcha\Captcha;
use think\Controller;
use think\Db;

class Index extends Controller
{
    // 初始化   过滤用户重复登录
    public function  initialize()
    {
        if (session('?admin.id')){
            $this->redirect('admin/home/index');
        }
    }

    public function index(){
        return view('login');
    }

    //后台登录功能
    public function login()
    {
        //后台接收数据登录判断验证
        if ($this->request->isAjax()) {
            $data = [
                'username' => input('post.username'),
                'password' => input('post.password')
            ];

            $result = model('Admin')->login($data);
            //由模型层得到验证数据  为1登陆成功且为管理员 为0则返回错误信息
            if ($result == 1) {
                $this->success('登录成功', 'admin/home/index');
            } else {
                $this->error($result);
            }
        }

        return view();
    }


    //后台注册功能
    public function register()
    {

        //后台接收数据注册
        if ($this->request->isAjax()) {
            $data = [
                'username' => input('post.username'),
                'password' => input('post.password'),
                'repassword' => input('post.repassword'),
                'nickname' => input('post.nickname'),
                'email' => input('post.email'),
            ];
            $result = model('Admin')->register($data);
            if ($result == 1) {
                $this->success('注册成功,即将跳转登录页面！', 'admin/index/login');
            } else {
                $this->error($result);
            }

        }


        return view();
    }


    //忘记密码
    public function forget()
    {
        $captcha = new Captcha();
        //后台接收数据 修改密码
        if ($this->request->isAjax()) {
            $data = [
                'username' => input('post.username'),
                'email' => input('post.email'),
                'code' => input('code'),
            ];
            if ($captcha->check($data['code'], 1) == true) {

                $result = model('Admin')->forget($data);

                if (strlen($result) == 6) {
                    $this->success(md5($result), '', $data);
                } else {
                    $this->error($result);
                }
            } else {
                $this->error('验证码错误');
            }


        }

        return view();
    }

    //设置验证码
    public function verify()
    {
        $captcha = new Captcha();
        $captcha->length = 4;
        $captcha->useNoise = true;
        $captcha->fontSize = 50;
        $captcha->fontttf = '4.ttf';
        return $captcha->entry(1);
    }

    //验证码验证 个人中心验证识别页面
    public function personal()
    {

        //后台接收数据注册   Ajax 提交方式
        if ($this->request->isAjax()) {
            $data = $_POST['data'];
            /*$result = model('Admin')->register($data);
            if ($result == 1) {
                $this->success('注册成功！', 'admin/index/login');
            } else {
                $this->error($result);
            }*/
            // $result = model('Admin')->personal($data);
            $result = Db::name('admin')->where(['username' => $data['username'], 'email' => $data['email']])->find();
            if ($result) {
                $this->success('验证成功', 'admin/index/personal', $data);
            } else {
                $this->error('验证失败');
            }

        }

        return view();
    }
    //跳转到修改密码页面
    public function postpersonal()
    {
        $username = $this->request->param('username');
        $email = $this->request->param('email');
        $this->assign('username', $username);
        $this->assign('email', $email);
        return $this->fetch('personal');
    }

    public function pwdchanged(){

        //后台接收数据注册   Ajax 提交方式
        if ($this->request->isAjax()) {
            $data = [
                'username' => input('post.username'),
                'email' => input('post.email'),
                'password' => input('post.password'),
                'repassword' => input('post.repassword'),
            ];
            $result = model('Admin')->pwdchanged($data);   //模型判断验证
            if ($result==1) {
                $this->success('密码更改成功','admin/index/login');
            } else {
                $this->error($result);
            }

        }


    }






}
