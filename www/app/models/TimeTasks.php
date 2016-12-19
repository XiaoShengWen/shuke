<?php

class TimeTasks extends App\Models\BaseModel
{
    public $name       = "name";
    public $plan_id    = "plan_id";
    public $action_num = "action_num";

    public function initialize()
    {
        $this->setSource("time_task");
    }

    public function getParamsAttr()
    {
        return $params_attr = [
            'int' => [
                $this->action_num,
                $this->plan_id,
            ],
        ];
    }

    public function getParamsNote()
    {
        return $ret = [
            $this->name => "名称",
            $this->plan_id => "所属计划",
            $this->action_num => "行动次数",
        ];
    }
}
