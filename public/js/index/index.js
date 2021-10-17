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
});