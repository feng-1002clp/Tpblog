<?php


namespace app\common\validate;


use think\Validate;

class Cate extends Validate
{

    protected $rule = [
        'catename|栏目名称' => 'require|unique:cate',
        'sort|排序' => 'require',
    ];

    //添加栏目场景
    public function sceneCateadd()
    {
        return $this->only([
            'catename', 'sort',
        ]);
    }

    //栏目排序场景
    public function sceneCatesort()
    {
        return $this->only(['sort']);
    }

    //栏目编辑保存场景
    public function sceneCateedit()
    {
        return $this->only(['catename']);
    }


}