<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Testify') }}</title>

    <!-- Scripts -->
    @vite(['resources/sass/app.scss', 'resources/js/main.tsx'])
</head>


<body>

    <script>
        window.authToken = "{{ session('authToken') }}";
    </script>

    <div class="layout">

        <header class="layout__header">

            <div class="container">

                <div class="header">

                    @auth
                        <div class="header__group">
                            <img class="header__group-image" src="{{ asset('img/comp.svg') }}" alt="Группа">
                            <div class="header__group-name">
                                {{ Auth::user()->group->name }}
                            </div>
                        </div>
                    @endauth

                    <div class="header__logo">Testify</div>

                    @auth
                        <div class="header__person">
                            <div class="header__person-name">
                                {{ Auth::user()->name }}
                            </div>
                            <img class="header__person-image" src="{{ asset('img/student.svg') }}" alt="Студент">
                        </div>
                    @endauth


                    <div class="header__burger-wrapper">
                        @auth
                            <div class="header__burger">
                                <span></span>
                                <span></span>
                                <span></span>
                            </div>
                        @endauth
                    </div>


                </div>

            </div>

        </header>

        <div class="layout__main">

            @auth
                <div class="container --h100">
                    <div class="main">
            @endauth

            @auth

            <aside class="sidebar">

                <nav class="sidebar__navigation">

                    <ul class="sidebar__list">

                        <li class="sidebar__item">
                            <a href="{{ route('inwork') }}" class="sidebar__link">
                                <img class="sidebar__icon" src="{{ asset('img/inwork.svg') }}" alt="all">
                                Заданные
                            </a>
                        </li>

                        <li class="sidebar__item">
                            <a href="{{ route('completed') }}" class="sidebar__link">
                                <img class="sidebar__icon" src=" {{ asset('img/done.svg') }}" alt="done">
                            Выполненные</a>
                        </li>

                    </ul>

                </nav>

        <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
            <a class="dropdown-item" href="{{ route('logout') }}"
            onclick="event.preventDefault();
                        document.getElementById('logout-form').submit();">
                <img src="{{ asset('img/exit.svg') }}" alt="Выход">
                {{ __('Выход') }}
            </a>

            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                @csrf
            </form>
        </div>

            </aside>
            @endauth

            <main class="content">
                @yield('content')
            </main>

            @auth
                    </div>
                </div>
            @endauth

        </div>

        <div class="sidebar-overlay"></div>

        <footer class="layout__footer">

            <div class="container">
                <div class="footer">

                        <a class="footer__link" href="#">
                            Обратная связь
                             <img src="{{ asset('img/sferum.svg') }}" alt="sferum">
                        </a>

                    <div class="footer__date">2025</div>
                </div>
            </div>

        </footer>

    </div>
</body>
</html>
