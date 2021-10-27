<!-- 模态框 -->
<div class="modal fade" id="resetPwdModal">
    <div class="modal-dialog">
        <div class="modal-content">

            <!-- 模态框头部 -->
            <div class="modal-header">
                <h4 class="modal-title">
                    <p style="display: inline-block;">修改ID为:</p>
                    <p id="adminUserModelId" style="display: inline-block;"></p>
                    <p style="display: inline-block;">的用户密码</p>
                </h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <!-- 模态框主体 -->
            <div class="modal-body">
                <form style="max-width: 420px; margin: auto;">
                    <div style="position: relative; margin-bottom: 1rem;">
                        <input type="password" id="adminUserNewPwd" name="admin_new_pwd" class="form-control" placeholder="新密码" required>
                    </div>
                    <div id="newpwd_msg"></div>
                </form>
                <button id="adminUserResetPwd" class="btn btn-lg btn-danger btn-block" style="max-width: 420px; margin: auto;" type="submit">修改</button>
            </div>

        </div>
    </div>
</div>
@include('admin.users.detail.admin_user_detail_model_msg')