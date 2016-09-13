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

    public static function getODMList($page = 1, $size = 100, array $filter = [], array $sort = [])
    {
        $condition = array(
            "conditions" => $filter,
            "limit" => $size,
            "skip" => ($page - 1) * $size,
        );
        if (!empty($sort)) {
            $condition["sort"] = $sort;
        }
        $result = static::find($condition);

        return $result;
    }
}
