<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/7/20
 * Time: 15:01
 */

namespace app\admin\controller;
use think\Controller;

class Product extends Controller
{
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
}