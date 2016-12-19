<?php

class LoopController extends BaseController
{
    protected $obj = null;

    public function initialize() {
        $id = trim($this->request->get('id'));
        if ($id) {
            $this->obj = TimeLoops::findFirst("id = {$id}");
        } 
    }

    public function listAction()
    {
        $conf = [
            'offset' => ['int', 1, false],
            'limit' => ['int', 10, false],
        ];
        $params = $this->getParams($conf);
        $list = TimeLoops::find([
            'order' => 'id desc',
            ]
        )->toArray();

        $result['total'] = TimeLoops::count();
        $result['rows'] = array_slice($list, ($params['offset'] - 1) * $params['limit'], $params['limit']);

        return $this->responseJsonRaw($result);
    }

    public function storeAction()
    {
        $obj = new TimeLoops();
        $conf = [
            $obj->name => ['striptags', null, true],
            $obj->type => ['int', null, true],
            $obj->loop => ['int', null, true],
            $obj->phase => ['int', null, true],
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
        $obj = new TimeLoops();
        $conf = [
            $obj->name => ['striptags', null, true],
            $obj->type => ['int', null, true],
            $obj->loop => ['int', null, true],
            $obj->phase => ['int', null, true],
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
