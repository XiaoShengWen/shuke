<?php

use App\Models\Experiment;
use App\Models\Exception;

class Novels extends App\Models\BaseCollection
{
    public $name;

    public $desc;

    public $collect;

    public $comment;

    public $reward;

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
}
