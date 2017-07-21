<?php
namespace app\api\controller;
use think\Controller;

/**
 * Class Index
 * @package app\api\controller/
 * api调用首页
 */
class Index extends Controller
{
    public function index()
    {
        $test_data = ['hello','world',['7howe'=>'Qhao']];
        return $test_data;
    }
}