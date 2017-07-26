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
                    'pwd' => MD5(MD5($this->request->post('password')))
                );
                $info = db('adminuser')->insert($map);
                $info ? $this->success('添加成功') : $this->error('操作失败');
            }
        } else {
            $this->assign('id',null);
            $this->assign('adminuserinfo',null);
            return $this->fetch();
        }
    }

    public function edit()
    {
        if ($this->request->isPost()) {

        } else {
            $id = intval($this->request->get('id'));
            $user = db('adminuser')->field('id,name')->find($id);
            $this->assign('adminuserinfo',$user);
            return $this->fetch('add');
        }
    }

    public function del($did)
    {
        $did = intval($did);
        if ($user = db('adminuser')->find($did)) {
            $data['del'] = $user['del'] == 1 ? 0 :1;
            $msg = $data['del'] ? '删除成功': '恢复成功';
            $info = db('adminuser')->where('id','eq',$did)->update($data);
            $info ? $this->success($msg) : $this->error('操作失败');
        } else {
            $this->error('非法操作');
        }
    }
}