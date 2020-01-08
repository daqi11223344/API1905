<?php

namespace App\Http\Controllers\Index;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;

class IndexController extends Controller
{
    public function index()
    {
        echo __METHOD__;
    }

    public function alipay()
    {
        $ali_gateway = 'https://openapi.alipaydev.com/gateway.do';  //支付网关
        // 公共请求参数
        $appid = '2016101300676944';
        $method = 'alipay.trade.page.pay';
        $charset = 'utf-8';
        $signtype = 'RSA2';
        $sign = '';
        $timestamp = date('Y-m-d H:i:s');
        $version = '1.0';
        $return_url = 'http://api.wangzhimo.top/test/alipay/return';       // 支付宝同步通知
        $notify_url = 'http://api.wangzhimo.top/test/alipay/notify';        // 支付宝异步通知地址
        $biz_content = '';
        // 请求参数
        $out_trade_no = time() . rand(1111,9999);       //商户订单号
        $product_code = 'FAST_INSTANT_TRADE_PAY';
        $total_amount = 10000;
        $subject = '测试订单' . $out_trade_no;
        $request_param = [
            'out_trade_no'  => $out_trade_no,
            'product_code'  => $product_code,
            'total_amount'  => $total_amount,
            'subject'       => $subject
        ];
        $param = [
            'app_id'        => $appid,
            'method'        => $method,
            'charset'       => $charset,
            'sign_type'     => $signtype,
            'timestamp'     => $timestamp,
            'version'       => $version,
            'notify_url'    => $notify_url,
            'return_url'    => $return_url,
            'biz_content'   => json_encode($request_param)
        ];
        //echo '<pre>';print_r($param);echo '</pre>';
        // 字典序排序
        ksort($param);
        //echo '<pre>';print_r($param);echo '</pre>';
        // 2 拼接 key1=value1&key2=value2...
        $str = "";
        foreach($param as $k=>$v)
        {
            $str .= $k . '=' . $v . '&';
        }
        //echo 'str: '.$str;echo '</br>';
        $str = rtrim($str,'&');
        //echo 'str: '.$str;echo '</br>';echo '<hr>';
        // 3 计算签名   https://docs.open.alipay.com/291/106118
        $key = storage_path('keys/app_priv');
        $priKey = file_get_contents($key);
        $res = openssl_get_privatekey($priKey);
        //var_dump($res);echo '</br>';
        openssl_sign($str, $sign, $res, OPENSSL_ALGO_SHA256);       //计算签名
        $sign = base64_encode($sign);
        $param['sign'] = $sign;
        // 4 urlencode
        $param_str = '?';
        foreach($param as $k=>$v){
            $param_str .= $k.'='.urlencode($v) . '&';
        }
        $param_str = rtrim($param_str,'&');
        $url = $ali_gateway . $param_str;
        //发送GET请求
        //echo $url;die;
        header("Location:".$url);
    }

    /**
     * 
     * 获取用户列表
     * 2020年1月2# 
     */

    public function userList()
    {
        $user_token = $_SERVER['HTTP_TOKEN'];
        $current_url = $_SERVER['REQUEST_URI'];
        echo 'user_token:'.$user_token;echo '</br>';
        echo "当前URL:".$current_url;echo'<hr>';
        // echo '<pre>';print_r($_SERVER);echo '</pre>';
        $redis_key = 'str:count:url:'.$user_token.'url:'.md5($current_url);
        echo 'redis key: '.$redis_key;echo '</br>'; 

        // $count = Redis::get($redis_key);    //获取接口的访问次数
        // echo "接口的访问次数： ".$count;echo '</br>';

        // if($count>=5){
        //     echo "<b style='color:red'>访问太频繁，本次访问已达到上限，下次吧</b>";
        //     Redis::expire($redis_key,60);
        //     die;
        // }

        $count = Redis::incr($redis_key);
        echo 'count: '.$count;
    }

    public function accii()
    {
        $char = 'Hello World';
        $length = strlen($char);
        echo $length;echo '<br>';

        $pass = "";
        for($i=0;$i<$length;$i++)
        {
            echo $char[$i] . '>>>' . ord($char[$i]); echo '<br>';
            $ord = ord($char[$i]) + 3;
            $chr = chr($ord);
            echo $char[$i] . '>>>' . $ord . '>>>' . $chr;echo '<hr>';
            $pass .= $chr;
        }

        echo '<br>';
        echo $pass;
    }


    // 解密
    public function dec()
    {
        $enc = 'Khoor#Zruog';
        echo "密文：".$enc;echo '<hr>';
        $length = strlen($enc);

        $str = "";
        for($i=0;$i<$length;$i++)
        {
            $ord = ord($enc[$i]) - 3;
            $chr = chr($ord);
            echo $ord . '>>>' . $chr ;echo '<br>';
            $str .=$chr;
        }
        echo "解密： ".$str;
    }
}