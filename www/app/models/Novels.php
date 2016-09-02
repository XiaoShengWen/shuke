<?php

use App\Models\Experiment;
use App\Models\Exception;

class Novels extends App\Models\BaseCollection
{
    // 章节名称
    public $name = 'name';

    // 描述 
    public $desc = 'desc';

    // 收藏 
    public $collect = 'collect';

    // 评论
    public $comment = 'comment';

    // 奖励 
    public $reward = 'reward';

    // 推荐 
    public $recommend = 'recommend';

    // 发布时间 
    public $publish_time = 'publish_time';

    // 创作消耗时间
    public $produce_time_num = 'produce_time_num';

    // 字数
    public $count = 'count';

    // 订阅 
    public $subscribe = 'subscribe';

    public function getSource()
    {
        return "novels";
    }

    public function beforeCreate()
    {
        parent::beforeCreate();
    }

    public function beforeUpdate()
    {
        parent::beforeUpdate();
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
}
