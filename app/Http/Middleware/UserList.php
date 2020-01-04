<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Redis;

class UserList
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $user_token = $_SERVER['HTTP_TOKEN'];
        $current_url = $_SERVER['REQUEST_URI'];
        echo 'user_token:'.$user_token;echo '</br>';
        echo "当前URL:".$current_url;echo'<hr>';
        // echo '<pre>';print_r($_SERVER);echo '</pre>';
        $redis_key = 'str:count:url:'.$user_token.'url:'.md5($current_url);
        echo 'redis key: '.$redis_key;echo '</br>'; 

        $count = Redis::get($redis_key);    //获取接口的访问次数
        echo "接口的访问次数： ".$count;echo '</br>';

        if($count>=5){
            echo "<b style='color:red'>访问太频繁，本次访问已达到上限，坐等10秒再继续</b>";
            Redis::expire($redis_key,10);
            die;
        }
        return $next($request);
    }
}
