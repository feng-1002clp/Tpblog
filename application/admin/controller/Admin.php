<?php


namespace app\admin\controller;


use think\cache\driver\Redis;

class Admin extends Base
{
    //管理员列表页面
    public function adminlist()
    {

        $adminInfo = model('Admin')->paginate('5');
        $viewData = [
            'admins' => $adminInfo
        ];
        $this->assign($viewData);
        return view();
    }

    //添加管理员页面
    public function adminadd()
    {


        return view();
    }


    //管理员权限操作
    public function adminissuper()
    {
        $data = [
            'id' => input('post.id'),
            'is_super' => input('post.is_super') ? 0 : 1
        ];
        $result = model('Admin')->adminissuper($data);
        if ($result == 1) {
            $this->success('操作成功！', 'admin/admin/adminlist');
        } else {
            $this->error('操作失败！');
        }

    }


    //管理员删除
    public function admindel()
    {
        $adminInfo = model('Admin')->find(input('post.id'));
        $result = $adminInfo->delete();
        if ($result) {
            $this->success('会员删除成功');
        } else {
            $this->error('删除失败！');
        }
    }


    //查看php信息
    public function phpinfo()
    {
        //两种方法配置使用redis tp5.1中

        //  配置cache.php的方式
        $redis = new Redis();
        $redis->set('key1', 'value1');
        $getKey1 = $redis->get('key2');
        echo $getKey1;
        echo '<br>';

        echo request()->ip();
        //配置Redis.php的方式
        /* Cache::store('redis')->set('key2', 'value2');
         $getKey2 = Cache::store('redis')->get('key2');
         echo $getKey2;*/

        //echo phpinfo();
    }



}