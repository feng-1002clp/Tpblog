<?php


namespace app\common\model;


use think\Model;
use think\model\concern\SoftDelete;

class Member extends Model
{

    //软删除
    use SoftDelete;

    //只读指端
    protected $readonly = ['email'];

    //用户模型  一个用户关联多个评论
    public function commenton(){
        return $this->hasMany('Comment','member_id','id');
    }

    //会员用户添加
    public function memberadd($data){

        $validate = new \app\common\validate\Member();
        if (!$validate->scene('memberadd')->check($data)) {
            return $validate->getError();
        }

        $result = $this->allowField(true)->save($data);
        if ($result) {
            return 1;
        } else {
            return '会员添加失败';
        }

    }


    //会员用户编辑
    public function memberedit($data){
        $validate = new \app\common\validate\Member();
        if (!$validate->scene('memberedit')->check($data)) {
            return $validate->getError();
        }

        $memberInfo = $this->find($data['id']);
        $memberInfo->username=$data['username'];
        $memberInfo->nickname=$data['nickname'];
        $memberInfo->password=$data['password'];
        $memberInfo->email=$data['email'];
        $result = $memberInfo->save();
        if ($result){
            return 1;
        }else{
            return '会员用户编辑失败';
        }

    }


    //会员用户注册
    public function register($data){
        $validate = new \app\common\validate\Member();
        if (!$validate->scene('register')->check($data)) {
            return $validate->getError();
        }
        $result = $this->allowField(true)->save($data);
        if ($result){
            return 1;
        }else{
            return '注册失败！';
        }
    }


    //会员用户登录
    public function login($data){
        $validate = new \app\common\validate\Member();
        if (!$validate->scene('login')->check($data)) {
            return $validate->getError();
        }
        unset($data['verify']);
        $result = $this->where($data)->find();
        if ($result){
            $sessionData = [
                'id' => $result['id'],
                'nickname' => $result['nickname'],
            ];
            session('index',$sessionData);
            return  1;
        }else{
            return '用户名或密码错误！';
        }
    }






}