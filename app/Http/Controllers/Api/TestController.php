<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class TestController extends Controller
{
    public function goods()
    {
        // dd(12133);
        echo '<pre>';print_r($_GET);echo '</pre>';
        $id = $_GET['id'];
        echo "goods_id: ".$id;
    }

    public function de()
    {
        // dd(666666);
        // echo "接收到的urlencode数据：" . $_GET['data'];
        // echo '<br>';
        // echo "base64decode数据：". base64_decode($_GET['data']);
        $data = base64_decode($_GET['data']);
        echo '<br>';
        $method = 'AES-256-CBC';
        $key = '1905api';
        $vi = 'WUSD8796IDjhkchd';

        // 解密
        $dec_data = openssl_decrypt($data,$method,$key,OPENSSL_RAW_DATA,$vi);
        echo "解密数据：" . $dec_data;
    }

    public function de2()
    {
        $data = base64_decode($_GET['data']);
        echo '<hr>';
        echo "接收到的数据：".$data;

        $method = 'AES-256-CBC';
        $key = '1905api';
        $vi = 'WUSD8796IDjhkchd';

        // 解密
        $dec_data = openssl_decrypt($data,$method,$key,OPENSSL_RAW_DATA,$vi);
        echo "解密数据：" . $dec_data;

        $arr = json_decode($dec_data);
        echo '<pre>';print_r($arr);echo '</pre>';
    }

    public function red1()
    {
        $enc_data_str = $_GET['data'];      //接收数据
        echo "接收到的base64的密文：" . $enc_data_str;
        echo '<hr>';
        $base64_decode_str = base64_decode($enc_data_str);
        echo "base64decode密文：" . $base64_decode_str; 
        echo '<hr>';

        // 解密
        $pub_key = file_get_contents(storage_path('keys/pub.key'));
        // echo "公钥：" . $pub_key;die;
        // $pub_key = openssl_get_privatekey(storage_path('keys/pub.key'));
        // var_dump($pub_key);
        // echo '<br>';
        // echo \openssl_error_string();die;
        openssl_public_decrypt($base64_decode_str,$dec_data,$pub_key);

        echo "解密数据：" . $dec_data;
    }

    public function curl1()
    {
        echo "server";echo '<br>';
        echo '<pre>';print_r($_GET);echo '</pre>';die;
    }
    public function curl2()
    {
        // echo "server";echo '<br>';
        echo '<pre>';print_r($_GET);echo '</pre>';die;
    }

    public function curl3()
    {
        // echo "server";echo '<br>';
        echo '<pre>';print_r($_POST);echo '</pre>';
        echo '<pre>';print_r($_FILES);echo '</pre>';
    }
}
