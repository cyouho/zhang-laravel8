<html>

<head>
    @include('global_header')
    @include('index.index_unique_header')
</head>

<body>
    @if ($isLogin)
    @include('global_navbar_login')
    @else
    @include('global_navbar_unlogin')
    @endif
    @include('index.new_index_contents')
    @include('index.popup_layer')
    @include('global_footer')
</body>

</html>