$(document).ready(function () {
    $("#user_id").click(function () {
        userId = $(this).attr("value");
        userInfo = $("#info").val();

    });

    function showUserInfoAjaxPost(userId, userInfo) {
        $.ajax({
            url: "/searchUserInfo",
            type: "POST",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: {
                "userId": userId,
                "userInfo": userInfo
            },
            success: function (data) {

            }
        });
    }
});