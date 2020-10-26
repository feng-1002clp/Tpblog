<?php

namespace app\common\model;

use think\cache\driver\Redis;
use think\Model;
use think\model\concern\SoftDelete;

class Admin extends Model
{
    //软删除
    use SoftDelete;

    //只读字段
    protected $readonly = ['email'];

    //登录校验
    public function login($data)
    {
        $validate = new \app\common\validate\Admin();
        if (!$validate->scene('login')->check($data)) {
            return $validate->getError();
        } else {

            $result = $this->where($data)->find();  //模型查找数据

            if ($result) {
                //判断用户是否可用
                if ($result['status'] != 1) {
                    return '账户被禁用';
                }
                //1 表示登录成功且为管理员 session传入登录状态
                $sessionData = [
                    'id' => $result['id'],
                    'nickname' => $result['nickname'],
                    'is_super' => $result['is_super'],
                ];
                session('admin', $sessionData);

                return 1;

            } else {

                $redis = new Redis();
                //得到登录方ip地址
                $login_ip = request()->ip();

                if (!empty($redis->get($login_ip))) {
                    /* return '666';
                     $redis->inc('locked_' + $login_ip + '');
                     $errorCount = $redis->get('locked_' + $login_ip + '');
                     // $residue = 5 - intval($errorCount);
                     echo $errorCount;*/
                    return '用户名或者密码错误,输入错误5次将会禁止登录!您还剩余次!';
                } else {
                    // $redis->set('locked_' + $login_ip + '', '1');
                    return '用户名或者密码错误,输入错误5次将会禁止登录!您还剩余4次机会!';
                }
            }

        }
    }

    //注册账户
    public function register($data)
    {
        $validate = new \app\common\validate\Admin();

        if (!$validate->scene('register')->check($data)) {
            return $validate->getError();
        }

        $result = $this->allowField(true)->save($data);
        if ($result) {
            mailto($data['email'], '注册管理员账户成功！', '欢迎来到冯自力制作的后台页面，恭喜你注册管理员成功！');
            return 1;   //注册成功
        } else {
            return '注册失败！';
        }

    }

    //忘记密码
    public function forget($data)
    {
        $validate = new \app\common\validate\Admin();

        if (!$validate->scene('forget')->check($data)) {
            return $validate->getError();
        }

        //用户名和对应的邮箱是否匹配   不配备则提示错误信息   匹配则发送验证码
        $result = $this->where(['username' => $data['username'], 'email' => $data['email']])->find();
        if ($result) {
            $random = random();
            mailto($data['email'], '验证码已发送，注意查看！', '您的验证码是' . $random . ' 注意任何人问你询问都要严格保密，此验证码关系到您的账户安全，可用于修改您的账户密码！');
            return $random;

        } else {
            return '用户名与对应的邮箱不匹配！';
        }

    }

    //个人验证
    public function personal($data)
    {

        $result = $this->where(['username' => $data['username'], 'email' => $data['email']])->find();

        if ($result) {
            return 1;   //注册成功
        } else {
            return '邮箱验证码错误！';
        }
    }

    //密码更改
    public function pwdchanged($data)
    {
        $validate = new \app\common\validate\Admin();

        if (!$validate->scene('pwdchanged')->check($data)) {
            return $validate->getError();
        }
        $adminInfo = $this->where(['username' => $data['username'], 'email' => $data['email']])->find();
        $adminInfo->password = $data['password'];
        $result = $adminInfo->save();
        if ($result) {
            return 1;
        } else {
            return '更改密码失败！';
        }


    }

    //管理员权限操作
    public function adminissuper($data)
    {
        $validate = new \app\common\validate\Admin();
        if (!$validate->scene('adminissuper')->check($data)) {
            return $validate->getError();
        }
        $adminInfo = $this->find($data['id']);
        $adminInfo->is_super = $data['is_super'];
        $result = $adminInfo->save();
        if ($result) {
            return 1;
        } else {
            return "操作失败!";
        }
    }


}
