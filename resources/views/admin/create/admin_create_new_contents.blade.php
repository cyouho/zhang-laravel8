<div class="jumbotron">

    <h1 class="text-center">创建新管理员:</h1><br>
    <form style="max-width: 420px; margin: auto;">
        <select class="form-control" id="adminRole" name="admin_role" style="position: relative; margin-bottom: 1rem;">
            <option value="1">超级管理员</option>
            <option value="2" selected>管理员</option>
            <option value="3">开发者</option>
        </select>
        <div style="position: relative; margin-bottom: 1rem;">
            <input type="email" id="adminEmail" name="admin_email" class="form-control" placeholder="邮箱地址" required autofocus>
        </div>
        <p id="create_errmsg">

        </p>

        <div style="position: relative; margin-bottom: 1rem;">
            <input type="password" id="adminPwd" name="admin_pwd" class="form-control" placeholder="密码" required>
        </div>

    </form>
    <button id="create" class="btn btn-lg btn-danger btn-block" style="max-width: 420px; margin: auto;" type="submit">创建</button>

</div>