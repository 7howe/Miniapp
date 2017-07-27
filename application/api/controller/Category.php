<?php
/**
 * Created by PhpStorm.
 * User: 7howe
 * Date: 2017/7/27
 * Time: 10:38
 */

namespace app\api\controller;


class Category
{
    public function index()
    {
        $cat = db('category')->where('tid','eq',1)->whereOr('tid','eq',2)->select();
        foreach ($cat as &$vo) {
            $vo['bz_1'] = DATAURL . str_replace(DS,'/',$vo['bz_1']);
            $vo['tid'] == 1 && ($list[] = $vo) || $catlist[] = $vo;
        }
        return array('status'=>1,'list'=>$list,'catList'=>$catlist);
    }

    public function getcat()
    {
        $catid = intval($_POST['cat_id']);
        if ($catlist = db('category')->field('id,name,bz_1')->where('tid', 'eq', $catid)->select()) {
            foreach ($catlist as &$item) {
                $item['bz_1'] = DATAURL .str_replace(DS,'/',$item['bz_1']);
            }
            return array('status'=>1,'catList'=>$catlist);
        } else {
            return array('status'=>0);
        }
    }
}