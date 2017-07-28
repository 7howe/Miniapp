<?php
/**
 * Created by PhpStorm.
 * User: 7howe
 * Date: 2017/7/28
 * Time: 11:51
 */

namespace app\admin\controller;


use think\Controller;

class Base extends Controller
{
    public function _initialize()
    {
        /**
         *  未作用户权限认证
         */
        if (!session('?user')) {
            $this->redirect('login/index');
        }
    }
}