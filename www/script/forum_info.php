<?php
include dirname(__DIR__)."/script/basic.php";

// 获取论坛页面，判断包含书名的帖子在第一页是否存在
function getForumInfo($href, $novel_title)
{
    $result = [];
    $exist_flag = false;
    do{
        $html = file_get_dom($href);
        $final_position = 15;
        foreach ($html("div[class='ly-main']") as $one) {
            $show_num_position = 0;
            foreach ($one("tr") as $two) {
                foreach ($two("a") as $three) {
                    $title = $three->getChild(0)->getInnerText();
                    $show_flag = strstr($title,$novel_title);
                    if ($show_flag) {
                        $exist_flag = true;
                        $final_position = $show_num_position - 2;
                        break;
                    }                
                    $show_num_position++;
                }
                if ($exist_flag) {
                    break;
                }                
            }
            if ($exist_flag) {
                break;
            }                
        }

        $show_limit = 9;
        if ($final_position > $show_limit) {
            $show_flag = false;
        }

        $control_flag = getFlag();
        $dbConn = getDbConn();
        $forum_log = $dbConn->fetchRow("select * from control_flag where type = {$control_flag['forum']}");
        $forum_flag = $forum_log['flag'];
        $forum_id = $forum_log['id'];

        if (!$exist_flag || !$show_flag || !$forum_flag) {
            postForum($dbConn, $forum_id);
        } else {
            echo "标题已存在";
        }
    } while(!$html);
    return $result;
}


$href = "http://www.hbooker.com/bbs/shuhuang";
$novel_title = "被二次元玩坏了怎么办";
getForumInfo($href, $novel_title);

function postForum($dbConn, $forum_id)
{

    $href = "http://www.hbooker.com/bbs/add_bbs_comment";

    $cookie_arr = [
        "user_id=775599",
        "reader_id=775599",
        "login_token=c54776db3093277af498c83ed5dbdc60",
        // "qdgd=1",
        // "get_task_type_sign=1",
        /* "Hm_lvt_e843afdff94820d69cd6d82d24b9647e=1473125257,1473814438,1474249285,1474252426", */
        /* "Hm_lpvt_e843afdff94820d69cd6d82d24b9647e=1474266547", */
        /* "visits=16", */
        /* "CNZZDATA1259915916=1039889845-1474261629-http%253A%252F%252Fwww.hbooker.com%252F%7C1474261629" */
    ];
    $session = $dbConn->fetchRow("select * from login_session order by id desc limit 1");
    $cookie_arr[] = $session['session'];

    $comment_arr = [
        "(>▽<)",
        "＜（＾－＾）＞",
        "Ｏ(≧口≦)Ｏ",
        "(～￣▽￣)～"
    ];
    $post_data = [
        "bbs_id" => 61647,
    ];
    $post_data['comment_content'] = $comment_arr[array_rand($comment_arr,1)];
    $cookie = getCookie($cookie_arr);
    $ret = curlForum($href, $cookie, $post_data);
    $ret_arr = explode("\n",$ret);
    $response_arr = json_decode(end($ret_arr),true);

    switch ($response_arr['code']) {
        default:
            echo '<pre>';
            var_dump($response_arr); 
            echo '</pre>';
            $dbConn->update('control_flag',['id' => $forum_id],['flag' => 0]);
            break;
        case 100000:
            $dbConn->update('control_flag',['id' => $forum_id],['flag' => 1]);
            break;
    }
}

