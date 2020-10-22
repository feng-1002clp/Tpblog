<?php


namespace app\common\validate;


use think\Validate;

class Article extends Validate
{

    protected $rule = [
        'title|文章标题' => 'require|unique:article',
        'tags|标签' => 'require',
        'cate_id|所属栏目' => 'require',
        'desc|文章概要' => 'require',
        'content|内容' => 'require',
        'is_top|是否推荐' => 'require'
    ];

    //添加文章场景
    public  function  sceneArticleadd(){
        return $this->only(['title','tags','cate_id','desc','content']);
    }

    //添加设置推荐场景
    public function  sceneArticleistop(){
        return $this->only(['is_top']);
    }


    //添加文章编辑场景
    public function sceneArticleedit(){
        return $this->only(['title','tags','cate_id','desc','content']);
    }


}