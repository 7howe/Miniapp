<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/7/21
 * Time: 10:46
 */

namespace app\admin\controller;
use think\Controller;

class Brand extends Controller
{
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
        $this->assign('id',null);
        return $this->fetch();
    }
}