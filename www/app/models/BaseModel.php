<?php
namespace App\Models;

use Phalcon\Mvc\Model;

class BaseModel extends Model 
{
    public $updateTime; 
   
    public function beforeCreate()
    {  
        $this->updateTime = date("Y-m-d H:i:s"); 
    }  
   
    public function beforeUpdate()
    {
        $this->updateTime = date("Y-m-d H:i:s"); 
    }

    public static function getODMList($page = 1, $size = 100, array $filter = [], $order = "id")
    {
        $limit_start = ($page - 1) * $size;
        $limit_end = $page * $size;
        $condition = array(
            "conditions" => $filter,
            "limit" => "{$limit_start},{$limit_end}",
        );
        if (!empty($order)) {
            $condition["order"] = $order;
        }
        $result = static::find($condition);

        return $result->toArray();
    }
}
