$(function() {
    var sub_type = Web.Info.sub_type;
    var sub_type_obj = eval('(' + sub_type + ')');  
    for (key in sub_type_obj) {
        var id_name = "#novel-" + sub_type_obj[key];
        var day_arr = [4,5,6,7,8,9,10,11];
        for (key in day_arr) {
            var day_num = day_arr[key];
            var list = $(id_name).find('table tbody').find('td:eq('+ day_num +')');
            var max_index = null;
            var max_value = 0;
            for (var i = 0;i< list.length;i++) {
                var value = $(list[i]).text();
                // 判断值是否小于0，如果小于则标红
                if (value != '--' && value <= 0) {
                    $(id_name).find('table tbody').eq(i).find('td').eq(day_num).css('color','#FF0000');
                }
                // 判断最大增幅的是哪一本书
                if (value != '--') {
                    value = parseInt(value);
                    max_value = parseInt(max_value);
                    if (value >= max_value) {
                        max_value = value;
                        max_index = i;
                    }
                }
            }
            if (max_value > 0 && max_index != null) {
                $(id_name).find('table tbody').eq(max_index).find('td').eq(day_num).css('color','#0000FF');
            }
        }
    }
});
