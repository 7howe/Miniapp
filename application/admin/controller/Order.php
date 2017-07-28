<?php
/**
 * Created by PhpStorm.
 * User: 7howe
 * Date: 2017/7/21
 * Time: 11:23
 */

namespace app\admin\controller;


use think\Controller;

class Order extends Base
{
    public function _initialize()
    {
        parent::_initialize();
        $order_status = array('10'=>'待付款','20'=>'待发货','30'=>'待收货','40'=>'已收货','50'=>'交易完成');
        $this->assign('order_status',$order_status);
    }
    public function index()
    {
        if ($this->request->isPost()) {
            $shop_id = $this->request->post('shop_id');
            $pay_type = $this->request->post('pay_type');
            $start_time = $this->request->post('start_time');
            $end_time = $this->request->post('end_time');

        } else {
            $this->assign('shop_id',null);
            $this->assign('pay_type',null);
            $this->assign('pay_status',null);
            $this->assign('start_time',null);
            $this->assign('end_time',null);
        }
        $data = db('order')->alias('o')->field('o.*,u.name u_name')->join('user u','o.uid=u.id','LEFT')->order('o.id desc')->paginate(10);
        $this->assign('order_list',$data);

        return $this->fetch();
    }
}