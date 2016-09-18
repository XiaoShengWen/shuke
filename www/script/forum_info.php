<?php
include dirname(__DIR__)."/app/library/ganon.php";
include dirname(__DIR__)."/vendor/autoload.php";
ini_set('date.timezone','Asia/Shanghai');
date_default_timezone_set('Asia/Shanghai');

// 获取论坛页面，判断包含书名的帖子在第一页是否存在
function getForumInfo($href, $novel_title)
{
    $result = [];
    $exist_flag = false;
    do{
        $html = file_get_dom($href);
        foreach ($html("div[class='ly-main']") as $one) {
            foreach ($one("tr") as $two) {
                foreach ($two("a") as $three) {
                    $title = $three->getChild(0)->getInnerText();
                    $show_flag = strstr($title,$novel_title);
                    if ($show_flag) {
                        $exist_flag = true;
                        break;
                    }                
                }
            }
        }
        if (!$exist_flag) {
            $post_href = "http://www.hbooker.com/bbs/add_bbs_comment";

            $cookie = "qdgd=1; ci_session=376f9d40a3c9b2d17ed9e71716b37f24e9e7e8e8; user_id=496128; get_task_type_sign=1; visits=11; Hm_lvt_e843afdff94820d69cd6d82d24b9647e=1473125124,1473125257,1473814438,1474164321; Hm_lpvt_e843afdff94820d69cd6d82d24b9647e=1474166223; CNZZDATA1259915916=53349536-1472606076-%7C1474164415";

            $post_arr = [
                //"bbs_id" => 58211,
                "bbs_id" => "test",
                "comment_content" => "♪(^∇^*)",
            ];
            postForum($post_href, $post_arr, $cookie);
        } else {
            var_dump("标题存在");
        }
    } while(!$html);
    return $result;
}

$href = "http://www.hbooker.com/bbs/shuhuang";
$novel_title = "从零开始当魔王";
getForumInfo($href, $novel_title);

function postForum($href, $post_data, $cookie)
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
    //显示获得的数据
    $response_arr = json_decode($data,true);
    if ($response_arr['code'] != 100000) {
        var_dump($response_arr);
        echo "发送失败";
    } 
}
