<?php
class NovelController extends BaseController
{
    protected $novel = null;

    public function initialize() {
        $id = trim($this->request->get('id'));
        if ($id) {
            $this->novel = Novels::findById($id);
        }
    }

    public function listAction()
    {
        $conf = [
            'page_no' => ['int', 1, false],
            'page_size' => ['int', 10, false],
        ];
        $params = $this->getParams($conf);
        $novel = new Novels();
        $result = $novel->getODMList($params['page_no'], $params['page_size']); 
        $this->view->list = $result;
        $this->view->test = "volt_ceshi";
    }

    public function addAction()
    {
        $conf = [
            'volume'    => ['int', null, true],
            'chapter'   => ['int', null, true],
            'name'      => ['striptags', null, true],
            'desc'      => ['striptags', null, false],
            'collect'   => ['alphanum', 0, false],
            'comment'   => ['alphanum', 0, false],
            'reward'    => ['alphanum', 0, false],
            'recommend' => ['alphanum', 0, false],
        ];
        $params = $this->getParams($conf);
        $novel = new Novels();
        foreach ($params as $index => $value) {
            $novel->$index = $value;
        }
        $novel->save();
        
        return $this->responseJson(Error::ERR_OK);
    }

    public function editAction()
    {
        $conf = [
            'volume'    => ['int', null, true],
            'chapter'   => ['int', null, true],
            'name'      => ['striptags', null, true],
            'desc'      => ['striptags', null, false],
            'collect'   => ['alphanum', 0, false],
            'comment'   => ['alphanum', 0, false],
            'reward'    => ['alphanum', 0, false],
            'recommend' => ['alphanum', 0, false],
        ];
        $params = $this->getParams($conf);
        
        foreach ($params as $index => $value) {
            $this->novel->$index = $value;
        }
        $this->novel->save();
        
        return $this->responseJson(Error::ERR_OK);
    }

    public function delAction()
    {
        $this->novel->delete();
        return $this->responseJson(Error::ERR_OK);
    }
}
