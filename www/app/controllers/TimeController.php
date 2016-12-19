<?php

class TimeController extends BaseController 
{
    public function indexAction()
    {
        $loop_result = TimeLoops::find()->toArray();
        $loop_list = [];
        foreach ($loop_result as $one) {
            $one['id_tag'] = 'loop-'.$one['loop'].'-'.$one['phase'];
            $loop_list[$one['loop']][$one['phase']] = $one;
            $loop_id_list[] = $one['id_tag'];
        }
        foreach ($loop_list as $index => $one) {
            ksort($one);
            $loop_list[$index] = $one;
        }
        $this->view->list = [
            'loop' => $loop_list,
            'loop-id' => $loop_id_list,
        ];
        $this->view->conf = [
            'loop' => TimeLoops::$type_conf,
            'plan' => TimePlans::$type_conf 
        ];
        $this->view->href = [
            'loop' => [
                'list' => '/loop/list',
                'add' => '/loop/store',
                'edit' => '/loop/edit',
                'del' => '/loop/del',
            ],
            'plan' => [
                'list' => '/plan/list?loop_id=',
                'add' => '/plan/store',
                'edit' => '/plan/edit',
                'del' => '/plan/del',
            ],
            'task' => [
                'list' => '/task/list?plan_id=',
                'add' => '/task/store',
                'edit' => '/task/edit',
                'del' => '/task/del',
            ],
        ];
    }

    public function statisticAction()
    {
        
    }
}
