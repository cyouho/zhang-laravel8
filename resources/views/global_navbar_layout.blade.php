@if ($isLogin)
@include('global_navbar_login')
@else
@include('global_navbar_unlogin')
@endif