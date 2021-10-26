<section class="jumbotron text-center">
    <div class="container">
        <h1>
            @if (isset($adminData['adminName']) && isset($adminData['adminRole']))
            {{$adminData['adminRole']}}: {{$adminData['adminName']}}
            @endif
        </h1>
    </div><br>
    <div class="container text-center">
        <div class="row">
            <div class="col-sm-4">
                <p>上次登录时间</p>
                <h3>
                    @if (isset($adminHomePageData['last_login_at']))
                    {{$adminHomePageData['last_login_at']}}
                    @endif
                </h3>
                <h5></h5>
            </div>
            <div class="col-sm-4">
                <p>总登录次数</p>
                <h3>
                    @if (isset($adminHomePageData['total_login_times']))
                    {{$adminHomePageData['total_login_times']}}
                    @endif
                </h3>
            </div>
            <div class="col-sm-4">
                <p>注册时间</p>
                <h3>
                    @if (isset($adminHomePageData['create_at']))
                    {{$adminHomePageData['create_at']}}
                    @endif
                </h3>
                <h5></h5>
            </div>
        </div>
    </div>
</section>