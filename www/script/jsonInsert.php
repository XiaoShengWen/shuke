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
/* $ret = $dbConn->fetchRowMany('SELECT * FROM web_info'); */
/* foreach ($ret as $index => $result) { */
/*     $show[$index]['time'][] = $result['end_time']; */
/*     $show[$index]['diff'][] = round((strtotime($result['start_time']) - strtotime($result['end_time']))/60,0); */
/*     $show[$index]['diff2'][] = round((strtotime($result['start_time']) - strtotime($result['end_time']))/60,0); */
/* } */
$file_name = dirname(__DIR__)."/database/mongo/backup.json";

$f = fopen($file_name,'r');
while(!feof($f))
{
    $line = fgets($f);
    $arr = json_decode($line,true);
    if (isset($arr['name'])) {
        $insert_arr = [
            'id'               => false,
            'name'             => $arr['name'],
            'desc'             => $arr['desc'],
            'volume'           => $arr['volume']['$numberLong'],
            'chapter'          => $arr['chapter']['$numberLong'],
            'collect'          => $arr['collect']['$numberLong'],
            'comment'          => $arr['comment']['$numberLong'],
            'reward'           => $arr['reward']['$numberLong'],
            'recommend'        => $arr['recommend']['$numberLong'],
            'publish_time'     => $arr['publish_time'],
            'produce_time_num' => (isset($arr['produce_time_num']['$numberLong']) && is_numeric($arr['produce_time_num']['$numberLong'])) ? $arr['produce_time_num']['$numberLong'] : 2,
            'count'            => $arr['count']['$numberLong'],
            'subscribe'        => 0,
            'month_ticket'     => $arr['month_ticket']['$numberLong'],
        ];
        $id = $dbConn->insert('novels',$insert_arr);
    }
}
fclose($f);
