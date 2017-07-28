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
        $ggtop = db('guanggao')->field('id,name,photo')->order('id desc')->page(0,10)->select();
        foreach ($ggtop as &$item) {
            $item['name'] = urlencode($item['name']);
            $item['photo'] = self::DATAURL.$item['photo'];
        }

        $brand = db('brand')->field('id,name,photo')->order('id desc')->page(0,10)->select();
        foreach ($brand as &$bitem) {
            $bitem['name'] = urlencode($bitem['name']);
            $bitem['photo'] = self::DATAURL.$bitem['photo'];
        }

        $course = db('course')->field('id,title,intro,photo')->order('id desc')->page(0,10)->select();
        foreach ($course as &$citem) {
            $citem['title'] = urlencode($citem['title']);
            $citem['intro'] = urlencode($citem['intro']);
            $citem['photo'] = str_replace(DS,'/',self::DATAURL.$citem['photo']);
        }

        $product = db('product')->field('id,name,intro,photo_x,price')->order('id desc')->page (0,10)->select();
        foreach ($product as &$pitem) {
//            $pitem['name'] = urlencode($pitem['name']);
            $pitem['photo_x'] = str_replace(DS,'/',self::DATAURL.$pitem['photo_x']);
        }
        return array('ggtop'=>$ggtop,'brand'=>$brand,'course'=>$course,'prolist'=>$product);
    }

    public function getlist()
    {
        $page = intval($this->request->param('page')) ? : 0;
        $map = [

        ];
        $prolist = db('product')->field('id,name,photo_x,price_yh')->where($map)->order('id desc')->page($page,10)->select();
        foreach ($prolist as &$pitem) {
            $pitem['photo_x'] = self::DATAURL.$pitem['photo_x'];
        }
        return $prolist;
    }

}