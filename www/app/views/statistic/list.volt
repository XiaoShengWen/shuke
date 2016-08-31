{% extends "layout.volt" %}
   
{% block head_script %} 
{% endblock %}
   
{% block content %}
<div class="container">
    <div class="row">
        <div class="col-xs-6">
            <table class="table"> 
                <caption>数据统计</caption> 
                <thead> 
                    <tr> 
                        <th>卷</th> 
                        <th>章节</th> 
                        <th>名称</th> 
                        <th>收藏</th> 
                        <th>评论</th> 
                        <th>打赏</th> 
                        <th>推荐</th> 
                        <th>描述</th> 
                    </tr> 
                </thead> 
                {% if !list is empty %}
                {% for l in list %}
                    <tbody> 
                        <tr> 
                            <th>{{ l['volume'] }}</th> 
                            <th>{{ l['chapter'] }}</th> 
                            <th>{{ l['name'] }}</th> 
                            <th>{{ l['collect'] }}</th> 
                            <th>{{ l['comment'] }}</th> 
                            <th>{{ l['reward'] }}</th> 
                            <th>{{ l['recommend'] }}</th> 
                            <th>{{ l['desc'] }}</th> 
                        </tr> 
                    </tbody> 
                {%endfor%}
                {%endif%}
            </table>
        </div>
        <div class="col-xs-6">
        </div>      
    </div>
    <div style="display:none">
        <form id="statistic-form" class="form-horizontal" role="form" > 
            <div class="form-group"> 
                <label for="lastname" class="col-sm-2 control-label">卷</label> 
                <div class="col-sm-10"> 
                    <input type="number" min="1" class="form-control" id="volume" name="volume" placeholder="请输入卷" value="1" > 
                </div> 
            </div> 
            <div class="form-group"> 
                <label for="lastname" class="col-sm-2 control-label">章节</label> 
                <div class="col-sm-10"> 
                    <input type="number" min="1" class="form-control" id="chapter" name="chapter" placeholder="请输入章节" value="1" > 
                </div> 
            </div> 
            <div class="form-group"> 
                <label for="firstname" class="col-sm-2 control-label">名字</label> 
                <div class="col-sm-10"> 
                    <input type="text" class="form-control" id="name" name="name" placeholder="请输入名称"> 
                </div> 
            </div> 
            <div class="form-group"> 
                <label for="lastname" class="col-sm-2 control-label">描述</label> 
                <div class="col-sm-10"> 
                    <input type="text" class="form-control" id="desc" name="desc" placeholder="请输入描述"> 
                </div> 
            </div> 
            <div class="form-group"> 
                <label for="lastname" class="col-sm-2 control-label">收藏</label> 
                <div class="col-sm-10"> 
                    <input type="number" class="form-control" id="collect" name="collect" placeholder="请输入收藏" > 
                </div> 
            </div> 
            <div class="form-group"> 
                <label for="lastname" class="col-sm-2 control-label">评论数量</label> 
                <div class="col-sm-10"> 
                    <input type="number" class="form-control" id="comment" name="comment" placeholder="请输入评论数量" > 
                </div> 
            </div> 
            <div class="form-group"> 
                <label for="lastname" class="col-sm-2 control-label">打赏</label> 
                <div class="col-sm-10"> 
                    <input type="number" class="form-control" id="reward" name="reward" placeholder="请输入打赏" > 
                </div> 
            </div> 
            <div class="form-group"> 
                <label for="lastname" class="col-sm-2 control-label">推荐</label> 
                <div class="col-sm-10"> 
                    <input type="number" class="form-control" id="recommend" name="recommend" placeholder="请输入推荐" > 
                </div> 
            </div> 
            <div class="form-group"> 
                <div class="col-sm-offset-2 col-sm-10"> 
                    <button id="statistic-submit" type="submit" class="btn btn-default">登录</button> 
                </div> 
            </div> 
        </form>
   </div>
</div>
{% endblock %}
   
{% block foot_script %} 
<script type="text/javascript" src="/js/web/statistic/list.js" ></script>
{% endblock %}

