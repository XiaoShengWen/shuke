<?php

class TimePlans extends App\Models\BaseModel
{
    public $name       = "name";
    public $type       = "type";
    public $loop_id    = "loop_id";
    public $begin_date = "begin_date";
    public $end_date   = "end_date";

    CONST PLAN_TYPE_WORK          = 1;
    CONST PLAN_TYPE_CAREER        = 2;
    CONST PLAN_TYPE_LIFE          = 3;
    CONST PLAN_TYPE_ENTERTAINMENT = 4;

    public static $type_conf = [
        self::PLAN_TYPE_WORK          => "工作",
        self::PLAN_TYPE_CAREER        => "事业",
        self::PLAN_TYPE_LIFE          => "生活",
        self::PLAN_TYPE_ENTERTAINMENT => "娱乐",
    ];

    public function getParamsAttr()
    {
        return $params_attr = [
            'int' => [
                $this->type,
                $this->loop_id,
            ],
        ];
    }

    public function initialize()
    {
        $this->setSource("time_plan");
    }

    public function getParamsNote()
    {
        return $ret = [
            $this->name => "名称",
            $this->type => "类别",
            $this->loop_id => "所属轮回",
            $this->begin_date => "开始周期",
            $this->end_date => "结束周期"
        ];
    }
}
