<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/7/21
 * Time: 17:17
 */

namespace app\admin\controller;


use think\Controller;

class Guanggao extends Controller
{
    public function index()
    {
        $adv_name=$this->request->get('adv_name');
        $this->assign('name',$adv_name);
        $this->assign('type',null);
        $list = db('guanggao')->order('id desc')->paginate(10);
        $this->assign('adv_list',$list);
        return $this->fetch();
    }
}