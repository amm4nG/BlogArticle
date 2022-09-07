<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link href="//fonts.gstatic.com" rel="dns-prefetch">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style>
        .image_upload>input {
            display: none;
        }
    </style>
    <!-- Scripts -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
</head>
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css" rel="stylesheet">

<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    {{ config('app.name', 'Laravel') }}
                </a>
                <button class="navbar-toggler" data-bs-toggle="modal" data-bs-target="#exampleModal" type="button"
                    aria-controls="navbarSupportedContent" aria-expanded="false"
                    aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                {{-- Modal --}}
                <div class="modal fade" id="exampleModal" aria-labelledby="exampleModalLabel" aria-hidden="true"
                    tabindex="-1">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title font-monospace fs-4" id="exampleModalLabel"><i
                                        class="bi bi-code-slash"></i>
                                    Lita' Mandar</h5>
                                <button class="btn-close" data-bs-dismiss="modal" type="button"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                @guest
                                    <a class="nav-link mb-3 fs-5" href="{{ url('/') }}">{{ __('Home') }}</a>
                                    @if (Route::has('login'))
                                        <a class="nav-link mb-3 fs-5" href="{{ route('login') }}">{{ __('Login') }}</a>
                                    @endif

                                    @if (Route::has('register'))
                                        <a class="nav-link mb-3 fs-5"
                                            href="{{ route('register') }}">{{ __('Register') }}</a>
                                    @endif
                                    <div class="modal-footer">
                                    </div>
                                @else
                                    @if (Auth::user()->level == 'admin')
                                        <a class="nav-link fs-5" href="{{ url('home') }}">Home</a>
                                        <a class="nav-link mt-3 fs-5" href="{{ route('artikel.index') }}">Articles</a>
                                    @endif
                                    <div class="modal-footer mt-3">
                                        <a class="btn btn-danger fs-5" href="{{ route('logout') }}"
                                            onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">Logout
                                        </a>

                                        <form class="d-none" id="logout-form" action="{{ route('logout') }}"
                                            method="POST">
                                            @csrf
                                        </form>
                                    </div>
                                @endguest
                            </div>
                        </div>
                    </div>
                </div>
                {{-- end modal --}}

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav me-auto">

                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ms-auto">
                        <!-- Authentication Links -->
                        @guest
                            <li class="nav-item">
                                <a class="nav-link" href="{{ url('/') }}">{{ __('Home') }}</a>
                            </li>
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
                        @else
                            <a class="nav-link" id="artikel" href="{{ url('home') }}" role="button"
                                aria-haspopup="true" aria-expanded="false" v-pre>
                                Home
                            </a>
                            <a class="nav-link" id="artikel" href="{{ url('artikel') }}" role="button"
                                aria-haspopup="true" aria-expanded="false" v-pre>
                                Articles
                            </a>
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" id="navbarDropdown" data-bs-toggle="dropdown"
                                    href="#" role="button" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }}
                                </a>

                                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                        onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>

                                    <form class="d-none" id="logout-form" action="{{ route('logout') }}"
                                        method="POST">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        <main class="py-4">
            @yield('content')
        </main>
    </div>
    @yield('script')
</body>

</html>
