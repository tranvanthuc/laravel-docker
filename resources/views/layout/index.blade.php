<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Document</title>
    @yield('head')
</head>
<body>
<div class="container">

    <header class="row">
        @include('layout.header')
    </header>

    <div id="main" class="row">
        @yield('content')
    </div>

    <footer class="row">
        @include('layout.footer')
    </footer>

</div>
<script src="{{ mix('/js/app.js') }}"></script>
</body>
</html>

