<?php
include dirname(__DIR__)."/script/basic.php";

// 统计书客pc界面的各种推荐效果

function getRecommendInfo()
{
    $result = [];
    $href = "http://www.hbooker.com/index";
    do{
        $html = file_get_dom($href);
        // 获取banner右侧
        getTop($html,$result);

        // 获取左侧推荐 
        getLeft($html,$result);

        // 获取右侧推荐
        getRight($html, $result);
        
    } while(!$html);
    return $result;
}

$result = getRecommendInfo();

$dbConn = getDbConn();
$date = date("Y-W",time());
$week_recommend = $dbConn->fetchRowMany("select * from web_recommend where date = '{$date}'");
if (!empty($week_recommend)) {
    foreach($week_recommend as $one) {
        $index = $one['type']."-".$one['book_id'];
        $week_rec_arr[$index] = $one;
    }
}
foreach ($result as $type => $book_list) {
    $insert_data = [];
    foreach ($book_list as $book) {
        // 先判断这周推荐类别是否存在
        if (!empty($week_recommend)) {
            $match_index = $type."-".$book['book_id'];
            if (isset($week_rec_arr[$match_index])) {
                // 如果存在则根据book_id和类别，更新收藏一栏
                $old_book = $week_rec_arr[$match_index];
                $old_collect_arr = json_decode($old_book['collect'],true);
                $old_collect_arr[date("Y-m-d H:i:s",time())] = $book['collect'];
                $new_collect = json_encode($old_collect_arr);
                $update_data = [
                    "collect" => $new_collect,
                ];
                $dbConn->update('web_recommend', ['id' => $old_book['id']], $update_data);
            } else {
                //如果不存在，则插入新的一条
                $insert_collect = [
                    date("Y-m-d H:i:s",time()) => $book['collect']
                ];
                $insert_data[] = [
                    "id"      => false,
                    "type"    => $type,
                    "title"   => $book['title'],
                    "author"  => $book['author'],
                    "book_id" => $book['book_id'],
                    "collect" => json_encode($insert_collect,true),
                    "date"    => $date,
                ];
                $dbConn->insert('web_recommend',$insert_data);
            }
        } else {
            // 如果不存在，新增新的内容
            $insert_collect = [
                date("Y-m-d H:i:s",time()) => $book['collect']
            ];
            $insert_data[] = [
                "id"      => false,
                "type"    => $type,
                "title"   => $book['title'],
                "author"  => $book['author'],
                "book_id" => $book['book_id'],
                "collect" => json_encode($insert_collect,true),
                "date"    => $date,
            ];
        }
    }
    if (!empty($insert_data)) {
        $dbConn->insertMany('web_recommend',$insert_data);
    }
}

function checkType($type_title)
{
    $ret = false;
    $filter_arr = [
        "主编",
        "宅文",
        "BOSS",
        "男生",
    ];
    foreach ($filter_arr as $one) {
        if (strstr($type_title,$one)) {
            $ret = true;
            break;
        }
    }
    
    return $ret;
}

function getTop($html, &$result)
{
    $book_id = 'book_id';
    $num = 0;
    $tag_name = "首页-右侧";
    foreach ($html("#J_Topic") as $one) {
        foreach ($one("li") as $two) {
            foreach ($two("a") as $three) {
                $num++;
                $href = $three->attributes['href'];
                $result[$tag_name][$num]['book_id'] = getHrefParams($book_id,$href);
                $result[$tag_name][$num]['position'] = $num;
                $book_info = getBookBasicInfo($href);
                $result[$tag_name][$num] = array_merge($result[$tag_name][$num],$book_info);
                sleep(1);
            }
        }
    }
    return false;
}

function getRight($html, &$result)
{
    $book_id = 'book_id';
    foreach ($html(".recomm-list") as $one) {
        $origin_title = $one('div',0);
        $origin_type_title = $origin_title->getInnerText(); 
        $num =0;
        $title_check_flag = checkType($origin_type_title);
        if ($title_check_flag) {
            $type_title = "右侧-".$origin_type_title;
            foreach ($one('ul') as $book_list) {
                foreach ($book_list('li') as $book) {
                    $num++;
                    $book_a = $book('a',0);
                    $href = $book_a->attributes['href'];
                    $result[$type_title][$num]['book_id'] = getHrefParams($book_id, $href); 
                    foreach ($book_a("i") as $position_obj) {
                        $result[$type_title][$num]['position'] = $position_obj->getInnerText(); 
                    }
                    $book_info = getBookBasicInfo($href);
                    $result[$type_title][$num] = array_merge($result[$type_title][$num],$book_info);
                    sleep(1);
                }
            }
        }
    }
    return false;
}

function getLeft($html, &$result)
{
    $book_id = 'book_id';
    $limit_num = 5;
    $collect_num = 0;
    foreach ($html(".mod-box") as $one) {
        $collect_num++;
        if ($collect_num<=$limit_num) {
            foreach ($one(".mod-tit") as $origin_title) {
                $h3_obj = $origin_title('h3',0);
                $origin_type_title = $h3_obj->getChild(0)->getInnerText(); 
            }

            $title_check_flag = checkType($origin_type_title);
            if ($title_check_flag) {
                $type_title = "左侧-".$origin_type_title;
                foreach ($one('.mod-body') as $body_obj) {
                    $ul_obj = $body_obj("ul",0);
                    $num = 0;
                    foreach ($ul_obj('li') as $two) {
                        $num++;
                        foreach ($two('.title') as $title) {
                            $title_a_obj = $title('a',0);
                            $result[$type_title][$num]['title'] = $title_a_obj->attributes['title'];
                        }
                        $all_a_obj = $two('a',0);
                        $result[$type_title][$num]['book_id'] = getHrefParams($book_id, $all_a_obj->attributes['href']); 
                        foreach ($all_a_obj('.num') as $collect_obj) {
                            $result[$type_title][$num]['collect'] = $collect_obj->getChild(0)->getInnerText(); 
                        }
                        foreach ($all_a_obj('.t') as $author_obj) {
                            $author = $author_obj->getChild(1)->getInnerText(); 
                            // 取出边上的括号
                            $author = substr(trim($author),3,-3);
                            $result[$type_title][$num]['author'] = $author; 
                        }
                        $result[$type_title][$num]['position'] = $num; 
                    }
                }
            }
        }
    }
    return false;
}

function getHrefParams($str,$href) 
{
    $book_id = 0;
    $href_info = parse_url($href);
    $params = explode('&',$href_info['query']);
    foreach ($params as $one) {
        if (strstr($one,$str)) {
            $book_id_arr = explode('=',$one);
            $book_id = $book_id_arr[1];
        }
    }
    return $book_id;
}

function getBookBasicInfo($href)
{
    $result = [
        'title' => '',
        'collect' => 0,
        'author' => '',
    ];
    do{
        $html = file_get_dom($href);
        // 获取banner右侧
        foreach ($html(".book-title") as $one) {
            foreach ($one("h3") as $two) {
                $result['title'] = $two->getInnerText();
            }
            foreach ($one("a") as $two) {
                $result['author'] = $two->getInnerText();
            }
        }
        foreach ($html(".J_Stock_Favor_total") as $one) {
            $result['collect'] = $one->getChild(0)->getInnerText();
        }
    } while(!$html);
    return $result;
}
