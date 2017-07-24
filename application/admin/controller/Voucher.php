<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/7/21
 * Time: 17:09
 */

namespace app\admin\controller;


use think\Controller;

class Voucher extends Controller
{
    public function index()
    {
        $keyword = $this->request->get('keyword');
        $this->assign('keyword',$keyword);
        $list = db('voucher')->order('id desc')->paginate(10);
        $this->assign('voucher_list',$list);
        return $this->fetch();
    }

    public function add()
    {
        if ($this->request->isPost()) {

        } else {
            $this->assign('voucher',null);
            return $this->fetch();
        }
    }
}