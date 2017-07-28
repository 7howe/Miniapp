<?php
/**
 * Created by PhpStorm.
 * User: 7howe
 * Date: 2017/7/21
 * Time: 10:46
 */

namespace app\admin\controller;
use think\Controller;
use think\image\Exception;

class Brand extends Base
{
    protected $brand_path;
    protected $brand_show;

    public function _initialize()
    {
        parent::_initialize();
        $this->brand_path = config('uploads.brand_path');
        $this->brand_show = 'UploadFiles'.DS.'brand';
    }
    public function index()
    {
        $this->assign('name',null);
        $list = db('brand')->paginate(5);
        $this->assign('list',$list);
        return $this->fetch();
    }

    public function add()
    {
        $this->assign('brand_info',null);

        if ($this->request->isPost()) {
            $data['name'] = $this->request->post('name');
            if ($photo = $this->request->file('file')) {
                $info = $photo->move($this->brand_path);
                $data['photo'] = $this->brand_show .DS. $info->getSaveName();
            }
            $data['addtime'] = time();
            $res = db('brand')->insert($data);
            if ($res) {
                $this->success('添加成功');
            } else {
                $this->error('添加失败');
            }
        } else {
            return $this->fetch();
        }
    }


    public function del($did)
    {
        $did = intval($did);
        if($brand = db('brand')->find($did)){
            $img_url = 'data' .DS. $brand['photo'];
                if (file_exists($img_url)) {
                    $move = unlink($img_url) ? true : false;
                }

            $info =db('brand')->where('id','eq',$did)->delete();
            $info&&$move ? $this->success('删除成功') : $this->error('删除失败');
        } else {
            $this->error('非法ID');
        }

    }

    public function set_tj($id)
    {
        $id = intval($id);
        if ($brand = db('brand')->find($id)) {
            $data['type'] = $brand['type'] == 1 ? 0 : 1;
            $msg = $data['type'] ? '推荐成功' : '取消推荐';
            $info = db('brand')->where('id', 'eq', $id)->update($data);
            $info ? $this->success($msg) : $this->error('操作失败');
        } else {
            $this->error('非法id');
        }
    }

    public function edit()
    {
        if ($this->request->isPost()) {
            $data['name'] = $this->request->post('name');
            $data['file'] = $this->request->file('file');
        } else {
            $id = intval($this->request->get('id'));
            if ($brand = db('brand')->find($id)) {
                $this->assign('brand_info',$brand);
                return $this->fetch('add');
            } else {
                $this->error('该品牌并不存在');
            }
        }
    }
}