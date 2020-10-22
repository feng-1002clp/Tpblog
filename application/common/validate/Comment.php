<?php


namespace app\common\validate;


use think\Validate;

class Comment extends Validate
{

    protected $rule = [
        'content|评论' => 'require',
    ];

    public function sceneComment(){
      return $this->only([
          'content'
      ]);
    }





}