<?php
include dirname(__DIR__)."/app/library/ganon.php";
include dirname(__DIR__)."/vendor/autoload.php";

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

$flag = false;
$title = "从零开始当魔王";
$table = "web_novel_show_log";
$data = [];
do {
    $html = file_get_dom('http://www.hbooker.com/index');
    if ($html) {
        foreach ($html('div[class="book-list-table-wrap"]') as $e) {
            foreach ($e('.book-list-table') as $one) {
                foreach ($one('tr') as $two) {
                    $final_flag = 0;
                    foreach($two('td') as $three) {
                        if ($final_flag == 2) {
                            foreach ($three('p') as $final) {
                                $novel_title =  $final->getChild(0)->getInnerText();
                                if (strstr($novel_title,$title)) {
                                    $flag = true;
                                    $data['title'] = $novel_title;
                                } else {
                                    $flag = false;
                                }
                            }
                            foreach ($three('span') as $final) {
                                $novel_chapter =  $final->getChild(0)->getInnerText();
                                if ($flag) {
                                    $all_arr = explode('.',$novel_chapter);
                                    $data['chapter'] = trim($all_arr[0]);
                                    $data['name'] = trim($all_arr[1]);
                                }                             
                            }
                        } 
                        $final_flag++;
                    }
                }
            }
        }
        $title_result = $dbConn->fetchRow("select * from {$table}  where name = '{$data['name']}' and chapter = '{$data['chapter']}' ");
        if (!empty($data)) {
            if (empty($title_result)) {
                $data['id'] = false;
                $id = $dbConn->insert($table, $data);
            }
        } else {
            $update_result = $dbConn->fetchRow("select * from {$table}  where end_time = ''");
            $conds = [
                'id' => $update_result['id']
            ];
            $update_data = [
                'end_time' => date('Y-m-d H:i:s',time()),
            ];
            $id = $dbConn->update($table,$conds, $update_data);
        }
    } 
} while (!$html); 
