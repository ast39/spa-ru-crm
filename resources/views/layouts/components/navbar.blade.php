<nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm newdesign-nav">
    <div class="container">
        <a class="navbar-brand" href="{{ url('/') }}">
            <img class="me-2 mb-2" style="margin-top: 10px" src="{{ asset('/images/header_logo.svg') }}" width="100" height="30" />
            <span style="font-size: 1.2rem">{{ Auth::check() ? Auth::user()->name : config('app.name', 'Laravel') }}</span>
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">

            <!-- Left Side Of Navbar -->
            <ul class="navbar-nav me-auto">
                @auth
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('cabinet.index') }}">{{ __('Кабинет') }}</a>
                    </li>
                    @if(Gate::allows('owner') || Gate::allows('admin'))
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('dict.user.index') }}">{{ __('Сотрудники') }}</a>
                        </li>
                    @endif
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('dict.program.index') }}">{{ __('Прайс') }}</a>
                    </li>
                @endauth
            </ul>

            <!-- Right Side Of Navbar -->
            <ul class="navbar-nav ms-auto">
                <!-- Authentication Links -->
                @guest
                    @if (Route::has('login'))
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('login') }}">{{ __('Войти') }}</a>
                        </li>
                    @endif
                @else
                    <li class="nav-item">
                        @if(Gate::allows('owner'))
                            <a class="nav-link" href="{{ route('report.index') }}">{{ __('Отчеты') }}</a>
                        @elseif(Gate::allows('admin'))
                            <a class="nav-link" href="{{ route('report.show') }}">{{ __('Последний отчет') }}</a>
                        @endif
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('shift.index') }}">{{ __('Смена') }}</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">{{ __('Выход') }}</a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                            @csrf
                        </form>
                    </li>
                @endguest
            </ul>
        </div>
    </div>
</nav>
