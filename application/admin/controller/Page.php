<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/7/19
 * Time: 17:42
 */

namespace app\admin\controller;
use think\Controller;

class Page extends Controller
{
    public function adminindex()
    {
        return $this->fetch();
    }

    public function shopindex()
    {
        return $this->fetch();
    }
}