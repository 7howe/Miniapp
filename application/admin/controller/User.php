<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/7/21
 * Time: 11:02
 */

namespace app\admin\controller;
use think\Controller;

class User  extends Controller
{
    public function index()
    {
        $data = db('user')->order('id desc')->paginate(10);
        $this->assign('name',null);
        $this->assign('tel',null);
        $this->assign('userlist',$data);
        return $this->fetch();

    }
}