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
        $conf = [
            'page_no' => ['int', 1, false],
            'page_size' => ['int', 10, false],
        ];
        $params = $this->getParams($conf);
        $statistic = new Statistics();
        $result = $statistic->getODMList($params['page_no'], $params['page_size']); 
        $this->view->list = $result;
    }

    public function addAction()
    {
        $conf = [
            'volume'    => ['int', null, true],
            'chapter'   => ['int', null, true],
            'name'      => ['striptags', null, true],
            'desc'      => ['striptags', null, false],
            'collect'   => ['int', null, true],
            'comment'   => ['int', null, true],
            'reward'    => ['int', 0, false],
            'recommend' => ['int', 0, false],
        ];
        $params = $this->getParams($conf);
        $statistic = new Statistics();
        foreach ($params as $index => $value) {
            $statistic->$index = $value;
        }
        $statistic->save();
        
        return $this->responseJson(Error::ERR_OK, $params);
    }

    public function editAction()
    {
        $conf = [
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
