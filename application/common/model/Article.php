<?php


namespace app\common\model;


use think\Model;
use think\model\concern\SoftDelete;

class Article extends Model
{

    //软删除
    use  SoftDelete;

    //关联栏目表
    public function  cate(){     //belongsto 多对一关联 关联表/关联外键/关联主键
        return $this->belongsTo('Cate','cate_id','id');
    }

    //关联评论表
    public function  commenton()
    {
        return $this->hasMany('Comment','article_id','id');
    }


    //文章添加方法
    public function articleadd($data)
    {
        $validate = new \app\common\validate\Article();
        if (!$validate->scene('articleadd')->check($data)) {
            return $validate->getError();
        }

        $result = $this->allowField(true)->save($data);
        if ($result) {
            return 1;
        } else {
            return '文章添加失败';
        }

    }


    //文章设置推荐
    public function articleistop($data)
    {
        $validate = new \app\common\validate\Article();
        if (!$validate->scene('articleistop')->check($data)) {
            return $validate->getError();
        }
        $articleInfo = $this->find($data['id']);
        $articleInfo->is_top = $data['is_top'];
        $result = $articleInfo->save();
        if ($result){
            return 1;
        }else{
            return "操作失败!";
        }

    }


    //文章编辑方法
    public function articleedit($data){
        $validate = new \app\common\validate\Article();
        if (!$validate->scene('articleedit')->check($data)) {
            return $validate->getError();
        }

      //  $result = $this->allowField(true)->where('id',$data['id'])->update($data);
        $articleInfo = $this->find($data['id']);
        $articleInfo->title = $data['title'];
        $articleInfo->tags = $data['tags'];
        $articleInfo->is_top = $data['is_top'];
        $articleInfo->cate_id = $data['cate_id'];
        $articleInfo->desc = $data['desc'];
        $articleInfo->content = $data['content'];
        $result = $articleInfo->save();
        if ($result){
            return 1;
        }else{
            return '文章编辑失败！';
        }

    }



    /*//创建 cate_id 字段的获取器
    public function getcate_idAttr($value)
    {
        $cate_id = [1 => '智谷新闻', 2 => '智谷科技', 3 => '智谷集团', 4 => '智谷人才', 5 => '智谷文化'];
        return $cate_id[$value];
    }

    public function getNothingAttr($value, $data)
    {
        $catename = [1 => '智谷新闻', 2 => '智谷科技', 3 => '智谷集团', 4 => '智谷人才', 5 => '智谷文化'];
        return $catename[$data['cate_id']];
    }*/


}