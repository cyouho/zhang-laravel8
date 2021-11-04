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

    userLoginRecord();

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
                var option = {
                    tooltip: {
                        trigger: 'axis',
                        axisPointer: { type: 'cross' }
                    },
                    xAxis: {
                        name: '登录日期',
                        data: [result[6]['login_day'], result[5]['login_day'], result[4]['login_day'], result[3]['login_day'], result[2]['login_day'], result[1]['login_day'], result[0]['login_day']]
                    },
                    yAxis: {
                        name: '登陆次数'
                    },
                    series: [
                        {
                            name: '登陆次数',
                            type: 'line',
                            data: [result[6]['login_times'], result[5]['login_times'], result[4]['login_times'], result[3]['login_times'], result[2]['login_times'], result[1]['login_times'], result[0]['login_times']],
                            lineStyle: {
                                normal: {
                                    color: 'green',
                                }
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