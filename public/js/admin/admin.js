$(document).ready(function () {
    $("#create").click(function () {
        adminRole = $("#adminRole").val();
        adminEmail = $("#adminEmail").val();
        adminPwd = $("#adminPwd").val();

        createAdminAjaxPost(adminRole, adminEmail, adminPwd);
    });

    // $(".delete").click(function () {
    //     adminId = $(this).attr("id");
    //     console.log(adminId);
    //     deleteAdminAjaxPost(adminId);
    // });

    $(".jumbotron").on("click", ".delete", function () {
        adminId = $(this).attr("id");

        deleteAdminAjaxPost(adminId);
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
                $("#created").fadeIn(1000);
                $("#created").fadeOut(3000);
                $("#adminRole").val("2");
                $("#adminEmail").val("");
                $("#adminPwd").val("");
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
});