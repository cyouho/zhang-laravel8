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
        userLoginRecordOn7Day(userId);
    }

    if ($("#fourteen_day_record").length > 0) {
        userId = $("#user_id").text();
        userLoginRecordOn14Day(userId);
    }

    if ($("#one_mouth_record").length > 0) {
        userId = $("#user_id").text();
        userLoginRecordOn30Day(userId);
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

    function userLoginRecordOn7Day(userId) {
        var myChart = echarts.init(document.getElementById('seven_day_record'));
        window.onresize = function () {
            myChart.resize();
        };
        var option = {
            tooltip: {
                trigger: 'axis',
                axisPointer: { type: 'cross' }
            },
            xAxis: {
                name: '登录日期',
                //data: loginDay.reverse()
                data: ['2021-10-22', '2021-10-22', '2021-10-22', '2021-10-22', '2021-10-22', '2021-10-22', '2021-10-22'],
            },
            yAxis: {
                name: '登陆次数'
            },
            series: [
                {
                    name: '登陆次数',
                    type: 'line',
                    //data: loginTimes.reverse(),
                    data: [1, 3, 4, 0, 5, 0, 3],
                }
            ]
        };

        // 使用刚指定的配置项和数据显示图表。
        myChart.setOption(option);
    }

    function userLoginRecordOn14Day(userId) {
        var myChart14Day = echarts.init(document.getElementById('fourteen_day_record'));
        window.onresize = function () {
            myChart14Day.resize();
        };
        var option = {
            tooltip: {
                trigger: 'axis',
                axisPointer: { type: 'cross' }
            },
            xAxis: {
                name: '登录日期',
                //data: loginDay.reverse()
                data: ['2021-10-22', '2021-10-22', '2021-10-22', '2021-10-22', '2021-10-22', '2021-10-22', '2021-10-22'],
            },
            yAxis: {
                name: '登陆次数'
            },
            series: [
                {
                    name: '登陆次数',
                    type: 'line',
                    //data: loginTimes.reverse(),
                    data: [1, 1, 1, 0, 1, 0, 1],
                }
            ]
        };

        // 使用刚指定的配置项和数据显示图表。
        myChart14Day.setOption(option);
    }

    function userLoginRecordOn30Day(userId) {
        var myChart30Day = echarts.init(document.getElementById('one_mouth_record'));
        window.onresize = function () {
            myChart30Day.resize();
        };
        var option = {
            tooltip: {
                trigger: 'axis',
                axisPointer: { type: 'cross' }
            },
            xAxis: {
                name: '登录日期',
                //data: loginDay.reverse()
                data: ['2021-10-22', '2021-10-22', '2021-10-22', '2021-10-22', '2021-10-22', '2021-10-22', '2021-10-22'],
            },
            yAxis: {
                name: '登陆次数'
            },
            series: [
                {
                    name: '登陆次数',
                    type: 'line',
                    //data: loginTimes.reverse(),
                    data: [5, 5, 5, 5, 5, 5, 3],
                }
            ]
        };

        // 使用刚指定的配置项和数据显示图表。
        myChart30Day.setOption(option);
    }
});