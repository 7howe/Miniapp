<?php
/**
 * Created by PhpStorm.
 * User: 7howe
 * Date: 2017/7/27
 * Time: 13:49
 */

namespace app\api\controller;


class Shopping
{
    public function index()
    {
        $uid = intval($_REQUEST['user_id']);
        $join = [
          ['product p','s.pid = p.id','LEFT']
        ];
        $carts = db('shopping_char')->alias('s')->field('s.id,s.uid,s.pid,s.price,s.num,p.name pro_name,p.photo_x')->join($join)->where('s.uid','eq',$uid)->select();
        foreach ($carts as &$citem) {
            $citem['photo_x'] = DATAURL.$citem['photo_x'];
        }

        return array('status'=>1,'cart'=>$carts);
    }

    public function delete()
    {
        $cart_id = intval($_REQUEST['cart_id']);
        if ($cartid = db('shopping_char')->field('id')->find($cart_id)) {
            $info = db('shopping_char')->where('id','eq',$cartid['id'])->delete();
            return $info ? array('status'=>1) : array('status'=>0);
        } else {
            return array('status'=>0,'err'=>'已删除');
        }

    }

    public function add()
    {
        $uid = intval($_REQUEST['uid']);
        $pid = intval($_POST['pid']);
        $num = intval($_POST['num']);

        $proinfo = db('product')->where('id','eq',$pid)->find();

        if ($num > $proinfo['num']) {
            return array('status'=>0,'err'=>'库存不足');
        } else {
            $map['uid'] = $uid;
            $map['pid'] = $pid;
            if ($ucart = db('shopping_char')->field('id,num')->where($map)->find()) {
                $data['num'] = $ucart['num'] + $num;
                if ($data['num'] > $proinfo['num']) {
                    return array('status'=>0,'err'=>'库存不足');
                } else {
                    $info = db('shopping_char')->where('id','eq',$ucart['id'])->update($data);
                    return $info ? array('status'=>1,'cart_id'=>$info) : array('status'=>0,'err'=>'更新购物车失败');
                }
            } else {
                $data['num'] = $num;
                $data = array_merge($map,$data);
                $info = db('shopping_char')->insert($data);
                return $info ? array('status'=>1,'cart_id'=>$info) : array('status'=>0,'err'=>'添加购物车失败');
            }

        }

    }

    public function up_cart()
    {
        $uid = intval($_REQUEST['user_id']);
        $pid = intval($_REQUEST['pid']);
        $cart_id = intval($_REQUEST['cart_id']);
        $num = intval($_REQUEST['num']);

        if ($cart = db('shopping_char')->where($map)->find()) {
            $pronum = db('product')->field('num')->where('id','eq','$pid')->find();
            if ($num > $pronum['num']) {
                return  array('status'=>0,'err'=>'库存不足');
            } else{
//                db('shopping_char')->
            }
        }
    }

    public function check_cart($pid)
    {
        $check = db('product')->where('id','eq',intval($pid))->find();
        return $check ? true : false;
    }
}