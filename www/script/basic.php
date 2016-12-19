<?php
include dirname(__DIR__)."/app/library/ganon.php";
include dirname(__DIR__)."/vendor/autoload.php";
ini_set('date.timezone','Asia/Shanghai');
date_default_timezone_set('Asia/Shanghai');
function getFlag()
{
    return $control_flag = [
        "forum" => 1,
    ];
}
function getDbConn()
{
    $config = array(
        'host'       => '127.0.0.1',
        'user'       => 'root',
        'password'   => 'a20138502@wzy-360',
        'database'   => 'novel',
        // optional

        'fetchMode'  => \PDO::FETCH_ASSOC,
        'charset'    => 'utf8',
        'port'       => 3306,
        'unixSocket' => null,
    );
    $dbConn = new \Simplon\Mysql\Mysql(
        $config['host'],
        $config['user'],
        $config['password'],
        $config['database']
    );
    $zone = $dbConn->executeSql("set time_zone = '+8:00';");
    return $dbConn;
}

function curlForum($href, $cookie, $post_data)
{
    //初始化
    $curl = curl_init();
    //设置抓取的url
    curl_setopt($curl, CURLOPT_URL, $href);
    //设置头文件的信息作为数据流输出
    curl_setopt($curl, CURLOPT_HEADER, 1);
    //设置获取的信息以文件流的形式返回，而不是直接输出。
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    //设置post方式提交
    curl_setopt($curl, CURLOPT_POST, 1);
    //设置cookie
    curl_setopt ($curl, CURLOPT_COOKIE , $cookie);
    //设置post数据
    curl_setopt($curl, CURLOPT_POSTFIELDS, $post_data);
    //执行命令
    $data = curl_exec($curl);
    //关闭URL请求
    curl_close($curl);
    return $data;
}

function getCookie($arr)
{
    return implode('; ',$arr);
}
