<?php

namespace app\index\controller;

class Index extends Base
{
    //文章主页
    public function index()
    {
        $id = $this->request->param('id');
        $where = [];
        $catename = null;
        if ($id) {
            $where = [
                'cate_id' => $id,
            ];
            $catename = model('Cate')->where('id', $id)->value('catename');
        }
        $articles = model('Article')->where($where)->order('create_time', 'desc')->paginate('5', false, ['query' => $where]);
        $viewData = [
            'articles' => $articles,
            'catename' => $catename,
        ];
        $this->assign($viewData);
        return view();
    }

    //注册功能
    public function register()
    {

        if ($this->request->isAjax()) {
            $data = [
                'username' => input('post.username'),
                'password' => input('post.password'),
                'conpass' => input('post.conpass'),
                'nickname' => input('post.nickname'),
                'email' => input('post.email'),
                'verify' => input('post.verify'),
            ];
            $result = model('Member')->register($data);
            if ($result == 1) {
                $this->success('用户注册成功！', 'index/index/login', $data);
            } else {
                $this->error($result);
            }
        }

        return view();
    }

    //登录功能
    public function login()
    {

        if ($this->request->isAjax()) {
            $data = [
                'username' => input('post.username'),
                'password' => input('post.password'),
                'verify' => input('post.verify'),
            ];
            $result = model('Member')->login($data);
            if ($result == 1) {
                $this->success('登录成功！', 'index/index/index', $data);
            } else {
                $this->error($result);
            }
        }

        $username = $this->request->param('username');
        $viewData = ['username' => $username];
        $this->assign($viewData);
        return view();
    }

    //用户退出
    public function loginout()
    {
        session(null);
        if (session('?index.id')){
            $this->error('退出失败');
        }else{
            $this->success('退出成功','index/index/index');
        }


    }

    //搜索
    public function search(){



    }


    public function hello($name = 'ThinkPHP5')
    {


    }


}
