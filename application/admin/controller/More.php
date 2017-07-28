<?php
/**
 * Created by PhpStorm.
 * User: 7howe
 * Date: 2017/7/20
 * Time: 14:50
 */

namespace app\admin\controller;
use think\Controller;


class More extends Base
{
    public function setup()
    {
        if($this->request->isPost()){

        } else {
            $data = db('program')->order('id','desc')->find();
            $this->assign('info',$data);
            return $this->fetch();
        }

    }
}