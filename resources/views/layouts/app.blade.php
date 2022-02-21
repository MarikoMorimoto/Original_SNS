<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Flowers') }}</title>

    <!-- Scripts -->
    {{-- Bootstrap4 を使用するために無効化 --}}
    {{-- <script src="{{ asset('js/app.js') }}" defer></script> --}}
    
    {{-- Bootstrap4 を使用するために追加 --}}
    <!-- jQuery first, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
    <script src="{{ asset('js/bootstrap.bundle.min.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
    <link href="https://use.fontawesome.com/releases/v5.6.1/css/all.css" rel="stylesheet">

    <!-- Styles -->
    {{-- Bootstrap4 を使用するために無効化 --}}
    {{-- <link href="{{ asset('css/app.css') }}" rel="stylesheet"> --}}
    
    {{-- Bootstrap4 を使用するために追加 --}}
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
    <!-- Original CSS -->
    <link href="{{ asset('css/styles.css') }}" rel="stylesheet">

    <!-- favicon -->
    <link rel="shortcut icon" href="{{ asset('favicon.ico') }}">
    <link rel="apple-touch-icon" type="image/png" href="{{ asset('apple-touch-icon-180x180.png') }}">
    <link rel="icon" type="image/png" href="{{ asset('icon-192x192.png') }}">
    
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light shadow-sm fixed-top">
            <div class="container-fluid">
                <a class="navbar-brand" href="{{ url('/') }}">
                    <img src="{{ asset('images/logo.png') }}" alt="logo">
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav me-auto">

                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav my-1 text-center ml-auto">
                        <!-- Authentication Links -->
                        @guest
                            @if (Route::has('login'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                                </li>
                            @endif

                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                                </li>
                            @endif
                                <li class="nav-item"><a href="{{ route('about.index') }}" class="nav-link"><i class="fas fas fa-seedling"> このサイトについて</i></a></li>
                                <li class="nav-item"><a href="{{ route('posts.index') }}" class="nav-link"><i class="fas fas fa-seedling"> 投稿一覧</i></a></li>
                                <li class="nav-item"><a href="#" class="nav-link"><i class="fas fas fa-seedling"> 投稿一覧</i></a></li>                            
                        @else
                        <li class="nav-item"><a href="{{ route('about.index') }}" class="nav-link"><i class="fas fas fa-seedling"> このサイトについて</i></a></li>
                        <li class="nav-item"><a href="{{ route('posts.index') }}" class="nav-link"><i class="fas fas fa-seedling"> 投稿一覧</i></a></li>
                        <li class="nav-item"><a href="#" class="nav-link"><i class="fas fas fa-seedling"> 投稿一覧</i></a></li>
                        <li class="nav-item dropdown">
                            <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                {{ Auth::user()->name }} さんのマイページ
                            </a>
                            <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                <a href="#" class="dropdown-item">mypage1</a>
                                <a href="#" class="dropdown-item">mypage2</a>
                                <a href="#" class="dropdown-item">mypage3</a>
                            </div>
                        </li>
                        <li class="nav-item">
                                <a href="{{ route('logout') }}"
                                    class="nav-link"
                                    onclick="event.preventDefault();
                                                    document.getElementById('logout-form').submit();">
                                    {{ __('Logout') }}
                                </a>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                    @csrf
                                </form>
                            </li>

                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        <!-- py-4 padding-top,bottom 1.5rem -->
        <main class="py-4">
            @yield('content')
        </main>
    </div>
</body>
</html>
