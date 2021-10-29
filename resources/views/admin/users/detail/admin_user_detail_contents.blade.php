<div class="jumbotron">
    <h1 class="text-center">用户详细信息</h1><br>
    <table class="table table-dark table-hover">
        <thead>
            <tr>
                <th>用户ID</th>
                <th>姓名</th>
                <th>邮箱</th>
                <th>账户创建日期</th>
                <th>最后登录日期</th>
                <th>登录次数</th>
                <th>操作</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            @if (isset($userData))
            <tr>
                <td>{{$userData['user_id']}}</td>
                <td>{{$userData['user_name']}}</td>
                <td>{{$userData['email']}}</td>
                <td>{{date("Y-m-d H:i:s", $userData['create_at'])}}</td>
                <td>{{date("Y-m-d H:i:s", $userData['last_login_at'])}}</td>
                <td>{{$userData['total_login_times']}}</td>
                <td>
                    <button type="button" id="{{$userData['user_id']}}" class="btn btn-warning btn-sm resetUserPwd" data-toggle="modal" data-target="#resetPwdModal" adminId="{{$adminData['adminId']}}" adminName="{{$adminData['adminName']}}" userId="{{$userData['user_id']}}">修改密码</button>
                    <button type="button" id="{{$userData['user_id']}}" class="btn btn-danger btn-sm deleteUser">删除</button>
                </td>
            </tr>
            @endif
        </tbody>
    </table><br>
    <h1 class="text-center">管理员修改用户密码记录</h1><br>
    <table class="table table-dark table-hover">
        <thead>
            <tr>
                <th>管理员ID</th>
                <th>管理员姓名</th>
                <th>修改用户密码日期</th>
            </tr>
        </thead>
        <tbody id="resetPwdAjax">
            @if (isset($resetPwdRecord))
            @foreach ($resetPwdRecord as $value)
            <tr>
                <td>{{$value['admin_id']}}</td>
                <td>{{$value['admin_name']}}</td>
                <td>{{date("Y-m-d H:i:s", $value['update_at'])}}</td>
            </tr>
            @endforeach
            @endif
        </tbody>
    </table><br>
</div>