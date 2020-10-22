<?php


namespace app\admin\controller;


class Cate extends Base
{
    //栏目列表
    public function catelist()
    {
        $cates = model('Cate')->order('sort', 'asc')->paginate('5');
        //定义一个模板数据变量
        $viewData = [
            'cates' => $cates
        ];
        $this->assign($viewData);
        return view();
    }

    //栏目添加
    public function cateadd()
    {

        if ($this->request->isAjax()) {
            $data = [
                'catename' => input('post.catename'),
                'sort' => input('post.sort')
            ];
            $result = model('Cate')->cateadd($data);
            if ($result == 1) {
                $this->success('栏目添加成功', 'admin/cate/catelist');
            } else {
                $this->error($result);
            }
        }


        return view();
    }

    //栏目排序
    public function catesort()
    {

        $data = [
            'id' => input('post.id'),
            'sort' => input('post.sort'),
        ];

        $result = model('Cate')->catesort($data);

        if ($result == 1) {
            $this->success('排序成功', 'admin/cate/catelist');
        } else {
            $this->error($result);
        }

    }

    //栏目编辑
    public function cateedit()
    {

        if ($this->request->isAjax()) {
            $data = [
                'id' => input('post.id'),
                'catename' => input('post.catename'),
            ];
            $result = model('Cate')->cateedit($data);
            if ($result == 1) {
                $this->success('栏目编辑成功！', 'admin/cate/catelist');
            } else {
                $this->error($result);
            }
        }


        $cateInfo = model('Cate')->find(input('id'));
        //模板变量
        $viewData = [
            'cateInfo' => $cateInfo,
        ];
        $this->assign($viewData);
        return view();
    }

    //栏目删除
    public function catedel()
    {
        $cateInfo = model('Cate')->with('Article')->find(input('post.id'));
        $result = $cateInfo->together('article')->delete();
        if ($result){
            $this->success('栏目删除成功');
        }else{
            $this->error('删除失败！');
        }
    }


}