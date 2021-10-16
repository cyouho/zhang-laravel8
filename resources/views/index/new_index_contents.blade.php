<section class="jumbotron text-center">
    <div class="container">
        <h1>以图搜图</h1>
        <p class="lead text-muted">image search site.</p>
    </div>
    <div class="container mt-3">
        <form>
            @csrf
            <div class="input-group mt-3 mb-3">
                <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">
                    选择网站
                </button>
                <div class="dropdown-menu">
                    <a id="baidu" class="dropdown-item" href="#" value="baidu">百度</a>
                    @if ($data['isLogin'])
                    @include('index.login.index_login_site')
                    @else
                    @include('index.unlogin.index_unlogin_site')
                    @endif
                </div>
                <span class="soutu-btn" data-toggle="modal" data-target="#myModal" data-toggle2="tooltip" data-placement="bottom" title="点击上传图片"></span>
                <input id="imageUrl" type="text" class="form-control" placeholder="图片地址" value="">
            </div>
        </form>
    </div>
</section>