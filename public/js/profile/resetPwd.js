$(document).ready(function () {
    $("#reset").click(function () {
        oldPwd = $("#oldPwd").val();
        newPwd = $("#newPwd").val();

        profileAjaxPost(oldPwd, newPwd);
    });

    function profileAjaxPost(oldPwd, newPwd) {
        $.ajax({
            url: "/resetPassword",
            type: "POST",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: {
                "oldPwd": oldPwd,
                "newPwd": newPwd
            },
            success: function (data) {
                if (data == 'pwd_err') {
                    $("#pwd_err").fadeIn(3000);
                } else if (data == 'pwd_updated') {
                    $("#pwd_updated").fadeIn(3000);
                } else if (data == 'pwd_update_err') {
                    $("#pwd_update_err").fadeIn(3000);
                }
            }
        });
    }
});