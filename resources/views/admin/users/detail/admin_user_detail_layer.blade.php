<html>

<head>
    @include('global_header')
    @include('admin.users.admin_users_unique_header')
</head>

<body>
    @include('admin.admin_navbar')
    @include('admin.users.detail.admin_user_detail_contents')
    @include('global_footer')
    @include('admin.users.detail.admin_user_detail_model')
</body>

</html>