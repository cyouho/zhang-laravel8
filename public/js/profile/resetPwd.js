$(document).ready(function () {
    $("#reset").click(function () {
        site = $("#baidu").attr("value");
        imageUrl = $("#imageUrl").val();
        if (imageUrl == '') {
            alert("尚未填写图片地址!");
            return false;
        }
        ajaxPost(site, imageUrl);
    });
});