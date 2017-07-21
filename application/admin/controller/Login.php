<?php
namespace app\admin\controller;
use think\Controller;
use think\Db;
use think\Session;

class Login extends Controller
{
    public function index()
    {
        if($this->request->isPost() && !Session::has('user'))
        {
            $user = $this->request->post('username');
            $pwd = $this->request->post('pwd');
            $data = Db::name('adminuser')->where('name',$user)->find();
            if($data){
                if(md5(md5($pwd)) === $data['pwd']) {
                    Session::set('user',$user);
                    $this->success('登录成功！','index/index');
                } else {
                    return 'password error';
                }
            } else {
                return 'user is not exists';
            }
        } else {
            $this->assign('sysname','7howe');
            $this->assign('key',rand(1000,10000));
            return $this->fetch();
        }

    }

    public function logout(){
        Session::clear();
        $this->success('已退出','login/index');
    }
}
