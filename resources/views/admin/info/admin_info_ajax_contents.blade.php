<h1 class="text-center">管理员信息一览:</h1><br>
<div class="row text-center">
    <div class="col-sm-3">
        <p>管理员总人数:</p>
        <h3>
            @if (isset($numberOfTotalAdmin['number_of_total_admins']))
            {{$numberOfTotalAdmin['number_of_total_admins']}}
            @endif
        </h3>
    </div>
    <div class="col-sm-3">
        <p>超级管理员人数:</p>
        <h3>
            @if (isset($numberOfTotalAdmin['number_of_super_admin']))
            {{$numberOfTotalAdmin['number_of_super_admin']}}
            @endif
        </h3>
    </div>
    <div class="col-sm-3">
        <p>管理员人数:</p>
        <h3>
            @if (isset($numberOfTotalAdmin['number_of_admin']))
            {{$numberOfTotalAdmin['number_of_admin']}}
            @endif
        </h3>
    </div>
    <div class="col-sm-3">
        <p>开发者人数:</p>
        <h3>
            @if (isset($numberOfTotalAdmin['number_of_develper']))
            {{$numberOfTotalAdmin['number_of_develper']}}
            @endif
        </h3>
    </div>
</div><br>
<table class="table table-dark table-hover">
    <thead>
        <tr>
            <th>管理员ID</th>
            <th>姓名</th>
            <th>角色</th>
            <th>邮箱</th>
            <th>账户创建日期</th>
            <th>最后登录日期</th>
            <th>登录次数</th>
            <th>操作</th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        @foreach ($adminInfo as $value)
        <tr class="li">
            <td>{{$value['admin_id']}}</td>
            <td>{{$value['admin_name']}}</td>
            <td>{{$value['role']}}</td>
            <td>{{$value['admin_email']}}</td>
            <td>{{date("Y-m-d H:i:s", $value['create_at'])}}</td>
            <td>{{date("Y-m-d H:i:s", $value['last_login_at'])}}</td>
            <td>{{$value['total_login_times']}}</td>
            @if ($adminData['adminName'] !== $value['admin_name'])
            <td><button type="button" id="{{$value['admin_id']}}" class="btn btn-warning btn-sm resetPwd" data-toggle="modal" data-target="#myModal">修改密码</button></td>
            <td><button type="button" id="{{$value['admin_id']}}" class="btn btn-danger btn-sm delete">删除</button></td>
            @else
            <td><button type="button" id="{{$value['admin_id']}}" class="btn btn-warning btn-sm resetPwd" data-toggle="modal" data-target="#myModal">修改密码</button></td>
            <td><button type="button" id="{{$value['admin_id']}}" class="btn btn-secondary btn-sm delete" disabled>删除</button></td>
            @endif
        </tr>
        @endforeach
    </tbody>
</table>