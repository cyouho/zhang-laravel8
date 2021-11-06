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
                <td id="user_id">{{$userData['user_id']}}</td>
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
    </table><br><br>
    <h1 class="text-center">用户登录记录</h1><br>
    <div class="container">
        <ul class="nav nav-tabs nav-justified" role="tablist">
            <li class="nav-item">
                <a id="seven_day_button" class="nav-link active" data-toggle="tab" href="#seven_day">近7天登录记录</a>
            </li>
            <li class="nav-item">
                <a id="foruteen_day_button" class="nav-link" data-toggle="tab" href="#foruteen_day">近14天登录记录</a>
            </li>
            <li class="nav-item">
                <a id="one_mouth_button" class="nav-link" data-toggle="tab" href="#one_mouth">近1个月登录记录</a>
            </li>
        </ul>
        <!-- Tab panes -->
        <div class="tab-content">
            <div id="seven_day" class="container tab-pane active"><br>
                <div id="seven_day_record">

                </div>
            </div>
            <div id="foruteen_day" class="container tab-pane"><br>
                <div id="fourteen_day_record" style="position: relative; width: 1080px; height: 400px; padding: 0px; margin: 0px; border-width: 0px; cursor: default;">

                </div>
            </div>
            <div id="one_mouth" class="container tab-pane"><br>
                <div id="one_mouth_record" style="position: relative; width: 1080px; height: 400px; padding: 0px; margin: 0px; border-width: 0px; cursor: default;">

                </div>
            </div>
        </div>
    </div><br><br>
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