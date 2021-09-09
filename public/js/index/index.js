$(document).ready(function () {
    var site = "";
    var imageUrl = "";

    $("#baidu").click(function () {
        site = $("#baidu").attr("value");
        imageUrl = $("#imageUrl").val();
        if (imageUrl == '') {
            alert("尚未填写图片地址!");
            return false;
        }
        ajaxPost(site, imageUrl);
    });

    function ajaxPost(site, imageUrl) {
        newwindow = window.open("about:blank");
        newwindow.document.write("<p>图片解析中... ...</p>");
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
});