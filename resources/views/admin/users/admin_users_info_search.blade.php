<div class="jumbotron">
    <div class="container mt-3">
        <h1 class="text-center">检索用户</h1>
        <p class="text-center">支持输入用户ID，用户邮箱，用户名。</p>
        <form action="/searchUserInfo" method="POST" target="_blank">
            <div class="input-group mt-3 mb-3">
                <div class="input-group-prepend">
                    <button type="submit" class="btn btn-outline-secondary dropdown-toggle" data-toggle="dropdown">
                        选择检索类别
                    </button>
                    <div class="dropdown-menu">
                        <a id="user_id" class="dropdown-item" href="#" value="user_id">用户ID</a>
                        <a id="user_email" class="dropdown-item" href="#" value="user_email">用户邮箱</a>
                        <a id="user_name" class="dropdown-item" href="#" value="user_name">用户名</a>
                    </div>
                </div>
                <input id="info" type="text" class="form-control" placeholder="用户信息">
            </div>
        </form>
    </div>
</div>