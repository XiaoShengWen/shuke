$(function () {
    var href = Web.Info.href;
    var href_obj = eval('(' + href + ')');  

    var loopConf = Web.Info.loopConf;
    var loop_conf = eval('(' + loopConf + ')'); 

    // 默认展示
    // var loop_active_id = $('.collapse-active-show').attr('id')
    // var loop_active_table_id = loop_active_id.replace("collapse","table");
    // var oTable = new TableInit(href_obj);
    // oTable.Init(loop_active_table_id);

    for (index in loop_conf) {
        var loop_id_tag = loop_conf[index];
        var collapse_id = "#" + loop_id_tag + "-collapse";
        var table_id = "#" + loop_id_tag + "-table";
        $(collapse_id).on('show.bs.collapse', function() {
            //1.初始化Table
            var loop_id = $(this).attr('loop_id');
            var loop_collapse_id = $(this).attr('id');
            var loop_collapse_table_id = loop_collapse_id.replace('collapse',"table"); 
            var oTable = new TableInit(href_obj, loop_id);
            oTable.Init(loop_collapse_table_id);
        });
    }

    // 添加loop按钮输入界面弹出 
    $('#toggle-loop-add').click(function(){
        $('#loop-add-form').modal('show');
    });     
    // 添加plan按钮输入界面弹出 
    $('.toggle-plan-add').click(function(){
        var loop_id = $(this).attr('loop_id');
        $('#plan_loop_id').val(loop_id);
        console.log(loop_id);
        $('#plan-add-form').modal('show');
    });     

    // loop提交展示 
    $("#loop-submit").click(function(){
        var url = href_obj.loop.add;
        var data = $("#loop-form").serializeArray();
        basicAdd(url, data);
    });

    // plan提交展示 
    $("#plan-submit").click(function(){
        var url = href_obj.plan.add;
        var data = $("#plan-form").serializeArray();
        basicAdd(url, data);
    });

    function basicAdd(url, data) {
        $.post(
            url,
            data,
            function(data,status) {
                alert(data.msg);
                if (data.code === 0) {
                    location.reload();
                }
            }
        );
    }

    // 时间按钮
    $('#plan_begin_date').datetimepicker();
    $('#plan_end_date').datetimepicker();
});

var TableInit = function (href_obj, loop_id) {
    var oTableInit = new Object();
    var href = href_obj.plan.list + loop_id;
    //初始化Table
    oTableInit.Init = function (table_id) {
        var btn_id = table_id.replace('table','btn');
        $("#" + table_id).bootstrapTable({
            url: href,         //请求后台的URL（*）
            method: 'get',                      //请求方式（*）
            toolbar: '#' + btn_id,                //工具按钮用哪个容器
            striped: true,                      //是否显示行间隔色
            cache: false,                       //是否使用缓存，默认为true，所以一般情况下需要设置一下这个属性（*）
            pagination: true,                   //是否显示分页（*）
            sortable: false,                     //是否启用排序
            sortOrder: "asc",                   //排序方式
            queryParams: function (params) {
                return params;
            },//传递参数（*）
            sidePagination: "server",           //分页方式：client客户端分页，server服务端分页（*）
            pageNumber:1,                       //初始化加载第一页，默认第一页
            pageSize: 10,                       //每页的记录行数（*）
            pageList: [10, 25, 50, 100],        //可供选择的每页的行数（*）
            search: true,                       //是否显示表格搜索，此搜索是客户端搜索，不会进服务端，所以，个人感觉意义不大
            strictSearch: true,
            showColumns: true,                  //是否显示所有的列
            showRefresh: true,                  //是否显示刷新按钮
            minimumCountColumns: 2,             //最少允许的列数
            clickToSelect: true,                //是否启用点击选中行
            height: 500,                        //行高，如果没有设置height属性，表格自动根据记录条数觉得表格高度
            uniqueId: "id",                     //每一行的唯一标识，一般为主键列
            showToggle:true,                    //是否显示详细视图和列表视图的切换按钮
            cardView: false,                    //是否显示详细视图
            detailView: true,                   //是否显示父子表
            columns: [{
                field: 'id',
                title: 'id'
            }, {
                field: 'name',
                title: '名称'
            }, {
                field: '类别',
                title: 'type'
            }, {
                field: 'begin_date',
                title: '开始周期'
            }, {
                field: 'end_date',
                title: '结束周期'
            },],
            onExpandRow: function (index, row, $detail) {
                oTableInit.InitTaskTable(index, row, $detail);
            }
        });
    };

    // oTableInit.InitPlanTable = function (index, row, $detail) {
    //     var parentid = row.id;
    //     var cur_table = $detail.html('<table></table>').find('table');
    //     $(cur_table).bootstrapTable({
    //         url: '/plan/list',
    //         method: 'get',
    //         cache: false,                       //是否使用缓存，默认为true，所以一般情况下需要设置一下这个属性（*）
    //         pagination: true,                   //是否显示分页（*）
    //         sortable: false,                     //是否启用排序
    //         sortOrder: "asc",                   //排序方式
    //         queryParams: function (params) {
    //             return params.data;
    //         },//传递参数（*）
    //         sidePagination: "server",           //分页方式：client客户端分页，server服务端分页（*）
    //         pageNumber:1,                       //初始化加载第一页，默认第一页
    //         pageSize: 10,                       //每页的记录行数（*）
    //         minimumCountColumns: 2,             //最少允许的列数
    //         clickToSelect: true,                //是否启用点击选中行
    //         uniqueId: "id",                     //每一行的唯一标识，一般为主键列
    //         detailView: true,                   //是否显示父子表
    //         columns: [{
    //             field: 'id',
    //             title: 'id'
    //         }, {
    //             field: 'name',
    //             title: '名称'
    //         }, {
    //             field: '类别',
    //             title: 'type'
    //         }, {
    //             field: 'begin_date',
    //             title: '开始周期'
    //         }, {
    //             field: 'end_date',
    //             title: '结束周期'
    //         }, ],
    //         onExpandRow: function (index, row, $Subdetail) {
    //             oTableInit.InitTaskTable(index, row, $Subdetail);
    //         }
    //     });
    // };

    oTableInit.InitTaskTable = function (index, row, $detail) {
        var parentid = row.id;
        var href = href_obj.task.list + parentid;
        var cur_table = $detail.html('<table></table>').find('table');
        $(cur_table).bootstrapTable({
            url: href,
            method: 'get',
            cache: false,                       //是否使用缓存，默认为true，所以一般情况下需要设置一下这个属性（*）
            pagination: true,                   //是否显示分页（*）
            sortable: false,                     //是否启用排序
            sortOrder: "asc",                   //排序方式
            queryParams: function (params) {
                return params.data;
            },//传递参数（*）
            sidePagination: "server",           //分页方式：client客户端分页，server服务端分页（*）
            pageNumber:1,                       //初始化加载第一页，默认第一页
            pageSize: 10,                       //每页的记录行数（*）
            minimumCountColumns: 2,             //最少允许的列数
            clickToSelect: true,                //是否启用点击选中行
            uniqueId: "id",                     //每一行的唯一标识，一般为主键列
            detailView: false,                   //是否显示父子表
            columns: [{
                checkbox: true,
            }, {
                field: 'id',
                title: 'id'
            }, {
                field: 'name',
                title: '名称'
            }, {
                field: '行动次数',
                title: 'action_num'
            }, ]
        });
    };

    return oTableInit;
};

var ButtonInit = function () {
    var oInit = new Object();
    var postdata = {};

    oInit.Init = function () {
        //初始化页面上面的按钮事件
    };
    return oInit;
};
