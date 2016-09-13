{% extends "layout.volt" %}
   
{% block head_script %} 
<link href="/css/jquery/jquery.datetimepicker.css" rel="stylesheet">
<link href="/css/web/novel/list.css" rel="stylesheet">
<script type="text/javascript">
$Info['href'] = '{{ href|json_encode }}'; 
$Info['chart'] = '{{ chart }}'; 
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
    <li><a href="#">轻小说</a></li>
</ul>
<!--面包屑结束-->

<!--数据总和-->
<div class="row-fluid">
    {% for index,l in sum_data %}
    <div class="statbox purple span3" ontablet="span6" ondesktop="span3">
        <div class="number">{{ l }}<i class="icon-arrow-up"></i></div>
        <div class="title">{{ index  }}</div>
        <div class="footer">
            <a href="#">{{ params_note[index]  }}</a>
        </div>  
    </div>
    {%endfor%}
</div>
<!--数据总和-->

<!--时间统计-->
<div class="box span12">
    <div class="box-header">
        <h2>
            <i class="halflings-icon th"></i>
            <span class="break">时间统计</span>
        </h2>
    </div>
    <div class="box-content">
        <ul class="nav tab-menu nav-tabs" id="myTab">
            <li class="active"><a href="#novel-day">日</a></li>
            <li><a href="#novel-week">周</a></li>
            <li><a href="#novel-month">月</a></li>
        </ul>
        <div id="myTabContent" class="tab-content">
            {% for date_type,date in date_statistic %}
            <div class="tab-pane 
                {% if date_type == 'day' %}
                active
                {% endif %}
                " 
                id="novel-{{ date_type }}">
                <div class="box-content">
                    <table class="table">
                        <thead> 
                            <tr> 
                                <th>日期</th> 
                                <th>章节数量</th> 
                                <th>字数</th> 
                                <th>收藏</th> 
                                <th>推荐</th> 
                                <th>订阅</th> 
                                <th>打赏</th> 
                                <th>章收比</th> 
                                <th>章推比</th> 
                                <th>创作时间</th> 
                            </tr> 
                        </thead> 
                        {% if !date.items is empty %}
                        {% for index,l in date.items %}
                        <tbody> 
                            <tr> 
                                <td>{{ index }}</th> 
                                <td>{{ l['num'] }}</th> 
                                <td>{{ l['count'] }}</th> 
                                <td>{{ l['collect'] }}</th> 
                                <td>{{ l['recommend'] }}</th> 
                                <td>{{ l['subscribe'] }}</th> 
                                <td>{{ l['reward'] }}</th> 
                                <td>{{ round(l['collect']/l['num'],1) }}</th> 
                                <td>{{ round(l['recommend']/l['num'],1) }}</th> 
                                <td>{{ l['produce_time_num'] }}</th> 
                            </tr> 
                        </tbody> 
                        {%endfor%}
                        {%endif%}
                    </table>  
                </div>
            </div>
            {%endfor%}
        </div>
    </div>
</div>
<!--时间统计结束-->

<!--章节统计-->
<div class="box span12">
    <div class="box-header">
        <h2><i class="halflings-icon align-justify"></i><span class="break"></span>章节统计</h2>
        <div class="box-icon">
            <a href="#" id="toggle-novel-add" class="btn-setting"><i class="halflings-icon wrench"></i></a>
            <a href="#" class="btn-minimize"><i class="halflings-icon chevron-up"></i></a>
            <a href="#" class="btn-close"><i class="halflings-icon remove"></i></a>
        </div>
    </div>
    <div class="box-content">
        <table class="table">
            <thead> 
                <tr> 
                    <th style="display:none">id</th> 
                    <th>卷</th> 
                    <th>章节</th> 
                    <th>名称</th> 
                    <th>描述</th> 
                    <th>收藏</th> 
                    <th>评论</th> 
                    <th>打赏</th> 
                    <th>推荐</th> 
                    <th>月票</th> 
                    <th>发布时间</th> 
                    <th>创作消耗</th> 
                    <th>字数</th> 
                    <th>操作</th> 
                </tr> 
            </thead> 
            {% if !page is empty %}
            {% for l in page.items %}
            <tbody> 
                <tr> 
                    <td style="display:none">{{ l['id'] }}</th> 
                    <td>{{ l['volume'] }}</td> 
                    <td>{{ l['chapter'] }}</td> 
                    <td>{{ l['name'] }}</td> 
                    <td>{{ l['desc'] }}</td> 
                    <td>{{ l['collect'] }}</td> 
                    <td>{{ l['comment'] }}</td> 
                    <td>{{ l['reward'] }}</td> 
                    <td>{{ l['recommend'] }}</td> 
                    <td>{{ l['month_ticket'] }}</td> 
                    <td>{{ l['publish_time'] }}</td> 
                    <td>{{ l['produce_time_num'] }}</td> 
                    <td>{{ l['count'] }}</td> 
                    <td>
                        <button class="btn btn-small btn-info novel-edit-btn">修改</button>
                        <button class="btn btn-small btn-danger novel-del-btn">删除</button>
                    </td> 
                </tr> 
            </tbody> 
            {%endfor%}
            {%endif%}
        </table>  
        {% include "common/phalcon-page.volt" %}
    </div>
