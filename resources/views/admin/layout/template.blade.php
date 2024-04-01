<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="{{ asset('css/bootstrap.css') }}">
    @vite(['resources/sass/style.scss'])

    <title>{{ $title }}</title>
</head>
<body>
    @include('admin.layout.header')

    @yield('content')

    @include('admin.layout.footer')
    <script src="{{ asset('js/bootstrap.bundle.js') }}"></script>
</body>
</html>