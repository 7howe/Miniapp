<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/7/19
 * Time: 17:07
 */

namespace app\admin\controller;
use think\Controller;


class Index extends Controller
{
    public function index()
    {
        return $this->fetch();

    }

}