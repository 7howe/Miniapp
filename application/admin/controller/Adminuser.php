<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/7/21
 * Time: 11:15
 */

namespace app\admin\controller;

use think\Controller;

class Adminuser extends  Controller
{
    public function adminuser()
    {
        $this->assign('name',null);
        $this->assign('tel',null);
        $list = db('adminuser')->order('id desc')->paginate(10);
        $this->assign('userlist',$list);
        return $this->fetch();
    }
}