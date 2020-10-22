<?php


namespace app\admin\controller;


class Member extends Base
{

    //会员列表
    public function memberlist()
    {

        $members = model('Member')->paginate('5');
        //定义一个模板数据变量
        $viewData = [
            'members' => $members
        ];
        $this->assign($viewData);

        return view();
    }

    //会员添加
    public function memberadd()
    {

        if ($this->request->isAjax()) {

            $data = [
                'username' => input('post.username'),
                'nickname' => input('post.nickname'),
                'password' => input('post.password'),
                'email' => input('post.email'),
            ];
            $result = model('Member')->memberadd($data);
            if ($result == 1) {
                $this->success('会员添加成功', 'admin/member/memberlist');
            } else {
                $this->error($result);
            }
        }

        return view();
    }



    //会员删除方法
    public function memberdel(){
        $memberInfo = model('Member')->find(input('post.id'));
        $result = $memberInfo->delete();
        if ($result){
            $this->success('会员删除成功');
        }else{
            $this->error('删除失败！');
        }
    }

    //会员编辑方法
    public function  memberedit(){

        if ($this->request->isAjax()){
            $data=[
                'id' => input('post.id'),
                'username' => input('post.username'),
                'password' => input('post.password'),
                'nickname' => input('post.nickname'),
                'email' => input('post.email'),
            ];
            $result = model('Member')->memberedit($data);
            if ($result == 1) {
                $this->success('会员用户编辑成功！', 'admin/member/memberlist');
            } else {
                $this->error($result);
            }
        }


        $memberInfo = model('Member')->find(input('id'));
        $viewData = [
            'member' => $memberInfo,
        ];
        $this->assign($viewData);
        return view();
    }



}

