<section class="jumbotron text-center">
    <div class="container">
        <h1>{{$data['userName']}} 个人主页</h1>
        <p class="lead text-muted">{{$data['userName']}} home page.</p>
    </div>
</section>
<div class="container text-center">
    <div class="row">
        <div class="col-sm-4">
            <p>上次登录时间</p>
            <h3>{{$myPageData['lastLoginTime']['year']}}</h3>
            <h5>{{$myPageData['lastLoginTime']['min']}}</h5>
        </div>
        <div class="col-sm-4">
            <p>总登录次数</p>
            <h3>{{$myPageData['totalLoginTimes']}}</h3>
        </div>
        <div class="col-sm-4">
            <p>注册时间</p>
            <h3>{{$myPageData['registerTime']['year']}}</h3>
            <h5>{{$myPageData['registerTime']['min']}}</h5>
        </div>
    </div><br><br>
    <h3 class="text-center">近7天登录情况一览</h3>
    <div id="homePage">

    </div>
</div>