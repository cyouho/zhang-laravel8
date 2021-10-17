<div class="d-flex flex-column flex-md-row align-items-center p-3 px-md-4 mb-3 bg-white border-bottom shadow-sm container">
    <h5 class="my-0 mr-md-auto font-weight-normal">
        <a class="navbar-brand text-dark" href="/">
            CYOUHO</a>
    </h5>
    <nav class="my-2 my-md-0 mr-md-3">
        <a class="p-2 text-dark" href="/index2">新主页</a>
        <a class="p-2 text-dark" href="https://github.com/cyouho" target="_blank">我的GitHub</a>
        <a class="p-2 text-dark" href="../en/about_site.html">测试按钮</a>
    </nav>

    <div class="dropdown">
        <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">
            {{$data['userName']}}
        </button>
        <div class="dropdown-menu">
            <a class="dropdown-item" href="/myPage">个人主页</a>
            <a class="dropdown-item" href="/profile">设置</a>
            <div class="dropdown-divider"></div>
            <a class="dropdown-item" href="/logout">退出</a>
        </div>
    </div>
</div>