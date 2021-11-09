$(document).ready(function () {
    $(".resetUserPwd").click(function () {
        userId = $(this).attr("id");
        $("#adminUserNewPwd").val("");
        $("#adminUserModelId").html(userId);
    });

    $("#adminUserResetPwd").click(function () {
        resetUserId = $("#adminUserModelId").text();
        resetUserPwd = $("#adminUserNewPwd").val();
        adminId = $(".resetUserPwd").attr("adminId");
        adminName = $(".resetUserPwd").attr("adminName");
        //console.log(adminName);

        if (resetUserPwd == '') {
            alert('新密码不能为空');
            return false;
        }

        adminUserPwdResetAjaxPost(resetUserId, resetUserPwd, adminId, adminName);
    });

    // 判断页面是否需要使用 echarts
    if ($("#seven_day_record").length > 0) {
        userId = $("#user_id").text();
        recordDay = $("#seven_day").attr("value");
        userLoginRecord(userId, recordDay);
    }

    if ($("#fourteen_day_record").length > 0) {
        userId = $("#user_id").text();
        recordDay = $("#foruteen_day").attr("value");
        userLoginRecord(userId, recordDay);
    }

    if ($("#one_mouth_record").length > 0) {
        userId = $("#user_id").text();
        recordDay = $("#one_mouth").attr("value");
        userLoginRecord(userId, recordDay);
    }

    function adminUserPwdResetAjaxPost(resetUserId, resetUserPwd) {
        $.ajax({
            url: "/resetAdminUserPassword",
            type: "POST",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: {
                "resetUserId": resetUserId,
                "resetUserPwd": resetUserPwd,
                'adminId': adminId,
                'adminName': adminName,
            },
            success: function (data) {
                selector = '#' + data;
                $(selector).slideDown(1000).delay(2000).slideUp(1000);
                token = $('meta[name="csrf-token"]').attr('content');
                $("#resetPwdAjax").load("/showResetPwdRecord", { 'user_id': resetUserId, '_token': token });
            }
        });
    }

    // 获取 user 的登录记录 ajax 方法 | 7 day, 14 day, 30 day.
    function userLoginRecord(userId, recordDay) {
        switch (recordDay) {
            case '7':
                var myChart = echarts.init(document.getElementById('seven_day_record'));
                window.onresize = function () {
                    myChart.resize();
                };
                break;
            case '14':
                var myChart = echarts.init(document.getElementById('fourteen_day_record'));
                window.onresize = function () {
                    myChart.resize();
                };
                break;
            case '30':
                var myChart = echarts.init(document.getElementById('one_mouth_record'));
                window.onresize = function () {
                    myChart.resize();
                };
                break;
            default:
                break;
        }
        $.ajax({
            url: "/userLoginRecord",
            type: "POST",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: {
                "userId": userId,
                "recordDay": recordDay,
            },
            success: function (data) {
                var option = {
                    tooltip: {
                        trigger: 'axis',
                        axisPointer: { type: 'cross' }
                    },
                    xAxis: {
                        name: '登录日期',
                        data: data['date'],
                        //data: ['2021-10-22', '2021-10-22', '2021-10-22', '2021-10-22', '2021-10-22', '2021-10-22', '2021-10-22'],
                    },
                    yAxis: {
                        name: '登陆次数'
                    },
                    series: [
                        {
                            name: '登陆次数',
                            type: 'line',
                            data: data['times'],
                            //data: [1, 3, 4, 0, 5, 0, 3],
                        }
                    ]
                };

                // 使用刚指定的配置项和数据显示图表。
                myChart.setOption(option);
            }
        });
    }
});