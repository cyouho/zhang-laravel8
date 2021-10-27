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
        console.log(adminName);

        if (resetUserPwd == '') {
            alert('新密码不能为空');
            return false;
        }

        adminUserPwdResetAjaxPost(resetUserId, resetUserPwd, adminId, adminName);
    });

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
                $("#resetPwdAjax").load("/showResetPwdRecord");
            }
        });
    }
});