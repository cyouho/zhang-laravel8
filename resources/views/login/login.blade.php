<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Hello Feng Jiaxi</title>
    <link rel="stylesheet" href="https://cdn.staticfile.org/twitter-bootstrap/4.3.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/login.css">
    <script src="https://cdn.staticfile.org/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://cdn.staticfile.org/popper.js/1.15.0/umd/popper.min.js"></script>
    <script src="https://cdn.staticfile.org/twitter-bootstrap/4.3.1/js/bootstrap.min.js"></script>
    <script src="/js/index/index.js"></script>
</head>

<body>
    <form class="form-signin" action="/dologin" method="POST">
        @csrf
        <div class="text-center mb-4">
            <h1 class="my-0 mr-md-auto font-weight-normal">
                <a class="navbar-brand text-dark" href="/">
                    CYOUHO</a>
            </h1>
            <h5 class="my-0 mr-md-auto font-weight-normal">
                <p class="navbar-brand text-dark">
                    登录已有账户</p>
            </h5>
        </div>

        <div class="form-label-group">
            <input type="email" id="inputEmail" name="login_email" class="form-control" placeholder="Email address" required autofocus>
            <label for="inputEmail">电子邮箱地址</label>
            @isset($errMSG['id'])
            <p class="error-message">{{$errMSG['id']}}</p>
            @endisset
        </div>

        <div class="form-label-group">
            <input type="password" id="inputPassword" name="login_pwd" class="form-control" placeholder="Password" required>
            <label for="inputPassword">登录密码</label>
            @isset($errMSG['pwd'])
            <p class="error-message">{{$errMSG['pwd']}}</p>
            @endisset
        </div>

        <div class="checkbox mb-3">
            <label>
                <input type="checkbox" value="remember-me"> 记住我
            </label>
        </div>
        <button id="login" class="btn btn-lg btn-primary btn-block" type="submit">登录</button>
        <p class="login-callout mt-3">
            没有账号？<a href="/register">创建一个</a>
        </p>
        <p class="mt-5 mb-3 text-muted text-center">This site was created by CYOUHO with &copy; Bootstrap 4!</p>
    </form>
</body>

</html>