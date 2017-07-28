<?php
/**
 * Created by PhpStorm.
 * User: 7howe
 * Date: 2017/7/19
 * Time: 17:07
 */

namespace app\admin\controller;
use think\Controller;


class Index extends Base
{
    public function index()
    {
        return $this->fetch();

    }

}