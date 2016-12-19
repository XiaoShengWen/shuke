<?php

class PlanController extends BaseController
{
    protected $obj = null;

    public function initialize() {
        $id = trim($this->request->get('id'));
        if ($id) {
            $this->obj = TimePlans::findFirst("id = {$id}");
        } 
    }

    public function listAction()
    {
        $conf = [
            'offset'  => ['int', 1, false],
            'limit'   => ['int', 10, false],
            'loop_id' => ['int', 10, false],
        ];
        $params = $this->getParams($conf);
        $list = TimePlans::find([
            "conditions" => "loop_id = ?1",
            "bind"       => [
                1 => $params['loop_id'],
            ],
            'order' => 'id desc',
            ]
        )->toArray();

        $result['total'] = TimePlans::count([
            "conditions" => "loop_id = ?1",
            "bind"       => [
                1 => $params['loop_id'],
            ],
        ]);
        $result['rows'] = array_slice($list, ($params['offset'] - 1) * $params['limit'], $params['limit']);

        return $this->responseJsonRaw($result);
    }

    public function storeAction()
    {
        $obj = new TimePlans();
        $conf = [
            $obj->name       => ['striptags', null, true],
            $obj->type       => ['int', null, true],
            $obj->loop_id    => ['int', null, true],
            $obj->begin_date => ['striptags', null, true],
            $obj->end_date   => ['striptags', null, true],
        ];
        $params = $this->getParams($conf);
        
        $attr_arr = $obj->getParamsAttr();
        foreach ($params as $index => $value) {
            if (in_array($index,$attr_arr['int'])) {
                $obj->$index = (int)$value;
            } else {
                $obj->$index = $value;
            }
        }
        $obj->save();
        
        return $this->responseJson(Error::ERR_OK);
        
    }

    public function editAction()
    {
        $obj = new TimePlans();
        $conf = [
            $obj->name       => ['striptags', null, true],
            $obj->type       => ['int', null, true],
            $obj->loop_id    => ['int', null, true],
            $obj->begin_date => ['striptags', null, true],
            $obj->end_date   => ['striptags', null, true],
        ];
        
        $attr_arr = $obj->getParamsAttr();
        $params = $this->getParams($conf);
        
        foreach ($params as $index => $value) {
            if (in_array($index,$attr_arr['int'])) {
                $this->obj->$index = (int)$value;
            } else {
                $this->obj->$index = $value;
            }
        }
        $result = $this->obj->update();
        
        return $this->responseJson(Error::ERR_OK);
    }

    public function delAction()
    {
        $this->obj->delete();
        return $this->responseJson(Error::ERR_OK);
    }
}
