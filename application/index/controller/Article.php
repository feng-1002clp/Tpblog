<?php


namespace app\index\controller;


use think\Controller;

class Article extends Base
{
    //文章详情页
    public function info(){
        $id = $this->request->param('id');
        $articleInfo = model('Article')->with('commenton,commenton.member')->find($id);
        $articleInfo->setInc('click');
        $viewData = [
            'articleInfo' => $articleInfo,
        ];
        $this->assign($viewData);
        return view();

    }

    //文章评论方法
    public function comment(){
        $data = [
            'article_id' => input('post.article_id'),
            'member_id'  => input('post.member_id'),
            'content' => input('post.commentcontent'),
        ];
        $result = model('Comment')->comment($data);
        if ($result==1){
            $this->success('评论成功!');
        }else{
            $this->error($result);
        }
    }



}