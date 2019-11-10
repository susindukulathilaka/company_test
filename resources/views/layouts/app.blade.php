<!-- Stored in resources/views/layouts/app.blade.php -->

<html>
<head>
    <title>App Name - @yield('title')</title>
</head>
<body>
@section('sidebar')

@show

<div class="title">
    @yield('content')
</div>
</body>
</html>