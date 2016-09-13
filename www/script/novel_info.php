<?php
include dirname(__DIR__)."/app/library/ganon.php";
include dirname(__DIR__)."/vendor/autoload.php";
ini_set('date.timezone','Asia/Shanghai');
date_default_timezone_set('Asia/Shanghai');

$config = array(
    'host'       => '127.0.0.1',
    'user'       => 'root',
    'password'   => '123456',
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

// 根据打点日志，获取时间间隔
function getShowInfo($chapter,$dbConn)
{
    $time_range = $dbConn->fetchRow("select * from web_novel_show_log where chapter = {$chapter}");
    if ($time_range) {
        $start = $dbConn->fetchRow("select * from novel_info where create_time <= '{$time_range['create_time']}' order by id desc limit 1");
        $end = $dbConn->fetchRow("select * from novel_info where create_time >= '".$time_range['end_time']."' limit 1");

        $diff = [
            'collect' => $end['collect'] - $start['collect'],
            'click' => $end['click'] 
        ];
    } else {
        $diff =[];
    }
    return $diff;
}


// 根据文章链接，获取发布日期和字数
function getPublishDateAndCount($href)
{
    $result = [];
    do{
        $html = file_get_dom($href);
        foreach ($html("div[class='read-hd']") as $one) {
            foreach ($one("p") as $final) {
                $date_obj = $final('span',2);
                $date  = $date_obj->getChild(0)->getInnerText();
                $result['publish_time'] = substr($date,15);
                $count_obj = $final('span',5);
                $count = $count_obj->getChild(0)->getInnerText();
                $result['count'] = substr($count,9);
            }
        }
    } while(!$html);
    return $result;
}


do{
    $html = file_get_dom('http://www.hbooker.com/book/book_detail?book_id=100017833');
    if($html) {
        foreach ($html('ul[class="ly-fl"]') as $e) {
            foreach ($e('.J_Stock_Favor_total') as $collect) {
                $col = $collect->getChild(0)->getInnerText();
                if (!empty($col)) {
                    $result['collect'] = $col;
                    break;
                }
            }
            foreach ($e('li') as $node) {
                $click = $node->getChild(2)->getInnerText();
                if (!empty($click)) {
                    $string = trim($click);
                    $first = substr($string,12);
                    $second = substr($first,0,-3);
                    $result['click'] = $second * 10000; 
                    break;
                }
            }
        }
        foreach ($html("div[class='book-intro-cnt']") as $e) {
            foreach ($e('.book-property') as $one) {
                $recommend_obj = $one('span',5);
                foreach ($recommend_obj('.J_Recommend_Rec_total') as $final) {
                    $result['recommend'] = $final->getChild(0)->getInnerText();
                }

                // 从href中获取
                /* $count_obj = $one('span',8); */
                /* $result['count'] = $count_obj->getChild(1)->getInnerText(); */
            }
        }
        foreach ($html("div[class='mod-tit1']") as $one) {
            foreach ($one('#J_CommentNum') as $final) {
                $result['comment'] = $final->getChild(0)->getInnerText();
            }
        }
        $new_list = [];
        foreach ($html("div[class='mod-bd']") as $one) {
            $flag_num = 0;
            foreach ($one("ul") as $bottom) {
                if ($flag_num == 1) {
                    foreach ($bottom("li") as $index => $li) {
                        $obj_a = $li->getChild(0);
                        $title = $obj_a->getInnerText();
                        $num_i = strpos($title,"</i>");
                        $all_title  = substr($title,$num_i + 4); 
                        $all_arr = explode('.',$all_title);
                        $new_list[$index]['chapter'] = trim($all_arr[0]);
                        $new_list[$index]['title'] = trim($all_arr[1]);
                        $new_list[$index]['href'] = $obj_a->attributes['href'];
                    }
                    $limit = 2;
                    $new_list = array_slice($new_list,-$limit);
                    ksort($new_list);
                }
                $flag_num++;
            }
        } 
        $max_chapter = $dbConn->fetchRow("select max(chapter) as max from novels ");
        $href_date_arr = [];
        foreach ($new_list as $index => $chapter) {
            $href_date_arr[$index] = getPublishDateAndCount($chapter['href']);
        }
        foreach ($new_list as $index => $chapter) {
            if ($chapter['chapter'] > $max_chapter['max']) {
                $data_arr = [
                    'name'      => $chapter['title'],
                    'end_time'  => "",
                    'collect'   => $result['collect'],
                    'comment'   => $result['comment'],
                    'recommend' => $result['recommend'],
                ];
                $data_arr = array_merge($data_arr,$date_and_count);
                $dbConn->insert('novels',$data_arr);
            } else {
                // 更新章节数据
                $chapter_old = $dbConn->fetchRow("select * from novels where chapter = {$chapter['chapter']}");
                if ($index != count($new_list) - 1) {
                    if ($chapter_old['auto_flag'] == 0) {
                        $chapter_first = $dbConn->fetchRow("select * from novel_info where create_time <= '{$href_date_arr[$index]['publish_time']}' order by id desc limit 1");
                        $chapter_second = $dbConn->fetchRow("select * from novel_info where create_time <= '{$href_date_arr[$index + 1]['publish_time']}' order by id desc limit 1");
                        $data_arr = [
                            'collect'   => $chapter_second['collect'] - $chapter_first['collect'],
                            'comment'   => $chapter_second['comment'] - $chapter_first['comment'],
                            'recommend' => $chapter_second['recommend'] - $chapter_first['recommend'],
                            'click'     => $chapter_second['click'],
                            'end_time' => date('Y-m-d H:i:s',time() + 8 *3600 ),
                            'auto_flag' => 1,
                        ];
                        $diff = getShowInfo($chapter['chapter'],$dbConn);
                        if ($diff) {
                            $data_arr['collect_show'] = $diff['collect'];
                        }
                        $dbConn->update('novels',['id' => $chapter_old['id']],$data_arr);
                    }
                } else {
                    $data_arr = [
                        'collect'   => $result['collect'] - $chapter_old['collect'],
                        'comment'   => $result['comment'] - $chapter_old['comment'],
                        'recommend' => $result['recommend'] - $chapter_old['recommend'],
                        'click'     => $result['click'],
                    ];
                    $dbConn->update('novels',['id' => $chapter_old['id']],$data_arr);
                }
            }
        }
        // 当发布最新章节时，统计上一章的数据
        // 1 根据打点日志记录的在线显示时间，区分推荐来源
        // 2 记录时，根据href获取发布时间等内容
        $data = array(
            'id'             => false,
            'collect'        => $result['collect'],
            'click'          => $result['click'],
            'recommend'      => $result['recommend'],
            'comment'        => $result['comment'],
            // 'create_time' => date('Y-m-d H:i:s',time() + 8 * 3600),
        );
        $id = $dbConn->insert('novel_info', $data);
    }
} while(!$html);


