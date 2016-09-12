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
                    $second = substr($first,0,3);
                    $result['click'] = $second * 10000; 
                    break;
                }
            }
        }
        $data = array(
            'id'   => false,
            'collect' => $result['collect'],
            'click'  => $result['click'],
        );
        $id = $dbConn->insert('novel_info', $data);
    }
} while(!$html);

