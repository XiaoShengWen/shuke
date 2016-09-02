<?php
use Phalcon\Paginator\Adapter\NativeArray as PaginatorArray;

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
        ];

        // 章节统计
        $params = $this->getParams($conf);
        $novel = new Novels();
        $result = $novel->getODMList(1, 1000, [], ['publish_time' => -1]); 
        $paginator = new PaginatorArray(
            array(
                "data"  => $result,
                "limit" => 10,
                "page"  => $params['page_no'],
            )
        );
        $page = $paginator->getPaginate();
        $this->view->page = $page;

        // 日期统计
        $field_arr = [
            $novel->collect,
            $novel->comment,
            $novel->reward,
            $novel->recommend,
            $novel->produce_time_num,
            $novel->count,
        ];
        $date  = $novel->statisticByDate($result, $field_arr);
        foreach ($date  as $date_type => $date_arr) {
            $list_arr = new PaginatorArray(
                array(
                    "data"  => $date_arr,
                    "limit" => 10,
                    "page"  => $params['page_no'],
                )
            );
            $list = $list_arr->getPaginate();
            $this->view->$date_type = $list;
        }

        $this->view->href = [
            'page' => "/novel/list?page_no=",
            'add'  => "/novel/add",
            'edit' => "/novel/edit",
            'del'  => "/novel/del",
        ];

        $field_arr = [
            $novel->collect,
            $novel->comment,
            $novel->reward,
            $novel->recommend,
        ];
        $chart = $novel->getChartData($result, $field_arr);
        $this->view->chart = json_encode($chart);
    }

    public function addAction()
    {
        $conf = [
            'volume'           => ['int', null, true],
            'chapter'          => ['int', null, true],
            'name'             => ['striptags', null, true],
            'desc'             => ['striptags', null, false],
            'collect'          => ['alphanum', 0, false],
            'comment'          => ['alphanum', 0, false],
            'reward'           => ['alphanum', 0, false],
            'recommend'        => ['alphanum', 0, false],
            'publish_time'     => ['striptags', 0, true],
            'produce_time_num' => ['alphanum', 0, true],
            'count'            => ['alphanum', 0, true],
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
            'volume'           => ['int', null, true],
            'chapter'          => ['int', null, true],
            'name'             => ['striptags', null, true],
            'desc'             => ['striptags', null, false],
            'collect'          => ['alphanum', 0, false],
            'comment'          => ['alphanum', 0, false],
            'reward'           => ['alphanum', 0, false],
            'recommend'        => ['alphanum', 0, false],
            'publish_time'     => ['striptags', 0, true],
            'produce_time_num' => ['alphanum', 0, true],
            'count'            => ['alphanum', 0, true],
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
