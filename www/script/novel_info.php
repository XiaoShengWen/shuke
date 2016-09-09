<?php
include dirname(__DIR__)."/app/library/ganon.php";
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
        echo '<pre>'; 
        var_dump($result); 
        echo '</pre>';
    }
} while(!$html);

