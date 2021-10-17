<!-- Tab panes -->
<div class="tab-content">
    <div id="password" class="container tab-pane active"><br>
        <form class="form-signin" style="max-width: 420px; margin: auto;" action="/dologin" method="POST">
            @csrf
            <div style="position: relative; margin-bottom: 1rem;">
                <input id="oldPwd" name="old_pwd" class="form-control" placeholder="旧密码" required autofocus>
                @isset($errMSG)
                <p class="error-message">{{$errMSG}}</p>
                @endisset
            </div>

            <div style="position: relative; margin-bottom: 1rem;">
                <input id="newPwd" name="new_pwd" class="form-control" placeholder="新密码" required>
            </div>

            <button id="reset" class="btn btn-lg btn-danger btn-block" type="submit">修改</button>
        </form>
    </div>
    <div id="menu1" class="container tab-pane fade"><br>
        <h3>Menu 1</h3>
        <p>Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
    </div>
    <div id="menu2" class="container tab-pane fade"><br>
        <h3>Menu 2</h3>
        <p>Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam.</p>
    </div>
</div>