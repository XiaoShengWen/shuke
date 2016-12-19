{% extends "layout.volt" %}

{% block head_script %} 
<link href="/css/jquery/jquery.datetimepicker.css" rel="stylesheet">
<link href="/css/other/bootstrap-table.css" rel="stylesheet">
<script type="text/javascript">
$Info['loopConf'] = '{{ list["loop-id"]|json_encode }}'; 
$Info['href'] = '{{ href|json_encode }}'; 
</script>
{% endblock %}

{% block content %}
<!--面包屑-->
<ul class="breadcrumb">
    <li>
        <i class="icon-home"></i>
        <a href="index.html">主页</a> 
        <i class="icon-angle-right"></i>
    </li>
    <li><a href="#">番茄时间</a></li>
</ul>
<!--面包屑结束-->

<!--土豆表单-->
<div class="box span12">
<div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
    <!-- loop添加模板 -->
    <div class="modal fade" id="loop-add-form" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                    <h4 class="modal-title" id="loop-modal-title">轮回新增</h4>
                </div>
                <div class="modal-body">
                    <form id="loop-form" class="form-horizontal">
                        <div class="control-group">
                            <label class="control-label" for="focusedInput">名称</label>
                            <div class="controls">
                                <input type="text" class="form-control" id="loop_name" name="name" placeholder="请输入名称"> 
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label" for="focusedInput">类别</label>
                            <div class="controls">
                                <select class="form-control" id="loop_type" name="type" >
                                    {% for v,k in conf['loop'] %}
                                    <option value='{{ v }}' >{{ k }}</option>
                                    {% endfor %}
                                </select>
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label" for="focusedInput">轮次</label>
                            <div class="controls">
                                <input type="number" min="1" class="form-control" id="loop" name="loop" placeholder="请输入轮次" value="1" > 
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label" for="focusedInput">阶段</label>
                            <div class="controls">
                                <input type="number" min="1" class="form-control" id="phase" name="phase" placeholder="请输入阶段" value="1" > 
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
                    <button type="button" class="btn btn-primary" id="loop-submit" >提交</button>
                </div>
            </div>
        </div>
    </div>
    <!-- loop添加模板结束 -->

    <!-- plan添加模板-->
    <div class="modal fade" id="plan-add-form" tabindex="-1" role="dialog" aria-labelledby="plan-add-form" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                    <h4 class="modal-title" id="plan-modal-title">计划新增</h4>
                </div>
                <div class="modal-body">
                    <form id="plan-form" class="form-horizontal">
                        <div class="control-group">
                            <label class="control-label" for="focusedInput">名称</label>
                            <div class="controls">
                                <input type="text" class="form-control" id="plan_name" name="name" placeholder="请输入名称"> 
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label" for="focusedInput">类别</label>
                            <div class="controls">
                                <select class="form-control" id="plan_type" name="type" >
                                    {% for v,k in conf['plan'] %}
                                    <option value='{{ v }}' >{{ k }}</option>
                                    {% endfor %}
                                </select>
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label" for="focusedInput">开始周期</label>
                            <div class="controls">
                                <input type="text" class="form-control" id="plan_begin_date" name="begin_date" placeholder="请选择开始日期" > 
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label" for="focusedInput">结束周期</label>
                            <div class="controls">
                                <input type="text" class="form-control" id="plan_end_date" name="end_date" placeholder="请选择结束日期" > 
                            </div>
                        </div>
                    </form>
                </div>
                <input type="hidden" class="form-control" id="plan_loop_id" name="loop_id"> 
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
                    <button type="button" class="btn btn-primary" id="plan-submit" >提交</button>
                </div>
            </div>
        </div>
    </div>
    <!-- plan添加模板结束 -->

    <div class="box-header">
        <h2>
            <i class="halflings-icon th"></i>
            <span class="break">任务列表</span>
        </h2>
        <!-- 添加按钮 -->
        <div class="box-icon">
            <a href="#" id="toggle-loop-add" class="btn-setting"><i class="halflings-icon wrench"></i></a>
        </div>
        <!-- 添加结束 -->
    </div>
    <div class="box-content">
        <ul class="nav nav-tabs" id="myTab">
            {% set loop_num = 0 %}
            {% for loop,one in list['loop'] %}
                <li
                    {% if loop_num == 0 %}
                        class = "active"
                    {% endif %}
                ><a href="#loop-{{ loop }}" role="tab" data-toggle="tab" >轮次{{ loop }}</a></li>
                {% set loop_num +=1 %}
            {% endfor %}
        </ul>
        <div class="tab-content">
            {% set loop_num = 0 %}
            {% set active_first = 0 %}
            {% for loop,one in list['loop'] %}
            <div role="tabpanel" class="tab-pane
                {% if loop_num == 0 %}
                    active
                {% endif %}
                " id="loop-{{ loop }}">
                <div class="box-content">
                    <div class="panel-group" id="{{ info['id_tag']}}-group" role="tablist" aria-multiselectable="true">
                        {% for info in one %}
                        <div class="panel panel-default">
                            <div class="panel-heading" role="tab" id="{{ info['id_tag'] }}-head">
                                <h4 class="panel-title">
                                    <a data-toggle="collapse" data-parent="#accordion" href="#{{ info['id_tag'] }}-collapse" aria-expanded="true" aria-controls="#{{ info['id_tag'] }}-collapse">
                                    {{ info['name'] }} 
                                    </a>
                                </h4>
                            </div>
                <!-- 默认展示{% if active_first == 0 %} -->
                <!--     in collapse-active-show --> 
                <!--     {% set active_first = 1 %} -->
                <!-- {% endif %} -->  
                            <div loop_id="{{ info['id'] }}" id="{{ info['id_tag'] }}-collapse" class="panel-collapse collapse" role="tabpanel" aria-labelledby="{{ info['id_tag'] }}-head">
                                <div class="panel-body">
                                    <div class="panel-body" style="padding-bottom:0px;">
                                        <!--按钮模块开始-->
                                        <div id="{{ info['id_tag']-btn }}" class="btn-group">
                                            <button loop_id="{{ info['id'] }}" type="button" class="btn btn-default toggle-plan-add" data-toggle="modal" data-target="#plan-modal" >
                                                <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>新增
                                            </button>
                                            <button type="button" class="btn btn-default time-login-submit">
                                                <span class="glyphicon glyphicon-remove" aria-hidden="true"></span>登记
                                            </button>
                                        </div>
                                        <!--按钮模块结束-->
                                        <table id="{{ info['id_tag'] }}-table"></table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        {% endfor %}
                    </div>
                </div>
                {% set loop_num +=1 %}
            {% endfor %}
            </div>
        </div>
    </div>
    <!--土豆表单结束-->

    <!--番茄列表-->
    <div class="panel-body" style="padding-bottom:0px;">
        <div id="toolbar-action" class="btn-group">
            <button id="action_add" type="button" class="btn btn-default" data-toggle="modal" data-target="#action-modal">
                <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>新增
            </button>
            <button id="action_delete" type="button" class="btn btn-default">
                <span class="glyphicon glyphicon-remove" aria-hidden="true"></span>删除
            </button>
        </div>

        <div class="modal fade" id="action-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                        <h4 class="modal-title" id="myModalLabel">Modal title</h4>
                    </div>
                    <div class="modal-body">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary">Save changes</button>
                    </div>
                </div>
            </div>
        </div>
        <table id="time-action"></table>
    </div>

</div>
<!--番茄表单结束-->

<!--统计表单结束-->
{% endblock %}

{% block foot_script %} 
<script type="text/javascript" src="/js/jquery/jquery.datetimepicker.full.js" ></script>
<script type="text/javascript" src="/js/other/bootstrap-table.js" ></script>
<script type="text/javascript" src="/js/web/time/index.js" ></script>
{% endblock %}
