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
    <nav id='nav'>
        <div class='text-right'>
            <img id='hamburger' src='/images/hamburger.svg'/>
            <div id='full_nav'>
                @if(Request::is('/'))
                    <span class='greyed'>News</span>
                @else
                    <a href='/'>News</a>
                @endif

                @if(Request::is('about'))
                    <span class='greyed'>About Us</span>
                @else
                    <a href='/about'>About Us</a>
                @endif

                @if(Request::is('assistance'))
                    <span class='greyed'>Assistance</span>
                @else
                    <a href='/assistance'>Assistance</a>
                @endif

                <a href='https://www.google.com/maps/place/Fish+of+Galesburg/@40.9732264,-90.3626674,17z/data=!3m1!4b1!4m5!3m4!1s0x87e195ec0721c13f:0xc6d114bd2d54c625!8m2!3d40.9732224!4d-90.3604787' target='_blank'>Find Us</a>
                
                @if(Auth::user() && (Auth::user()->role === 'admin' || Auth::user()->role === 'editor'))
                    <div class='admin_nav'>
                        <a href='/home'>Dash</a>
                        <a href='/archive'>Archives</a>
                        <a id='logoutlink' href='/'>Log out</a>
                        <form id='logoutform' method='POST' action='/logout'>
                            @csrf
                            <input type='submit' class='btn btn-link m-0' value='Log out'/>
                        </form>
                    </div>
                @endif

            </div>
        </div>
    </nav>

    <main>
        @yield('content')
    </main>

    <footer id='footer'>
        <p>Site design by <a class='exempt' target='_blank' href='http://www.jacobrunge.com'>Jacob Runge</a></p>
    </footer>

</body>
</html>
