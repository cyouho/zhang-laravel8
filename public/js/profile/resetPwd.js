$(document).ready(function () {
    $("#reset").click(function () {
        oldPwd = $("#oldPwd").val();
        newPwd = $("#newPwd").val();
        if (oldPwd == '') {
            alert('旧密码不能为空');
            return false;
        } else if (newPwd == '') {
            alert('新密码不能为空');
            return false;
        }

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
                    $("#pwd_err").fadeIn(1000);
                    $("#pwd_err").fadeOut(3000);
                    $("#oldPwd").val("");
                    $("#newPwd").val("");
                } else if (data == 'pwd_updated') {
                    $("#pwd_updated").fadeIn(1000);
                    $("#pwd_updated").fadeOut(3000);
                    $("#oldPwd").val("");
                    $("#newPwd").val("");
                } else if (data == 'pwd_update_err') {
                    $("#pwd_update_err").fadeIn(1000);
                    $("#pwd_update_err").fadeOut(3000);
                    $("#oldPwd").val("");
                    $("#newPwd").val("");
                }
            }
        });
    }
});