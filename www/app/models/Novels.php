<?php

class Novels extends App\Models\BaseModel
{
    public $name             = 'name';             // 章节名称
    public $desc             = 'desc';             // 描述
    public $volume           = 'volume';           // 卷
    public $chapter          = 'chapter';          // 章
    public $collect          = 'collect';          // 收藏
    public $comment          = 'comment';          // 评论
    public $reward           = 'reward';           // 奖励
    public $recommend        = 'recommend';        // 推荐
    public $publish_time     = 'publish_time';     // 发布时间
    public $produce_time_num = 'produce_time_num'; // 创作消耗时间
    public $count            = 'count';            // 字数
    public $subscribe        = 'subscribe';        // 订阅
    public $month_ticket     = 'month_ticket';     // 月票

    public function getParamsAttr()
    {
        return $params_attr = [
            'int' => [
                $this->collect,
                $this->comment,
                $this->reward,
                $this->recommend,
                $this->count,
                $this->subscribe,
                $this->month_ticket,
            ],
        ];
    }

    public function getParamsNote()
    {
        return $ret = [
            $this->name             => '章节名称',
            $this->desc             => '描述',
            $this->volume           => '卷',
            $this->chapter          => '章',
            $this->collect          => '收藏',
            $this->comment          => '评论',
            $this->reward           => '打赏',
            $this->recommend        => '推荐',
            $this->publish_time     => '发布时间',
            $this->produce_time_num => '创作时间',
            $this->count            => '字数',
            $this->subscribe        => '订阅',
            $this->month_ticket     => '月票',
        ];
    }

    public function statisticByDate(array $resource, array $field_arr)
    {
        $result = [];
        foreach ($resource as $one) {
            $day = date("Y-m-d", strtotime($one['publish_time']));
            $week = date("Y-W", strtotime($one['publish_time']));
            $month = date("Y-m", strtotime($one['publish_time']));
            foreach ($field_arr as $field) {
                $result['day'][$day][$field] += $one[$field];
                $result['week'][$week][$field] += $one[$field];
                $result['month'][$month][$field] += $one[$field];
            }
            $result['day'][$day]['num'] += 1;
            $result['week'][$week]['num'] += 1;
            $result['month'][$month]['num'] += 1;
        }
        return $result;
    }

    public function getChartData($resource, array $field_arr, $limit = 30)
    {
        krsort($resource);
        $arr_num = count($resource);
        if ($arr_num >= $limit) {
            $slice_start = $arr_num - $limit;
        }
        $resource = array_slice($resource,$slice_start);
        $result = [];
        foreach ($resource as $one) {
            // 章节统计
            $num = count($result['chapter']['axis']);
            if ($num < $limit) {
                $result['chapter']['axis'][] = $one['volume']."-".$one['chapter'];
                foreach($field_arr as $field) {
                    $result['chapter'][$field][] = $one[$field];
                }
            }
        }
        $date = $this->statisticByDate($resource, $field_arr);
        foreach ($date as $date_type => $arr) {
            foreach ($arr as $date => $one) {
                $num = count($result[$date_type]['axis']);
                if ($num < $limit) {
                    $result[$date_type]['axis'][] = $date;
                    foreach($field_arr as $field) {
                        $result[$date_type][$field][] = $one[$field];
                    }
                }
            }
        }
        return $result;
    }

    public function getSumData(array $field_arr ,$novel_id)
    {
        $columns = [];
        foreach ($field_arr as $field) {
            $columns[] = $field;
        }
        $columns = implode($columns,',');

        $result = static::find(array(
            'columns' => $columns,
            'conditions' => "book_id = $novel_id",
            )
        );
        $ret = [];
        foreach ($result as $one) {
            foreach ($field_arr as $field) {
                $ret[$field] += $one->$field;
            }
        }
        return $ret;
    }
}
