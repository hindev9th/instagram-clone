<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body>
<div id="app">
    <div class="container-fluid">
        <div class="container mt-5 d-flex justify-content-between align-items-center">
            <a class="text-dark text-decoration-none font-weight-bold" href="{{ url('/') }}">
                <h1 class="m-0">{{ config('app.name', 'Laravel') }}</h1>
            </a>

            @guest
                <div class="d-flex p-2 align-items-center">
                    <a class="pr-2 text-decoration-none text-dark" href="{{ route('login') }}">{{ __('Login') }}</a>
                    @if (Route::has('register'))
                        <a class="pl-2 text-decoration-none text-dark"
                           href="{{ route('register') }}">{{ __('Register') }}</a>
                    @endif
                </div>
            @else
                <div class="box-user shadow-sm overflow-hidden d-flex align-items-center position-relative" style="border-radius: 0.7rem;">
                    <a href="{{ route('profile.index',['user' => Auth::user()->username]) }}"
                       class="text-decoration-none text-dark">
                        <div
                            class=" d-flex align-items-center pr-3 pl-3">
                            <img src="{{ Auth::user()->profile->getImage() }}" width="55px" alt="" class=" position-absolute" style="left: -5px">
                            <strong class="p-2 pl-5" style="font-size: 18px">{{ Auth::user()->username }}</strong>
                        </div>
                    </a>
                    <div class="logout pl-2 pr-2">
                        <a href="{{ route('logout') }}"
                           onclick="event.preventDefault();document.getElementById('logout-form').submit();" style="font-size: 18px"><i
                                class="fas fa-sign-out-alt"></i></a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                    </div>
                </div>
            @endguest
        </div>
    </div>

    <main class="py-4">
        @yield('content')
    </main>
</div>
</body>
</html>
