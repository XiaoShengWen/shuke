{% extends "layout.volt" %}

{% block head_script %} 
<link href="/css/jquery/jquery.datetimepicker.css" rel="stylesheet">
<script type="text/javascript">
$Info['sub_type'] = '{{ sub_type_list|json_encode }}'; 
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
    <li><a href="#">书客统计</a></li>
</ul>
<!--面包屑结束-->

<!--时间统计-->
{% for type,sub_type_list in recommend_list %}
<div class="box span12">
    <div class="box-header">
        <h2>
            <i class="halflings-icon th"></i>
            <span class="break">{{ type }}</span>
        </h2>
    </div>
    <div class="box-content">
        <ul class="nav tab-menu nav-tabs" id="myTab">
            {% set num = 0 %}
            {% for sub_type,list in sub_type_list %}
                <li 
                {% if num == 0 %}
                class="active"
                {% endif %}
                ><a href="#novel-{{ sub_type }}">{{ sub_type }}</a></li>
                {% set num += 1 %}
            {% endfor %}
        </ul>
        <div id="myTabContent" class="tab-content">
            {% set num = 0 %}
            {% for sub_type,list in sub_type_list %}
            <div class="tab-pane 
                {% if num == 0 %}
                active
                {% endif %}
                " 
                id="novel-{{ sub_type }}">
                {% set num += 1 %}
                <div class="box-content">
                    <table class="table">
                        <thead> 
                            <tr> 
                                <th width=20% >作品名称</th> 
                                <th>作者</th> 
                                <th>作品id</th> 
                                <th>初始收藏</th> 
                                <th>周一</th> 
                                <th>周二</th> 
                                <th>周三</th> 
                                <th>周四</th> 
                                <th>周五</th> 
                                <th>周六</th> 
                                <th>周日</th> 
                                <th>变化总和</th> 
                            </tr> 
                        </thead> 
                        {% if !list is empty %}
                        {% for l in list %}
                        <tbody> 
                            <tr> 
                                <td>{{ l['title'] }}</th> 
                                <td>{{ l['author'] }}</th> 
                                <td>{{ l['book_id'] }}</th> 
                                <td>{{ l['collect']['raw'] }}</th> 
                                {% set week = [1,2,3,4,5,6,7] %}
                                {% for day in week %}
                                <td>
                                    {% if !l['collect'][day] is empty %}
                                        {{ l['collect'][day] }}
                                    {% else %}
                                        --
                                    {% endif %}
                                </th> 
                                {% endfor %}
                                <td>
                                    {% if !l['collect']['sum'] is empty %}
                                        {{ l['collect']['sum'] }}
                                    {% else %}
                                        --
                                    {% endif %}
                                </th> 
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
{% endfor %}
<!--时间统计结束-->
{% endblock %}

{% block foot_script %} 
<script type="text/javascript" src="/js/common/info.js" ></script>
<script type="text/javascript" src="/js/jquery/jquery.datetimepicker.full.js" ></script>
<script type="text/javascript" src="/js/other/echarts.common.min.js" ></script>
<script type="text/javascript" src="/js/web/recommend/list.js" ></script>
{% endblock %}
