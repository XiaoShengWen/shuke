$(function() {
    var href = Web.Info.href;
    var href_obj = eval('(' + href + ')');  

    var chart = Web.Info.chart;
    var chart_obj = eval('(' + chart + ')');  

    console.log(chart_obj);

    //章节图示echart
    var chart_arr        = new Array();
    chart_arr['chapter'] = echarts.init(document.getElementById('chapter_chart'));
    chart_arr['day']     = echarts.init(document.getElementById('day_chart'));
    chart_arr['week']    = echarts.init(document.getElementById('week_chart'));
    chart_arr['month']   = echarts.init(document.getElementById('month_chart'));

    for (key in chart_obj) {
        var obj = chart_obj[key];
        var option  = {
            title: {
                text: key 
            },
            tooltip: {
                trigger: 'axis'
            },
            legend: {
                data:['收藏','评论','推荐','打赏']
            },
            grid: {
                left: '3%',
                right: '4%',
                bottom: '3%',
                containLabel: true
            },
            toolbox: {
                feature: {
                    saveAsImage: {}
                }
            },
            xAxis: {
                type: 'category',
                boundaryGap: false,
                data:obj.axis 
            },
            yAxis: {
                type: 'value'
            },
            series: [
                {
                    name:'收藏',
                    type:'line',
                    stack: '总量',
                    data:obj.collect
                },
                {
                    name:'评论',
                    type:'line',
                    stack: '总量',
                    data:obj.comment
                },
                {
                    name:'推荐',
                    type:'line',
                    stack: '总量',
                    data:obj.recommend
                },
                {
                    name:'打赏',
                    type:'line',
                    stack: '总量',
                    data:obj.reward
                }
            ]
        };
        chart_arr[key].setOption(option);
    }


    // 时间按钮
    $('#publish_time').datetimepicker();

    // 添加按钮输入界面弹出 
    $('#toggle-novel-add').click(function(){
        $('#novel-add-form').modal('show');
    });     

    // 编辑按钮输入界面更新并弹出
    $('.novel-edit-btn').click(function(){
        $(this).parent().parent().find('td').each(function(){
            var value = $(this).text();
            console.log(value);
            var input_index = $(this).index();
            $('#novel-form').find('input.form-control').eq(input_index).attr('value',value);
        });
        $('#novel-add-form').modal('show');
    });     

    $('.novel-del-btn').click(function(){
        var id = $(this).parent().parent().find('td').eq(0).text();
        $.get(href_obj.del  + id,
            function(data,status){
                alert(data.msg);
                if (data.code === 0) {
                    location.reload();
                }
            }
        );
    });

    // 禁止form表单自动刷新
    $(".form-horizontal").submit(function(e){
        e.preventDefault();
    });

    $("#novel-submit").click(function(){
        var id = $("#id").attr('value');
        if (id) {
            var url = href_obj.edit;
        } else {
            var url = href_obj.add;
        }
        $.post(
            url,
            $("#novel-form").serializeArray(),
            function(data,status) {
                alert(data.msg);
                if (data.code === 0) {
                    location.reload();
                }
            }
        );
    });
})
