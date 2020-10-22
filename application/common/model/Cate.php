<?php


namespace app\common\model;


use think\Model;
use think\model\concern\SoftDelete;

class Cate extends Model
{

    //软删除
    use  SoftDelete;

    //关联文章表的模型  文章表的模型关联栏目
    public function article(){
        return $this->hasMany('Article','cate_id','id');
    }

    //栏目添加
    public function cateadd($data)
    {

        $validate = new \app\common\validate\Cate();
        if (!$validate->scene('cateadd')->check($data)) {
            return $validate->getError();
        } else {
            $result = $this->allowField(true)->save($data);


            if ($result) {
                return 1;
            } else {
                return '栏目添加失败！！';
            }

        }


    }

    //栏目排序
    public function catesort($data)
    {
        $validate = new \app\common\validate\Cate();
        if (!$validate->scene('catesort')->check($data)) {
            return $validate->getError();
        } else {
            $cateInfo = $this->find($data['id']);
            $cateInfo->sort = $data['sort'];
            $result = $cateInfo->save();
            if ($result) {
                return 1;
            } else {
                return '设置排序失败';
            }

        }
    }

    //栏目更新
    public function cateedit($data)
    {
        $validate = new \app\common\validate\Cate();
        if (!$validate->scene('cateedit')->check($data)){
            return $validate->getError();
        }

        $cateInfo = $this->find($data['id']);
        $cateInfo->catename = $data['catename'];
        $result = $cateInfo->save();
        if ($result){
            return  1;
        }else{
            return  '栏目编辑保存失败！';
        }
    }

}