</div><!--/span-->
<!--章节统计结束-->

<!--数据图-->
<div class="box span12">
    <div class="box-header">
        <h2>
            <i class="halflings-icon th"></i>
            <span class="break">数据图示</span>
        </h2>
    </div>
    <div class="box-content">
        <ul class="nav tab-menu nav-tabs" id="myTab">
            <li class="active"><a href="#chapter-chart">章节</a></li>
            <li><a href="#day-chart">日</a></li>
            <li><a href="#week-chart">周</a></li>
            <li><a href="#month-chart">月</a></li>
        </ul>
        <div id="myTabContent" class="tab-content">
            <div class="tab-pane active" id="chapter-chart">
                <div class="box-content novel-echart" id="chapter_chart" >
                </div>
            </div>
            <div class="tab-pane" id="day-chart">
                <div class="box-content novel-echart" id="day_chart">
                </div>
            </div>
            <div class="tab-pane" id="week-chart">
                <div class="box-content novel-echart" id="week_chart">
                </div>
            </div>
            <div class="tab-pane" id="month-chart">
                <div class="box-content novel-echart" id="month_chart">
                </div>
            </div>
        </div>
    </div>
</div>
<!--数据图-->

<!--章节统计表单-->
<div class="modal hide fade" id="novel-add-form">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">×</button>
        <h3>新增记录</h3>
    </div>
    <div class="modal-body">
        <form id="novel-form" class="form-horizontal">
            <fieldset>
              <div class="control-group">
                <div class="controls">
                    <input type="hidden" class="form-control" id="id" name="id" > 
                </div>
              </div>
              <div class="control-group">
                <label class="control-label" for="focusedInput">卷</label>
                <div class="controls">
                    <input type="number" min="1" class="form-control" id="volume" name="volume" placeholder="请输入卷" value="1" > 
                </div>
              </div>
              <div class="control-group">
                <label class="control-label" for="focusedInput">章节</label>
                <div class="controls">
                    <input type="number" min="1" class="form-control" id="chapter" name="chapter" placeholder="请输入章节" value="1" > 
                </div>
              </div>
              <div class="control-group">
                <label class="control-label" for="focusedInput">章节名称</label>
                <div class="controls">
                    <input type="text" class="form-control" id="name" name="name" placeholder="请输入名称"> 
                </div>
              </div>
              <div class="control-group">
                <label class="control-label" for="focusedInput">描述</label>
                <div class="controls">
                    <input type="text" class="form-control" id="desc" name="desc" placeholder="请输入描述"> 
                </div>
              </div>
              <div class="control-group">
                <label class="control-label" for="focusedInput">收藏</label>
                <div class="controls">
                    <input type="number" class="form-control" id="collect" name="collect" placeholder="请输入收藏" value="0" > 
                </div>
              </div>
              <div class="control-group">
                <label class="control-label" for="focusedInput">评论</label>
                <div class="controls">
                    <input type="number" class="form-control" id="comment" name="comment" placeholder="请输入评论数量" value="0" > 
                </div>
              </div>
              <div class="control-group">
                <label class="control-label" for="focusedInput">打赏</label>
                <div class="controls">
                    <input type="number" class="form-control" id="reward" name="reward" placeholder="请输入打赏" value="0" > 
                </div>
              </div>
              <div class="control-group">
                <label class="control-label" for="focusedInput">推荐</label>
                <div class="controls">
                    <input type="number" class="form-control" id="recommend" name="recommend" placeholder="请输入推荐" value="0" > 
                </div>
              </div>
              <div class="control-group">
                <label class="control-label" for="focusedInput">月票</label>
                <div class="controls">
                    <input type="number" class="form-control" id="month_ticket" name="month_ticket" placeholder="请输入月票" value="0" > 
                </div>
              </div>
              <div class="control-group">
                <label class="control-label" for="focusedInput">发布时间</label>
                <div class="controls">
                    <input type="text" class="form-control" id="publish_time" name="publish_time" value="0" > 
                </div>
              </div>
              <div class="control-group">
                <label class="control-label" for="focusedInput">创作消耗番茄(单位/半小时)</label>
                <div class="controls">
                    <input type="number" class="form-control" id="produce_time_num" name="produce_time_num" placeholder="请输入创作消耗时间" value="0" > 
                </div>
              </div>
              <div class="control-group">
                <label class="control-label" for="focusedInput">字数</label>
                <div class="controls">
                    <input type="number" class="form-control" id="count" name="count" placeholder="请输入字数" value="0" > 
                </div>
              </div>
            </fieldset>
        </form>
    </div>
    <div class="modal-footer">
        <a href="#" class="btn" data-dismiss="modal">关闭</a>
        <a id="novel-submit" href="#" class="btn btn-primary">提交</a>
    </div>
</div>
<!--章节统计表单结束-->
{% endblock %}
   
{% block foot_script %} 
<script type="text/javascript" src="/js/web/novel/list.js" ></script>
<script type="text/javascript" src="/js/common/info.js" ></script>
<script type="text/javascript" src="/js/jquery/jquery.datetimepicker.full.js" ></script>
<script type="text/javascript" src="/js/other/echarts.common.min.js" ></script>
{% endblock %}

