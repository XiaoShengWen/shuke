$(function() {
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
        $.get("/novel/del?id=" + id,
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
            var url = "/novel/edit";
        } else {
            var url = "/novel/add";
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
