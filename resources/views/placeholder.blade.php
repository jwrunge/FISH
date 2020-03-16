<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Alegreya|Lato" rel="stylesheet">

    <!-- Scripts -->
    <script src="{{ asset('/js/app.js') }}"></script>

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body>
    <div class='content topmargin toppadding'>
        <div class='unboxed_content'>
            <h1>Coming soon!</h1>
            <p>It won't be long before the new Galesburg FISH Food Pantry website is here! Check back soon.</p>
        </div>
    </div>
</body>