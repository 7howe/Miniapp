<?php
/**
 * Created by PhpStorm.
 * User: 7howe
 * Date: 2017/7/21
 * Time: 11:02
 */

namespace app\admin\controller;
use think\Controller;

class User  extends Base
{
    public function index()
    {
        $data = db('user')->order('id desc')->paginate(10);
        $this->assign('name',null);
        $this->assign('tel',null);
        $this->assign('userlist',$data);
        return $this->fetch();

    }

    public function del($did)
    {
        $did = intval($did);
        if ($user = db('user')->find($did)) {
            $data['del'] =$user['del'] == 1 ? 0 :1;
            $msg = $data['del'] ? '禁用成功' : '恢复成功';
            $info = db('user')->where('id','eq',$did)->update($data);
            $info ? $this->success($msg) : $this->error('操作失败');
        } else {
            $this->error('非法ID');
        }
    }
}