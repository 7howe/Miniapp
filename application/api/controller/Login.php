<?php
/**
 * Created by PhpStorm.
 * User: 7howe
 * Date: 2017/7/28
 * Time: 8:55
 */

namespace app\api\controller;


class Login
{
    public function dologin()
    {
        session(null);
        $name = trim($_POST['name']);
        $pwd = md5(md5($_POST['pwd']));

        $map = [
            'name'=>$name,
            'pwd'=>$pwd
        ];
        if ($user = db('user')->where($map)->find()) {
            session('LoginName',$user['name']);
            session('id',$user['id']);
            session('photo',$user['photo']);
            return array('status'=>1,'session'=>$_SESSION);
        } else {
            return array('status'=>0,'err'=>'账号或密码错误');
        }
    }

    public function authlogin()
    {
        $openid = trim($_POST['openid']);
        if( $uid = db('user')->where('openid','eq',$openid)->find() ) {
            if ($uid['del'] == 1) {
                return array('status'=>0,'err'=>'账号已禁用');
            } else {
                $data['id'] = $uid['id'];
                $data['NickName'] = $_POST['NickName'];
                $data['HeadUrl'] = $_POST['HeadUrl'];
                return array('status'=>1,'arr'=>$data);
            }
        } else {
            $data['name'] = $_POST['NickName'];
            $data['uname'] = $_POST['NickName'];
            $data['photo'] = $_POST['HeadUrl'];
            $data['sex'] = $_POST['gender'];
            $data['openid'] = $openid;
            $data['source'] = 'wx';
            $data['addtime'] = time();

            if ($info = db('user')->insert($data)) {
                $data['id'] = $info;
                $data['NickName'] = $data['name'];
                $data['HeadUrl']  =$data['photo'];
                return array('status'=>1,'arr'=>$data);
            } else {
                return array('status'=>0,'err'=>'数据错误，操作失败');
            }

        }

    }

    public function getsessionkey()
    {
        $wx_config = config('weixin');
        $appid = $wx_config['appid'];
        $secret = $wx_config['secret'];
        $code = trim($_POST['code']);
        $get_token_url = 'https://api.weixin.qq.com/sns/jscode2session?appid='.$appid.'&secret='.$secret.'&js_code='.$code.'&grant_type=authorization_code';
        $ch = curl_init();
        curl_setopt($ch,'CURLOPT_URL',$get_token_url);
        curl_setopt($ch,'CURLOPT_HEADER',0);
        curl_setopt($ch,'CURLOPT_RETURNTRANSER',1);
        curl_setopt($ch,'CURLOPT_TIMEOUT',10);
        $res = curl_exec($ch);
        curl_close($ch);
        return $res;
    }

    public function logout()
    {
        session(null);
        return array('status'=>1,'err'=>'登出成功');
    }
}