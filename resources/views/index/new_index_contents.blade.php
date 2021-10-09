<section class="jumbotron text-center">
    <div class="container">
        <h1>以图搜图</h1>
        <p class="lead text-muted">image search site.</p>
    </div>
    <div class="container mt-3">
        <form>
            @csrf
            <div class="input-group mt-3 mb-3">
                <div class="input-group-prepend">
                    <button id="select" type="button" value="" class="btn btn-outline-secondary dropdown-toggle" data-toggle="dropdown">
                        选择网站
                    </button>
                    <div id="site" class="dropdown-menu">
                        <a id="baidu" class="dropdown-item" value="baidu">百度</a>
                        <a id="onesix" class="dropdown-item" href="#" value="onesix">1688</a>
                        <a id="alibaba" class="dropdown-item" href="#" value="alibaba">Alibaba</a>
                        <a id="taobao" class="dropdown-item" href="#" value="taobao">淘宝</a>
                    </div>
                </div>
                <span class="soutu-btn" data-toggle="modal" data-target="#myModal" data-toggle2="tooltip" data-placement="bottom" title="点击上传图片"></span>
                <input id="imageUrl" type="text" class="form-control" placeholder="图片地址" value="">
            </div>
        </form>
    </div>
</section>