<html>

<head>
    @include('global_header')
    @include('mypage.profile.profile_unique_header')
    @include('mypage.my_home_page_unique_header')
</head>

<body>
    @include('global_navbar_login')
    @include('mypage.profile.profile_contents')
    @include('global_footer')
    @include('mypage.profile.profile_alert_message')
</body>

</html>