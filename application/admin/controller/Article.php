<?php


namespace app\admin\controller;


class Article extends Base
{

    //文章列表
    public function articlelist()
    {

        $articles = model('Article')->with(['cate'])->order(['is_top' => 'asc', 'create_time' => 'desc'])->paginate('5');
        $viewData = [
            'articles' => $articles
        ];
        $this->assign($viewData);
        return view();
    }


    //文章添加
    public function articleadd()
    {

        if ($this->request->isAjax()) {
            // Request::only(['title','tags','is_top','cateid','desc','content']);
            $data = [
                'title' => input('post.title'),
                'tags' => input('post.tags'),
                'is_top' => input('post.is_top', 0),
                'cate_id' => input('post.cate_id'),
                'desc' => input('post.desc'),
                'content' => input('post.content'),
            ];
            $result = model('Article')->articleadd($data);
            if ($result == 1) {
                $this->success('文章添加成功', 'admin/article/articlelist');
            } else {
                $this->error($result);
            }
        }

        $cates = model('Cate')->select();
        $viewData = [
            'cates' => $cates
        ];
        $this->assign($viewData);
        return view();
    }


    //文章删除
    public function articledel()
    {
        $articleInfo = model('Article')->find(input('post.id'));
        $result = $articleInfo->delete();
        if ($result) {
            $this->success('文章删除成功');
        } else {
            $this->error('删除失败！');
        }
    }


    //文章编辑
    public function articleedit()
    {

        if ($this->request->isAjax()) {
            $data = [
                'id' => input('post.id'),
                'title' => input('post.title'),
                'tags' => input('post.tags'),
                'is_top' => input('post.is_top', 0),
                'cate_id' => input('post.cate_id'),
                'desc' => input('post.desc'),
                'content' => input('post.content'),
            ];
            $result = model('Article')->articleedit($data);
            if ($result == 1) {
                $this->success('文章编辑成功！', 'admin/article/articlelist');
            } else {
                $this->error($result);
            }
        }

        $articleInfo = model('Article')->find(input('id'));
        $cates = model('Cate')->select();
        //模板变量
        $viewData = [
            'articleInfo' => $articleInfo,
            'cates' => $cates
        ];
        $this->assign($viewData);
        return view();
    }


    //文章设置推荐
    public function articleistop()
    {
        $data = [
            'id' => input('post.id'),
            'is_top' => input('post.is_top') ? 0 : 1
        ];
        $result = model('Article')->articleistop($data);
        if ($result == 1) {
            $this->success('更改成功！', 'admin/article/articlelist');
        } else {
            $this->error('操作失败！');
        }


    }


}