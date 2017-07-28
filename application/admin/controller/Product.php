<?php
/**
 * Created by PhpStorm.
 * User: 7howe
 * Date: 2017/7/20
 * Time: 15:01
 */

namespace app\admin\controller;
use think\Controller;

class Product extends Base
{
    protected $upload_path;
    protected $upload_show;

    public function _initialize()
    {
        parent::_initialize();
        $this->upload_path = config('uploads.product_path');
        $this->upload_show = 'UploadFiles' . DS . 'product';
    }
    public function index()
    {
        $map['pro_type'] = 1;
        $join = [
            ['category c','a.cid=c.id','LEFT'],
            ['brand b','a.brand_id=b.id','LEFT']
        ];
        $list = db('product')->alias('a')->field('a.*,c.name cname,b.name brand')->where($map)->join($join)->paginate(5);
        $this->assign('productlist',$list);
        $this->assign('name',null);
        $this->assign('tuijian',null);
        $this->assign('type',null);
        $this->assign('shop_id',1);
        $this->assign('page_index',1);
        return $this->fetch();
    }

    public function add()
    {
        $this->assign('pro_allinfo',null);
        $this->assign('shangchang',null);
        $this->assign('id',null);
        $this->assign('name',null);
        $this->assign('type',null);
        $this->assign('shop_id',null);
        $this->assign('page',null);
        $this->assign('catetwo',null);
        $this->assign('img_str',null);

        if ($this->request->isPost()) {
            $array=array(
                'name'=>$_POST['name'] ,
                'intro'=>$_POST['intro'] ,
                'shop_id'=>  0 ,//所属店铺
                'cid'=> intval($_POST['cid']) ,			//产品分类ID
                'brand_id'=> intval($_POST['brand_id']) ,//产品品牌ID
                'pro_number'=>$_POST['pro_number'] ,	//产品编号
                'sort'=>0 ,
                'price'=>(float)$_POST['price'] ,
                'price_yh'=>(float)$_POST['price_yh'] ,
                'price_jf'=>(float)$_POST['price_jf'] ,//赠送积分
                'updatetime'=>time(),
                'num'=>(int)$_POST['num'] ,			//库存
                'content'=>$_POST['content'] ,
                'company'=>$_POST['company'],  //产品单位
                'pro_type'=>1,
                'renqi' => intval($_POST['renqi']),
                'is_hot'=>intval($_POST['is_hot']),//是否热卖
                'is_show'=>intval($_POST['is_show']),//是否新品
                'is_sale'=>0,//是否折扣
            );
            if ($photo_x = $this->request->file('photo_x')) {
                $info = $photo_x->move($this->upload_path);
                $info && $array['photo_x'] = $this->upload_show .DS.$info->getSaveName();
            }
            if ($photo_d = $this->request->file('photo_d')) {
                $info = $photo_d->move($this->upload_path);
                $info && $array['photo_d'] = $this->upload_show .DS.$info->getSaveName();
            }
            $photo_string = '';
            foreach ($this->request->file('files') as $pic) {
                $info = $pic->move($this->upload_path);
                $info && $photo_string .= $this->upload_show .DS.$info->getSaveName() .',';
            }
            $photo_string != '' && $array['photo_string']=trim($photo_string,',');
            $res = db('product')->data($array)->insert();
            if ($res) {
                $this->success('添加产品成功');
            } else {
                $this->error('添加产品失败');
            }
        } else {
            $cate = db('category')->field('id,tid,name')->where('tid','eq',1)->select();
            $brand = db('brand')->field('id,name')->select();
            $this->assign('cate_list',$cate);
            $this->assign('brand_list',$brand);
            return $this->fetch();
        }

    }

    public function getcid()
    {
        $cid = $this->request->post('cateid') ? : null;
        if (intval($cid)) {
            $list = db('category')->where('tid','eq',intval($cid))->select();
            $data['catelist'] = $list;
            return $data;
        } else {
            $this->error('未指定父类ID');
        }
    }

    public function set_tj()
    {
        if ($pro_id = $this->request->get('pro_id')) {
            $map['id'] = intval($pro_id);
            $pro_info = db('product')->field('type')->find($pro_id);
            if(!$pro_info){
                $this->error('非法产品id');
            }else{
                $data['type'] = $pro_info['type'] === 1 ? 0 : 1;
                $info = db('product')->where($map)->update($data);
                if ($info) {
                    $msg = $data['type'] ? '推荐成功':'取消推荐';
                    $this->success($msg);
                } else{
                    $this->error('操作失败');
                }
            }
        }

    }

    public function del()
    {
        if ($did = $this->request->get('did')) {
            $pro_info = db('product')->find(intval($did));
            if ($pro_info) {
                $map['id'] = intval($did);
                $data['del'] = $pro_info['del'] === 1 ? 0 : 1;
                $res = db('product')->where($map)->update($data);
                if ($res) {
                    $msg = $data['del'] ? '删除成功': '恢复成功';
                    $this->success($msg);
                } else {
                    $this->error('操作失败');
                }
            } else{
                $this->error('非法产品ID');
            }
        }
    }

    public function edit()
    {
        if ($pid = $this->request->get('pid')) {
            $pro_info = db('product')->find($pid);
            $cate_list = db('category')->field('id,tid,name')->where('tid','eq',1)->select();
            $catetwo = db('category')
                ->field('id,tid,name')
                ->where('tid','eq',function  ($query) use ($pro_info) {
                    $query->name('category')->where('id','eq',$pro_info['cid'])->field('tid');
                })
                ->select();
            $pro_info['tid'] = $catetwo ?$catetwo[0]['tid'] : null;
            $brand_list = db('brand')->field('id,name')->order('id desc')->select();
            $this->assign('brand_list',$brand_list);
            $this->assign('cate_list',$cate_list);
            $this->assign('catetwo',$catetwo);
            if ($pro_info) {
                $this->assign('pro_allinfo',$pro_info);
                $img_str = $pro_info['photo_string'] != '' ? explode(',',trim($pro_info['photo_string'],',')) : null;
                $this->assign('img_str',$img_str);
                return $this->fetch('add');
            } else {
                $this->error('非法产品ID');
            }
        }
    }
}