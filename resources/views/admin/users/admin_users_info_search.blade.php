<div class="jumbotron">
    <h1 class="text-center">用户信息检索:</h1><br>
    <form action="/searchUserInfo" method="POST" target="_blank" style="max-width: 420px; margin: auto;">
        @csrf
        <input type="hidden" id="adminName" name="admin_name" value="{{$adminData['adminName']}}">
        <input type="hidden" id="adminId" name="admin_id" value="{{$adminData['adminId']}}">
        <select class="form-control" id="searchRole" name="search_role" style="position: relative; margin-bottom: 1rem;">
            <option value="1">用户ID</option>
            <option value="2" selected>用户邮箱</option>
            <option value="3">用户名</option>
        </select>
        <div style="position: relative; margin-bottom: 1rem;">
            <input type="text" id="searchText" name="search_text" class="form-control" placeholder="邮箱地址" required autofocus>
        </div>
        <p id="create_errmsg">

        </p>
        <button id="search" class="btn btn-lg btn-primary btn-block" style="max-width: 420px; margin: auto;" type="submit">检索</button>
    </form>
</div>