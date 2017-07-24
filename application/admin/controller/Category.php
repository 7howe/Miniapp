<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/7/21
 * Time: 15:30
 */

namespace app\admin\controller;


use think\Controller;

class Category extends Controller
{
    public function _initialize()
    {
        $list = db('category')->field('id,tid,name,bz_2,bz_4')->select();
        foreach($list as $k=>$v){
            if($v['tid']===0){
                $tree[]=&$list[$k];
            }else{
                foreach ($list as $ki=>$kv) {
                    if ($kv['id'] === $v['tid']) {
                        $list[$ki]['_child'][] = &$list[$k];
                    }
                }
            }
        }
        $this->assign('list',$tree);
    }
    public function index()
    {
        $this->assign('name',null);
        $this->assign('tel',null);
        return $this->fetch();
    }

    public function add()
    {
        if ($this->request->isPost()) {

        } else {
            $this->assign('cate_info',null);
            return $this->fetch();
        }
    }
}