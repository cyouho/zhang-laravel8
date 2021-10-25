<!-- 模态框 -->
<div class="modal fade" id="myModal">
    <div class="modal-dialog">
        <div class="modal-content">

            <!-- 模态框头部 -->
            <div class="modal-header">
                <h4 class="modal-title">
                    <p style="display: inline-block;">修改ID为:</p>
                    <p id="adminModelId" style="display: inline-block;"></p>
                    <p style="display: inline-block;">的管理员密码</p>
                </h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <!-- 模态框主体 -->
            <div class="modal-body">
                <form style="max-width: 420px; margin: auto;">
                    <div style="position: relative; margin-bottom: 1rem;">
                        <input type="password" id="adminNewPwd" name="admin_new_pwd" class="form-control" placeholder="新密码" required>
                    </div>
                    <div id="newpwd_msg"></div>
                </form>
                <button id="adminResetPwd" class="btn btn-lg btn-danger btn-block" style="max-width: 420px; margin: auto;" type="submit">修改</button>
            </div>

        </div>
    </div>
</div>
@include('admin.info.admin_info_model_msg')