<?php
include dirname(__DIR__)."/app/library/ganon.php";
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
                    if ($three_flag == 1 || $three_flag == 30) {
                        foreach($two('td') as $three) {
                            if ($final_flag == 5) {
                                foreach ($three('p') as $final) {
                                    $date_time =  $final->getChild(0)->getInnerText();
                                    switch ($three_flag) {
                                    case 1 :
                                        $result['start_time'] = $date_time;
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
        echo '<pre>'; 
        var_dump($result); 
        echo '</pre>';
    } 
} while (!$html); 
