$(document).ready(function () {
    $("#create").click(function () {
        adminRole = $("#adminRole").val();
        adminEmail = $("#adminEmail").val();
        adminPwd = $("#adminPwd").val();

        createAdminAjaxPost(adminRole, adminEmail, adminPwd);
    });

    $(".jumbotron").on("click", ".delete", function () {
        adminId = $(this).attr("id");

        deleteAdminAjaxPost(adminId);
    });

    $(".jumbotron").on("click", ".resetPwd", function () {
        adminId = $(this).attr("id");
        $("#adminNewPwd").val("");
        $("#adminModelId").html(adminId);
    });

    $("#adminResetPwd").click(function () {
        adminId = $("#adminModelId").text();
        adminNewPwd = $("#adminNewPwd").val();

        resetAdminPwdAjaxPost(adminId, adminNewPwd)
    });

    function createAdminAjaxPost(adminRole, adminEmail, adminPwd) {
        $.ajax({
            url: "/createAdmin",
            type: "POST",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: {
                "adminRole": adminRole,
                "adminEmail": adminEmail,
                "adminPwd": adminPwd,
            },
            success: function (data) {
                if (data == 'admin_created') {
                    $("#created").fadeIn(1000);
                    $("#created").fadeOut(3000);
                    $("#adminRole").val("2");
                    $("#adminEmail").val("");
                    $("#adminPwd").val("");
                } else {
                    $("#created").html('账户已存在');
                }
            }
        });
    }

    function deleteAdminAjaxPost(adminId) {
        $.ajax({
            url: "/deleteAdmin",
            type: "POST",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: {
                "adminId": adminId
            },
            success: function (data) {
                $(".jumbotron").load("/showAdminInfoAjax")
            }
        });
    }

    function resetAdminPwdAjaxPost(adminId, adminNewPwd) {
        $.ajax({
            url: "/resetAdminPassword",
            type: "POST",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: {
                "adminId": adminId,
                "adminNewPwd": adminNewPwd,
            },
            success: function (data) {

            }
        });
    }
});