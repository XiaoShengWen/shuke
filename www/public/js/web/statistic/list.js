$(function() {
    $(".form-horizontal").submit(function(e){
        e.preventDefault();
    });
    $("#statistic-submit").click(function(){
        $.post(
            "/statistic/add",
            $("#statistic-form").serializeArray(),
            function(data,status) {
                console.log(data);
                console.log(status);
            }
        );
    });
})
