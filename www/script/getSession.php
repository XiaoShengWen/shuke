<?php
include dirname(__DIR__)."/script/basic.php";

$dbConn = getDbConn();

// 去浏览页面，获取ci_session的cookie
$href = "http://www.hbooker.com/bbs/shuhuang";

$session = $dbConn->fetchRow("select * from login_session order by id desc limit 1");
if (!empty($session)) {
    $dbConn->executeSql("delete from login_session where id < {$session['id']}");
} else {
    $session['session'] = 'ci_session=8182dccb7d675173550bc2117924cb617eb5c4cb';
}

$cookie_arr = [
    "user_id=775599",
];
$cookie_arr[] = $session['session'];

$cookie = getCookie($cookie_arr);
$post_data = [];
$user_name = "书架";
$ret = curlForum($href, $cookie, $post_data);
if (strpos($ret,$user_name)) {
    $start = strpos($ret,"Set-Cookie");
    $ci_session = null;
    if ($start) {
        $final_cookie = substr($ret,$start,$start+32);
        $final_cookie_arr = explode("\n",$final_cookie);
        foreach ($final_cookie_arr as $one) {
            if (strstr($one, "ci_session")) {
                $session_arr = explode(";",strstr($one, "ci_session"));
                $ci_session = $session_arr[0];
                break;
            }
        }
    }
    if ($ci_session) {
        $data_arr = [
            'session'      => $ci_session,
        ];
        $dbConn->insert('login_session',$data_arr);
        echo '<pre>'; 
        var_dump("新的登录session:".$ci_session); 
        echo '</pre>';
    } else {
        echo '<pre>'; 
        var_dump("session未更新"); 
        echo '</pre>';
    }
} else {
    echo '<pre>'; 
    var_dump("session已丢失"); 
    echo '</pre>';
}
