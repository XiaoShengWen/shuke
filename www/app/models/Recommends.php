<?php
class Recommends extends App\Models\BaseModel
{
    public $type    = 'type';
    public $title   = 'title';
    public $author  = 'author';
    public $book_id = 'book_id';
    public $collect = 'collect';
    public $date    = 'date';

    public function initialize()
    {
        $this->setSource("web_recommend");
    }

    public function getParamsNote()
    {
        return $ret = [
            $this->type    => '推荐类别',
            $this->title   => '标题',
            $this->author  => '作者',
            $this->book_id => '作品id',
            $this->collect => '收藏',
            $this->date    => '日期',
        ];
    }


    public function getTypeName()
    {
        return static::query()
            ->columns('distinct type')
            ->execute()
            ->toArray();
    }

    public function getListByDateAndType($week_date)
    {
        $list = static::query()
            ->where("date = :date:")
            ->bind(['date' => $week_date])
            ->execute()
            ->toArray();
        $result = [];
        foreach ($list as $one) {
            $collect_arr = json_decode($one['collect'],true);
            $collect_new_arr = [];
            $collect_list = [];
            foreach ($collect_arr as $date_time => $collect) {
                $temp = [
                    "date_time" => $date_time,
                    "collect" => $collect
                ];
                $collect_new_arr[] = $temp;
            }
            foreach ($collect_new_arr as $index => $temp) {
                if ($index == 0) {
                    $collect_list['raw'] = $temp['collect']; 
                    $collect_list['sum'] = 0;
                } else {
                    $date_day = date("Y-m-d",strtotime($temp['date_time']));
                    $date_num = date("N",strtotime($date_day));
                    $before_collect = $collect_new_arr[$index - 1]['collect'];
                    $collect_list[$date_num] = $temp['collect'] - $before_collect;
                    $collect_list['sum'] += $temp['collect'] - $before_collect;
                }
            }
            $one['collect'] = $collect_list;
            $type_arr = explode('-',$one['type']);
            $result[$type_arr[0]][$type_arr[1]][] = $one;
        }
        return $result;
    }
}
