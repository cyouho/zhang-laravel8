<nav class="navbar navbar-expand-sm bg-dark navbar-dark d-flex flex-column flex-md-row align-items-center p-3 px-md-4 mb-3 border-bottom shadow-sm container">
    <!-- Brand -->
    <a class="navbar-brand" href="/adminIndex">CYOUHO</a>

    <!-- Links -->
    <ul class="navbar-nav ml-auto">
        <!-- Dropdown -->
        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="navbardrop" data-toggle="dropdown">
                @if (isset($adminData['adminName']) && isset($adminData['adminRole']))
                {{$adminData['adminRole']}}: {{$adminData['adminName']}}
                @endif
            </a>
            <div class="dropdown-menu">
                @if ($adminData['adminRole'] === '超级管理员')
                <a class="dropdown-item" href="/createAdminIndex">创建新管理员</a>
                <a class="dropdown-item" href="/showAdminInfo">管理员信息一览</a>
                @endif
                <a class="dropdown-item" href="#">用户管理</a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="/adminLogout">退出</a>
            </div>
        </li>
    </ul>
</nav>