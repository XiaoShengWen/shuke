<?php
class StatisticController extends BaseController
{
    protected $statistic = null;

    public function initialize() {
        $id = $this->request->get('id');
        if ($id) {
            $this->statistic = Statistics::findById($id);
        }
    }

    public function listAction()
    {
        $this->conf = [
            'name' => ['striptags', null, false],
            'desc' => ['striptags', null, false],
        ];
        $statistic = new Statistics();
        $result = $statistic->getODMList(); 
        return $this->responseJson(Error::ERR_OK, $result);
    }

    public function addAction()
    {
        $this->conf = [
            'name'    => ['striptags', null, true],
            'desc'    => ['striptags', null, false],
            'collect' => ['int', null, true],
            'comment' => ['int', null, true],
            'reward'  => ['int', 0, false],
        ];
        $params = $this->getParams($conf);
        $statistic = new Statistics();
        foreach ($params as $index => $value) {
            $statistic->$index = $value;
        }
        $statistic->save();
        
        return $this->responseJson(Error::ERR_OK);
    }

    public function editAction()
    {
        $this->conf = [
            'name'    => ['striptags', null, false],
            'desc'    => ['striptags', null, false],
            'collect' => ['int', null, false],
            'comment' => ['int', null, false],
            'reward'  => ['int', null, false],
        ];
        $params = $this->getParams($conf);
        
    }

    public function delAction()
    {
        $this->statistic->delete();
        return $this->responseJson(Error::ERR_OK);
    }
}
