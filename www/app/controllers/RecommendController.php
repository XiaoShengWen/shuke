<?php
use Phalcon\Paginator\Adapter\NativeArray as PaginatorArray;

class RecommendController extends BaseController
{
    protected $recommend_list = [];

    public function initialize()
    {
        $date = trim($this->request->get('date'));
        if (!$date) {
            $date = date("Y-W",time());
        }     
        $recommend = new Recommends();
        $this->recommend_list = $recommend->getListByDateAndType($date);
    }

    public function listAction()
    {
        $date = trim($this->request->get('date'));
        $this->view->date = $date;
        $sub_type_list = [];
        foreach ($this->recommend_list as $type => $sub_type) {
            $sub_type_list = array_merge($sub_type_list,array_keys($sub_type));
        }
        $this->view->recommend_list = $this->recommend_list;
        $this->view->sub_type_list = $sub_type_list;
    }
}
