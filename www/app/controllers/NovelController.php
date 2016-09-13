<?php
use Phalcon\Paginator\Adapter\NativeArray as PaginatorArray;

class NovelController extends BaseController
{
    protected $novel = null;

    public function initialize() {
        $id = trim($this->request->get('id'));
        if ($id) {
            $this->novel = Novels::findFirst("id = {$id}");
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
        $result = $novel->getODMList(1, 1000, [], 'id desc'); 
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

        // 数据综合
        $sum_data = $novel->getSumData($field_arr);
        $this->view->sum_data = $sum_data;
        $this->view->params_note = $novel->getParamsNote();
    }

    public function addAction()
    {
        $novel = new Novels();
        $conf = [
            $novel->volume           => ['int', null, true],
            $novel->chapter          => ['int', null, true],
            $novel->name             => ['striptags', null, true],
            $novel->desc             => ['striptags', null, false],
            $novel->collect          => ['alphanum', 0, true],
            $novel->comment          => ['alphanum', 0, false],
            $novel->reward           => ['alphanum', 0, false],
            $novel->recommend        => ['alphanum', 0, false],
            $novel->publish_time     => ['striptags', 0, true],
            $novel->produce_time_num => ['alphanum', 0, true],
            $novel->count            => ['alphanum', 0, true],
            $novel->month_ticket     => ['alphanum', 0, false],
        ];
        $params = $this->getParams($conf);
        $attr_arr = $novel->getParamsAttr();
        foreach ($params as $index => $value) {
            if (in_array($index,$attr_arr['int'])) {
                $novel->$index = (int)$value;
            } else {
                $novel->$index = $value;
            }
        }
        $novel->save();
        
        return $this->responseJson(Error::ERR_OK);
    }

    public function editAction()
    {
        $novel = new Novels();
        $conf = [
            $novel->volume           => ['int', null, true],
            $novel->chapter          => ['int', null, true],
            $novel->name             => ['striptags', null, true],
            $novel->desc             => ['striptags', null, false],
            $novel->collect          => ['alphanum', 0, true],
            $novel->comment          => ['alphanum', 0, false],
            $novel->reward           => ['alphanum', 0, false],
            $novel->recommend        => ['alphanum', 0, false],
            $novel->publish_time     => ['striptags', 0, true],
            $novel->produce_time_num => ['alphanum', 0, true],
            $novel->count            => ['alphanum', 0, true],
            $novel->month_ticket     => ['alphanum', 0, false],
        ];
        $attr_arr = $novel->getParamsAttr();
        $params = $this->getParams($conf);
        
        foreach ($params as $index => $value) {
            if (in_array($index,$attr_arr['int'])) {
                $this->novel->$index = (int)$value;
            } else {
                $this->novel->$index = $value;
            }
        }
        $result = $this->novel->update();
        
        return $this->responseJson(Error::ERR_OK);
    }

    public function delAction()
    {
        $this->novel->delete();
        return $this->responseJson(Error::ERR_OK);
    }
}
