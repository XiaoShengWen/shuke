<?php

class TimeActions extends App\Models\BaseModel
{
    public $name       = 'name';
    public $task_id    = 'task_id';
    public $begin_time = "begin_time";
    public $end_time   = "end_time";

    public function initialize()
    {
        $this->setSource("time_action");
    }

    public function getParamsAttr()
    {
        return $params_attr = [
            'int' => [
                $this->task_id,
            ],
        ];
    }

    public function getParamsNote()
    {
        return $ret = [
            $this->name       => "行为简介",
            $this->task_id    => "所属任务id",
            $this->begin_time => "开始时间",
            $this->end_time   => "结束时间",
        ];
    }
}
