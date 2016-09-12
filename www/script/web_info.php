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

do {
    $html = file_get_dom('http://www.hbooker.com/index');
    if ($html) {
        $one_flag = 0;
        foreach ($html('div[class="book-list-table-wrap"]') as $e) {
            $two_flag = 0;
            foreach ($e('.book-list-table') as $one) {
                $three_flag = 0;
                foreach ($one('tr') as $two) {
                    $final_flag = 0;
                    $white_arr = [1,2,30];
                    if (in_array($three_flag,$white_arr)) {
                        foreach($two('td') as $three) {
                            if ($final_flag == 5) {
                                foreach ($three('p') as $final) {
                                    $date_time =  $final->getChild(0)->getInnerText();
                                    switch ($three_flag) {
                                    case 1 :
                                        $result['start_time'] = $date_time;
                                        break;
                                    case 2 :
                                        $result['second_time'] = $date_time;
                                        break;
                                    case 30 :
                                        $result['end_time'] = $date_time;
                                        break;
                                    }
                                    /* echo $date_time; */
                                    /* echo "<br>"; */
                                    /* echo $one_flag."-".$two_flag."-".$three_flag."-".$final_flag."-"; */
                                    /* echo "<br>"; */
                                }
                            }
                            $final_flag++;
                        }
                    }
                    $three_flag++;
                }
                $two_flag++;
            }
            $one_flag++;
        }
        $time_diff = round((strtotime($result['start_time']) - strtotime($result['end_time']))/60,0);
        $time_diff_2 = round((strtotime($result['start_time']) - strtotime($result['end_time']))/60,0);
        $data = array(
            'id'          => false,
            'start_time'  => $result['start_time'],
            'second_time' => $result['second_time'],
            'end_time'    => $result['end_time'],
            // 'create_time' => date('Y-m-d H:i:s',time() + 8 * 3600),
            'time_diff'   => $time_diff,
            'time_diff2'  => $time_diff_2,
        );
        $id = $dbConn->insert('web_info', $data);
    } 
} while (!$html); 
