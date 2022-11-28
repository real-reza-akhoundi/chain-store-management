<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    @include('layouts.inc.head')
    @yield('head-tag')
</head>
<body>
    @include('layouts.inc.main_header')

    <div class="container">
        <div class="row">
            @yield('content')
        </div>
    </div>
    @include('layouts.inc.scripts')
    @yield('script')
</body>
</html>