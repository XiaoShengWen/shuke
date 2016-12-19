<?php

class TimeLoops extends App\Models\BaseModel
{
    public $name = 'name';
    public $type = 'type';
    public $loop = 'loop';
    public $phase = 'phase';

    CONST LOOP_TYPE_ENGINEER    = 1;
    CONST LOOP_TYPE_BUSINESSMAN = 2;
    CONST LOOP_TYPE_ARTIST      = 3;
    CONST LOOP_TYPE_POLITICIAN  = 4;
    CONST LOOP_TYPE_ATHLETE     = 5;
    CONST LOOP_TYPE_HUMAN       = 6;

    public static $type_conf = [
        self::LOOP_TYPE_ENGINEER    => '工',
        self::LOOP_TYPE_BUSINESSMAN => '商',
        self::LOOP_TYPE_ARTIST      => '文',
        self::LOOP_TYPE_POLITICIAN  => '政',
        self::LOOP_TYPE_ATHLETE     => '体',
        self::LOOP_TYPE_HUMAN       => '通',
    ];

    public function initialize()
    {
        $this->setSource("time_loop");
    }

    public function getParamsAttr()
    {
        return $params_attr = [
            'int' => [
                $this->type,
                $this->loop,
                $this->phase,
            ],
        ];
    }

    public function getParamsNote()
    {
        return $ret = [
            $this->name => "名称",
            $this->type => "类别",
            $this->loop => "循环次数",
            $this->phase => "循环阶段",
        ];
    }
}
