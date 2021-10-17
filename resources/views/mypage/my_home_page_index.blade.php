<section class="jumbotron text-center">
    <div class="container">
        <h1>欢迎用户 {{$data['userName']}}</h1>
        <p class="lead text-muted">welcome {{$data['userName']}}.</p>
    </div>
    <div class="row">
        <div class="col-sm-4">
            <p>上次登录时间</p>
            <h3>{{$myPageData['lastLoginTime']}}</h3>
        </div>
        <div class="col-sm-4">
            <p>总登录次数</p>
            <h3>{{$myPageData['totalLoginTimes']}}</h3>
        </div>
        <div class="col-sm-4">
            <p>注册时间</p>
        </div>
    </div>
</section>