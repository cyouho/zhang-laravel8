$(document).ready(function () {
    var site = "";
    var imageUrl = "";
    var siteName = new Array;
    siteName['baidu'] = '百度';
    siteName['onesix'] = '1688';
    siteName['alibaba'] = 'Alibaba';
    siteName['taobao'] = '淘宝';

    $("#baidu").click(function () {
        site = $("#baidu").attr("value");
        imageUrl = $("#imageUrl").val();
        if (imageUrl == '') {
            alert("尚未填写图片地址!");
            return false;
        }
        ajaxPost(site, imageUrl);
    });

    $("#onesix").click(function () {
        site = $("#onesix").attr("value");
        imageUrl = $("#imageUrl").val();
        if (imageUrl == '') {
            alert("尚未填写图片地址!");
            return false;
        }
        ajaxPost(site, imageUrl);
    });

    $("#alibaba").click(function () {
        site = $("#alibaba").attr("value");
        imageUrl = $("#imageUrl").val();
        if (imageUrl == '') {
            alert("尚未填写图片地址!");
            return false;
        }
        ajaxPost(site, imageUrl);
    });

    $("#taobao").click(function () {
        site = $("taobao").attr("value");
        imageUrl = $("#imageUrl").val();
        if (imageUrl == '') {
            alert("尚未填写图片地址!");
            return false;
        }
        ajaxPost(site, imageUrl);
    });

    // 判断页面是否需要使用 echarts
    if ($("#homePage").length > 0) {
        userLoginRecord();
    }

    function ajaxPost(site, imageUrl) {
        newwindow = window.open("about:blank");
        pageDocument = '<p>' + siteName[site] + '图片解析中... ...</p>';
        newwindow.document.write(pageDocument);
        window.focus();
        $.ajax({
            url: "/imageSearch",
            type: "POST",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: {
                "imageUrl": imageUrl,
                "site": site
            },
            success: function (data) {
                newwindow.location.href = data;
                newwindow.focus();
            }
        });
    }

    $('[data-toggle="tooltip"]').tooltip();
    $('[data-toggle2="tooltip"]').tooltip();
    $('[data-toggle3="tooltip"]').tooltip();

    function userLoginRecord() {
        var myChart = echarts.init(document.getElementById('homePage'));
        window.onresize = function () {
            myChart.resize();
        };

        $.ajax({
            url: "/userLoginRecordAjax",
            type: "POST",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function (result) {
                var loginDay = new Array();
                var loginTimes = new Array();
                for (var i = 0; i < result.length; i++) {
                    loginDay.push(result[i]['login_day']);
                    loginTimes.push(result[i]['login_times']);
                }
                var option = {
                    tooltip: {
                        trigger: 'axis',
                        axisPointer: { type: 'cross' }
                    },
                    xAxis: {
                        name: '登录日期',
                        data: loginDay.reverse()
                    },
                    yAxis: {
                        name: '登陆次数'
                    },
                    series: [
                        {
                            name: '登陆次数',
                            type: 'line',
                            data: loginTimes.reverse(),
                            lineStyle: {
                                color: 'green',
                            }
                        }
                    ]
                };

                // 使用刚指定的配置项和数据显示图表。
                myChart.setOption(option);
            }
        });
    }
});