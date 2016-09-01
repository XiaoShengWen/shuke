{% extends "layout.volt" %}
   
{% block head_script %} 
<script type="text/javascript">
//$Info['test'] = "{{ test }}"; 
</script>
{% endblock %}
   
{% block content %}
<ul class="breadcrumb">
    <li>
        <i class="icon-home"></i>
        <a href="index.html">主页</a> 
        <i class="icon-angle-right"></i>
    </li>
    <li><a href="#">轻小说</a></li>
</ul>
<div class="box span12">
    <div class="box-header">
        <h2><i class="halflings-icon align-justify"></i><span class="break"></span>数据统计</h2>
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
                    <th>操作</th> 
                </tr> 
            </thead> 
            {% if !list is empty %}
            {% for l in list %}
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
                    <td>
                        <button class="btn btn-small btn-info novel-edit-btn">修改</button>
                        <button class="btn btn-small btn-danger novel-del-btn">删除</button>
                    </td> 
                </tr> 
            </tbody> 
            {%endfor%}
            {%endif%}
         </table>  
         <div class="pagination pagination-centered">
          <ul>
            <li><a href="#">Prev</a></li>
            <li class="active">
              <a href="#">1</a>
            </li>
            <li><a href="#">2</a></li>
            <li><a href="#">3</a></li>
            <li><a href="#">4</a></li>
            <li><a href="#">Next</a></li>
          </ul>
        </div>     
    </div>
</div><!--/span-->

<!--绘图-->
<div class="box span12">
    <div class="box-header">
        <h2>
            <i class="halflings-icon th"></i>
            <span class="break"></span>数据展示
        </h2>
    </div>
    <div class="box-content">
        <ul class="nav tab-menu nav-tabs" id="myTab">
            <li class="active"><a href="#collect-chart">收藏</a></li>
            <li><a href="#comment-chart">评论</a></li>
        </ul>
        <div id="myTabContent" class="tab-content">
            <div class="tab-pane active" id="collect-chart">
                <div id="sincos"  class="center" style="height:300px;" ></div>
                <p id="hoverdata">Mouse position at (<span id="x">0</span>, <span id="y">0</span>). <span id="clickdata"></span></p>
            </div>
            <div class="tab-pane" id="comment-chart">
            </div>
        </div>
    </div>
</div>
<!--绘图结束-->

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
            </fieldset>
        </form>
    </div>
    <div class="modal-footer">
        <a href="#" class="btn" data-dismiss="modal">关闭</a>
        <a id="novel-submit" href="#" class="btn btn-primary">提交</a>
    </div>
</div>
{% endblock %}
   
{% block foot_script %} 
<script type="text/javascript" src="/js/web/novel/list.js" ></script>
<script type="text/javascript" src="/js/common/info.js" ></script>
{% endblock %}

