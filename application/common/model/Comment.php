<?php


namespace app\common\model;


use think\Model;
use think\model\concern\SoftDelete;

class Comment extends Model
{

    //软删除
    use  SoftDelete;

    //关联文章表
    public function  article(){     //belongsto 多对一关联 关联表/关联外键/关联主键
        return $this->belongsTo('Article','article_id','id');
    }

    //关联用户表
    public function  member(){
        return $this->belongsTo('Member','member_id','id');
    }


    //用户评论
    public function comment($data){
        $validate = new \app\common\validate\Comment();
        if (!$validate->scene('comment')->check($data)){
            return $validate->getError();
        }
        $result = $this->allowField(true)->save($data);
        if ($result){
            return 1;
        }else{
            return '评论失败!';
        }

    }


}