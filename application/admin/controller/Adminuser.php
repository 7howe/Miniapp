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

    public function add()
    {
        if ($this->request->isPost()) {
            if (!$this->request->post('name') || !$this->request->post('password')) {
                $this->error('账号、密码，都不能为空');
            } else{
                $map = array(
                    'name' => $this->request->post('name'),
                    'uname' => '普通管理员',
                    'qx'   => 5,
                    'password' => MD5(MD5($this->request->post('password')))
                );
                db('adminuser')->insert($map);
            }
        } else {
            $this->assign('id',null);
            $this->assign('adminuserinfo',null);
            return $this->fetch();
        }
    }
}