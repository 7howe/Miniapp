<?php
/**
 * Created by PhpStorm.
 * User: 7howe
 * Date: 2017/7/27
 * Time: 10:04
 */

namespace app\api\controller;


class Product
{
    public function index()
    {
        $proid = intval($_REQUEST['pro_id']);
        $join = [
                ['brand b','p.brand_id = b.id','LEFT'],
            ['category c','p.cid = c.id','LEFT']
        ];
        if ($proinfo = db('product')->alias('p')->field('p.*,b.name brand,c.name cat_name')->join($join)->find($proid)) {
            return array('status'=>1,'pro'=>$proinfo,'commodityAttr'=>null,'attrValueList'=>null);
        } else {
            return array('status'=>0);
        }

    }

    public function details()
    {
        $proid = intval($_REQUEST['pro_id']);
        if ($pro = db('product')->field('content')->find($proid)) {
            return array('status'=>1,'content'=>$pro['content']);
        }else {
            return array('status'=>0);
        }
    }

    public function lists($map='',$page=0,$type=null)
    {
        $_POST['cat_id'] && $where = 'cid ='.$_POST['cat_id'];
        $_POST['brand_id'] && $where .= 'brand_id = '.$_POST['brand_id'];
        $cmap = ['new'=>'is_show = 1','hot'=>'is_hot = 1','zk'=>'is_sale = 1'];
        $map .= array_key_exists($_POST['ptype'],$cmap) ? $cmap[$_POST['ptype']] : '';
        $page = array_key_exists('page',$_POST) ? : $page;
        $type = array_key_exists('type',$_POST) ? : $type;
        $order = "addtime desc";
        switch ($type) {
            case 'ids':
                $order ='id desc';
                break;
            case 'sale':
                $order ='shiyong desc';
                break;
            case 'price':
                $order ='price_yh desc';
                break;
            case 'hot':
                $order = 'renqi desc';
                break;
            default:
                break;
        }

        $product = db('product')->order($order)->where($map)->page($page,'10')->select();
        foreach ($product as &$pitem) {
            $pitem['photo_x'] = DATAURL . $pitem['photo_x'];
        }
        $catname = db('category')->field('name')->find(intval($_POST['cat_id']));

        return array('status'=>1,'pro'=>$product,'cat_name'=>$catname);

    }

    public function get_more()
    {

    }
}