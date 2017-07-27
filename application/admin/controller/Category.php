<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/7/21
 * Time: 15:30
 */

namespace app\admin\controller;


use think\Controller;

class Category extends Controller
{
    protected $category_path;
    protected $category_show = 'UploadFiles'.DS.'category';

    public function _initialize()
    {
        parent::_initialize();
        $this->category_path  = config('uploads.category_path');
        $list = db('category')->field('id,tid,name,bz_2,bz_4')->select();
        foreach($list as $k=>$v){
            if($v['tid']===0){
                $tree[]=&$list[$k];
            }else{
                foreach ($list as $ki=>$kv) {
                    if ($kv['id'] === $v['tid']) {
                        $list[$ki]['_child'][] = &$list[$k];
                    }
                }
            }
        }
        $this->assign('list',$tree);
    }
    public function index()
    {
        $this->assign('name',null);
        $this->assign('tel',null);
        return $this->fetch();
    }

    public function add()
    {
        if ($this->request->isPost()) {
            $data = $this->request->post();
            if ($thumb = $this->request->file('file')) {
                $data['bz_1'] = $this->category_show .DS. $thumb->move($this->category_path)->getSaveName();
            }
            $info = db('category')->insert($data);
            $info ? $this->success('添加成功') : $this->error('操作失败');
        } else {
            $this->assign('cate_info',null);
            return $this->fetch();
        }
    }

    public function edit()
    {
        if ($this->request->isPost()) {

        } else {
            $id = intval($this->request->get('cid'));
            $cateinfo = db('category')->find($id);
            $this->assign('cate_info',$cateinfo);
            return $this->fetch('add');
        }
    }

    public function set_tj($tj_id)
    {
        $tj_id = intval($tj_id);
        if ($category = db('category')->find($tj_id)) {
            $data['bz_2'] = $category['bz_2']== 1 ? 0 : 1;
            $msg = $data['bz_2'] == 1 ? '推荐成功' : '取消推荐';
            $info = db('category')->where('id','eq',$tj_id)->update($data);
            $info ? $this->success($msg) : $this->error('操作成功');
        } else {
            $this->error('非法操作');
        }
    }

    public function del($did)
    {
        $did = intval($did);
        $info = db('category')->where('id', 'eq', $did)->delete();
        $info ? $this->success('删除成功') : $this->error('未知错误');
    }
}